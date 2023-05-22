<?php
    spl_autoload_register(function($class){
        require "./Class/{$class}.php";
    });
?>