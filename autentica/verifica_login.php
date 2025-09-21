<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['idUsuario'])) {
        $root = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\');
        header("Location: $root/index.php");
        exit();
    }
?>