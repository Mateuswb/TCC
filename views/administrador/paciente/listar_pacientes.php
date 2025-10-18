<?php
  include "../../../public/includes/administrador/sidebar.php"; 
  include "../../../public/includes/administrador/header.html"; 
  include "../../../public/includes/administrador/footer.php"; 

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

  <link rel="stylesheet" href="../../../public/assets/css/administrador/listar_pacientes.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../../../public/assets/alertas/alerta_exclusao_paciente.js"></script>
  <script src="../../../public/assets/alertas/alerta_padrao_pos.js"></script>
</head>

<body>

  <!-- Main -->
  <div class="main">


    <!-- Conteúdo -->
    <div class="content">
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
              <li><strong>ID:</strong> <?php echo $paciente['id_paciente']; ?></li>
              <li><strong>Observações:</strong> <?= substr($paciente['observacoes'],0,10) ?>...</li>
            </ul>

            <div class="footer">
              <a href="editar_paciente.php?idPaciente=<?php echo $paciente['id_paciente']; ?>" class="btn-edit">Editar</a>
              <a class="btn-delete"
                href="deletar.php?idPaciente=<?php echo $paciente['id_paciente']; ?>&cpf=<?php echo $paciente['cpf']; ?>"
                onclick="confirmarExclusao(this.href); return false;">
                Excluir
              </a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

  <?php
  if (isset($_GET['alerta'])) {
    if ($_GET['alerta'] == 0) {
      $tipo = 'sucesso'; $titulo = 'Atualizado'; $mensagem = 'Paciente excluído com sucesso.';
    } elseif ($_GET['alerta'] == 1) {
      $tipo = 'erro'; $titulo = 'Erro'; $mensagem = 'Erro ao excluir paciente ou bloquear conta.';
    }
    echo "<script>
      window.addEventListener('DOMContentLoaded', () => {
        alertaPadraoPos('$tipo', '$titulo', '$mensagem');
      });
    </script>";
  }
  ?>
</body>
</html>
