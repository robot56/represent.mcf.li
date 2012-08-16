<?php

    if(php_sapi_name() != 'cli')
        die('No permission to access');

    require 'class/minecraftforum.php';
    require 'class/minotar.php';
    require 'class/database.php';
    require 'helper.php';
    
    error_reporting(0);

    $post_id = $argv[1] ?: $_GET['post_id'];
    
    if(!is_numeric($post_id))
        die('invalid post_id');
    
    $database = new database();

    $post = $database->get_post($post_id);

    if (!$post) {
        $database->add_post($post_id);
    } else {
        $database->update_post($post_id);
    }

    $minecraftforum = new Minecraftforum();
    $minecraftforum->authenticate();
    $reputation_page = $minecraftforum->page_contents("http://www.minecraftforum.net/index.php?app=core&module=ajax&section=reputation&do=view&repApp=forums&repType=pid&repId=$post_id", true);
    
    preg_match_all('%<a href=\'http://www.minecraftforum.net/user/([0-9]+)-(.*?)/\'>(.*?)</a>%sm', $reputation_page["page"], $reputation_givers);
    
    foreach($reputation_givers[0] as $k => $user) {
        $rep_inserts[] = array("user_id" => $reputation_givers[1][$k], "post_id" => $post_id);
    }
    
    $users = $database->get_all_users();
    
    foreach($reputation_givers[1] as $key => $user_id) {
        if($users[$user_id]) {
            unset($reputation_givers[0][$key]);
        }
    }
    
    foreach($reputation_givers[0] as $k => $rep)
    {
        $custom_head = 0;
        if(Minotar::is_head_custom($reputation_givers[3][$k]))
            $custom_head = 1;

        $user_inserts[] = array("user_id" => $reputation_givers[1][$k], "display_name" => $reputation_givers[3][$k], "minecraft_name" => $reputation_givers[3][$k], "custom_head" => $custom_head);
    }
    
    if(!empty($user_inserts))
        $database->add_users($user_inserts);
    
    if(!empty($rep_inserts))
        $database->add_reps($rep_inserts);