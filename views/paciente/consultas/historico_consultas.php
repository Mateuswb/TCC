<?php
  session_start();
  $idPaciente = $_SESSION['idPaciente'];

  require_once "../../../controllers/PacienteController.php";

  include '../../../public/includes/paciente/sidebar.php';
  include '../../../public/includes/paciente/header.php';
  include '../../../public/includes/paciente/footer.php';


    $controllar = new PacienteController($conn);
    $agendamentos = $controllar->historicoAgendamentosConsulta($idPaciente)
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

    
.indicadores {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  margin-bottom: 20px;
}

.card-indicador {
  flex: 1;
  min-width: 250px;
  height: 100px;
  display: flex;
  align-items: center;
  gap: 15px;
  border-radius: 12px;
  color: #fff;
  padding: 0px 20px;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
}

.card-indicador i {
  font-size: 1.8rem;
}

.card-indicador p {
  font-size: 0.9rem;
  margin: 0;
}

.card-indicador h2 {
  margin: 0;
  font-size: 1.4rem;
  font-weight: 600;
}

.card-indicador.azul {
  background: #3b82f6;
}

.card-indicador.cinza {
  background: #6b7280;
}

.card-indicador.vermelho {
  background: #ef4444;
}


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

        <!-- Indicadores -->
        <div class="indicadores">
          <div class="card-indicador azul">
            <i class="fa-solid fa-file-medical"></i>
            <div>
              <p>Total Consultas já realizadas</p>
              <h2><?php  ?></h2>
            </div>
          </div>

          <div class="card-indicador cinza">
            <i class="fa-solid fa-flask"></i>
            <div>
              <p>Total de consultas de retorno</p>
              <h2><?php  ?></h2>
            </div>
          </div>

          <div class="card-indicador vermelho">
            <i class="fa-solid fa-ban"></i>
            <div>
              <p>Total de consultas Canceladas</p>
              <h2><?php  ?></h2>
            </div>
          </div>
        </div>

        <div class="consultas">
          <?php foreach($agendamentos as $consulta){ ?>
          <div class="card-consulta">
                <div class="topo-card">
                    <h3>Agendamento #3</h3>
                    <button class="btn-delete">Deletar</button>
                </div>
                <p><strong>Data:</strong> <?php echo $consulta['dia_agendamento']?></p>
                <p><strong>Hora:</strong>  <?php echo $consulta['horario_agendamento']?></p>
                <p><strong>Status:</strong> <span class="status  <?php echo $consulta['status']?>"> <?php echo $consulta['status']?></span></p>
                <p><strong>Profissional:</strong> <?php echo $consulta['nome_profissional']?> </p>
                <p><strong>Obs:</strong> <?php echo $consulta['observacoes']?></p>
              
          </div>
          <?php } ?>  
    </div>
</main>
</body>
</html>
