<?php
session_start();
require_once "../../../controllers/PacienteController.php";

include '../../../public/includes/paciente/sidebar.php';
include '../../../public/includes/paciente/header.php';
include '../../../public/includes/paciente/footer.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>MedHub — Histórico de Consultas</title>

<!-- Fonte -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    /* ===== RESET ===== */
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

    .conteudo-principal {
        flex: 1;
        padding: 2rem 3rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        margin: 70px 0 70px 0;
    }

    /* ===== TÍTULO ===== */
    .content h1 {
        color: #023e8a;
        font-weight: 700;
        margin-bottom: 35px;
        text-align: center;
    }

    /* ===== CARDS DE INFORMAÇÃO ===== */
    .cards-info {
        display: flex;
        gap: 20px;
        margin-bottom: 40px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .card-info {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 25px 20px;
        border-radius: 12px;
        font-weight: 600;
        color: #023e8a;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        transition: 0.3s;
        min-width: 280px;
    }

    .card-info:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
    }

    .card-info i {
        font-size: 28px;
        flex-shrink: 0;
    }

    .card-info .texto {
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    .card-info .texto span {
        font-size: 18px;
        font-weight: 700;
        color: #000;
    }

    .card-info.azul { background: #d0e8ff; color: #0a4b8a; }
    .card-info.verde { background: #d7f9d7; color: #126d12; }
    .card-info.vermelho { background: #ffd7d7; color: #a02020; }

    /* ===== CONSULTAS ===== */
    .consultas {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
        gap: 25px;
    }

    .card-consulta {
        background: #fff;
        border-radius: 14px;
        padding: 25px 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12);
        transition: 0.3s ease;
        border: 1px solid #e5e5e5;
    }

    .card-consulta:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.18);
    }

    .topo-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .topo-card h3 {
        font-size: 1.1rem;
        color: #023e8a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-delete {
        background: #dc3545;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 14px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-delete:hover {
        background: #b91c1c;
    }

    .card-consulta p {
        font-size: 15px;
        margin-bottom: 6px;
    }

    .status {
        padding: 4px 12px;
        border-radius: 10px;
        color: #fff;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .status.realizada { background: #28a745; }
    .status.cancelada { background: #dc3545; }

</style>
</head>

<body>
<main class="conteudo-principal">
    <div class="content">
        <h1>Histórico de Consultas</h1>

        <div class="cards-info">
            <div class="card-info azul"><i class="fa-solid fa-file-medical"></i>Total de consultas Já realizadas<span>36</span></div>
            <div class="card-info verde"><i class="fa-solid fa-rotate-left"></i>Total de consultas de retorno<span>10</span></div>
            <div class="card-info vermelho"><i class="fa-solid fa-ban"></i>Total de consultas canceladas<span>6</span></div>
        </div>

       <div class="consultas">
    <div class="card-consulta">
        <div class="topo-card">
            <h3>Agendamento #4</h3>
            <button class="btn-delete">Deletar</button>
        </div>
        <p><strong>Data:</strong> 2025-10-01</p>
        <p><strong>Hora:</strong> 13:30:00</p>
        <p><strong>Status:</strong> <span class="status realizada">Realizada</span></p>
        <p><strong>Profissional:</strong> Dr. Luiz - Cardiologista</p>
        <p><strong>Obs:</strong> ---</p>
    </div>

    <div class="card-consulta">
        <div class="topo-card">
            <h3>Agendamento #3</h3>
            <button class="btn-delete">Deletar</button>
        </div>
        <p><strong>Data:</strong> 2025-09-14</p>
        <p><strong>Hora:</strong> 09:30:00</p>
        <p><strong>Status:</strong> <span class="status cancelada">Cancelada</span></p>
        <p><strong>Profissional:</strong> Dr. Marcos - Oftalmologista</p>
        <p><strong>Obs:</strong> ---</p>
    </div>

    <div class="card-consulta">
        <div class="topo-card">
            <h3>Agendamento #2</h3>
            <button class="btn-delete">Deletar</button>
        </div>
        <p><strong>Data:</strong> 2025-08-03</p>
        <p><strong>Hora:</strong> 15:00:00</p>
        <p><strong>Status:</strong> <span class="status cancelada">Cancelada</span></p>
        <p><strong>Profissional:</strong> Dr. Pedro - Neurologista</p>
        <p><strong>Obs:</strong> ---</p>
    </div>

    <div class="card-consulta">
        <div class="topo-card">
            <h3>Agendamento #1</h3>
            <button class="btn-delete">Deletar</button>
        </div>
        <p><strong>Data:</strong> 2025-07-02</p>
        <p><strong>Hora:</strong> 10:00:00</p>
        <p><strong>Status:</strong> <span class="status cancelada">Cancelada</span></p>
        <p><strong>Profissional:</strong> Dr. João - Pediatra</p>
        <p><strong>Obs:</strong> ---</p>
    </div>
</div>

    </div>
</main>
</body>
</html>
