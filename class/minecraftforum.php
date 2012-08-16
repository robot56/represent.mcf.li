<?php

/*
 * Friendly warning:
 * This code is truly horrendouse, it's shamefully bad. The curse login process
 * has changed a few times and every time I hate working on this so much that
 * I half ass it and it ends up like... this. It's the culmination of multiple
 * changes to the login system and a lack of care or attention. Although the 
 * code... "works"... it's awful. I will rewrite this one day and have a proper, 
 * usable, maintainable and not shameful library for authenticating with curse
 * websites. until then I advise averting your eyes.
 */

class minecraftforum {
    
    public function authenticate ($username = false, $password = false) {
        if(!$username || !$password)
            require '../config/minecraftforum.php';
        
        // check the database for the current authentication 
        require 'config/database.php';
        $pdo = new PDO("mysql:host=$database_server;dbname=$database_database", $database_username, $database_password);
        
        $query = $pdo->prepare("SELECT * FROM auth WHERE username = :username AND password = :password");
        $query->execute(array(":username" => $username, ":password" => $password));
        $cookie = $query->fetch(PDO::FETCH_ASSOC);
        
        // verify login
        $this->cookie = $cookie["cookie"];
        $contents = $this->page_contents("http://www.minecraftforum.net/index.php?app=core&module=usercp");
        
        $this->secure_hash = $cookie["secure_hash"];
        $this->session_id = $cookie["session_id"];
        
        if($contents["info"]["http_code"] == 200)
            return true;
        
        $this->login($username, $password);
        
        $s_i = $this->page_contents("http://www.minecraftforum.net/index.php?app=core&module=usercp");
        
        $secure_hash = str_replace("'", "", $s_i["ipb_vars"]["secure_hash"]);
        $session_id = str_replace("'", "", $s_i["ipb_vars"]["session_id"]); // could be fetched from cookie
        
        $query = $pdo->prepare("UPDATE auth SET COOKIE = :cookie, secure_hash = :secure_hash, session_id = :session_id WHERE username = :username AND password = :password"); // why am i preparing these when i control the input lolol
        $query->execute(array(":cookie" => $this->cookie, ":username" => $username, ":password" => $password, ":secure_hash" => $secure_hash, ":session_id" => $session_id));
        
        $this->secure_hash = $secure_hash;
        $this->session_id = $session_id;
        
        return true;
    }
    
    function login ($username, $password) {
        $form_options = array(CURLOPT_URL => "http://www.minecraftforum.net/index.php?app=core&module=global&section=login");
        $form_page = $this->curl($form_options);
        $form_header = end($form_page["headers"]);
        $form_cookie = $form_header['clean-cookie'];
        
        /*
         * Load the curse auth service (from can be anything, it's just for client redirection which we ignore) and retrieve the cookie
         */
        $curseauth_options = array(CURLOPT_URL => "http://auth.curse.com/NetworkService.asmx/shareSession?from=something", CURLOPT_COOKIE => $form_cookie);
        $curseauth_req = $this->curl($curseauth_options);
        $curseauth_headers = end($curseauth_req["headers"]);
        
        // login cookie, includes the ipb session and the curse session
        $login_cookie = $form_cookie.' '.$curseauth_headers["clean-cookie"];
        
        preg_match('%networkcookie=(.*?);%sm', $curseauth_headers["clean-cookie"], $soap_cookie);
        
        $soapauth_options = array(CURLOPT_URL => "http://www.minecraftforum.net/admin/sources/loginauth/cursesoap/cookie.php?section=login&cookie=".$soap_cookie[1], CURLOPT_COOKIE => $form_cookie);
        $soapauth_req = $this->curl($soapauth_options);
        
        preg_match('%network_cookie=(.*?);%sm', $soapauth_req["headers"][0]["set-cookie"], $soap_network_cookie);
        
        $new_login_cookie = $form_cookie.' network_cookie='.$soap_network_cookie[1];
        
        /*
         * Send a request to IPB 3.1.4 login page with the cookie (ipb sess + curse auth sess) to get the authentication key
         */
        
        $login_options = array(CURLOPT_URL => "http://www.minecraftforum.net/index.php?app=curseauth&module=global&section=login", CURLOPT_COOKIE => $new_login_cookie);
        $login_page = $this->curl($login_options);
        
        // parse the login page to get the auth key
        $login_authkey = $this->_authkey($login_page["page"]);
        
        /*
         * POST to the login system with the auth key, login cookie and account info
         */
        
        $post_fields = array("auth_key" => $login_authkey, "ips_password" => $password, "ips_username" => $username, "referer" => "http://www.minecraftforum.net/index.php?app=curseauth&module=global&section=register&do=process", "rememberMe" => 1, "submit" => "Login");
        $process_options = array(CURLOPT_URL => "http://www.minecraftforum.net/index.php?app=curseauth&module=global&section=login&do=process", CURLOPT_POST => true, CURLOPT_POSTFIELDS => $post_fields, CURLOPT_COOKIE => $new_login_cookie, CURLOPT_RETURNTRANSFER => true);
        $login_process = $this->curl($process_options);
        
        $login_process_headers = end($login_process["headers"]);

        // Login process done, we now have the response, BUT IS IT A SUCCESFUL LOGIN? No HTTP status related to the login so I have to parse the page... ugh
        // preg_match('%<title>(.*?)</title>%sm', $login_process["page"], $login_page_title);
        // $title = $login_page_title[1];

        // save the cookie returned by the login, this cookie will authenticate all future requests
        $this->cookie = $login_process_headers["clean-cookie"];
        
        return true;
    }
    
