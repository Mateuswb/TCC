<?php 
    include '../../../autentica/verifica_login.php';
    include '../../../public/includes/profissional/sidebar.php'; 
    include '../../../public/includes/profissional/header.php';
    include '../../../public/includes/profissional/footer.html';
    include '../../../controllers/RelatorioController.php'; 

    #modals
    include '../../../public/modals/profissional/consultas/detalhes_consulta.html';

    $idProfissional = $_SESSION['idProfissional'];
    $controllerRelatorio = new RelatorioController($conn);
    $consultas = $controllerRelatorio->listarAgendamentosProfissional($idProfissional);

    $totalAgendamentos = $controllerRelatorio->totalAgendamentosProfissional($idProfissional);
    $totalConcluidas = $controllerRelatorio->totalAgendamentosConcluidas($idProfissional);
    $totalCanceladas = $controllerRelatorio->totalAgendamentosCanceladas($idProfissional);

    $percentConcluidas = $totalAgendamentos['total_agendamentos'] > 0 
    ? round(($totalConcluidas['total_concluidas'] / $totalAgendamentos['total_agendamentos']) * 100, 1)
    : 0;

    $percentCanceladas = $totalAgendamentos['total_agendamentos'] > 0
    ? round(($totalCanceladas['total_canceladas'] / $totalAgendamentos['total_agendamentos']) * 100, 1)
    : 0;

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Histórico de Consultas</title>

  <!-- IMPORT DO CSS-->
  <link rel="stylesheet" href="../../../public/assets/css/profissional/historico_consultas.css">

</head>
<body>

<div class="main-content">
  <div class="content">

    <div class="search-box">
      <input type="text" placeholder="Pesquisar por paciente...">
    </div>

    <!-- Cards -->
    <div class="cards">
      <div class="card">
        <div class="title"><i class="fa fa-calendar"></i> Total de Agendametnos</div>
        <div class="value"><?php echo $totalAgendamentos['total_agendamentos'] ?></div>
        <div class="percent">Em toto o período</div>
      </div>
      <div class="card green">
        <div class="title"><i class="fa fa-clock"></i> Agendamentos Concluídos</div>
        <div class="value"><?php echo $totalConcluidas['total_concluidas'] ?></div>
        <div class="percent"><?php echo $percentConcluidas; ?> % do total</div>
      </div>
      <div class="card red">
        <div class="title"><i class="fa fa-user"></i> Agendamentos Cancelados</div>
        <div class="value"><?php echo $totalCanceladas['total_canceladas'] ?></div>
        <div class="percent"><?php echo $percentCanceladas; ?> % do total</div>
      </div>

    </div>

    <table>
      <thead>
        <tr>
          <th>Data</th>
          <th>Horário</th>
          <th>Paciente</th>
          <th>Tipo</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php  foreach($consultas as $consulta){ ?>

        <tr>
          <td><?= $consulta['dia_agendamento']; ?></td>
          <td><?= $consulta['horario_agendamento']; ?></td>
          <td><?= $consulta['nome_paciente']; ?></td>
          <td>
              <?= $consulta['tipo'] == 'c' ? 'Consulta' : ($consulta['tipo'] == 'r' ? 'Reconsulta' : 'Exame') ?>
          </td>
          <td>
              <span class="status <?= $consulta['status']; ?>">
                  <?= ucfirst($consulta['status']); ?>
              </span>
          </td>


         <td id="actions"
            class="consulta-item"
            data-dia="<?= htmlspecialchars($consulta['dia_agendamento']) ?>"
            data-hora="<?= htmlspecialchars($consulta['horario_agendamento']) ?>"
            data-paciente="<?= htmlspecialchars($consulta['nome_paciente']) ?>"
            data-tipo="<?= htmlspecialchars(
                $consulta['tipo'] == 'c' ? 'Consulta' : 
                ($consulta['tipo'] == 'r' ? 'Reconsulta' : 
                ($consulta['tipo'] == 'e' ? 'Exame: ' . $consulta['nome_exame'] : '-'))
            ) ?>"
            data-status="<?= htmlspecialchars($consulta['status']) ?>"
            data-observacoes="<?= htmlspecialchars($consulta['observacoes']) ?>"
            data-anexo="<?= !empty($consulta['anexo']) ? 'data:application/pdf;base64,' . base64_encode($consulta['anexo']) : '' ?>">
            <i class="fas fa-eye"></i>
        </td>

        </tr>
      <?php } ?>
      </tbody>
    </table>

  </div>
</div>
</body>
</html>

