<?php 
    session_start();
    include '../../../public/includes/profissional/sidebar.php'; 
    include '../../../controllers/RelatorioController.php'; 

    $idProfissional = $_SESSION['idProfissional'];

    $controllerRelatorio = new RelatorioController($conn);
    $consultas = $controllerRelatorio->listarConsultas($idProfissional);

    $totalAgendamentos = $controllerRelatorio->totalConsultasProfissional($idProfissional);
    $totalConcluidas = $controllerRelatorio->totalConsultasConcluidas($idProfissional);
    $totalCanceladas = $controllerRelatorio->totalConsultasCanceladas($idProfissional);

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

  <!-- STYLE  CSS-->
  <link rel="stylesheet" href="../../../public/assets/css/profissional/historico_consultas.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


</head>
<body>

<div class="main-content">

  <!-- Sidebar já incluído acima -->

  <!-- Conteúdo principal -->
  <div class="content">

    <!-- Header -->
    <div class="header">
      <div>
        <h2>Histórico de Consultas</h2>
        <p>Visualize e gerencie todo o histórico de atendimentos realizados</p>
      </div>
      <div class="actions">
        <button class="btn-filtro"><i class="fas fa-filter"></i> Filtros Avançados</button>
        <button class="btn-export"><i class="fas fa-file-csv"></i> Exportar CSV</button>
      </div>
    </div>

    <!-- Search -->
    <div class="search-box">
      <input type="text" placeholder="Pesquisar por paciente...">
    </div>

    <!-- Summary Cards -->
    <div class="cards">
      <div class="card">
        <div class="title"><i class="fa fa-calendar"></i> Total de Consultas</div>
        <div class="value"><?php echo $totalAgendamentos['total_agendamentos'] ?></div>
        <div class="percent">No período selecionado</div>
      </div>
      <div class="card green">
        <div class="title"><i class="fa fa-clock"></i> Consultas Concluídas</div>
        <div class="value"><?php echo $totalConcluidas['total_concluidas'] ?></div>
        <div class="percent"><?php echo $percentConcluidas; ?></div>
      </div>
      <div class="card red">
        <div class="title"><i class="fa fa-user"></i> Consultas Canceladas</div>
        <div class="value"><?php echo $totalCanceladas['total_canceladas'] ?></div>
        <div class="percent"><?php echo $percentCanceladas; ?></div>
      </div>
      <div class="card purple">
        <div class="title"><i class="fa fa-chart-line"></i> Total de atendimentos</div>
        <div class="value">R$ 2.570,00</div>
        <div class="percent">Consultas concluídas</div>
      </div>
    </div>

    <!-- Table -->
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
          <td><?php echo $consulta['dia_agendamento']; ?></td>
          <td><?php echo $consulta['horario_agendamento']; ?></td>
          <td><?php echo $consulta['nome_paciente']; ?></td>
          <td>
            <?php 
              if ($consulta['tipo_consulta'] == 'c') {
                  echo 'Consulta';
              } elseif ($consulta['tipo_consulta'] == 'r') {
                  echo 'Reconsulta';
              } else {
                  echo '-';
              }
            ?>
          </td>

          <td><span class="status <?php echo $consulta['status']; ?>"><?php echo $consulta['status']; ?></span></td>
          <td class="actions"><i class="fas fa-eye"></i><i class="fas fa-edit"></i></td>
        </tr>
        <tr>
      <?php } ?>
      </tbody>
    </table>

  </div> <!-- fim content -->

</div> <!-- fim wrapper -->

</body>
</html>
