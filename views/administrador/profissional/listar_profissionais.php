<?php
  include "../../../public/includes/administrador/sidebar.php"; 
  include "../../../public/includes/administrador/header.html"; 
  include "../../../public/includes/administrador/footer.php";
  
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

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../../../public/assets/alertas/alerta_exclusao_profissional.js"></script>
  <script src="../../../public/assets/alertas/alerta_padrao_pos.js"></script>

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

    /* Main */
    .main {
      margin-left: 250px;
      flex: 1;
      display: flex;
      flex-direction: column;
      margin-top: 50px;
      margin-bottom: 100px;
    }

    .sidebar.collapsed ~ .main {
      margin-left: 80px;
    }


    /* Conteúdo */
    .content {
      padding: 30px;
    }

    h1 {
      color: #2980b9;
      text-align: center;
      margin-bottom: 30px;
      font-weight: 700;
    }

    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 25px;
    }

    .card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: 0.25s ease;
    }

    .card:hover {
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      transform: translateY(-4px);
    }

    .card h2 {
      margin: 0 0 14px 0;
      font-size: 20px;
      color: #2980b9;
      border-bottom: 2px solid #2980b9;
      padding-bottom: 6px;
    }

    .info-list {
      list-style: none;
      margin: 0 0 15px 0;
      padding: 0;
      font-size: 15px;
      color: #333;
      line-height: 1.5;
    }

    .info-list li strong {
      width: 140px;
      display: inline-block;
      color: #085274;
    }

    .footer {
      text-align: right;
    }

    .btn-edit, .btn-delete {
      background-color: #2980b9;
      color: white;
      border: none;
      padding: 8px 14px;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      transition: 0.3s;
      margin-left: 10px;
    }

    .btn-edit:hover {
      background-color: #1f6391;
    }

    .btn-delete {
      background-color: #c0392b;
    }

    .btn-delete:hover {
      background-color: #b12e22;
    }
  </style>
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
              <a href='editar_profissional.php?idProfissional=<?php echo $profissional['id_profissional']; ?>' class="btn-edit">Editar</a>
              <a class="btn-delete"
                href="excluir.php?idProfissional=<?php echo $profissional['id_profissional']; ?>&cpf=<?php echo $profissional['id_profissional']; ?>"
                onclick="confirmarExclusaoProfissional(this.href); return false;">
                Excluir
              </a>
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
