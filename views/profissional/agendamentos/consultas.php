<?php 
session_start();
include '../../../controllers/AgendamentoConsultaController.php';
include '../../../public/includes/profissional/sidebar.php';

// consulta
include '../../../public/modals/profissional/consultas/cancelar_consulta.php';
include '../../../public/modals/profissional/consultas/encaminhar_consulta.php';
include '../../../public/modals/profissional/consultas/finalizar_consulta.php';

// exame
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
  <link rel="stylesheet" href="../../../public/assets/css/profissional/painel_agendamentos_consultas.css">

  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/pt-br.global.min.js"></script> -->

</head>

<style>

  /* === ESTILOS ESPECÍFICOS DE EVENTOS === */

/* Consultas - azul */
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

/* Exames - estilo diferente (verde água) */
.fc-event.exame {
  background-color: #50e3c2 !important;
  border: 1px solid #28b89a !important;
  color: #083a35 !important;
  font-weight: 600;
  border-radius: 50px; /* mais arredondado para diferenciar */
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
  font-style: italic;
}

.fc-event.exame:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
}

</style>
<body>

<div class="main">
  <div class="header">
    <div class="menu-btn" onclick="toggleSidebar()">
      <i class="fas fa-bars"></i>
    </div>
    <h1>Agenda - Dr. João da Silva</h1>
  </div>

  <div class="filter-bar">
    <label for="tipoFiltro">Filtrar por tipo:</label>
    <select id="tipoFiltro" onchange="filtrarEventos()">
      <option value="todos">Todos</option>
      <option value="c">Consulta</option>
      <option value="r">Retorno</option>
    </select>
  </div>

  <div class="calendar" id="calendar"></div>

  <div id="eventModal" class="modal">
    <div class="modal-content">
      <h3 id="eventTitle">Consulta</h3>
      <button class="btn-finalizar" onclick="executarAcao('finalizar')">✅ Finalizar</button>
      <button class="btn-cancelar" onclick="executarAcao('cancelar')">❌ Cancelar</button>
      <button class="btn-encaminhar" onclick="executarAcao('encaminhar')">📤 Encaminhar</button>
      <button class="btn-fechar" onclick="fecharModal()">Fechar</button>
    </div>
  </div>

    <div id="modalExame" class="modal">
      <div class="modal-content">
        <h3 id="exameTitle">Exame</h3>
        <button class="btn-finalizar" onclick="executarAcaoExame('finalizar')">✅ Finalizar</button>
        <button class="btn-cancelar" onclick="executarAcaoExame('cancelar')">❌ Cancelar</button>
        <button class="btn-fechar" onclick="fecharModalExame()">Fechar</button>
      </div>
    </div>
</div>



<script>
let calendar;
let selectedEvent = null;

document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');

  const events = <?php echo json_encode(array_map(function($ag, $i) use ($cores) {
    $tipo = $ag['tipo']; // 'consulta' ou 'exame'
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
      'extendedProps' => [
          'tipo' => $tipo
      ]
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
      // Modal de exame
      document.getElementById("modalExame").style.display = "flex";
      document.getElementById("idExame").value = selectedEvent.id;
    } else {
      // Modal de consulta
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

console.log('1');
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

// Função para executar ações do exame 
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

function toggleSidebar() {
  document.getElementById("sidebar").classList.toggle("collapsed");
}
</script>
</body>
</html>
