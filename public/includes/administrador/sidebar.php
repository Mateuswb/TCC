<?php
    include 'config.php';

    $currentFile = basename($_SERVER['PHP_SELF']); 
?>

<div class="sidebar" id="sidebar">
    <h2>ClinicAdmin</h2>

    <a href="<?= BASE_URL ?>/views/administrador/home.php"
        class="<?= ($currentFile == 'home.php') ? 'active' : '' ?>">
        <i class="fas fa-home"></i> <span>Home</span>
    </a>

    <a href="<?= BASE_URL ?>/views/administrador/cadastrar/cadastrar.php"
        class="<?= ($currentFile == 'cadastrar.php') ? 'active' : '' ?>">
        <i class="fas fa-user-plus"></i> <span>Cadastrar Usuário</span>
    </a>

    <a href="<?= BASE_URL ?>/views/administrador/exame/listar_exames.php" 
        class="<?= ($currentFile == 'listar_exames.php') ? 'active' : '' ?>">
        <i class="fas fa-user-plus"></i> <span>Exames</span>
    </a>
    <a href="<?= BASE_URL ?>/views/administrador/profissional/listar_profissionais.php"
        class="<?= ($currentFile == 'listar_profissionais.php') ? 'active' : '' ?>">
        <i class="fas fa-user-md"></i> <span>Profissionais</span>
    </a>
    <a href="<?= BASE_URL ?>/views/administrador/paciente/listar_pacientes.php"
        class="<?= ($currentFile == 'listar_pacientes.php') ? 'active' : '' ?>">
        <i class="fas fa-user-injured"></i> <span>Pacientes</span>
    </a>
    <a href="<?= BASE_URL ?>/views/administrador/agendamento/agendamentos.php"
        class="<?= ($currentFile == 'agendamentos.php') ? 'active' : '' ?>">
        <i class="fas fa-calendar-check"></i> <span>Agendamentos</span>
    </a>

    <a href="<?= BASE_URL ?>/views/administrador/usuario/listar_usuarios.php"
        class="<?= ($currentFile == 'listar_usuarios.php') ? 'active' : '' ?>">
        <i class="fas fa-vials"></i> <span>Usuários</span>
    </a>
    <a href="<?= BASE_URL ?>"
        class="<?= ($currentFile == '') ? 'active' : '' ?>">
        <i class="fas fa-vials"></i> <span>Relatórios</span>
    </a>

    <a href="<?= BASE_URL ?>/views/logout/logout.php" class="logout">
        <i class="fas fa-sign-out-alt"></i> <span>Sair</span>
    </a>
</div>

<style>
  .sidebar {
    width: 250px;
    background: #09275E;
    color: #fff;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    padding: 20px;
    overflow: hidden;
}

.sidebar a.logout {
    position: absolute;
    bottom: 40px;      
    left: 20px;        
    right: 20px;       
    background: #e6000b;
    color: #fff;
    padding: 10px 15px;
    text-align: center;
    border-radius: 5px;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sidebar a.logout:hover {
    background: #ac0009;
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
i{
    margin-right: 5px;
    font-size: 20px;
}

.sidebar a {
display: flex;
align-items: center;
gap: 15px;
color: #f7fbff;
text-decoration: none;
padding: 17px 15px;
font-weight: 510;
border-radius: 8px;
margin-bottom: 8px;
transition: 0.2s;
white-space: nowrap;
}

.sidebar.collapsed a span {
display: none;
}

.sidebar a:hover,
.sidebar  a.active {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
}
</style>