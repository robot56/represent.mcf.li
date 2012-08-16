<?php

    require 'class/klein.php';
    require 'class/minecraftforum.php';
    require 'class/minotar.php';
    require 'class/database.php';
    require 'helper.php';

    respond('/', function ($request, $response) {
        echo 'index';
    });
    
    respond('/post/[i:id]', function ($request, $response) {
        $post_id = $request->param('id');
        $database = new database();
        
        $post = $database->get_post($post_id);
        
        if(!$post OR strtotime($post["last_update"]) < time() - 86400) {
            echo 'coming soon';
            return false;
        }
            
        $users = $database->get_post_rep_users($post_id);
        
        header('Access-Control-Allow-Origin: *'); // we're using cross domain ajax
        $response->render("views/rep.php", array("users" => $users));
    });

    dispatch();