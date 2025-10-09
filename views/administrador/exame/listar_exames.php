<?php
    include "../../../public/includes/sidebar.php"; 
    include "cadastrar_exame.php";
    include "editar_exame.php";
    include "deletar_exame.php";
    require_once "../../../controllers/AdministradorController.php";

    $controller = new AdministradorController($conn);
    $exames = $controller->listarExames();

    $categorias = [
        'im' => 'Imagem',
        'ca' => 'Cardiologia',
        'la' => 'Laboratorial',
        'ne' => 'Neurologia',
        'ec' => 'Ecocardiograma',
    ];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Painel Administrativo</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    body {
        background: #f5f6fa;
        min-height: 100vh;
        display: flex;
    }

    .main {
        margin-left: 250px;
        flex: 1;
        display: flex;
        flex-direction: column;
        transition: margin-left 0.3s;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #085274;
        color: #fff;
        padding: 15px 30px;
    }

    .header input {
        padding: 6px 10px;
        border: none;
        border-radius: 20px;
        outline: none;
        width: 180px;
    }

    .profile {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile img {
        width: 35px;
        height: 35px;
        border-radius: 20%;
    }

    .menu-btn {
        cursor: pointer;
        font-size: 20px;
        margin-right: 15px;
    }

    .content {
        padding: 20px;
    }

    .btn-new {
        background: #4f46e5;
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-new:hover {
        background: #4338ca;
    }

    .exams-box {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .exams-box h3 {
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #searchInput {
        flex: 2;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    #filterCategoria {
        flex: 1;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .exam-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
    }

    .exam-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .exam-tags {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .tag {
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        background: #e0e7ff;
        color: #1e3a8a;
        font-weight: 500;
    }

    .time {
        font-size: 13px;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .exam-body h4 {
        margin-bottom: 5px;
        font-size: 16px;
    }

    .exam-body p {
        font-size: 14px;
        color: #374151;
        margin-bottom: 8px;
    }

    .exam-footer {
        font-size: 12px;
        color: #6b7280;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }

    .actions {
        display: flex;
        gap: 10px;
        align-items: center;
        justify-content: center;
        margin-left: auto; /* empurra os botões para a direita */
    }

    .actions i {
        cursor: pointer;
        font-size: 18px;
        padding: 8px;
        border-radius: 50%;
        transition: all 0.2s;
    }

    .actions i.fa-eye {
        background: #e0f7fa;
        color: #006064;
    }

    .actions i.fa-edit {
        background: #fff3e0;
        color: #ef6c00;
    }

    .actions i.fa-trash {
        background: #ffebee;
        color: #c62828;
    }

    .actions i:hover {
        transform: scale(1.2);
        opacity: 0.8;
    }

</style>
</head>
<body>
<div class="main">
    <div class="header">
        <div class="menu-btn"><i class="fas fa-bars"></i></div>
        <input type="text" placeholder="Pesquisar...">
        <div class="profile">
            <img src="../../../public/assets/icones/icon_admin.png" alt="user">
            <div><strong>Perfil Admin</strong><br><small>Administrador</small></div>
        </div>
    </div>

    <div class="content">
        <div class="exams-box">
            <h3>
                Exames Cadastrados
                <button class="btn-new" id="openModal"><i class="fa fa-plus"></i> Novo Exame</button>

    
            </h3>
            <div style="display:flex; gap:10px; margin-bottom:15px;">
                <input id="searchInput" type="text" placeholder="Pesquisar exame...">
                <select id="filterCategoria">
                    <option value="">Todas as Categorias</option>
                    <option value="Imagem">Imagem</option>
                    <option value="Laboratorial">Laboratorial</option>
                    <option value="Cardiologia">Cardiologia</option>
                </select>
            </div>

            <?php foreach ($exames as $exame): ?>
                <div class="exam-card">
                    <div class="exam-header">
                        <div class="exam-tags">
                            <span class="tag"><?= $categorias[$exame["categoria"]] ?></span>
                            <span class="time"><i class="fa fa-clock"></i> <?= $exame["tempo_minutos"] ?></span>
                        </div>
                        <div class="actions">
                            <!-- <i class="fa fa-eye" title="Visualizar"></i> -->
                            <i 
                                class="fa fa-edit" 
                                title="Editar"
                                data-id="<?= $exame["id_exame"] ?>"
                                data-nome="<?= $exame["nome"] ?>"
                                data-categoria="<?= $exame["categoria"] ?>"
                                data-tempo="<?= $exame["tempo_minutos"] ?>"
                                descricao="<?= $exame["descricao"] ?>"
                                onclick="abrirModal(this)">
                                </i>
                            <i class="fa fa-trash text-danger"
                                data-id="<?= $exame['id_exame'] ?>"
                                data-nome="<?= $exame['nome'] ?>"
                                onclick="abrirModalExcluir(this)"></i>
                        </div>
                    </div>
                    <div class="exam-body">
                        <h4><?= $exame["nome"] ?></h4>
                        <p><?= $exame["descricao"] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</div>
</body>
</html>
