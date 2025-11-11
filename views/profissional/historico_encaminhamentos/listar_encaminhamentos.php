<?php
    include '../../../autentica/verifica_login.php';
    include '../../../public/includes/profissional/sidebar.php'; 
    include '../../../public/includes/profissional/header.php';
    include '../../../public/includes/profissional/footer.html';

    include 'modal_reencaminhar.php';
    include 'modal_cancelar_exame.php';

    $idProfissional = $_SESSION['idProfissional'];

    require_once "../../../controllers/EncaminhamentoController.php";
    $controller = new EncaminhamentoController($conn);

    $encaminhamentos = $controller->listarEncaminhamentosProfissioal($idProfissional);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Encaminhamentos</title>
    
    <!-- IMPORT DOS ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
        }

        main {
            margin-left: 250px; /* espaço para a sidebar */
            width: calc(100% - 250px);
            padding: 100px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #title {
            color: #0b3b5a;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            letter-spacing: 0.5px;
        }

        #tabela-container {
            width: 95%;
            max-width: 1650px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1rem;
        }

        thead {
            background: #0b3b5a;
            color: #fff;
        }

        th, td {
            padding: 15px 18px;
            text-align: left;
            border-bottom: 1px solid #e3e8ef;
        }

        th {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        tbody tr {
            transition: background 0.3s, transform 0.1s;
        }

        tbody tr:hover {
            background: #eef6ff;
        }

        .status {
            font-weight: 600;
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 0.9rem;
            display: inline-block;
            text-transform: capitalize;
        }

        .status.pendente { background: #fff3cd; color: #856404; }
        .status.agendado { background: #cce5ff; color: #004085; }
        .status.concluido { background: #d4edda; color: #155724; }
        .status.cancelado { background: #f8d7da; color: #721c24; }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 8px 14px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: 0.3s;
        }

        .btn i { font-size: 1rem; }

        .btn-cancelar {
            background: #f80000ff;
            color: white;
        }

        .btn-cancelar:hover {
            background: #d90000ff;
            transform: translateY(-2px);
        }

        .btn-reencaminhar {
            background: #ffc107;
            color: #333;
        }

        .btn-reencaminhar:hover {
            background: #e0a800;
            transform: translateY(-2px);
        }

        .sem-encaminhamentos {
            text-align: center;
            padding: 30px;
            color: #777;
            font-style: italic;
            font-size: 1.1rem;
        }

        .voltar {
            color: #0b3b5a;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
            font-size: 1rem;
        }

        .voltar i {
            font-size: 1.2rem;
        }

        .voltar:hover {
            text-decoration: underline;
        }

        @media (max-width: 1024px) {
            main {
                margin-left: 0;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            th, td {
                font-size: 0.9rem;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<main>
<?php include '../../../public/assets/alerta/flash.php'; ?>
    <h2 id="title"><i class="fa-solid fa-file-medical"></i> Histórico de Encaminhamentos</h2>

    <div id="tabela-container">
        <?php if (empty($encaminhamentos)): ?>
            <div class="sem-encaminhamentos">
                <i class="fa-solid fa-circle-exclamation"></i> Nenhum encaminhamento registrado para este profissional.
            </div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Paciente</th>
                    <th>Profissional Encaminhou</th>
                    <th>Exame</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($encaminhamentos as $e): ?>
                <tr>
                    <td><?= htmlspecialchars(date("d/m/Y", strtotime($e['dia_agendamento']))) ?></td>
                    <td><?= htmlspecialchars(substr($e['horario_agendamento'], 0, 5)) ?></td>
                    <td><?= htmlspecialchars($e['nome_paciente'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($e['profissional_encaminhou'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($e['nome_exame'] ?? '—') ?></td>
                    <td>
                        <span class="status <?= strtolower($e['status_encaminhamento']) ?>">
                            <?= ucfirst($e['status_encaminhamento']) ?>
                        </span>
                    </td>
                    <td>
                    <button 
                        class="btn btn-cancelar"
                        onclick="abrirModalCancelar(this)"
                        data-id-encaminhamento="<?= $e['id_encaminhamento'] ?>"
                        data-id-agendamento-exame="<?= $e['id_agendamento_exame'] ?? '' ?>"
                        data-id-agendamento-consulta="<?= $e['id_agendamento'] ?>">
                        <i class="fa-solid fa-ban"></i> Cancelar
                    </button>

                    <button
                        class="btn btn-reencaminhar" 
                        onclick="abrirModalReencaminhar(this)"
                        data-id="<?= $e['id_encaminhamento'] ?>"
                        data-id-consulta="<?= $e['id_agendamento'] ?>"
                        data-id-agendamento-exame="<?= $e['id_agendamento_exame'] ?>"
                        data-observacoes="<?= htmlspecialchars($e['observacoes']) ?>"
                        >
                        <i class="fa-solid fa-share-from-square"></i> Reencaminhar
                    </button>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</main>

<script>
    // cancelar
    function abrirModalCancelar(button) {
        const modal = document.getElementById("modalCancelar");

        const idEncaminhamento = button.dataset.idEncaminhamento;
        const idAgendamentoExame = button.dataset.idAgendamentoExame;
        const idAgendamentoConsulta = button.dataset.idAgendamentoConsulta;

        modal.querySelector("#inputIdEncaminhamento").value = idEncaminhamento;
        modal.querySelector("#inputIdAgendamentoExame").value = idAgendamentoExame;
        modal.querySelector("#inputIdConsulta").value = idAgendamentoConsulta;
        idEncaminhamentoSelecionado = idEncaminhamento;

        modal.style.display = "flex";
    }
    function fecharModalCancelar() {
        document.getElementById("modalCancelar").style.display = "none";
    }


    // encaminhar
    function abrirModalReencaminhar(button) {
    const modal = document.getElementById("encaminharModal");

    const idEncaminhamento = button.dataset.id;
    const idAgendamentoConsulta = button.dataset.idConsulta;
    const idAgendamentoExame = button.dataset.idAgendamentoExame;
    const observacoes = button.dataset.observacoes || '';

    modal.querySelector("#encaminharId").value = idEncaminhamento;
    modal.querySelector("#consultaId").value = idAgendamentoConsulta;
    modal.querySelector("#idAgendamentoExame").value = idAgendamentoExame;
    modal.querySelector("#observacoes").value = observacoes;

    modal.style.display = "flex";
    }

    function fecharEncaminharModal() {
    document.getElementById("encaminharModal").style.display = "none";
    }
</script>

</body>
</html>
