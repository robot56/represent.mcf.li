<?php

class minotar {
    
    function is_head_custom ($username) { 
        $steve = file_get_contents("assets/img/steve.png");
        $user_head = self::get_head($username);
        
        if(!$user_head || $user_head == $steve)
            return false;
        
        return true;
    }
    
    function get_head ($username, $size = 8) {
        $head = self::fetch_head($username, $size);
        return $head;
    }
    
    function fetch_head ($username, $size, $type = "avatar") {
        $url = "http://minotar.net/$type/$username/$size.png";
        $head = @file_get_contents($url);
        
        // account for minotar sometimes not having the head til second request
        if(!$head)
            $head = @file_get_contents($url);
        
        if(!$head)
            return false;
        
        return $head;
    }
    
    function curl ($url) {
        $options = array(
            CURLOPT_USERAGENT => "citricsquid ~ sryan@curse.com",
            CURLOPT_HEADER => false,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_ENCODING => "gzip",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
        );
        
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $curl_return = curl_exec($curl);

        $curl_getinfo = curl_getinfo($curl);
        
        return array("info" => $curl_getinfo, "page" => $curl_return);
    }
    
    function _curray_merge ($options, $set_options) {
        foreach($set_options as $nid => $value)
            $options[$nid] = $value;
        
        return $options;
    }
    
}