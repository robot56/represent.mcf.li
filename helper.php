<?php

    function preint_r ($array)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
    
    function id_to_key ($array, $key = false, $multi_key = false) {
        if(empty($array) || !is_array($array))
            return false;
        
        foreach($array as $item) {
            if($key) {
                if($multi_key) {
                    $items[$item[$key]][$item[$multi_key]] = $item;
                } else {
                    $items[$item[$key]] = $item;
                }
            } else {
                $items[$item] = $item;
            }
        }
        return $items;
    }
    
    function select_value_from_array ($array, $find_key, $find_value) {
        foreach($array as $key => $value) {
            if($value[$find_key] == $find_value)
                $return_array[$key] = $value;
        }
        return $return_array;
    }
    
    // preparse
    // get it, it's a pun, PREPARE a string for regex PARSING
    function preparse($string) {
        return str_replace(array("\n", "\r", "\t", "\0", "\x0B"), "", $string);
    }