    function page_contents ($url, $secure = false) {
        if($secure)
            $url .= "&s=".$this->session_id."&secure_key=".$this->secure_hash;
        
        $curl_options = array(CURLOPT_URL => $url, CURLOPT_COOKIE => $this->cookie, CURLOPT_FOLLOWLOCATION => true, CURLOPT_TIMEOUT => 10);
        
        $curl_result = $this->curl($curl_options);
        
        if(!empty($curl_result["page"]))
            $curl_result["ipb_vars"] = $this->_ipb_vars($curl_result["page"]);
        
        return $curl_result;
    }
    
    function curl ($set_options = array()) {
        $default_options = array(
            CURLOPT_USERAGENT => "citricsquid ~ sryan@curse.com",
            CURLOPT_HEADER => true,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_ENCODING => "gzip",
            CURLOPT_RETURNTRANSFER => true,
        );

        $options = $this->_curray_merge($default_options, $set_options);
        
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $curl_return = curl_exec($curl);

        $curl_getinfo = curl_getinfo($curl);
        $request_headers = substr($curl_return, 0, $curl_getinfo["header_size"]);
        $html = substr($curl_return, $curl_getinfo["header_size"]);
        
        $headers = $this->_curl_seperate_headers($request_headers);
        
        return array("info" => $curl_getinfo, "headers" => $headers, "page" => $html);
    }
    
    function _curray_merge ($options, $set_options) {
        foreach($set_options as $nid => $value)
            $options[$nid] = $value;
        
        return $options;
    }
    
    function _curl_seperate_headers ($output) {
        preg_match_all('%HTTP(.*?)^\r?$%sm', $output, $headers);
        
        foreach($headers[0] as $pos => $header)
        {
            $heads[$pos] = $this->_curl_parse_headers(trim($header));
            $heads[$pos]["raw"] = trim($header);
        }
        
        return $heads;
    }
    
    function _curl_parse_headers ($output) {
        preg_match('%^(.*(\r|\n|)){1}%', $output, $status);
        preg_match('%HTTP/([0-9\.]{1,9}) ([0-9]{1,9}) (.*?)$%m', $status[1], $http_statuses);

        $headers["http_status_version"] = $http_statuses[1];
        $headers["http_status_code"] = $http_statuses[2];
        $headers["http_status_msg"] = $http_statuses[3];

        $output = preg_replace("%^(.*\r\n){1}%", "", $output); // remove first line (the HTTP status code)
        preg_match_all('%(.*?):(.*?)(?:\r\n)%sm', $output, $header_vals);

        $multi_headers = array("set-cookie"); // array of things to allow dupes of

        foreach($header_vals[1] as $pos => $name)
        {
            $name = strtolower($name);

            // if the header exists twice or more make it an array and include the values
            if(isset($headers[$name]) && in_array($name, $multi_headers))
            {
                if(!is_array($headers[$name]))
                    unset($headers[$name]);
                
                $headers[$name][] = $header_vals[2][$pos];
            }
            else
            {
                $headers[$name] = $header_vals[2][$pos];
            }
        }
        
        // I should make this work for any multi value fuck it
        if(isset($headers["set-cookie"]) && is_array($headers["set-cookie"]))
        {
            $headers["clean-cookie"] = '';
            foreach($headers["set-cookie"] as $cookie)
            {
                $cleaned_cookie = $this->_clean_header_cookie($cookie);
                $headers["clean-cookie"] .= (strlen($headers["clean-cookie"]) > 0 ? ' ' : '').$cleaned_cookie;
            }
        }
        elseif(isset($headers["set-cookie"]) && !is_array($headers["set-cookie"]))
        {
           $headers["clean-cookie"] = $this->_clean_header_cookie($headers["set-cookie"]);
        }
        
        return $headers;
    }
    
    function _clean_header_cookie ($cookie) {
        preg_match('%(.*?)(?:(domain=(.*?);)|(path=(.*?);)|(expires=(.*?))$)%m', $cookie, $preg_cookie);
        return trim($preg_cookie[1]);
    }
    
    function _ipb_vars ($page) {
        preg_match_all('%ipb\.vars\[\'(.*?)\'\](?:.*?)= (.*?);%sm', $page, $found_vars);
        
        if(empty($found_vars[1]))
            return false;
        
        foreach($found_vars[1] as $key => $var)
            $ipb_vars[$var] = $found_vars[2][$key];
        
        return $ipb_vars;
    }
    
    function _postkey($page_contents)
    {
        preg_match('%name=(?:\'|")postKey(?:\'|") value=(?:\'|")([a-zA-Z0-9]{32})(?:\'|")%sm', $page_contents, $auth_key);
        return $auth_key[1];
    }
    
    function _authkey($page_contents)
    {
        preg_match('%name=(?:\'|")auth_key(?:\'|") value=(?:\'|")([a-zA-Z0-9]{32})(?:\'|")%sm', $page_contents, $auth_key);
        return $auth_key[1];
    }

}