<?php 
  session_start();
  include '../../../controllers/AgendamentoConsultaController.php';

  include '../../../public/includes/profissional/sidebar.php';
  include 'cancelar_consulta.php';
  include 'encaminhar_consulta.php';
  include 'finalizar_consulta.php';

  $profissionalId = $_SESSION['idProfissional'];
  $controller = new AgendamentoConsultaController($conn);
  $agendamentos = $controller->listarAgendamentosDoProfissional($profissionalId);

  // $controllerExame = new ExameController($conn);
  // $exames = $controllerExame->listarExames(); 

  $cores = ["#4a90e2", "#50e3c2", "#f36f45", "#9b59b6", "#e67e22", "#2ecc71"];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Agenda - Profissional</title>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/pt-br.global.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  
  <style>
    body { margin:0; font-family: Arial, sans-serif; display:flex; height:100vh; background:#f7f9fb; }
    .main { flex:1; display:flex; flex-direction:column; }
    .header { background:#f5f6fa; padding:10px 20px; display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid #ddd; }
    .header h1 { font-size:18px; margin:0; }
    .menu-btn { font-size:24px; cursor:pointer; margin-right:15px; user-select:none; }

    .calendar {
      flex:1;
      padding:10px;
      min-width:0;
      background:#fff;
      border-radius:12px;
      margin:15px;
      box-shadow:0 3px 10px rgba(0,0,0,0.08);
      overflow:auto;
      max-height: calc(100vh - 100px);
    }

    .fc .fc-day-today { background:rgba(243,111,69,0.1)!important; border:2px solid #f36f45!important; }
    .fc-event { 
      border-radius:10px !important;
      font-size:13px !important;
      font-weight:600;
      padding:8px !important;
      box-shadow:0 3px 8px rgba(0,0,0,0.2);
      text-align:center;
      margin:0 auto !important;
      width:85% !important;
    }
    .fc-timegrid-slot { height:65px !important; }
    .fc-col-header-cell { background:#f9f9f9; font-weight:600; }

    .fc-calendario-button {
      background: #2575fc;
      color: #fff;
      border-radius: 6px;
      padding: 6px 10px;
      font-size: 16px;
      cursor: pointer;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    .fc-calendario-button:hover { background: #1a5fcc; }

    .modal {
      display:none;
      position:fixed;
      top:0; left:0; width:100%; height:100%;
      background:rgba(0,0,0,0.5);
      justify-content:center;
      align-items:center;
      z-index:9999;
    }
    .modal-content {
      background:#fff;
      padding:20px;
      border-radius:12px;
      width:300px;
      box-shadow:0 4px 12px rgba(0,0,0,0.25);
      text-align:center;
    }
    .modal-content h3 { margin-bottom:15px; }
    .modal-content button {
      display:block;
      width:100%;
      margin:8px 0;
      padding:10px;
      border:none;
      border-radius:6px;
      font-size:15px;
      cursor:pointer;
    }
    .btn-finalizar { background:#27ae60; color:#fff; }
    .btn-cancelar { background:#e74c3c; color:#fff; }
    .btn-encaminhar { background:#f39c12; color:#fff; }
    .btn-fechar { background:#bdc3c7; color:#fff; }
    .modal-content button:hover { opacity:0.9; }


  </style>
</head>
<body>

  <div class="main">
    <div class="header">
      <div class="menu-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
      </div>
      <h1>Agenda - Dr. João da Silva</h1>
    </div>

    <div class="calendar" id="calendar"></div>
    <input type="text" id="datepicker" style="display:none;">

    <div id="eventModal" class="modal">
      <div class="modal-content">
        <h3 id="eventTitle">Consulta</h3>
        <button class="btn-finalizar" onclick="executarAcao('finalizar')">✅ Finalizar</button>
        <button class="btn-cancelar" onclick="executarAcao('cancelar')">❌ Cancelar</button>
        <button class="btn-encaminhar" onclick="executarAcao('encaminhar')">📤 Encaminhar</button>
        <button class="btn-fechar" onclick="fecharModal()">Fechar</button>
      </div>
    </div>
  </div>

  
  <script>
    let calendar;
    let selectedEvent = null;

    document.addEventListener('DOMContentLoaded', function () {
      const calendarEl = document.getElementById('calendar');

      const events = <?php echo json_encode(array_map(function($ag, $i) use ($cores) {
        $dia = $ag['dia'] ?? date('Y-m-d');
        $cor = $cores[$i % count($cores)];
        return [
          'id'    => $ag['id_agendamento'],
          'title' => $ag['nome_paciente'].' - '.$ag['servico'],
          'start' => $dia.'T'.$ag['horario'],
          'end'   => $dia.'T'.date('H:i:s', strtotime($ag['horario'].' +30 minutes')),
          'color' => $cor
        ];
      }, $agendamentos, array_keys($agendamentos)), JSON_UNESCAPED_UNICODE); ?>;

      calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'pt-br',
        slotMinTime: "07:00:00",
        slotMaxTime: "20:00:00",
        allDaySlot: false,
        events: events,
        customButtons: {
          calendario: {
            text: '📅',
            click: function() {
              document.getElementById('datepicker')._flatpickr.open();
            }
          },
          hoje: {
            text: 'Hoje',
            click: function() {
              calendar.today();
              calendar.changeView('timeGridDay');
            }
          }
        },
        headerToolbar: {
          left: 'prev,next calendario',
          center: 'title',
          right: 'timeGridWeek,hoje'
        },
        eventClick: function(info) {
          selectedEvent = info.event;
          document.getElementById("eventTitle").innerText = selectedEvent.title;
          document.getElementById("eventModal").style.display = "flex";
        }
      });

      calendar.render();

      flatpickr("#datepicker", {
        onChange: function(selectedDates, dateStr) {
          calendar.gotoDate(dateStr);
        }
      });
    });

    function fecharModal() {
      document.getElementById("eventModal").style.display = "none";
    }

    function executarAcao(acao) {
      if (!selectedEvent) return;

      if (acao === 'encaminhar') {
        document.getElementById("eventModal").style.display = "none";
        document.getElementById("encaminharModal").style.display = "flex";

        document.getElementById("encaminharId").value = selectedEvent.id;
        return;
      }
      if (acao == 'cancelar') {
        document.getElementById("eventModal").style.display = "none";
        document.getElementById("cancelarModal").style.display = "flex";

        document.getElementById("idConsulta").value = selectedEvent.id;
        return;
      }
      
      if (acao == 'finalizar') {
        document.getElementById("eventModal").style.display = "none";
        document.getElementById("finalizarModal").style.display = "flex";

        document.getElementById("idFinalizarConsulta").value = selectedEvent.id;
        return;
      }

    }


  function fecharEncaminharModal() {
    document.getElementById("encaminharModal").style.display = "none";
  }

  function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("collapsed");
  }
  </script>
</body>
</html>
