<?php
  include "../../../public/includes/administrador/sidebar.php"; 
  include "../../../public/includes/administrador/header.html"; 
  include "../../../public/includes/administrador/footer.php";

  include "../../../public/modals/administrador/edicao/editar_dados_profissional.html";
  
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

  <link rel="stylesheet" href="../../../public/assets/css/administrador/listar_profissionais.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../../../public/assets/alertas/alerta_exclusao_profissional.js"></script>
  <script src="../../../public/assets/alertas/alerta_padrao_pos.js"></script>

</head>
<body>
  <!-- Sidebar já incluída -->
  
  <!-- Main -->
  <div class="main">
    <!-- Header -->
    

    <!-- Conteúdo -->
    <div class="content">
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
              <li><strong>Obs:</strong> <?php echo $profissional['observacoes']; ?></li>
            </ul>
            <div class="footer">

              <button
                class="btn-edit" 
                data-id="12"
                data-nome="João da Silva Santos"
                data-rg="98.675.678-76"
                data-email="joaosilvasantos@gmail.com"
                data-data-nascimento="21/12/1998"
                data-crm="CRM/SP 123456"
                data-especialidade="Cardiologia"
                data-telefone="(48) 99897-8788"
                data-sexo="Masculino"
                data-estado-civil="Casado"
                data-endereco="Rua das Palmeiras, nº 125"
                data-bairro="Jardim Esperança"
                data-numero="Nº 125"
                data-cidade="Florença"
                data-observacoes="Especialista em cirurgias de coração."
                onclick="abrirModalEditar(this)">
                Editar
              </button>

              <!-- <a class="btn-delete"
                href="excluir.php?idProfissional=<?php echo $profissional['id_profissional']; ?>&cpf=<?php echo $profissional['id_profissional']; ?>"
                onclick="confirmarExclusaoProfissional(this.href); return false;">
                Excluir
              </a> -->
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("collapsed");
    }
  </script>

  <?php
    if (isset($_GET['alerta'])) {
      if ($_GET['alerta'] == 0) {
          $tipo = 'sucesso';
          $titulo = 'Atualizado';
          $mensagem = 'Profissional excluído e conta desativada com sucesso.';
      } elseif ($_GET['alerta'] == 1) {
          $tipo = 'erro';
          $titulo = 'Erro';
          $mensagem = 'Erro ao excluir profissional ou desativar conta.';
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
