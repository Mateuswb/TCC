<?php
    session_start();

    session_unset();
    session_destroy();

    $root = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\');
    header("Location: $root/views/index.php");
    exit();
?>
