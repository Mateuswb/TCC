<?php
  include '../../../autentica/verifica_login.php';
  include "../../../public/includes/administrador/sidebar.php"; 
  include "../../../public/includes/administrador/header.php"; 
  include "../../../public/includes/administrador/footer.php"; 

  require "../../../public/modals/administrador/deletar_paciente.php";

  require_once "../../../controllers/AdministradorController.php";
  $controller = new AdministradorController($conn);
  $pacientes = $controller->listarPacientes();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lista de Pacientes</title>

  <!-- IMPORT DO CSS -->
  <link rel="stylesheet" href="../../../public/assets/css/administrador/listar_pacientes.css">

</head>

<body>
  <div class="main">

  <?php 
    require "../../../public/modals/administrador/edicao/editar_dados_paciente.html"; 
  ?>
  
    <div class="content">
      <?php  require '../../../public/assets/alerta/flash.php' ?>

      <h1>Lista de Pacientes</h1>

      <div class="grid-container">
        <?php foreach ($pacientes as $paciente) { ?>
          <div class="card">
            <h2><?php echo $paciente['nome']; ?></h2>
            <ul class="info-list">
              <li><strong>CPF:</strong> <?php echo $paciente['cpf']; ?></li>
              <li><strong>Email:</strong> <?php echo $paciente['email']; ?></li>
              <li><strong>Data Nasc.:</strong> <?php echo $paciente['data_nascimento']; ?></li>
              <li><strong>Telefone:</strong> <?php echo $paciente['telefone']; ?></li>
              <li><strong>Sexo:</strong> <?php echo $paciente['sexo']; ?></li>
              <li><strong>Estado Civil:</strong> <?php echo $paciente['estado_civil']; ?></li>
              <li><strong>Tipo Sanguíneo:</strong> <?php echo $paciente['tipo_sanguineo']; ?></li>
              <li><strong>Altura:</strong> <?php echo $paciente['altura']; ?></li>
              <li><strong>Peso:</strong> <?php echo $paciente['peso']; ?></li>
              <li><strong>Bairro:</strong> <?php echo $paciente['bairro']; ?></li>
              <li><strong>Cidade:</strong> <?php echo $paciente['cidade']; ?></li>
              <li><strong>Observações:</strong> <?= substr($paciente['observacoes'],0,10) ?>...</li>
            </ul>

            <div class="footer">
              <button
                class="btn-edit" 
                data-id="<?php echo $paciente['id_paciente']; ?>"
                data-nome="<?php echo $paciente['nome']; ?>"
                data-email="<?php echo $paciente['email']; ?>"
                data-data-nascimento="<?php echo $paciente['data_nascimento']; ?>"
                data-telefone=" <?php echo $paciente['telefone']; ?>"
                data-sexo="<?php echo $paciente['sexo']; ?>"
                data-estado-civil="<?php echo $paciente['estado_civil']; ?>"
                data-tipo-sanguineo="<?php echo $paciente['tipo_sanguineo']; ?>"
                data-altura="<?php echo $paciente['altura']; ?>"
                data-peso="<?php echo $paciente['peso']; ?>"
                data-bairro="<?php echo $paciente['bairro']; ?>"
                data-cidade="<?php echo $paciente['cidade']; ?>"
                data-numero-casa="<?php echo $paciente['numero_casa']; ?>"
                data-endereco="<?php echo $paciente['endereco']; ?>"
                data-observacoes="<?php echo $paciente['observacoes']; ?>"
                onclick="abrirModalEditar(this)">
                Editar
              </button>

              <button 
                class="btn-delete" 
                data-id="<?php echo $paciente['id_paciente']; ?>"
                data-cpf="<?php echo $paciente['cpf']; ?>"
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
