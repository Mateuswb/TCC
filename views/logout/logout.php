<?php
    require_once "../../autentica/verifica_login.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Encerrar Sessão</title>

  <!-- IMPORT ICONS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <script src="../../public/assets/js/recarrega_pagina.js"></script>

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #eef1f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .logout-box {
      background: white;
      border-radius: 15px;
      box-shadow: 0px 2px 8px rgb(145, 145, 145);
      padding: 30px 30px 30px;
      text-align: center;
      width: 380px;
      position: relative;
    }

    .btn-back {
      color: #007bff;
      text-decoration: none;
      gap: 5px;
      position: absolute;
      top: 15px;
      left: 15px;
    }

    .user-photo {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
      margin-top: 20px;
      border: 3px solid #007bff;
      background-color: #f0f0f0;
    }

    h2 {
      margin: 10px 0 5px;
    }

    p {
      color: #555;
      margin-bottom: 25px;
    }

    .btn-group {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .btn {
      padding: 10px;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      color: white;
      width: 100%;
      width: 200px;
      text-align: center; 
    }

    .logout {
      background-color: #dc3545;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .logout:hover {
      background-color: #b02a37;
    }

    .link-outra-conta {
      padding-top: 15px;
      font-size: 13px;
    }

    .avatar-sub-menu{
      width: 70px;
      height: 70px;
      background-color: #0069d1;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-left: 150px;
      font-weight: 500;
      color: #fff;
      text-transform: uppercase;
      cursor: pointer;
  }
  </style>
</head>
<body>
  <div class="logout-box">
    
    <a href="listar_agendamentos.php" class="btn-back">
      <i class="fas fa-arrow-left"></i> Voltar
    </a>


    <!-- <div class="avatar-sub-menu"><?php echo $iniciais; ?></div > -->

    <!-- <h2><?php echo $_SESSION['username']; ?></h2> -->
    <p>Deseja realmente sair da sua conta?</p>

    <div class="btn-group">
      <a href="../../autentica/logout.php" class="btn logout" onclyck="logout()">Sair</a>
    </div>
  </div>
</body>
</html>
