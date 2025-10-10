<?php    
    session_start();

    $idProfissional = $_GET['idProfissional'] ?? null;
    $idPaciente     = $_SESSION['idPaciente'] ?? null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Agendamento de Consulta</title>

    <!-- STYLE  CSS-->
    <link rel="stylesheet" href="../../../public/assets/css/paciente/consulta/agendar_consulta.css">

    <!-- FONT ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
<div class="container">
    <a href="../paciente/home.php" class="btn-back"><i class="fas fa-arrow-left"></i> Voltar</a>

    <div class="profile">
        <img src="https://cdn-icons-png.flaticon.com/512/3870/3870822.png" alt="Foto do Médico">
        <div class="profile-info">
            <h2>Nome do Profissional</h2>
            <p>Especialidade</p>
            <p>Atendimento Particular</p>
        </div>
    </div>

    <h3>Confirme os dados para o agendamento</h3>

    <form action="../../../controllers/AgendamentoConsultaController.php?acao=agendarConsulta" method="post" id="form" enctype="multipart/form-data">
        <input type="hidden" name="idPaciente" value="<?= $idPaciente; ?>">
        <input type="hidden" name="idProfissional" value="<?= $idProfissional; ?>">
        <input type="hidden" name="status" value="agendada">

        <div class="form-control">
            <label for="tipoConsulta">Tipo de Consulta</label>
            <select name="tipoConsulta" id="tipoConsulta">
                <option value="c">Consulta</option>
                <option value="r">Retorno</option>
            </select>
        </div>

        <div class="form-control" id="box-anexo" style="display:none;">
            <label for="anexo">Anexar Arquivo (apenas para retorno)</label>
            <input type="file" name="anexo" id="anexo" accept=".pdf,.jpg,.png,.jpeg">
        </div>

        <div class="form-control">
            <label for="diaAgendamento">Dia da Consulta</label>
            <input type="date" id="diaAgendamento" name="diaAgendamento">
        </div>

        <div class="form-control">
            <label for="horarioAgendamento">Escolha o Horário</label>
            <small id="erro-horario" style="color: #e74c3c;"></small>

            <div class="times" id="times"></div>
        </div>

        <div class="form-control">
            <label for="observacao">Observações</label>
            <textarea id="observacao" name="observacao" placeholder="Escreva alguma observação..."></textarea>
        </div>

        <input type="submit" value="Agendar" class="btn-agendar">
    </form>

    <div class="clinic-info">
        <h3>Local da Consulta</h3>
        <p>Clínica Synapse</p>
        <p>Av. Santa, 9999 - Centro, Santa Catarina - SC</p>
        <p>CEP: 99999-999</p>
    </div>
</div>

<script>
    // mostrar/esconder campo de anexo
    const tipoConsulta = document.getElementById('tipoConsulta');
    const boxAnexo = document.getElementById('box-anexo');
    tipoConsulta.addEventListener('change', function() {
        if (this.value === 'r') {
            boxAnexo.style.display = 'block';
        } else {
            boxAnexo.style.display = 'none';
        }
    });

    // carregar horários
    document.getElementById('diaAgendamento').addEventListener('change', function() {
        let data = this.value;
        let idProfissional = <?= $idProfissional ?>; 

        fetch('../../controllers/PacienteController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'data=' + encodeURIComponent(data) + '&idProfissional=' + encodeURIComponent(idProfissional)
        })
        .then(response => response.json())
        .then(retorno => {
            let divResultado = document.getElementById('times');
            divResultado.innerHTML = '';

            if (retorno) {
                retorno.disponiveis.forEach(h => {
                    if (retorno.agendamento.includes(h)) {
                        divResultado.innerHTML += `
                            <label class="time-slot-bloqueado">
                                <input type="radio" name="horarioAgendamento" value="${h}" disabled>
                                ${h}
                            </label>`;
                    } else {
                        divResultado.innerHTML += `
                            <label class="time-slot">
                                 <input type="radio" name="horarioAgendamento" value="${h}">
                                <span>${h}</span>
                            </label>`;
                    }
                });
            }
        })
        .catch(error => console.error("Erro:", error));
    });
</script>
</body>
</html>
