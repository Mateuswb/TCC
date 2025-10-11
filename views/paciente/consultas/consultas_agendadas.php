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
    <title>MedHub — Página Inicial</title>

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
            background: #f5f6fa;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            margin-top: 70px;
            margin-bottom: 70px;
        }


.content::-webkit-scrollbar {
  width: 10px;
}
.content::-webkit-scrollbar-thumb {
  background: #004aad;
  border-radius: 10px;
}
.content::-webkit-scrollbar-track {
  background: #e0e0e0;
}

/* ===== TÍTULO ===== */
.titulo {
  text-align: center;
  font-size: 1.8rem;
  color: #083d6a;
  margin-bottom: 30px;
}

/* ===== CONTAINER DE AGENDAMENTOS ===== */
.agendamentos-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
  gap: 20px;
}

/* ===== CARD DE AGENDAMENTO ===== */
.card-agendamento {
  background-color: #fff;
  border-radius: 14px;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12);
  padding: 25px 20px;
  border: 1px solid #e5e5e5;
  transition: 0.3s;
}

.card-agendamento:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 14px rgba(0, 0, 0, 0.18);
}

.card-agendamento h3 {
  color: #083d6a;
  margin-bottom: 15px;
  font-weight: 600;
  border-bottom: 1px solid #ccc;
  padding-bottom: 5px;
}

.card-agendamento p {
  margin-bottom: 8px;
}

/* ===== STATUS ===== */
.status {
  padding: 4px 10px;
  border-radius: 10px;
  color: #fff;
  font-weight: 600;
  font-size: 0.9rem;
}

.status.agendado {
  background-color: #4caf50;
}

/* ===== BOTÕES ===== */
.botoes {
  display: flex;
  justify-content: space-between;
  margin-top: 15px;
}

.btn {
  border: none;
  outline: none;
  padding: 8px 16px;
  border-radius: 20px;
  cursor: pointer;
  font-size: 0.9rem;
  transition: 0.2s;
}

.btn.editar {
  background-color: #085274;
  color: white;
}

.btn.editar:hover {
  background-color: #084298;
}

.btn.cancelar {
  background-color: #dc3545;
  color: white;
}

.btn.cancelar:hover {
  background-color: #b02a37;
}


    </style>
</head>

<body>
    <main class="conteudo-principal">
         <div class="content">
            <h1 class="titulo">Consultas Agendadas</h1>

            <div class="agendamentos-container">
                <!-- Card 1 -->
                <div class="card-agendamento">
                <h3>Agendamento #1</h3>
                <p><strong>Data:</strong> 2025-08-04</p>
                <p><strong>Hora:</strong> 10:30:00</p>
                <p><strong>Status:</strong> <span class="status agendado">Agendado</span></p>
                <p><strong>Profissional:</strong> Dr. Marcos</p>
                <p><strong>Obs:</strong> ---</p>
                <div class="botoes">
                    <button class="btn editar">✏️ Editar</button>
                    <button class="btn cancelar">❌ Cancelar</button>
                </div>
                </div>

                <!-- Card 2 -->
                <div class="card-agendamento">
                <h3>Agendamento #2</h3>
                <p><strong>Data:</strong> 2025-10-09</p>
                <p><strong>Hora:</strong> 14:30:00</p>
                <p><strong>Status:</strong> <span class="status agendado">Agendado</span></p>
                <p><strong>Profissional:</strong> Dr. Luiz</p>
                <p><strong>Obs:</strong> ---</p>
                <div class="botoes">
                    <button class="btn editar">✏️ Editar</button>
                    <button class="btn cancelar">❌ Cancelar</button>
                </div>
                </div>
                <!-- Card 2 -->
                <div class="card-agendamento">
                <h3>Agendamento #2</h3>
                <p><strong>Data:</strong> 2025-10-09</p>
                <p><strong>Hora:</strong> 14:30:00</p>
                <p><strong>Status:</strong> <span class="status agendado">Agendado</span></p>
                <p><strong>Profissional:</strong> Dr. Luiz</p>
                <p><strong>Obs:</strong> ---</p>
                <div class="botoes">
                    <button class="btn editar">✏️ Editar</button>
                    <button class="btn cancelar">❌ Cancelar</button>
                </div>
                </div>
                <!-- Card 2 -->
                <div class="card-agendamento">
                <h3>Agendamento #2</h3>
                <p><strong>Data:</strong> 2025-10-09</p>
                <p><strong>Hora:</strong> 14:30:00</p>
                <p><strong>Status:</strong> <span class="status agendado">Agendado</span></p>
                <p><strong>Profissional:</strong> Dr. Luiz</p>
                <p><strong>Obs:</strong> ---</p>
                <div class="botoes">
                    <button class="btn editar">✏️ Editar</button>
                    <button class="btn cancelar">❌ Cancelar</button>
                </div>
                </div>

                <!-- Card 3 -->
                <div class="card-agendamento">
                <h3>Agendamento #3</h3>
                <p><strong>Data:</strong> 2025-11-01</p>
                <p><strong>Hora:</strong> 08:30:00</p>
                <p><strong>Status:</strong> <span class="status agendado">Agendado</span></p>
                <p><strong>Profissional:</strong> Dr. Luiz</p>
                <p><strong>Obs:</strong> ---</p>
                <div class="botoes">
                    <button class="btn editar">✏️ Editar</button>
                    <button class="btn cancelar">❌ Cancelar</button>
                </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
