<?php
  session_start();
  include '../../../../public/includes/paciente/sidebar.php';
  include '../../../../public/includes/paciente/header.php';
  include '../../../../public/includes/paciente/footer.php';

  require_once "../../../../controllers/RelatorioController.php";
  require_once "../../../../controllers/PacienteController.php";

  $idPaciente = $_SESSION['idPaciente'];

  $controller = new RelatorioController($conn);
  $pacienteController = new PacienteController($conn);

  $totalExames = $controller->totalExamesPaciente($idPaciente);
  $exameMaisComum = $controller->exameMaisRecorrente($idPaciente);
  $totalExamesCancelados = $controller->totalExamesCancelados($idPaciente);

  $agendamentos = $pacienteController->historicoAgendamentosExame($idPaciente);

?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>MedHub — Histórico de Exames</title>

  <!-- IMPORT DO CSS -->
  <link rel="stylesheet" href="../../../../public/assets/css/paciente/exames/historico_exames.css">

</head>


<style>
  .modal-bg {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.modal-box {
  background: #fff;
  padding: 25px;
  border-radius: 10px;
  width: 400px;
  max-width: 90%;
  position: relative;
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 15px;
  border: none;
  background: none;
  font-size: 1.5rem;
  cursor: pointer;
}

.modal-box h2 {
  margin-bottom: 15px;
}

</style>
<body>
  <main class="conteudo-principal">
  <div class="titulo-pagina">
    <h1>Histórico de Exames</h1>
  </div>

  <div class="indicadores">
    <div class="card-indicador azul">
      <i class="fa-solid fa-file-medical"></i>
      <div>
        <p>Total de Exames já efetuados</p>
        <h2><?php echo $totalExames ?></h2>
      </div>
    </div>

    <div class="card-indicador cinza">
      <i class="fa-solid fa-flask"></i>
      <div>
        <p>Exame mais recorrente</p>
        <h2><?php echo $exameMaisComum ?></h2>
      </div>
    </div>

    <div class="card-indicador vermelho">
      <i class="fa-solid fa-ban"></i>
      <div>
        <p>Total de Exames Cancelados</p>
        <h2><?php echo $totalExamesCancelados ?></h2>
      </div>
    </div>
  </div>

  <!-- Cards dos exames -->
  <div class="cards-exames">
  <?php foreach($agendamentos as $agendamento){ ?>
    <div class="card-exame"
         data-exame="<?php echo htmlspecialchars($agendamento['nome_exame']); ?>"
         data-categoria="<?php echo htmlspecialchars($agendamento['nome_categoria']); ?>"
         data-dia="<?php echo $agendamento['dia_agendamento']; ?>"
         data-horario="<?php echo $agendamento['horario_agendamento']; ?>"
         data-profissional="<?php echo htmlspecialchars($agendamento['nome_profissional']); ?>"
         data-status="<?php echo $agendamento['status_agendamento']; ?>">
      <div class="header-card">
        <h3><?php echo $agendamento['nome_exame']; ?></h3>
        <span class="status <?php echo $agendamento['status_agendamento']; ?> "><?php echo $agendamento['status_agendamento']; ?> </span>
      </div>
      <p class="categoria"><?php echo $agendamento['nome_categoria']; ?> </p>
      <p class="data">Exame realizado em: <strong><?php echo $agendamento['dia_agendamento']; ?> </strong> às <strong><?php echo $agendamento['horario_agendamento']; ?> </strong></p>
      <div class="acoes">
        <button class="btn-ver">Ver detalhes</button>
        <button class="btn-baixar">Baixar Resultado</button>
      </div>
    </div>
  <?php } ?>
</div>

</main>

<!-- Modal -->
<div class="modal-bg" id="modal-detalhes">
  <div class="modal-box">
    <button class="close-btn" id="fecharModal">&times;</button>
    <h2 id="modal-exame">Nome do Exame</h2>
    <p><strong>Categoria:</strong> <span id="modal-categoria"></span></p>
    <p><strong>Data:</strong> <span id="modal-dia"></span> às <span id="modal-horario"></span></p>
    <p><strong>Profissional:</strong> <span id="modal-profissional"></span></p>
    <p><strong>Status:</strong> <span id="modal-status"></span></p>
    <p><strong>Observações:</strong> <span id="modal-observacoes"></span></p>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("modal-detalhes");
  const fechar = document.getElementById("fecharModal");

  document.querySelectorAll(".btn-ver").forEach(btn => {
    btn.addEventListener("click", (e) => {
      const card = e.target.closest(".card-exame");
      
      // Preencher modal com dados do card
      document.getElementById("modal-exame").textContent = card.dataset.exame;
      document.getElementById("modal-categoria").textContent = card.dataset.categoria;
      document.getElementById("modal-dia").textContent = card.dataset.dia;
      document.getElementById("modal-horario").textContent = card.dataset.horario;
      document.getElementById("modal-profissional").textContent = card.dataset.profissional;
      document.getElementById("modal-status").textContent = card.dataset.status;
      document.getElementById("modal-observacoes").textContent = card.dataset.observacoes;

      modal.style.display = "flex";
    });
  });

  fechar.addEventListener("click", () => {
    modal.style.display = "none";
  });

  // Fecha ao clicar fora do modal
  modal.addEventListener("click", (e) => {
    if(e.target === modal) modal.style.display = "none";
  });
});

</script>
</body>
</html>

