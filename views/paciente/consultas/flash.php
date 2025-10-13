<?php

           if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    // Remove a mensagem da sessão para não repetir
    unset($_SESSION['flash']);
    
    // Define a classe de acordo com o tipo
    $class = $flash['type'] === 'success' ? 'flash-success' : 'flash-error';
    echo "<div class='{$class}'>{$flash['message']}</div>";
  }
?>