<?php 
session_start();
include '../../../controllers/AdministradorController.php';
include '../../../public/includes/administrador/sidebar.php';
include '../../../public/includes/administrador/header.php';
include '../../../public/includes/administrador/footer.php';

$controller = new AdministradorController($conn);
$agendamentos = $controller->listarAgendamentos();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Agenda - Profissional</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <!-- IMPORT DO CSS -->
  <link rel="stylesheet" href="../../../public/assets/css/administrador/agendamentos.css">

  <!-- IMPORT DO CALENDER  MUDAR AAAAAQQQQQQ-->
  <link href="../../../libs/calender/index.global.js" rel="stylesheet">  
  <script src="../../../libs/calender/index.global.min.js"></script>

</head>

<body>
  <div class="main">
    <div class="content">
      <h1>Agenda - Dr. João da Silva</h1>

      <div class="filter-bar">
        <label for="tipoFiltro">Tipo:</label>
        <select id="tipoFiltro" onchange="aplicarFiltros()">
          <option value="todos">Todos</option>
          <option value="consulta">Consulta</option>
          <option value="exame">Exame</option>
        </select>

        <label for="profissionalFiltro">Profissional:</label>
        <select id="profissionalFiltro" onchange="aplicarFiltros()">
          <option value="todos">Todos</option>
          <?php
            $profissionais = $controller->listarProfissionais();
            foreach ($profissionais as $prof) {
                echo "<option value='{$prof['id_profissional']}'>{$prof['nome']}</option>";
            }
          ?>
        </select>

        <label for="statusFiltro">Status:</label>
        <select id="statusFiltro" onchange="aplicarFiltros()">
          <option value="todos">Todos</option>
          <option value="agendada">Agendada</option>
          <option value="finalizada">Finalizada</option>
          <option value="cancelada">Cancelada</option>
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
  </div>


<script>
let calendar;
let selectedEvent = null;

document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');

  const events = <?php echo json_encode(array_map(function($ag) {
    $tipo = $ag['tipo'];
    $nomeEvento = $tipo === 'consulta' ? ucfirst($ag['tipo_consulta']) : $ag['nome_exame'];
    $dia = $ag['dia'] ?? date('Y-m-d');

    return [
      'id' => $ag['id_agendamento'],
      'title' => $ag['nome_paciente'] . ' - ' . $nomeEvento,
      'start' => $dia.'T'.$ag['horario'],
      'end' => $dia.'T'.date('H:i:s', strtotime($ag['horario'].' + 30 minutes')),
      'classNames' => [$tipo],
      'extendedProps' => [
          'tipo' => $tipo
      ]
    ];
  }, $agendamentos), JSON_UNESCAPED_UNICODE); ?>;

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

    eventDidMount: function(info) {
    if (new Date(info.event.start) < new Date()) {
        info.el.style.opacity = 0.9;
        info.el.style.background = '#a3a3a3ff';  
        info.el.style.borderColor = '#616161ff'; 
        info.el.style.color = '#000000ff';       
        info.event.setProp('editable', false); 
    }
},


   eventClick: function(info) {
    selectedEvent = info.event;

    // Verifica se o evento já passou
    const eventoPassado = new Date(selectedEvent.start) < new Date();
    if (eventoPassado) return; // Bloqueia modal para eventos passados

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
    if (selectedEvent.extendedProps.tipo !== 'exame') {
      document.getElementById("eventModal").style.display = "none";
      document.getElementById("finalizarModal").style.display = "flex";
      document.getElementById("idFinalizarConsulta").value = selectedEvent.id;
    }
  }
}

function executarAcaoExame(acao) {
  if (!selectedEvent) return;

  if (acao === 'finalizar') {
    document.getElementById("modalExame").style.display = "none";
    document.getElementById("finalizarExameModal").style.display = "flex";
    document.getElementById("idFinalizarExame").value = selectedEvent.id;
  }

  if (acao === 'cancelar') {
    document.getElementById("modalExame").style.display = "none";
  }
}
</script>
</body>
</html>
