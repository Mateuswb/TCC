

<?php
session_start();
$idProfissional = $_SESSION['idProfissional'];

include '../../../controllers/HorarioController.php';
include '../../../public/includes/profissional/sidebar.php'; 

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
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    body {
        display: flex;
        height: 100vh;
        background: #ecf0f3;
    }

    .main {
        flex: 1;
        padding: 20px;
        overflow-x: auto;
    }

    h1 {
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .agenda-table {
        border-collapse: collapse;
        width: 100%;
        min-width: 700px;
    }

    .agenda-table th,
    .agenda-table td {
        border: 1px solid #ddd;
        text-align: center;
        padding: 10px;
    }

    .agenda-table th {
        background: #3498db;
        color: #fff;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .agenda-table td {
        background: #fff;
    }

    .btn-Editar {
        padding: 5px;
        width: 70px;
        font-weight: bold;
        color: white;
        background-color: rgba(0, 39, 148, 1);
        font-size: 15px;
        border-radius: 7px;
        cursor: pointer;
    }

    .btn-adicionar {
        padding: 5px;
        width: 90px;
        font-weight: bold;
        color: white;
        background-color: rgba(79, 148, 0, 1);
        font-size: 15px;
        border-radius: 7px;
        cursor: pointer;
    }

    #modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        width: 350px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .modal-content label {
        font-weight: bold;
    }

    .modal-content input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .modal-content button {
        padding: 8px;
        border: none;
        border-radius: 4px;
        background: #3498db;
        color: #fff;
        cursor: pointer;
        font-weight: bold;
    }

    .modal-content button:hover {
        background: #2980b9;
    }

    .modal-header {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #2c3e50;
        display: flex;
        justify-content: space-between;
    }

    .modal-close {
        cursor: pointer;
        font-weight: bold;
        font-size: 18px;
    }

</style>
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
