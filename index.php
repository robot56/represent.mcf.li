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
        echo 'option to force update of a username and skin';
        echo 'pull minecraft name from mcf profile :D';
    });
    
    respond('/reputation/[i:id]', function ($request, $response) {
        echo 'full list of reputation for a post';
    });
    
    respond('/post/[i:id]', function ($request, $response) {
        $post_id = $request->param('id');
        $database = new database();
        
        header('Access-Control-Allow-Origin: *'); // we're using cross domain ajax
        
        $post = $database->get_post($post_id);
        
        if(!$post OR strtotime($post["last_update"]) < time() - 86400) {
            exec("php ".APP_PATH."process.php $post_id  >> /dev/null &");
        }
            
        $users = $database->get_post_rep_users($post_id);
        
        if(!$post) {
            $response->render("views/status.php", array("status" => "processing :D"));
        } else if (empty($users)) {
            $response->render("views/status.php", array("status" => "no users yet"));
        } else {
            $response->render("views/rep.php", array("users" => $users));
        }
    });

    respond('/404', function ($request, $response) {
        echo '404 :(';
    });

    dispatch();