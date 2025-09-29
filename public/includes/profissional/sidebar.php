<?php
    // Pega a pasta raiz do projeto
    $parts = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
    $root = $parts[0]; 

    define("BASE_URL", "/$root/views");
?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="sidebar" id="sidebar">
  <h2>Meu Painel</h2>

    <a href="<?= BASE_URL ?>/profissional/home.php">
        <i class="fas fa-home"></i> <span>Home</span>
    </a>
    <a href="<?= BASE_URL ?>/profissional/agendamentos/consultas.php">
        <i class="fas fa-calendar-check"></i> <span>Meus Agendamentos </span>
    </a>

    <a href="<?= BASE_URL ?>/profissional/paciente/listar_pacientes.php">
      <i class="fas fa-user-injured"></i> <span>Pacientes </span>
    </a>
       <a href="<?= BASE_URL ?>/profissional/historico_consultas/listar_consultas.php">
        <i class="fas fa-history"></i> <span>Histórico de Consultas</span>
    </a>
        <a href="<?= BASE_URL ?>/profissional/agendamentos/consultas.php">
        <i class="fas fa-file-alt"></i> <span>Relatórios</span>
    </a>

    </a>
        <a href="<?= BASE_URL ?>/profissional/horarios/listar_horarios.php">
        <i class="fas fa-file-alt"></i> <span>Horários</span>
    </a>
        <a href="<?= BASE_URL ?>/profissional/perfil.php">
        <i class="fa-solid fa-user"></i> <span>Perfil</span>

    <a href="<?= BASE_URL ?>/logout/logout.php" class="logout">
        <i class="fas fa-sign-out-alt"></i> <span>Sair</span>
    </a>

</div>

<style>

  /* Sidebar */
    .sidebar {
        width: 250px;
        background: #073a52ff;
        color: #fff;
        height: 100vh;
        padding: 10px;
        
    }

    .sidebar a.logout {
        background: #ef4444;
        color: #fff;
        padding: 10px 15px;
        text-align: center;
        border-radius: 5px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 50%;
    }
    .sidebar a.logout:hover {
        background: #fc3636ff; /* vermelho */

    }
    .sidebar.collapsed {
    width: 80px;
    }

    .sidebar h2 {
    margin-bottom: 30px;
    font-size: 20px;
    text-align: center;
    transition: 0.3s;
    }

    .sidebar.collapsed h2 {
    opacity: 0;
    }

    .sidebar a {
    display: flex;
    align-items: center;
    gap: 20px;
    color: #cbd5e1;
    text-decoration: none;
    padding: 17px 15px;
    border-radius: 8px;
    margin-bottom: 8px;
    transition: 0.2s;
    white-space: nowrap;
    }

    .sidebar.collapsed a span {
    display: none;
    }

    .sidebar a:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    }

</style>
