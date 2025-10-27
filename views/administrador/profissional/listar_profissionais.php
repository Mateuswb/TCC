<?php
  session_start();
  require "../../../public/includes/administrador/sidebar.php"; 
  require "../../../public/includes/administrador/header.php"; 
  require "../../../public/includes/administrador/footer.php";
  require "../../../public/modals/administrador/deletar_profissional.php";
  
  require_once "../../../controllers/AdministradorController.php";
  $controller = new AdministradorController($conn);
  $profissionais = $controller->listarProfissionais();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lista de Profissionais</title>

  <!-- IMPORT DO CSS -->
  <link rel="stylesheet" href="../../../public/assets/css/administrador/listar_profissionais.css">

</head>
<body>
  <div class="main">
    <?php
        require "../../../public/modals/administrador/edicao/editar_dados_profissional.html";
    ?>

    <div class="content">
      <?php
      include '../../../public/assets/alerta/flash.php';
      ?>
      <h1>Lista de Profissionais</h1>
      <div class="grid-container">
        <?php foreach($profissionais as $profissional) { ?>
          <div class="card">
            <h2><?php echo $profissional['nome']; ?></h2>
            <ul class="info-list">
              <li><strong>CPF:</strong> <?php echo $profissional['cpf']; ?></li>
              <li><strong>RG:</strong> <?php echo $profissional['rg']; ?></li>
              <li><strong>Email:</strong> <?php echo $profissional['email']; ?></li>
              <li><strong>Nascimento:</strong> <?php echo $profissional['data_nascimento']; ?></li>
              <li><strong>Telefone:</strong> <?php echo $profissional['telefone']; ?></li>
              <li><strong>Sexo:</strong> <?php echo $profissional['sexo']; ?></li>
              <li><strong>Estado Civil:</strong> <?php echo $profissional['estado_civil']; ?></li>
              <li><strong>CRM:</strong> <?php echo $profissional['crm_crp']; ?></li>
              <li><strong>Especialidade:</strong> <?php echo $profissional['especialidade']; ?></li>
              <li><strong>Nº Casa:</strong> <?php echo $profissional['numero_casa']; ?></li>
              <li><strong>Bairro:</strong> <?php echo $profissional['bairro']; ?></li>
              <li><strong>Cidade:</strong> <?php echo $profissional['cidade']; ?></li>  
              <li><strong>Endereço:</strong> <?php echo $profissional['endereco']; ?></li>
              <li><strong>Obs:</strong> <?php echo $profissional['observacoes']; ?></li>
            </ul> 
            <div class="footer">

              <button
                class="btn-edit" 
                data-id="<?php echo $profissional['id_profissional']; ?>"
                data-nome="<?php echo $profissional['nome']; ?>"
                data-rg=" <?php echo $profissional['rg']; ?>"
                data-email="<?php echo $profissional['email']; ?>"
                data-data-nascimento="<?php echo $profissional['data_nascimento']; ?>"
                data-crm=" <?php echo $profissional['crm_crp']; ?>"
                 data-especialidades="<?= json_encode($profissional['especialidade'])?>"
                data-telefone=" <?php echo $profissional['telefone']; ?>"
                data-sexo="<?php echo $profissional['sexo']; ?>"
                data-estado-civil="<?php echo $profissional['estado_civil']; ?>"
                data-endereco="<?php echo $profissional['endereco']; ?>"
                data-bairro="<?php echo $profissional['bairro']; ?>"
                data-numero="<?php echo $profissional['numero_casa']; ?>"
                data-cidade="<?php echo $profissional['cidade']; ?>"
                data-observacoes="<?php echo $profissional['observacoes']; ?>"
                onclick="abrirModalEditar(this)">
                Editar
              </button>

              <button 
                class="btn-delete" 
                data-id="<?php echo $profissional['id_profissional']; ?>"
                data-cpf="<?php echo $profissional['cpf']; ?>"
                onclick="abrirModalExclusao(this)">
                Excluir
              </button>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</body>
</html>
