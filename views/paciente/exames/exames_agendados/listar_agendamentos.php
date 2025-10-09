<?php
  session_start();
  include '../../../../public/includes/paciente/sidebar.php';
  include '../../../../public/includes/paciente/header.php';
  include '../../../../public/includes/paciente/footer.php';

  $idPaciente = $_SESSION['idPaciente'];

  require_once "../../../../controllers/EncaminhamentoController.php";

  $controller = new EncaminhamentoController($conn);
  $encaminhamentos = $controller->listarEncaminhamentosPorPaciente($idPaciente);
?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>MedHub — Exames Agendados</title>

  <!-- STYLE  CSS-->
  <link rel="stylesheet" href="../../../../public/assets/css/paciente/exames/lista_agendamentos.css">

  <!-- Fonte e ícones -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
   rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>
  <main>
    <h1>Exames Agendados</h1>

    <section class="cards" aria-live="polite" id="cardsContainer">
      <?php if (!empty($encaminhamentos)): ?>
        <?php foreach ($encaminhamentos as $p): ?>
          <article class="card">
            <span class="badge">Agendado</span>
            <h3><?php echo htmlspecialchars($p['exame']); ?></h3>

            <div class="meta">
              <div><i class="fas fa-user-md"></i> Encaminhado por: <strong><?php echo htmlspecialchars($p['profissional_encaminhou']); ?></strong></div>
              <div><i class="fas fa-calendar"></i> <?php echo htmlspecialchars($p['data_exame'] ?? '----/--/--'); ?></div>
              <div><i class="fas fa-clock"></i> <?php echo htmlspecialchars($p['hora_exame'] ?? '--:--'); ?></div>
            </div>

            <div class="btns">
                <!-- colocar o id aqqqqq -->
              <a class="btn btn-primary" href="editar.php?id=">Editar Dados do Exame</a>
              <a class="btn btn-danger" href="cancelar.php?id=">Cancelar</a>
            </div>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align:center;color:var(--muted);font-size:15px;">Nenhum exame agendado no momento.</p>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>
