<?php
  session_start();
  include '../../../../public/includes/paciente/sidebar.php';
  include '../../../../public/includes/paciente/header.php';
  include '../../../../public/includes/paciente/footer.php';

  require_once "../../../../controllers/RelatorioController.php";

  $idPaciente = $_SESSION['idPaciente'];

  $controller = new RelatorioController($conn);

  $totalExames = $controller->totalExamesPaciente($idPaciente);
  $exameMaisComum = $controller->exameMaisRecorrente($idPaciente);
  $totalExamesCancelados = $controller->totalExamesCancelados($idPaciente);
?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>MedHub — Histórico de Exames</title>

  <!-- STYLE  CSS-->
  <link rel="stylesheet" href="../../../../public/assets/css/paciente/exames/historico_exames.css">

  <!-- Fonte e ícones -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
   rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>
  <main class="conteudo-principal">
  <div class="titulo-pagina">
    <h1>Histórico de Exames</h1>
  </div>

  <!-- Indicadores -->
  <div class="indicadores">
    <div class="card-indicador azul">
      <i class="fa-solid fa-file-medical"></i>
      <div>
        <p>Total de Exames já efetuados</p>
        <h2><?php echo $totalExames ?></h2>
      </div>
    </div>

    <div class="card-indicador cinza">
      <i class="fa-solid fa-flask"></i>
      <div>
        <p>Exame mais recorrente</p>
        <h2><?php echo $exameMaisComum ?></h2>
      </div>
    </div>

    <div class="card-indicador vermelho">
      <i class="fa-solid fa-ban"></i>
      <div>
        <p>Total de Exames Cancelados</p>
        <h2><?php echo $totalExamesCancelados ?></h2>
      </div>
    </div>
  </div>

  <!-- Cards dos exames -->
  <div class="cards-exames">
    <!-- Exame 1 -->
    <div class="card-exame">
      <div class="header-card">
        <h3>Hemograma Completo</h3>
        <span class="status realizado">Realizado</span>
      </div>
      <p class="categoria">Sangue</p>
      <p class="data">Exame realizado em: <strong>2025-08-01</strong> às <strong>10:30</strong></p>
      <div class="acoes">
        <button class="btn-ver">Ver detalhes</button>
        <button class="btn-baixar">Baixar Resultado</button>
      </div>
    </div>

    <!-- Exame 2 -->
    <div class="card-exame">
      <div class="header-card">
        <h3>Ressonância Magnética</h3>
        <span class="status realizado">Realizado</span>
      </div>
      <p class="categoria">Imagem</p>
      <p class="data">Exame realizado em: <strong>2025-07-03</strong> às <strong>09:00</strong></p>
      <div class="acoes">
        <button class="btn-ver">Ver detalhes</button>
        <button class="btn-baixar">Baixar Resultado</button>
      </div>
    </div>

    <!-- Exame 3 -->
    <div class="card-exame">
      <div class="header-card">
        <h3>Endoscopia Digestiva</h3>
        <span class="status cancelado">Cancelado</span>
      </div>
      <p class="categoria">Clínico</p>
      <p class="data">Exame cancelado em: <strong>2025-09-15</strong> às <strong>11:00</strong></p>
      <div class="acoes">
        <button class="btn-ver">Ver detalhes</button>
      </div>
    </div>
  </div>
</main>

</body>
</html>
