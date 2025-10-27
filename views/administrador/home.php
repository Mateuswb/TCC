<?php
    include "../../public/includes/administrador/sidebar.php"; 
    include "../../public/includes/administrador/header.php"; 
    include "../../public/includes/administrador/footer.php"; 
    require_once "../../controllers/RelatorioController.php";

    $controller = new RelatorioController($conn);
    $usuarios = $controller->usuariosMaisRecentes();

    $totalPacientes = $controller->totalPacientes();
    $totalProfissionais = $controller->totalProfissionais();
    $totalUsuarios = $controller->totalUsuarios();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel Administrativo</title>

  <!-- IMPORT CHART.JS -->
  <script src="../../libs/chart.min.js"></script>
</head>
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
    }

    .sidebar.collapsed ~ .main {
    margin-left: 80px;
    }

    
    /* Conteúdo */
    .content {
    padding: 20px;
    }

    /* Cards */
    .cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
    }

    .card {
    padding: 20px;
    border-radius: 12px;
    color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: transform 0.2s;
    }

    .card:hover {
    transform: translateY(-5px);
    }

    .card h3 {
    font-size: 26px;
    margin-bottom: 10px;
    }

    .card p {
    font-size: 14px;
    opacity: 0.9;
    }

    .blue {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .purple {
    background: linear-gradient(135deg, #6366f1, #4338ca);
    }

    .green {
    background: linear-gradient(135deg, #10b981, #059669);
    }

    .yellow {
    background: linear-gradient(135deg, #fbb024f3, #b9631cff);
    }

    /* Gráficos */
    .grid-graphs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
    }

    .report-box {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .report-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    }

    .tabs button {
    border: none;
    background: #e5e7eb;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    margin-left: 5px;
    }

    .tabs button.active {
    background: #1e3a8a;
    color: #fff;
    }

    /* Usuários */
    .users-box {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
    }

    .users-box h3 {
    margin-bottom: 15px;
    }

    .users-box table {
    width: 100%;
    border-collapse: collapse;
    }

    .users-box th,
    .users-box td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
    }

    .users-box th {
    background: #f3f4f6;
    }

    .users-box tr:hover {
    background: #f9fafb;
    }


</style>

<body>
  <div class="main">
    <div class="content">

      <!-- Cards -->
      <div class="cards">
        <div class="card blue">
          <h3>120</h3>
          <p>Agendamentos Hoje</p>
        </div>
        <div class="card purple">
          <h3><?php echo $totalPacientes['totalPaciente']; ?></h3>
          <p>Pacientes Cadastrados</p>
        </div>
        <div class="card green">
          <h3><?php echo $totalProfissionais['totalProfissional']; ?></h3>
          <p>Profissionais Cadastrados</p>
        </div>
        <div class="card yellow">
          <h3><?php echo $totalUsuarios['totalUsuario']; ?></h3>
          <p>Perfis</p>
        </div>
      </div>

      <!-- Gráficos -->
      <div class="grid-graphs">
        <div class="report-box">
          <div class="report-header">
            <h3>Agendamentos Semana</h3>
            <div class="tabs">
              <button class="active" onclick="switchTab(1)">Semana</button>
              <button onclick="switchTab(2)">Mês</button>
            </div>
          </div>
          <canvas id="chart1"></canvas>
        </div>

        <div class="report-box">
          <div class="report-header">
            <h3>Principais Dias de agendamento</h3>
          </div>
          <canvas id="chart2"></canvas>
        </div>
      </div>

      <div class="users-box">
        <h3>Usuários Mais Recentes</h3>
        <table>
          <thead>
            <tr>
              <th>Nome</th>
              <th>Email</th>
              <th>Telefone</th>
              <th>Status</th>
              <th>Data Cadastro</th>
            </tr>
          </thead>

          <tbody>
              <?php foreach($usuarios as $usuario){ ?>
              <tr>
                <td><?php echo $usuario['nome']; ?></td>
                <td><?php echo $usuario['email']; ?></td>
                <td><?php echo $usuario['telefone']; ?></td>
                <td><?php echo $usuario['status']; ?></td>
                <td><?php echo $usuario['data_criacao']; ?></td>
              </tr>
              <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


  <script>

    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("collapsed");
    }

    // Gráfico 1 - Agendamentos
    let chart1;
    function renderChart1(labels, data) {
      const ctx1 = document.getElementById('chart1').getContext('2d');
      if (chart1) chart1.destroy();

      chart1 = new Chart(ctx1, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'Agendamentos',
            data: data,
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.2)',
            fill: true,
            tension: 0.3
          }]
        },
        options: { 
        responsive: true, 
        plugins: { legend: { display: false } },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1,
              callback: function(value) {
                return value;
              }
            },
            min: 0 
          }
        }
      }
      });
    }

    fetch("../../controllers/RelatorioController.php?acao=agendamentosJson")
      .then(res => res.json())
      .then(dados => {
        renderChart1(dados.labels, dados.valores);

        const totalHoje = dados.valores[dados.valores.length - 1] || 0;
        document.getElementById("agendamentosHoje").innerText = totalHoje;
      })
      

    // Gráfico 2 - Dia com mais consultas
    fetch('../../controllers/RelatorioController.php?acao=atendimentosSemanaJson')
      .then(response => response.json())
      .then(data => {

        const diasOrdem = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        const diasAbreviados = ['Seg','Ter','Qua','Qui','Sex','Sáb','Dom'];

        const labels = [];
        const valores = [];
        diasOrdem.forEach((dia, index) => {
          const diaData = data.find(d => d.dia_semana === dia);
          labels.push(diasAbreviados[index]);
          valores.push(diaData ? diaData.total_atendimentos : 0);
        });

        // Criar o gráfico
        const ctx2 = document.getElementById('chart2').getContext('2d');
        const chart2 = new Chart(ctx2, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: 'Consultas',
              data: valores,
              backgroundColor: '#1097b9ff'
            }]
          },
          options: {
          responsive: true,
          plugins: { legend: { display: false } },
          scales: {
            y: {
              beginAtZero: true, 
              ticks: {
                stepSize: 1,       
                precision: 0       
              }
            }
          }
        }
        });
      })
      .catch(error => console.error('Erro ao carregar dados do gráfico:', error));

  </script>
</body>
</html>
