<?php
    include '../../../autentica/verifica_login.php';
    $idProfissional = $_SESSION['idProfissional'];

    include '../../../controllers/HorarioController.php';
    include '../../../public/includes/profissional/sidebar.php'; 
    include '../../../public/includes/profissional/header.php';
    include '../../../public/includes/profissional/footer.html';

    # modals 
    include '../../../public/modals/profissional/editar_horario.php';

    $controller = new HorarioController($conn);
    $horarios = $controller->listarHorarios($idProfissional);


    $dias = [
        ['sigla'=>'SEG','nome'=>'Segunda-Feira','cor'=>'#f59e0b','key'=>'segunda'],
        ['sigla'=>'TER','nome'=>'Terça-Feira','cor'=>'#ef4444','key'=>'terca'],
        ['sigla'=>'QUA','nome'=>'Quarta-Feira','cor'=>'#10b981','key'=>'quarta'],
        ['sigla'=>'QUI','nome'=>'Quinta-Feira','cor'=>'#3b82f6','key'=>'quinta'],
        ['sigla'=>'SEX','nome'=>'Sexta-Feira','cor'=>'#0ea5e9','key'=>'sexta'],
        ['sigla'=>'SÁB','nome'=>'Sábado','cor'=>'#8b5cf6','key'=>'sabado'],
        ['sigla'=>'DOM','nome'=>'Domingo','cor'=>'#6366f1','key'=>'domingo']
    ];

    $mapDias = array_column($dias, null, 'key');

    $horariosJS = [];
    foreach($horarios as $h){
        $key = $h['dia_semana'];
        $horariosJS[$key] = [
            'idHorario' => $h['id_horario'],
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

</head>
<body>
<div class="main">
    <?php include '../../../public/assets/alerta/flash.php'; ?>
    <div class="page">
    
    <div class="page-header">
        <h1>Agenda Semanal</h1>
        <button type="button" id="btn-planilha" onclick="abrirModalEdicao()">Abrir Planilha</button>
    </div>
    <table class="agenda-table">
        <thead>
            <tr>
                <th>Dia</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Início Intervalo</th>
                <th>Fim Intervalo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($dias as $dia): 
                $key = $dia['key'];
                $h = $horariosJS[$key] ?? null;
            ?>
            <tr>
                <td>
                    <div class="day-cell">
                        <span class="day-dot" style="background:<?= $dia['cor'] ?>"></span>
                        <span class="day-title"><?= $dia['sigla'] ?></span>
                        <span class="day-sub"><?= $dia['nome'] ?></span>
                    </div>
                </td>
                <td><div class="time-card"><input type="text" value="<?= $h['hora_inicio'] ?? '--:--' ?>" readonly><i class="far fa-clock"></i></div></td>
                <td><div class="time-card"><input type="text" value="<?= $h['hora_fim'] ?? '--:--' ?>" readonly><i class="far fa-clock"></i></div></td>
                <td><div class="time-card"><input type="text" value="<?= $h['intervalo_inicio'] ?? '--:--' ?>" readonly><i class="far fa-clock"></i></div></td>
                <td><div class="time-card"><input type="text" value="<?= $h['intervalo_fim'] ?? '--:--' ?>" readonly><i class="far fa-clock"></i></div></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
  </div>
</div>


<script>
    const horarios = <?= json_encode($horariosJS); ?>;
    const modal = document.getElementById('modalPlanilha');

    window.abrirModalEdicao = function(){
        const modal = document.getElementById('modalPlanilha');
        modal.style.display = 'flex';

        const tableBody = document.getElementById('tableBody');
        tableBody.querySelectorAll('tr').forEach(tr => {
            const day = tr.querySelector('input[name="diaSemana[]"]').value.toLowerCase(); 

            if(horarios[day]){
                tr.querySelector('input[name="idHorario[]"]').value = horarios[day].idHorario || ''; 
                tr.querySelector('input[name="horaInicio[]"]').value = horarios[day].hora_inicio || '';
                tr.querySelector('input[name="horaFim[]"]').value = horarios[day].hora_fim || '';
                tr.querySelector('input[name="inicioIntervalo[]"]').value = horarios[day].intervalo_inicio || '';
                tr.querySelector('input[name="fimIntervalo[]"]').value = horarios[day].intervalo_fim || '';
            } else {
                tr.querySelector('input[name="horaInicio[]"]').value = '';
                tr.querySelector('input[name="horaFim[]"]').value = '';
                tr.querySelector('input[name="inicioIntervalo[]"]').value = '';
                tr.querySelector('input[name="fimIntervalo[]"]').value = '';
            }
        });
    }

    modal.addEventListener('click', (e) => {
        if(e.target === modal) modal.style.display = 'none';
    });

</script>

</body>
</html>
