<?php
    // Pega a pasta raiz do projeto
    $parts = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
    $root = $parts[0]; 

    define("BASE_URL", "/$root");
?>
