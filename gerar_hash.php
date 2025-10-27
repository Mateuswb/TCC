<?php
    $senha = "79515538084";
    $hash = password_hash($senha, PASSWORD_DEFAULT);
    echo $hash;
?>