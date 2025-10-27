<?php 
  session_start();
  include '../../../controllers/AgendamentoConsultaController.php';
  include '../../../public/includes/profissional/sidebar.php';
  include '../../../public/includes/profissional/header.php';
  include '../../../public/includes/profissional/footer.html';

  // Modais de consulta
  include '../../../public/modals/profissional/consultas/cancelar_consulta.php';
  include '../../../public/modals/profissional/consultas/encaminhar_consulta.php';
  include '../../../public/modals/profissional/consultas/finalizar_consulta.php';

  // Modal de exame
  include '../../../public/modals/profissional/exames/finalizar_exame.php';

  $profissionalId = $_SESSION['idProfissional'];
  $controller = new AgendamentoConsultaController($conn);
  $agendamentos = $controller->listarAgendamentosDoProfissional($profissionalId);

  $cores = ["#4a90e2", "#50e3c2", "#f36f45", "#9b59b6", "#e67e22", "#2ecc71"];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Agenda - Profissional</title>

  <!-- FullCalendar -->
  <script src="../../../libs/calender/index.global.min.js"></script>
  
  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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


.main {
  flex: 1;
  display: flex;
  flex-direction: column;
  margin-bottom: 35px;
  margin-top: 17px;
}

.content {
  margin-top: 40px;
  margin-bottom: 20px;
  padding: 20px;
  overflow-x: auto;
}

h1 {
  margin-bottom: 20px;
  color: #2980b9;
  font-size: 26px;
  font-weight: 700;
}

/* ====== BARRA DE FILTROS ====== */
.filter-bar {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 12px;
  padding: 12px 16px;
  background: #fff;
  border-radius: 12px;
  margin-bottom: 20px;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
  font-size: 15px;
  font-weight: 600;
}

.filter-bar label {
  color: #333;
}

.filter-bar select {
  padding: 6px 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 14px;
  background: #f9f9f9;
  cursor: pointer;
  transition: all 0.2s ease;
}

.filter-bar select:hover {
  border-color: #2980b9;
}

/* ====== CALENDÁRIO ====== */
.calendar {
  flex: 1;
  padding: 15px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
  overflow: auto;
  max-height: calc(100vh - 180px);
}

.fc .fc-day-today {
  background: rgba(243, 111, 69, 0.1) !important;
  border: 2px solid #f36f45 !important;
}

.fc-event {
  border-radius: 12px !important;
  font-size: 15px !important;
  font-weight: 700 !important;
  padding: 8px 10px !important;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  margin: 0 auto !important;
  width: 90% !important;
  color: #fff !important;
  line-height: 1.4;
  border-left: 5px solid #fff;
}

/* === ESTILOS ESPECÍFICOS === */
.fc-event.consulta {
  background-color: #4a90e2 !important;
  border: 1px solid #2e6eb5 !important;
  color: white !important;
  font-weight: 600;
  border-radius: 6px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.fc-event.consulta:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
}

.fc-event.exame {
  background-color: #50e3c2 !important;
  border: 1px solid #28b89a !important;
  color: #083a35 !important;
  font-weight: 600;
  border-radius: 50px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
  font-style: italic;
}

.fc-event.exame:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
}

