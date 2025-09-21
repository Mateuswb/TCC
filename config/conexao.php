<?php
    try {
        $conn = new PDO("mysql:host=localhost;dbname=bd_agenda352;charset=utf8", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erro de conexão como bd: " . $e->getMessage();
        exit();
    }
?>

