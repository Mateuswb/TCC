<?php
    // Pega a pasta raiz do projeto
    $parts = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
    $root = $parts[0]; 

    define("BASE_URL", "/$root/views");
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/../public/assets/css/sidebar.css">

<div class="sidebar" id="sidebar">
    <h2>ClinicAdmin</h2>

    <a href="<?= BASE_URL ?>/administrador/home.php">
        <i class="fas fa-home"></i> <span>Home</span>
    </a>

    <a href="<?= BASE_URL ?>/administrador/cadastrar/cadastrar.php">
        <i class="fas fa-user-plus"></i> <span>Cadastrar Usuário</span>
    </a>

    <a href="<?= BASE_URL ?>/administrador/exame/listar_exames.php">
        <i class="fas fa-user-plus"></i> <span>Exames</span>
    </a>
    <a href="<?= BASE_URL ?>/administrador/profissional/listar_profissionais.php">
        <i class="fas fa-user-md"></i> <span>Profissionais</span>
    </a>
    <a href="<?= BASE_URL ?>/administrador/paciente/listar_pacientes.php">
        <i class="fas fa-user-injured"></i> <span>Pacientes</span>
    </a>
    <a href="<?= BASE_URL ?>/administrador/agendamento/consultas.php">
        <i class="fas fa-calendar-check"></i> <span>Consultas Agendadas</span>
    </a>
    <a href="<?= BASE_URL ?>/administrador/exame/listar_exames.php">
        <i class="fas fa-vials"></i> <span>Exames Agendados</span>
    </a>
    <a href="<?= BASE_URL ?>/administrador/usuario/listar_usuarios.php">
        <i class="fas fa-vials"></i> <span>Usuarios</span>
    </a>

    <a href="<?= BASE_URL ?>/logout/logout.php" class="logout">
        <i class="fas fa-sign-out-alt"></i> <span>Sair</span>
    </a>
</div>