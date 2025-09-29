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

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <!-- Font Awesome para ícones -->
  <script src="https://kit.fontawesome.com/a2d9b7f7d2.js" crossorigin="anonymous"></script>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    :root{
      --bg:#f1f3f7;
      --card:#ffffff;
      --muted:#9aa3b2;
      --accent:#0d9957;
      --purple:#f0eef6;
    }
    *{box-sizing:border-box}
    body{
      padding: 0;
      margin:0;
      font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: linear-gradient(180deg,#f3f4f8 0%, #eaeaf0 100%);
      color:#263244;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

    .sidebar {
      position: fixed;
} 


    /* Layout */
    .app{
      display:flex;
      min-height:100vh;
      gap:24px;
      padding:24px;
    }


    .logo{
      width:36px;height:36px;border-radius:6px;background:linear-gradient(45deg,#1da1f2,#2de6a3);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;
    }
    .brand h1{font-size:14px;margin:0;color:#137a54}
    .user{
      display:flex;align-items:center;gap:10px;margin-top:6px;
    }
    .avatar{width:36px;height:36px;border-radius:50%;background:#ddd;display:block}
    .menu{width:100%;margin-top:6px}
    .menu a{display:flex;gap:10px;align-items:center;padding:10px;border-radius:8px;color:#2a3b46;text-decoration:none;font-size:14px}
    .menu a.active{background:linear-gradient(90deg, #0e7049, #0b6b44);color:#fff}
    .menu a i{min-width:18px;text-align:center}
    .logout{margin-top:auto;color:#e14a4a;font-weight:600;font-size:14px;display:flex;align-items:center;gap:8px}

    /* Main content */
    .main{
      flex:1;
      display:flex;
      flex-direction:column;
      gap:18px;
      margin-left: 240px;
    }

    /* Top info cards grid */
    .top-grid{
      display:grid;
      grid-template-columns: repeat(4, 1fr);
      gap:14px;
    }
    .card{
      background:var(--card);
      border-radius:10px;
      padding:16px;
      box-shadow: 0 6px 20px rgba(20,24,40,0.04);
      display:flex;
      justify-content:space-between;
      align-items:center;
      gap:12px;
    }
    .card .left{
      display:flex;flex-direction:column;gap:6px;
    }
    .card .left small{color:var(--muted);font-size:13px}
    .card .left strong{font-size:20px}
    .card .icon{
      width:44px;height:44px;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:18px;
    }
    .icon.blue{background:linear-gradient(180deg,#1f77f6,#3aa0ff)}
    .icon.green{background:linear-gradient(180deg,#27ae60,#2ecc71)}
    .icon.yellow{background:linear-gradient(180deg,#f1c40f,#f6d365)}
    .icon.red{background:linear-gradient(180deg,#ff6b6b,#ff8a8a)}

    /* Big content area with graph and right panel */
    .content-row{
      display:grid;
      grid-template-columns: 2fr 1fr;
      gap:18px;
      align-items:start;
    }
    .chart-card{
      background:var(--card);
      border-radius:10px;
      padding:20px;
      box-shadow: 0 6px 20px rgba(20,24,40,0.04);
    }
    .chart-card h3{margin:0 0 10px 0;color:#4b5563;text-align:center}

    /* Right panel earnings */
    .right-panel{
      background:var(--card);
      border-radius:10px;
      padding:18px;
      box-shadow: 0 6px 20px rgba(20,24,40,0.04);
      display:flex;
      flex-direction:column;
      gap:12px;
      align-items:stretch;
    }
    .right-panel .toggle{
      display:flex;gap:8px;align-self:flex-end;
    }
    .btn-toggle{
      border:1px solid #e6e9ee;padding:6px 10px;border-radius:6px;font-size:13px;background:#fff;cursor:pointer;
    }
    .btn-toggle.active{background:#0d9957;color:#fff;border:1px solid #0d9957}

    .earn-value{font-size:20px;font-weight:700}
    .small-muted{color:var(--muted);font-size:13px}

    .donut-row{display:flex;gap:12px;justify-content:space-evenly;padding-top:8px}
    .donut-box{flex:1;text-align:center;padding:8px}

    /* footer style */
    footer{margin-top:18px;background:transparent;padding:12px;border-radius:8px;color:var(--muted);font-size:13px;text-align:center}

    /* responsive */
    @media (max-width:1100px){
      .top-grid{grid-template-columns: repeat(2,1fr)}
      .content-row{grid-template-columns:1fr}
      aside.sidebar{display:none}
      .app{padding:12px}
    }
  </style>
</head>
<body>
  <div class="app">
    <!-- sidebar -->


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
