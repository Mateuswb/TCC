<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['idUsuario'])) {
        $parts = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
        $root = $parts[0]; 
        define("BASE_URL", "/$root");
        header("Location: " . BASE_URL . "/views/index.php");
        exit();
    }
?>