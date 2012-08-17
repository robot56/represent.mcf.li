<?php

    require 'class/klein.php';
    require 'class/minecraftforum.php';
    require 'class/minotar.php';
    require 'class/database.php';
    require 'config/application.php';
    require 'helper.php';

    respond('/', function ($request, $response) {
        $response->render("views/index.php");
    });
    
    respond('/username', function ($request, $response) {
        if($_POST['url'])
        {
            preg_match('%http://www.minecraftforum.net/user/([0-9]{1,9})-(?:.*?)$%', $_POST['url'], $user_id);
            
            if(is_numeric($user_id[1])) {
                $database = new database();
                
                if(!$database->get_user($user_id[1])) {
                    $status = array("message" => "That account doesn't exist in the user database, have you repped before?", "type" => "error"); // maybe I should insert instead...?
                    $response->render("views/username.php", array("status" => $status));
                    return;
                }
                
                // don't want to do this in runtime but SOMEONE DECIDED TO MAKE MCF PROFILES HIDDEN TO GUESTS >>>>:(
                $minecraftforum = new Minecraftforum();
                $minecraftforum->authenticate();
                $profile_page = $minecraftforum->page_contents("http://www.minecraftforum.net/user/".$user_id[1]."-");

                if($profile_page["info"]["http_code"] == 200) {
                    $html = preparse($profile_page["page"]);
                    preg_match('%<li class=\'clear clearfix\'><span class=\'row_title\'>Minecraft</span><div class=\'row_data\'>([a-zA-Z0-9_]{2,16})</div>%', $html, $minecraft_name);
                    if($minecraft_name[1]) {
                        $custom_head = 0;
                        
                        if(Minotar::is_head_custom($minecraft_name[1]))
                            $custom_head = 1;
                        
                        $database->update_user_minecraft_name($user_id[1], $minecraft_name[1], $custom_head);
                        $status = array("message" => "Minecraft name updated to ".$minecraft_name[1], "type" => "success");
                    } else {
                        $status = array("message" => "A valid Minecraft name cannot be found on the profile, is it valid?", "type" => "error");
                    }
                } else {
                    $status = array("message" => "Profile could not be loaded", "type" => "error");
                }
            } else {
                $status = array("message" => "invalid profile link", "type" => "error");
            }

            $response->render("views/username.php", array("status" => $status));
        } else { 
            $response->render("views/username.php");
        }
        
    });
    
    respond('/reputation/[i:id]', function ($request, $response) {
        $post_id = $request->param('id');
        $database = new database();
        
        $post = $database->get_post($post_id);
        
        if(!$post)
        {
            $response->render("views/404.php", array("message" => "Page not found"));
            return;
        }
        
        $users = $database->get_post_rep_users($post_id);
        
        $response->render("views/reputation.php", array("users" => $users, "post_id" => $post_id));
    });
    
    respond('/post/[i:id]', function ($request, $response) {
        $post_id = $request->param('id');
        $database = new database();
        
        header('Access-Control-Allow-Origin: *'); // we're using cross domain ajax
        
        $post = $database->get_post($post_id);
        
        if(!$post OR strtotime($post["last_update"]) < time() - 7200) {
            exec("php ".APP_PATH."process.php $post_id  >> /dev/null &");
        }
            
        $users = $database->get_post_rep_users($post_id);
        
        if(!$post) {
            $response->render("views/status.php", array("status" => "processing :D"));
        } else if (empty($users)) {
            $response->render("views/status.php", array("status" => "no users yet"));
        } else {
            $response->render("views/rep.php", array("users" => $users, "post_id" => $post_id));
        }
    });

    respond('/404', function ($request, $response) {
        $response->render("views/404.php", array("message" => "Page not found"));
    });

    dispatch();