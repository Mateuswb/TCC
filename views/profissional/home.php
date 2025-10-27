<?php
    session_start();
    $idProfissional = $_SESSION['idProfissional'];
    include '../../public/includes/profissional/sidebar.php';
    include '../../public/includes/profissional/header.php';
    include '../../public/includes/profissional/footer.html';
    require_once '../../controllers/RelatorioController.php';
    
    $controller = new RelatorioController($conn);
    $agendamentosHoje = $controller->agendamentosHoje($idProfissional);
    $agendamentosMes = $controller->agendamentosMes($idProfissional);
    $totalConsultasRetorno = $controller->totalConsultasRetorno($idProfissional);
    $cancelamentos = $controller->cancelamentos($idProfissional);
    $principalDiaAgendamento = $controller->principalDiaAgendamento($idProfissional);
    $principalHoraAgendamento = $controller->principalHoraAgendamento($idProfissional);
    $novosPacientesMes = $controller->novosPacientesMes($idProfissional);
    $totalPacientes = $controller->totalPacientesPorProfissional($idProfissional);

?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Dashboard - HealthEase (Clone)</title>

  <!-- STYLE  CSS-->
  <link rel="stylesheet" href="../../public/assets/css/profissional/home.css">


  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
  <div class="app">

    <!-- main -->
    <main class="main">
      <!-- top cards -->
      <div class="top-grid">
        <div class="card">
          <div class="left"><small>Agendamentos Hoje</small><strong> <?php echo $agendamentosHoje ?> </strong></div>
          <div class="icon blue"><i class="fa-solid fa-sitemap"></i></div>
        </div>

        <div class="card">
          <div class="left"><small>Total de agendamentos do mês</small><strong> <?php echo $agendamentosMes ?></strong></div>
          <div class="icon green"><i class="fa-solid fa-user-md"></i></div>
        </div>

        <div class="card">
          <div class="left"><small>Total de consultas de retorno</small><strong> <?php echo $totalConsultasRetorno ?></strong></div>
          <div class="icon blue"><i class="fa-solid fa-user"></i></div>
        </div>

        <div class="card">
          <div class="left"><small>Taxa de cancelamento</small><strong> <?php echo $cancelamentos ?></strong></div>
          <div class="icon yellow"><i class="fa-solid fa-calendar-check"></i></div>
        </div>

        <div class="card">
          <div class="left"><small>Principal dia de agendamento</small><strong> <?php echo $principalDiaAgendamento ?></strong></div>
          <div class="icon yellow"><i class="fa-solid fa-file-lines"></i></div>
        </div>

        <div class="card">
          <div class="left"><small>Horarios com maior concentração de agendamentos</small><strong> <?php echo $principalHoraAgendamento ?></strong></div>
          <div class="icon blue"><i class="fa-solid fa-receipt"></i></div>
        </div>

        <div class="card">
          <div class="left"><small>Total de novos pacientes do mês</small><strong> <?php echo $novosPacientesMes ?></strong></div>
          <div class="icon green"><i class="fa-solid fa-prescription"></i></div>
        </div>

        <div class="card">
          <div class="left"><small>Total de pacientes</small><strong><?php echo $totalPacientes; ?></strong></div>
          <div class="icon blue"><i class="fa-solid fa-credit-card"></i></div>
        </div>
      </div>

      <!-- content row: chart + right panel -->
      <div class="content-row">
        <section class="chart-card">
          <h3>Gráfico de consultas</h3>
          <canvas id="barChart" style="max-height:360px;"></canvas>
        </section>

        <aside class="right-panel">
          <div style="display:flex;justify-content:space-between;align-items:center">
            <div>
              <div style="font-size:14px;color:#4b5563;font-weight:600">Comparação</div>
              <div class="small-muted" style="margin-top:2px">Essa semana</div>
              <div style="margin-top:6px">
                <span style="display:inline-block;background:#0d6efd;color:#fff;padding:4px 8px;border-radius:6px;font-size:13px">relaorio vai aq depois</span>
              </div>
            </div>
          </div>

          <div class="donut-row">
            <div class="donut-box">
              <canvas id="donut1" width="140" height="140"></canvas>
            </div>
          </div>
        </aside>
      </div>

    </main>
  </div>

<script>

// Gráfico da comparação de atendimentos
fetch("../../controllers/RelatorioController.php?acao=compararAtendimentosSemanais&idProfissional=<?= $idProfissional ?>")
  .then(res => res.json())
  .then(dados => {
    const ctxLine = document.getElementById('barChart').getContext('2d');

    const lineChart = new Chart(ctxLine, {
      type: 'line',
      data: {
        labels: dados.labels,
        datasets: [
          {
            label: 'Essa semana',
            data: dados.essaSemana,
            borderColor: '#f1c40f',
            backgroundColor: 'rgba(241, 196, 15, 0.2)',
            borderWidth: 3,
            tension: 0.4,
            pointRadius: 5,
            pointBackgroundColor: '#f1c40f',
            fill: false
          },
          {
            label: 'Semana passada',
            data: dados.semanaPassada,
            borderColor: '#e74c3c',
            backgroundColor: 'rgba(231, 76, 60, 0.2)',
            borderWidth: 3,
            tension: 0.4,
            pointRadius: 5,
            pointBackgroundColor: '#e74c3c',
            fill: false
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { usePointStyle: true, boxWidth: 10, color: '#333' }
          },
          tooltip: { mode: 'index', intersect: false }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { color: '#555', font: { weight: '600' } }
          },
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(0,0,0,0.05)' },
            ticks: { color: '#555', stepSize: 5 }
          }
        }
      }
    });

    // Atualiza o card de agendamentos de hoje
    const totalHoje = dados.essaSemana[dados.essaSemana.length - 1] || 0;
    document.getElementById("agendamentosHoje").innerText = totalHoje;
  })
  .catch(err => console.error("Erro ao carregar dados:", err));

// grafico de bola
fetch("../../controllers/RelatorioController.php?acao=contarConsultasERetornos&idProfissional=<?= $idProfissional ?>")
  .then(res => res.json())
  .then(data => {
    const labels = ['Primeiras Consultas', 'Retornos'];
    const valores = [data.consultas, data.retornos];

    new Chart(document.getElementById('donut1').getContext('2d'), {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          data: valores,
          backgroundColor: ['#2e86de', '#10ac84'],
          borderWidth: 0,
          cutout: '70%',
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { usePointStyle: true, color: '#333' }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                const total = context.dataset.data.reduce((a,b)=>a+b,0);
                const value = context.raw;
                const percent = ((value/total)*100).toFixed(1);
                return `${context.label}: ${value} (${percent}%)`;
              }
            }
          }
        }
      }
    });
  })
  .catch(err => console.error("Erro ao carregar dados do gráfico:", err));

</script>
</body>
</html>
