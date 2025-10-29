<?php
    include '../../../autentica/verifica_login.php';

    include "../../../public/modals/administrador/cadastrar_exame.php";
    include "../../../public/modals/administrador/editar_exame.php";
    include "../../../public/modals/administrador/deletar_exame.php";
    require_once "../../../controllers/AdministradorController.php";
    
    include "../../../public/includes/administrador/sidebar.php"; 
    include "../../../public/includes/administrador/header.php"; 
    include "../../../public/includes/administrador/footer.php"; 

    $controller = new AdministradorController($conn);
    $exames = $controller->listarExames();

    $categorias = [
        'Sa' => 'Sangue',
        'Im' => 'Imagem',
        'Ca' => 'Cardiológicos',
        'Ur' => 'Urina',
        'Ho' => 'Hormonais',
        'In' => 'Infecciosos',
        'Re' => 'Respiratórios'
    ];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Painel Administrativo</title>

    <!-- IMPORT DO CSS -->
    <link rel="stylesheet" href="../../../public/assets/css/administrador/listar_exames.css">

</head>
<body>
<div class="main">
    <?php  include '../../../public/assets/alerta/flash.php' ?>
    
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
                            <span class="time"><i class="fa fa-clock"></i> <?= $exame["tempo_minutos"] ?> min</span>
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
                                data-descricao="<?= $exame["descricao"] ?>"
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

