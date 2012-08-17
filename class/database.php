<?php

class database {
    
    function __construct() { 
        require "../config/database.php";
        $this->pdo = new PDO("mysql:host=$database_server;dbname=$database_database", $database_username, $database_password);
    }
    
    function add_post ($post_id) {
        $query = $this->pdo->prepare("INSERT INTO posts (post_id) VALUES (?)");
        $query->execute(array($post_id));
    }
    
    function get_post ($post_id) {
        $query = $this->pdo->prepare("SELECT * FROM posts WHERE post_id = :post_id");
        $query->execute(array(":post_id" => $post_id));
        $post = $query->fetch(PDO::FETCH_ASSOC);
        
        return $post;
    }
    
    function update_post ($post_id) {
        $query = $this->pdo->prepare("UPDATE posts SET last_update = now() WHERE post_id = :post_id");
        $query->execute(array(":post_id" => $post_id));
    }
    
    function get_post_rep_users ($post_id) {
        $query = $this->pdo->prepare("SELECT users.user_id, users.display_name, users.minecraft_name, users.custom_head FROM users INNER JOIN posts_reps ON users.user_id=posts_reps.user_id WHERE post_id = :post_id");
        $query->execute(array(":post_id" => $post_id));
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $users;
    }
    
    function get_all_users ($key = "user_id") {
        $query = $this->pdo->prepare("SELECT * FROM users");
        $query->execute();
        return id_to_key($query->fetchAll(PDO::FETCH_ASSOC), $key);
    }
    
    function add_reps ($reps) {
        foreach($reps as $rep) {
            $query = $this->pdo->prepare("INSERT INTO posts_reps (post_id, user_id) VALUES (?, ?)");
            $query->execute(array($rep["post_id"], $rep["user_id"]));
        }
    }
    
    function add_users ($users) {
        foreach($users as $user) {
            $query = $this->pdo->prepare("INSERT INTO users (user_id, display_name, minecraft_name, custom_head) VALUES (?, ?, ?, ?)");
            $query->execute(array($user["user_id"], $user["display_name"], $user["minecraft_name"], $user["custom_head"]));
        }
    }
    
    function get_user ($user_id) { 
        $query = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $query->execute(array(":user_id" => $user_id));
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        return $user;
    }
    
    function update_user_minecraft_name ($user_id, $minecraft_name, $custom_head) {
        $query = $this->pdo->prepare("UPDATE users SET minecraft_name = ?, custom_head = ? WHERE user_id = ?");
        $query->execute(array($minecraft_name, $custom_head, $user_id));
    }

}