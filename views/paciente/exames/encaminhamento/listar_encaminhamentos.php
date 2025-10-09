<?php
session_start();
   include '../../../../public/includes/paciente/sidebar.php';
   include '../../../../public/includes/paciente/header.php';
   include '../../../../public/includes/paciente/footer.php';

   
   $idPaciente = $_SESSION['idPaciente'];

   require_once "../../../../controllers/EncaminhamentoController.php";

   $controller = new EncaminhamentoController($conn);
   $encaminhamentos = $controller->listarEncaminhamentosPorPaciente($idPaciente);
?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>MedHub — Encaminhamentos</title>

  <!-- STYLE  CSS-->
  <link rel="stylesheet" href="../../../../public/assets/css/paciente/exames/lista_encaminhamentos.css">


  <!-- Fonte e ícones -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
   rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>
  <main>
    <h1>Seus <span>Encaminhamentos</span> estão <span>aqui</span></h1>

    <section class="cards" aria-live="polite" id="cardsContainer">
      <?php if (!empty($encaminhamentos)): ?>
        <?php foreach ($encaminhamentos as $p): ?>
          <article class="card" role="article" aria-label="Encaminhamento de <?php echo $p['profissional_encaminhou']; ?>">
            <span class="badge">Pendente</span>
            <div class="top">
              <div class="icon-box" aria-hidden="true">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                  <path d="M12 2v8" stroke="#0b3b5a" stroke-width="1.4" stroke-linecap="round"/>
                  <rect x="6" y="10" width="12" height="10" rx="2" fill="#eaf6ff" stroke="#0b3b5a" stroke-width="0.9"/>
                  <path d="M9 6h6" stroke="#0b3b5a" stroke-width="1.2" stroke-linecap="round"/>
                </svg>
              </div>

              <div style="flex:1">
                <h3><?php echo htmlspecialchars($p['exame']); ?></h3>
                <div style="font-size:13px;color:var(--muted);margin-top:6px">
                  Encaminhado por:<br>
                  <strong style="color:#113a58;font-weight:600">
                    <?php echo htmlspecialchars($p['profissional_encaminhou']); ?>
                  </strong>
                </div>
              </div>
            </div>

            <div class="meta">
              <div>Detalhes do encaminhamento</div>
              <div>
                <a class="btn openModalExame" id="">Agendar Exame</a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align:center;color:var(--muted);font-size:15px;">Nenhum encaminhamento disponível no momento.</p>
      <?php endif; ?>
    </section>
  </main>


  <!-- MODAL -->
<div id="modalExame" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Agendar Exame</h2>
    
    <form id="formAgendamentoExame">
      <!-- Dia do Agendamento -->
      <label for="dataExame">Data:</label>
      <input type="date" id="dataExame" name="dataExame" required>

      <!-- Horário -->
      <label for="horarioExame">Horário:</label>
      <input type="time" id="horarioExame" name="horarioExame" required>

      <!-- Observações -->
      <label for="observacoesExame">Observações:</label>
      <textarea id="observacoesExame" name="observacoesExame" placeholder="Digite observações..." rows="4"></textarea>

      <!-- BOTOES -->
      <div class="modal-buttons">
        <button type="button" class="cancel">Cancelar</button>
        <button type="submit" class="agendar">Agendar</button>
      </div>
    </form>
  </div>
</div>
        
</body>
</html>

<script>

// ABRIR MODAL EM TODOS OS BOTÕES
document.querySelectorAll('.openModalExame').forEach(function(btn){
    btn.addEventListener('click', function() {
        document.getElementById('modalExame').style.display = 'flex';
    });
});


// FECHAR MODAL
document.querySelectorAll('.close, .cancel').forEach(function(btn){
    btn.addEventListener('click', function() {
        this.closest('.modal').style.display = 'none';
    });
});

// FECHAR AO CLICAR FORA DO MODAL
window.addEventListener('click', function(e) {
    const modal = document.getElementById('modalExame');
    if(e.target == modal) {
        modal.style.display = 'none';
    }
});

</script>