/* ====== MODAIS ====== */
.modal {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.modal-content {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  width: 320px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
  text-align: center;
  animation: modalFade 0.25s ease;
}

@keyframes modalFade {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}

.modal-content h3 {
  margin-bottom: 15px;
  color: #2980b9;
}

.modal-content button {
  display: block;
  width: 100%;
  margin: 8px 0;
  padding: 10px;
  border: none;
  border-radius: 6px;
  font-size: 15px;
  cursor: pointer;
  font-weight: 600;
  transition: transform 0.2s, opacity 0.2s;
}
.fc-event {
  border-radius: 12px !important;
  font-size: 15px !important;
  font-weight: 700 !important;
  padding: 8px 10px !important;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  margin: 0 auto !important;
  width: 90% !important;
  color: #fff !important;
  line-height: 1.4;
  border-left: 5px solid #fff;
}

.fc-timegrid-slot {
  height: 100px !important;
}


.modal-content button:hover {
  opacity: 0.9;
  transform: translateY(-2px);
}

/* ====== BOTÕES ====== */
.btn-finalizar { background: #27ae60; color: #fff; }
.btn-cancelar  { background: #e74c3c; color: #fff; }
.btn-encaminhar { background: #f39c12; color: #fff; }
.btn-fechar    { background: #bdc3c7; color: #fff; }

/* ====== RESPONSIVIDADE ====== */
@media (max-width: 992px) {
  .filter-bar {
    flex-direction: column;
    align-items: flex-start;
  }
  .calendar {
    max-height: calc(100vh - 220px);
  }
}

@media (max-width: 480px) {
  .modal-content {
    width: 90%;
    padding: 16px;
  }
  h1 { font-size: 22px; }
  .filter-bar { font-size: 14px; }
}
</style>

<body>
<div class="main">
  <div class="content">
    <div class="filter-bar">
      <label for="tipoFiltro">Filtrar por tipo:</label>
      <select id="tipoFiltro" onchange="filtrarEventos()">
        <option value="todos">Todos</option>
        <option value="c">Consulta</option>
        <option value="r">Retorno</option>
      </select>
    </div>

    <div class="calendar" id="calendar"></div>

    <!-- Modal Consulta -->
    <div id="eventModal" class="modal">
      <div class="modal-content">
        <h3 id="eventTitle">Consulta</h3>
        <button class="btn-finalizar" onclick="executarAcao('finalizar')">✅ Finalizar</button>
        <button class="btn-cancelar" onclick="executarAcao('cancelar')">❌ Cancelar</button>
        <button class="btn-encaminhar" onclick="executarAcao('encaminhar')">📤 Encaminhar</button>
        <button class="btn-fechar" onclick="fecharModal()">Fechar</button>
      </div>
    </div>

    <!-- Modal Exame -->
    <div id="modalExame" class="modal">
      <div class="modal-content">
        <h3 id="exameTitle">Exame</h3>
        <button class="btn-finalizar" onclick="executarAcaoExame('finalizar')">✅ Finalizar</button>
        <button class="btn-cancelar" onclick="executarAcaoExame('cancelar')">❌ Cancelar</button>
        <button class="btn-fechar" onclick="fecharModalExame()">Fechar</button>
      </div>
    </div>
  </div>
</div>

<script>
let calendar;
let selectedEvent = null;

document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');

  const events = <?php echo json_encode(array_map(function($ag, $i) use ($cores) {
    $tipo = $ag['tipo'];
    $nomeEvento = $tipo === 'consulta' ? ucfirst($ag['tipo_consulta']) : $ag['nome_exame'];
    $dia = $ag['dia'] ?? date('Y-m-d');
    $cor = $cores[$i % count($cores)];
    return [
      'id' => $ag['id_agendamento'],
      'title' => $ag['nome_paciente'] . ' - ' . $nomeEvento,
      'start' => $dia.'T'.$ag['horario'],
      'end' => $dia.'T'.date('H:i:s', strtotime($ag['horario'].' + 30 minutes')),
      'color' => $cor,
      'classNames' => [$tipo],
      'extendedProps' => [ 'tipo' => $tipo ]
    ];
  }, $agendamentos, array_keys($agendamentos)), JSON_UNESCAPED_UNICODE); ?>;

  calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'timeGridWeek',
    locale: 'pt-br',
    slotMinTime: "07:00:00",
    slotMaxTime: "20:00:00",
    allDaySlot: false,
    events: events,
    headerToolbar: {
      left: 'prev,next',
      center: 'title',
      right: 'timeGridWeek,timeGridDay'
    },
    eventClick: function(info) {
      selectedEvent = info.event;
      const tipo = selectedEvent.extendedProps.tipo;

      if (tipo === 'exame') {
        document.getElementById("modalExame").style.display = "flex";
        document.getElementById("idExame").value = selectedEvent.id;
      } else {
        document.getElementById("eventTitle").innerText = selectedEvent.title;
        document.getElementById("eventModal").style.display = "flex";
      }
    }
  });

  calendar.render();
});

function fecharModal() {
  document.getElementById("eventModal").style.display = "none";
}

function fecharModalExame() {
  document.getElementById("modalExame").style.display = "none";
}

function executarAcao(acao) {
  if (!selectedEvent) return;

  if (acao === 'encaminhar') {
    document.getElementById("eventModal").style.display = "none";
    document.getElementById("encaminharModal").style.display = "flex";
    document.getElementById("encaminharId").value = selectedEvent.id;
    return;
  }

  if (acao === 'cancelar') {
    document.getElementById("eventModal").style.display = "none";
    document.getElementById("cancelarModal").style.display = "flex";
    document.getElementById("idConsulta").value = selectedEvent.id;
    return;
  }

  if (acao === 'finalizar') {
    const tipo = selectedEvent.extendedProps.tipo;
    if (tipo !== 'exame') {
      document.getElementById("eventModal").style.display = "none";
      document.getElementById("finalizarModal").style.display = "flex";
      document.getElementById("idFinalizarConsulta").value = selectedEvent.id;
    }
  }
}

function executarAcaoExame(acao) {
  if(!selectedEvent) return;

  if(acao === 'finalizar') {
    document.getElementById("modalExame").style.display = "none";
    document.getElementById("finalizarExameModal").style.display = "flex";
    document.getElementById("idFinalizarExame").value = selectedEvent.id;
  }

  if(acao === 'cancelar') {
    document.getElementById("modalExame").style.display = "none";
  }
}

function filtrarEventos() {
  const filtro = document.getElementById('tipoFiltro').value;
  calendar.getEvents().forEach(event => {
    if (filtro === 'todos' || event.extendedProps.tipo === filtro) {
      event.setProp('display', 'auto');
    } else {
      event.setProp('display', 'none');
    }
  });
}
</script>
</body>
</html>
