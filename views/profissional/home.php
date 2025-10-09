<?php
    session_start();
    $idProfissional = $_SESSION['idProfissional'];
    include '../../public/includes/profissional/sidebar.php';
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

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <!-- Font Awesome para ícones -->
  <script src="https://kit.fontawesome.com/a2d9b7f7d2.js" crossorigin="anonymous"></script>

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
            <div class="toggle">
              <button class="btn-toggle active" id="btnWeekly">Weekly</button>
              <button class="btn-toggle" id="btnMonthly">Monthly</button>
            </div>
          </div>

          <div class="donut-row">
            <div class="donut-box">
              <canvas id="donut1" width="140" height="140"></canvas>
              <div class="small-muted" style="margin-top:8px">mês passado</div>
            </div>
            <div class="donut-box">
              <canvas id="donut2" width="140" height="140"></canvas>
              <div class="small-muted" style="margin-top:8px">Esse mês</div>
            </div>
          </div>
        </aside>
      </div>

      <footer>Copyright © 2025 HealthEase Medical. All rights reserved.</footer>
    </main>
  </div>

  <script>
    // --- Bar chart (Monthly Registered Users) ---
    const ctxBar = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(ctxBar, {
      type: 'bar',
      data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [
          {
            label: 'Users',
            data: [60, 75, 58, 85, 70, 78, 55, 70, 40, 8, 5, 10],
            backgroundColor: [
              '#4aa3ff','#2ecc71','#ff4d6d','#f6c23e','#4aa3ff','#2ecc71','#ff4d6d','#f6c23e','#4aa3ff','#2ecc71','#ff4d6d','#f6c23e'
            ],
            borderRadius:6,
            maxBarThickness:28
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        plugins: {
          legend:{display:false},
          tooltip:{mode:'index',intersect:false}
        },
        scales: {
          x: { grid: { display:false }, ticks:{ color:'#6b7280' } },
          y: {
            beginAtZero:true,
            grid: { color:'rgba(0,0,0,0.04)' },
            ticks: { stepSize:20, color:'#6b7280' }
          }
        }
      }
    });

    // --- Donut charts ---
    function createDonut(id, value, label){
      const ctx = document.getElementById(id).getContext('2d');
      return new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: [label, 'Remaining'],
          datasets: [{
            data: [value, 100 - value],
            backgroundColor: [ '#2d9cdb', '#e6eef8' ],
            hoverOffset: 4,
            cutout: '74%'
          }]
        },
        options:{
          maintainAspectRatio:true,
          plugins:{legend:{display:false}, tooltip:{enabled:false}},
        }
      });
    }

    const donut1 = createDonut('donut1', 40, 'Analytics');
    const donut2 = createDonut('donut2', 60, 'Analytics');

    // --- Toggle Weekly / Monthly (just visual) ---
    const btnWeekly = document.getElementById('btnWeekly');
    const btnMonthly = document.getElementById('btnMonthly');

    btnWeekly.addEventListener('click', () => {
      btnWeekly.classList.add('active'); btnMonthly.classList.remove('active');
      // exemplo: atualizar dados do barChart (opcional)
      barChart.data.datasets[0].data = [60, 75, 58, 85, 70, 78, 55, 70, 40, 8, 5, 10];
      barChart.update();
    });
    btnMonthly.addEventListener('click', () => {
      btnMonthly.classList.add('active'); btnWeekly.classList.remove('active');
      // exemplo: trocar para dados mensais
      barChart.data.datasets[0].data = [400, 520, 450, 610, 520, 560, 480, 520, 330, 60, 40, 70];
      barChart.update();
    });

    // Make canvas high dpi friendly
    function fixRetina(){
      document.querySelectorAll('canvas').forEach(c => {
        const dpr = window.devicePixelRatio || 1;
        const w = c.width;
        const h = c.height;
        c.width = w * dpr;
        c.height = h * dpr;
        c.style.width = w + 'px';
        c.style.height = h + 'px';
        const ctx = c.getContext('2d');
        ctx.scale(dpr, dpr);
      });
    }
    fixRetina();
    // if resized, fix again
    window.addEventListener('resize', () => {
      setTimeout(() => { fixRetina(); }, 100);
    });
  </script>
</body>
</html>
