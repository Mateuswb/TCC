<?php
    // Pega a pasta raiz do projeto
    $parts = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
    $root = $parts[0]; 

    define("BASE_URL", "/$root/views");
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<div class="sidebar" id="sidebar"> 
<div class="logo">
    <img src="https://i.imgur.com/o0F1W1Z.png" alt="MedHub">
</div>
<nav>
    <ul>
   <li><a href="<?= BASE_URL ?>/paciente/home.php"><i class="fa-solid fa-house"></i> Início</a></li>

    <h4>Gestão de Consultas</h4>

    <li><a href="<?= BASE_URL ?>/paciente/consultas/listar_profissionais.php"><i class="fa-solid fa-stethoscope"></i> Marcar consulta</a></li>
    <li><a href="<?= BASE_URL ?>/paciente/consultas/consultas_agendadas.php"><i class="fa-solid fa-calendar-check"></i> Consultas agendadas</a></li>
    <li><a href="<?= BASE_URL ?>/paciente/consultas/historico_consultas.php"><i class="fa-solid fa-book"></i> Histórico de consultas</a></li>

    <h4>Gestão de Exames</h4>
    <li>
    <a href="<?= BASE_URL ?>/paciente/exames/encaminhamento/listar_encaminhamentos.php">
        <i class="fa-solid fa-file-lines"></i> Encaminhamentos
    </a>
    </li>
    <li><a href="<?= BASE_URL ?>/paciente/exames/exames_agendados/listar_agendamentos.php"><i class="fa-solid fa-vial"></i> Exames agendados</a></li>
    <li><a href="<?= BASE_URL ?>/paciente/exames/historico/historico_exames.php"><i class="fa-solid fa-file-medical "></i> Histórico de exames</a></li>
    <li><a href="#"><i class="fa-solid fa-chart-column"></i> Resultado dos exames</a></li>

    </ul>
</nav>
</div>

<style>
     /* MENU LATERAL */
    .sidebar {
      width: 250px;
      background-color: #ffffff;
      border-right: 1px solid #e0e0e0;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 20px 0;
    }
    li a i {
        margin-right: 10px;
        font-size: 25px;
        color: #002a4dff;
    }

    .sidebar .logo {
      text-align: center;
      margin-bottom: 20px;
    }

    .sidebar .logo img {
      width: 120px;
    }

    .sidebar nav {
      flex: 1;
      padding-left: 20px;
    }

    .sidebar nav h4 {
      color: #003366;
      font-size: 14px;
      margin: 20px 0 8px;
      font-weight: 600;
    }

    .sidebar nav ul {
      list-style: none;

    }

    .sidebar nav ul li {
      margin: 15px 0;
    }

    .sidebar nav ul li a {
      text-decoration: none;
      color: #333;
      font-size: 15px;
      display: flex;
      align-items: center;
      padding: 8px 10px;
      border-radius: 8px;
      transition: 0.3s;
    }

    .sidebar nav ul li a:hover,
    .sidebar nav ul li a.active {
      background-color: #e6f0ff;
      color: #003366;
    }


</style>