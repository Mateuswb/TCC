

<?php
session_start();
$idProfissional = $_SESSION['idProfissional'];

include '../../../controllers/HorarioController.php';
include '../../../public/includes/profissional/sidebar.php'; 
include '../../../public/includes/profissional/header.php';
include '../../../public/includes/profissional/footer.html';

$controller = new HorarioController($conn);
$horarios = $controller->listarHorarios($idProfissional);

// Mapear dias para índice 0-6
$mapDias = ['segunda'=>0,'terca'=>1,'quarta'=>2,'quinta'=>3,'sexta'=>4,'sabado'=>5,'domingo'=>6];

$horariosJS = [];
foreach($horarios as $h){
    $horariosJS[$mapDias[$h['dia_semana']]] = [
        'idhorario' => $h['id_horario'],     
        'hora_inicio' => $h['hora_inicio'],
        'hora_fim' => $h['hora_fim'],
        'intervalo_inicio' => $h['inicio_intervalo'],
        'intervalo_fim' => $h['fim_intervalo']
    ];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Agenda Semanal</title>
<link rel="stylesheet" href="../../../public/assets/css/profissional/horarios/listar_horarios.css">
</head>
<body>

<div class="main">
  <h1>Horários Semanais - Dr. João da Silva</h1>
  <table class="agenda-table">
    <thead>
      <tr>
        <th>Dia</th>
        <th>Início</th>
        <th>Fim</th>
        <th>Início Intervalo</th>
        <th>Fim Intervalo</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $dias = ['SEG','TER','QUA','QUI','SEX','SÁB','DOM'];
    for($i=0;$i<7;$i++){
        echo '<tr>';
        echo '<td>'.$dias[$i].'</td>';
        if(isset($horariosJS[$i])){
            $h = $horariosJS[$i];
            echo '<td>'.$h['hora_inicio'].'</td>';
            echo '<td>'.$h['hora_fim'].'</td>';
            echo '<td>'.($h['intervalo_inicio'] ?? '-').'</td>';
            echo '<td>'.($h['intervalo_fim'] ?? '-').'</td>';
            echo '<td><button onclick="abrirModal('.$i.')" class="btn-Editar">Editar</button></td>';
        } else {
            echo '<td>-</td><td>-</td><td>-</td><td>-</td>';
            echo '<td><button onclick="abrirModal('.$i.')" class="btn-adicionar">Adicionar</button></td>';
        }
        echo '</tr>';
    }
    ?>
    </tbody>
  </table>
</div>

<!-- Modal -->
<div id="modal">
  <form class="modal-content" id="formHorario" method="POST" action="../../../controllers/HorarioController.php?acao=editarHorario">
    <div class="modal-header">
      <span>Editar Horário</span>
      <span class="modal-close" onclick="fecharModal()">&times;</span>
    </div>
    <input type="int" name="idHorario" id="idHorario">
    <input type="int" name="idProfissional" value="<?php echo $idProfissional; ?>">
    <input type="hidden" name="diaSemana" id="diaSemana">
    
    <label>Início:</label>
    <input type="time" name="horaInicio" id="hora_inicio_modal" required>
    <label>Fim:</label>
    <input type="time" name="horaFim" id="hora_fim_modal" required>
    <label>Início Intervalo:</label>
    <input type="time" name="inicioIntervalo" id="intervalo_inicio_modal">
    <label>Fim Intervalo:</label>
    <input type="time" name="fimIntervalo" id="intervalo_fim_modal">
    <button type="submit">Salvar</button>
  </form>
</div>

<script>
let diaAtual = null;
let slots = <?php echo json_encode($horariosJS); ?>;

function abrirModal(dia){
    diaAtual = dia;
    document.getElementById('diaSemana').value = dia;

    if(slots[dia]){
        document.getElementById('idHorario').value = slots[dia].idhorario;
        document.getElementById('hora_inicio_modal').value = slots[dia].hora_inicio;
        document.getElementById('hora_fim_modal').value = slots[dia].hora_fim;
        document.getElementById('intervalo_inicio_modal').value = slots[dia].intervalo_inicio ?? '';
        document.getElementById('intervalo_fim_modal').value = slots[dia].intervalo_fim ?? '';
    } else {
        document.getElementById('idHorario').value = '';
        document.getElementById('hora_inicio_modal').value = '';
        document.getElementById('hora_fim_modal').value = '';
        document.getElementById('intervalo_inicio_modal').value = '';
        document.getElementById('intervalo_fim_modal').value = '';
    }
    document.getElementById('modal').style.display='flex';
}

function fecharModal(){
    document.getElementById('modal').style.display='none';
}
</script>
</body>
</html>
