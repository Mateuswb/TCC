<?php 
  require '../../../autentica/verifica_login.php';
  include '../../../controllers/AdministradorController.php';
  include '../../../public/includes/administrador/sidebar.php';
  include '../../../public/includes/administrador/header.php';
  include '../../../public/includes/administrador/footer.php';

  // Modals de consulta
  include '../../../public/modals/administrador/consultas/cancelar_consulta.php';
  include '../../../public/modals/administrador/exame/cancelar_exame.php';

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

  <!-- IMPORT DO CALENDER-->
  <script src="../../../libs/calender/index.global.min.js"></script>

</head>

<style>
  .calendar {
    flex: 1;
    padding: 15px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    overflow: hidden; 
    position: relative;
    height: calc(100vh - 90px);
  }

  .fc .fc-day-today {
    background: rgba(243, 111, 69, 0.08) !important;
    border: 2px solid #f36f45 !important;
  }


  .filter-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
    padding: 8px 20px;
    background: #fff;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
    font-size: 15px;
    font-weight: 600;
  }

  .filter-bar label {
    color: #333;
  }

  .filter-bar select {
    padding: 10px 20px;
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


  .fc-event {
    position: relative !important;
    border-radius: 12px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    padding: 8px 10px !important;
    line-height: 1.4;
    color: #fff !important;
    border-left: 5px solid #fff;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    text-align: left;
    overflow: hidden;
    white-space: normal !important;
  }


  .fc-event:hover {
    transform: scale(1.04);
    z-index: 10 !important;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
  }


  .fc-timegrid-event-harness {
    display: flex !important;
    align-items: stretch !important;
    justify-content: center !important;
  }

  .fc-timegrid-event {
    flex: 1 1 auto !important;
    margin: 3px !important;
    height: auto !important;
    min-height: 130px !important;
    display: flex !important;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    text-align: left;
    box-sizing: border-box;
    cursor: pointer;
  }


  .fc-timegrid-slot {
    height: 140px !important;
  }

  .fc-event.consulta {
    background-color: #2E86C1 !important;
    border-color: #1B4F72 !important;
  }

  .fc-event.reconsulta {
    background-color: #3498DB !important;
    border-color: #21618C !important;
  }

  .fc-event.exame {
    background-color: #5DADE2 !important;
    border-color: #2E86C1 !important;
  }


  .fc-event.cancelada,
  .fc-event.cancelado {
    background-color: #E74C3C !important;
    border-color: #C0392B !important;
    opacity: 0.6 !important;
  }

  .fc-event.finalizada,
  .fc-event.realizada {
    background-color: #1F618D !important;
    border-color: #154360 !important;
  }

  .btn-pdf {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid #fff;
    border-radius: 8px;
    color: #fff;
    padding: 2px 6px;
    margin-top: 6px;
    font-size: 12px;
    cursor: pointer;
    transition: background 0.2s ease;
  }

  .btn-pdf:hover {
    background: rgba(255, 255, 255, 0.35);
  }
  .calendar .fc-scroller {
    overflow-y: auto !important;
    overflow-x: hidden !important;
    max-height: calc(100vh - 240px);
  }
</style>


<body>
  <div class="main">
    <?php include '../../../public/assets/alerta/flash.php'; ?>
    <div class="content">
      <h1>Agendamentos da Clínica</h1>

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
      <button class="btn-cancelar" onclick="executarAcao('cancelar')">❌ Cancelar</button>
      <button class="btn-fechar" onclick="fecharModal()">Fechar</button>
    </div>
  </div>

    <div id="modalExame" class="modal">
      <div class="modal-content">
        <h3 id="exameTitle">Exame</h3>
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

    // Converte os agendamentos pro FullCalendar
    const events = <?php echo json_encode(array_map(function($ag) {
        $tipo = $ag['tipo'];
        $nomeEvento = '';

        if ($tipo == 'c') {
            $nomeEvento = 'Consulta';
        } else if ($tipo == 'r') {
            $nomeEvento = 'Reconsulta';
        } else {
            $nomeEvento = $ag['nome_exame'];
        }

        $duracao = $ag['duracao'] ?? 30; 
        $dia = $ag['dia'] ?? date('Y-m-d');

        return [
            'id' => $ag['id_agendamento'],
            'title' => $ag['nome_paciente'] . ' - ' . $nomeEvento,
            'start' => $dia . 'T' . $ag['horario'],
            'end' => $dia . 'T' . date('H:i:s', strtotime($ag['horario'] . ' + ' . $duracao . ' minutes')),
            'classNames' => [$tipo],
            'extendedProps' => [
                'tipo' => $tipo,
                'status' => $ag['status'],
                'pdf' => !empty($ag['anexo']) ? 'data:application/pdf;base64,' . base64_encode($ag['anexo']) : null
            ]
        ];
    }, $agendamentos), JSON_UNESCAPED_UNICODE); ?>;

    // Inicialização
    calendar = new FullCalendar.Calendar(calendarEl, {
         initialView: 'timeGridWeek',
        locale: 'pt-br',
        slotMinTime: "06:00:00",
        slotMaxTime: "23:31:00",
        allDaySlot: false,
        expandRows: true,
        height: "auto",
        events: events,
        events: events,
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'timeGridWeek,timeGridDay'
        },
         buttonText: {
          week:     'Semana',
          day:      'Dia',

        },

        eventDidMount: function(info) {
            const tipo = info.event.extendedProps.tipo;
            const status = info.event.extendedProps.status;
            

            const agora = new Date();
            const dataAtual = new Date(agora.getFullYear(), agora.getMonth(), agora.getDate());
            const fimEvento = new Date(info.event.end);
            const dataEvento = new Date(fimEvento.getFullYear(), fimEvento.getMonth(), fimEvento.getDate());

            let bg = '', border = '', color = '#fff';


            if (tipo === 'c') {
                switch (status) {
                    case 'agendada':  bg = '#2E86C1'; border = '#1B4F72'; break;
                    case 'realizada': bg = '#2874A6'; border = '#1A5276'; break; 
                    case 'cancelada': bg = '#E74C3C'; border = '#C0392B'; break; 
                }

            } else if (tipo === 'r') {
                switch (status) {
                    case 'agendada':  bg = '#3498DB'; border = '#21618C'; break; 
                    case 'realizada': bg = '#1F618D'; border = '#154360'; break; 
                    case 'cancelada': bg = '#E74C3C'; border = '#C0392B'; break; 
                }

            } else if (tipo === 'exame') { 
                switch (status) {
                    case 'agendado':  bg = '#5DADE2'; border = '#2E86C1'; break; 
                    case 'realizado': bg = '#2E86C1'; border = '#1B4F72'; break;
                    case 'cancelado': bg = '#E74C3C'; border = '#C0392B'; break; 
                }
            }

            info.el.style.backgroundColor = bg;
            info.el.style.borderColor = border;
            info.el.style.color = color;

            if (dataEvento < dataAtual) {
                info.el.style.opacity = 0.5;
                info.event.setProp('editable', false);
                info.el.style.pointerEvents = 'none';
            }

            if (status === 'cancelada' || status === 'cancelado') {
                info.el.style.opacity = 0.6;
                info.event.setProp('editable', false);
                info.el.style.pointerEvents = 'none';
            }

            if (info.event.extendedProps?.tipo === 'r' && info.event.extendedProps?.pdf) {
              const btn = document.createElement('button');
              btn.className = 'btn-pdf';
              btn.innerText = '📄 PDF';
              btn.style.marginLeft = '5px';
              btn.style.fontSize = '12px';
              btn.style.cursor = 'pointer';

              btn.onclick = (event) => {
                  event.stopPropagation(); 
                  const link = document.createElement('a');
                  link.href = info.event.extendedProps.pdf;
                  link.download = `${info.event.title.replace(/\s+/g, '_')}.pdf`;
                  document.body.appendChild(link);
                  link.click();
                  document.body.removeChild(link);
              };

              info.el.style.display = 'flex';
              info.el.style.alignItems = 'center';
              info.el.appendChild(btn);
            }


        },

        
        eventClick: function(info) {
            const agora = new Date();
            const dataAtual = new Date(agora.getFullYear(), agora.getMonth(), agora.getDate());
            const fimEvento = new Date(info.event.end);
            const dataEvento = new Date(fimEvento.getFullYear(), fimEvento.getMonth(), fimEvento.getDate());

            // Bloqueia abertura de eventos de dias passados
            if (dataEvento < dataAtual) return;

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
    setInterval(() => {
        console.log('Chamando finalizarEventosPassados em:', new Date().toLocaleTimeString());
        fetch('../../../controllers/ProfissionalController.php?acao=finalizarEventosPassados')
            .then(res => res.json())
            .then(data => {
                console.log(`Consultas: ${data.consultas_finalizadas}, Exames: ${data.exames_finalizados}`);
                if (data.consultas_finalizadas > 0 || data.exames_finalizados > 0) {
                    calendar.refetchEvents();
                }
            })
            .catch(err => console.error(err));
    }, 600000);
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
console.log(selectedEvent.extendedProps);

function executarAcaoExame(acao) {
    if (!selectedEvent) return;

    if (acao === 'cancelar') {
      document.getElementById("modalExame").style.display = "none";
      document.getElementById("cancelarExameModal").style.display = "flex";
      document.getElementById("idAgendamentoExame").value = selectedEvent.id;

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
