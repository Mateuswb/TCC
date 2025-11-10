<?php
    $parts = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
    $root = $parts[0]; 

    define("BASE_URL", "/$root");
?>
