<?php
  session_start();
  include '../../../../public/includes/paciente/sidebar.php';
  include '../../../../public/includes/paciente/header.php';
  include '../../../../public/includes/paciente/footer.php';
  include '../../../../public/modals/paciente/exames/modal_editar_exame.html';
  include '../../../../public/modals/paciente/exames/modal_cancelamento_exame.html';

  $idPaciente = $_SESSION['idPaciente'];

  require_once "../../../../controllers/PacienteController.php";

  $controller = new PacienteController($conn);
  $agendamentos = $controller->listarAgendamentosExame($idPaciente);
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
      <?php if (!empty($agendamentos)): ?>
        <?php foreach ($agendamentos as $agendamento): ?>
          <article class="card">
            <span class="badge">Agendado</span>
            <h3><?php echo htmlspecialchars($agendamento['nome_exame']); ?></h3>
            <h3><?php echo htmlspecialchars($agendamento['id_agendamento']); ?></h3>

            <div class="meta">
              <div><i class="fas fa-user-md"></i> Encaminhado por: <strong><?php echo htmlspecialchars($agendamento['nome_profissional']); ?></strong></div>
              <div><i class="fas fa-calendar"></i> <?php echo htmlspecialchars($agendamento['dia_agendamento'] ?? '----/--/--'); ?></div>
              <div><i class="fas fa-clock"></i> <?php echo htmlspecialchars($agendamento['horario_agendamento'] ?? '--:--'); ?></div>
            </div>

            <div class="btns">
            <button 
              class="btn editar"
              data-id-exame="<?= $agendamento['id_agendamento'] ?>"
              data-dia="<?= $agendamento['dia_agendamento'] ?>"
              data-hora="<?= $agendamento['horario_agendamento'] ?>"
              data-profissional="<?= htmlspecialchars($agendamento['nome_profissional']) ?>"

              onclick="abrirModal(this)"> 
              <i class="fa-solid fa-pencil"></i> Editar
            </button>

            <button 
              class="btn cancelar" 
              data-id="<?= $agendamento['id_agendamento'] ?>"
              onclick="abrirModalCancelar(this)">
              <i class="fa-solid fa-xmark"></i> Cancelar
            </button>

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
