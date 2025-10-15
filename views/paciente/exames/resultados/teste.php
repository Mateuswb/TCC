<?php
session_start();
include '../../../../public/includes/paciente/sidebar.php';
include '../../../../public/includes/paciente/header.php';
include '../../../../public/includes/paciente/footer.php';

require_once "../../../../controllers/ResultadoExameController.php";

$idPaciente = $_SESSION['idPaciente'];

$controller = new ResultadoExameController($conn);
$resultados = $controller->listarResultadosPorPaciente($idPaciente);
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
      .flash-success {
    background-color: #d4edda;
    color: #155724;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #c3e6cb;
}

.flash-error {
    background-color: #f8d7da;
    color: #721c24;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #f5c6cb;
}


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
  color: #000000ff;
  font-weight: 600;
  font-size: 0.9rem;
}

.status.agendada {
  background-color: #61b864ff;
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

.btn.editar {
  color: #fff;

  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.btn.editar:hover {
  background-color: #0056b3;
}

.btn.cancelar:hover {
  background-color: #b02a37;
}
.msg-msg {
    position: fixed;          /* fixa na tela */
    top: 50%;                 /* central vertical */
    left: 50%;                /* central horizontal */
    transform: translate(-50%, -50%); /* ajuste perfeito */
    padding: 15px 25px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    z-index: 9999;            /* garante que fique acima de tudo */
    text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}


    </style>
</head>

<body>
    <main class="conteudo-principal">
         <div class="content">
            <?php
              include 'flash.php';
            ?>
            <h1 class="titulo">Consultas Agendadas</h1>

              <div class="agendamento-container">
        <?php foreach($resultados as $resultado): ?>
        <div class="card">
            <div>
                <div class="card-agendamento">
                    <h3><?= htmlspecialchars($resultado['nome_exame']); ?></h3>
                    <?php 
                        $status = strtolower($resultado['status']);
                        $classeStatus = $status == 'finalizado' ? 'finalizado' : 'pendente';
                    ?>
                    <span class="status <?= $classeStatus; ?>">
                        <?= ucfirst($resultado['status']); ?>
                    </span>
                </div>
                <p class="info">
                    <i class="fa-regular fa-calendar"></i>
                    <strong>Data do Lançamento:</strong>
                    <?= date('d/m/Y', strtotime($resultado['data_resultado'])); ?>
                </p>
                <p class="info">
                    <i class="fa-regular fa-calendar-days"></i>
                    <strong>Data do Exame:</strong>
                    <?= date('d/m/Y', strtotime($resultado['data_exame'])); ?>
                </p>
            </div>

            <div class="botoes">
                <a href="#" class="btn-detalhes"><i class="fa-regular fa-eye"></i> Ver detalhes</a>
                <a href="download_resultado.php?idResultado=<?= $resultado['id_resultado']; ?>" class="btn-baixar">
                    <i class="fa-solid fa-file-arrow-down"></i> Baixar Resultado
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
        </div>
    </main>
</body>
</html>
