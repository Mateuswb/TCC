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
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Histórico de Consultas</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
body { background:#f5f8fa; }

/* Wrapper geral */
.main-content  {
  margin-left: 220px;
padding: 20px;
}

.sidebar {
  position: fixed;
}



.content {
  flex: 1;
  padding: 20px;
  transition: margin-left 0.3s;
}

/* Header */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}
.header h2 { font-size:22px; color:#111; }
.header p { color:#666; font-size:14px; margin-top:5px; }
.header .actions {
  display:flex;
  gap:10px;
  margin-top:10px;
}
.header .actions button {
  border:none;
  padding:8px 16px;
  border-radius:6px;
  cursor:pointer;
  font-size:14px;
  display:flex;
  align-items:center;
  gap:5px;
}
.btn-filtro { background:#2b6cdf; color:#fff; }
.btn-export { background:#28a745; color:#fff; }

/* Search */
.search-box { margin:20px 0; }
.search-box input {
  width:100%;
  padding:10px 15px;
  border-radius:8px;
  border:1px solid #ccc;
  font-size:14px;
}


/* Summary cards */
.cards {
  display:grid;
  grid-template-columns:repeat(auto-fit, minmax(200px,1fr));
  gap:15px;
  margin-bottom:20px;
}
.card {
  background:#f0f5ff;
  border-radius:10px;
  padding:15px 20px;
}
.card.green { background:#e6f9ee; }
.card.red { background:#fde2e2; }
.card.purple { background:#f4ebff; }
.card .title { font-size:12px; color:#666; margin-bottom:5px; }
.card .value { font-size:20px; font-weight:700; color:#111; }
.card .percent { font-size:12px; color:#555; margin-top:2px; }

/* Table */
table {
  width:100%;
  border-collapse:collapse;
  background:#fff;
  border-radius:10px;
  overflow:hidden;
  box-shadow:0 2px 5px rgba(0,0,0,0.05);
}
th, td {
  padding:12px 15px;
  text-align:left;
  font-size:14px;
  border-bottom:1px solid #eee;
}
th { background:#f9f9f9; }
td .status {
  padding:4px 10px;
  border-radius:20px;
  font-size:12px;
  font-weight:600;
  display:inline-block;
  color:#fff;
}
.status.agendada { background:#4caf50; }
.status.realizada { background:#ff9800; }
.status.Cancelada { background:#f44336; }
td .actions i {
  cursor:pointer;
  margin-right:10px;
  color:#666;
  transition:color 0.2s;
}
td .actions i:hover { color:#007B8F; }

</style>
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
        <div class="percent">75.0% do total</div>
      </div>
      <div class="card red">
        <div class="title"><i class="fa fa-user"></i> Consultas Canceladas</div>
        <div class="value"><?php echo $totalCanceladas['total_canceladas'] ?></div>
        <div class="percent">10.0% do total</div>
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
