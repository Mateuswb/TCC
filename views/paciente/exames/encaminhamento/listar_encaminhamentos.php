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

  <!-- Fonte e ícones -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
   rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    :root {
      --blue: #003366;
      --accent: #0b7fc1;
      --muted: #6c757d;
      --card-bg: #fff;
      --shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #f4f6fa;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    main {
      flex: 1;
      margin-top: 60px;
      padding: 30px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      flex: 2; /* ocupa todo espaço disponível */
      overflow-x: auto; /* permite rolar só o conteúdo */
      margin-bottom: 50px;
    }

    main h1 {
      font-size: 28px;
      color: var(--blue);
      font-weight: 700;
      margin-bottom: 30px;
      text-align: center;
    }

    main h1 span {
      color: #007bff;
    }

    /* Grid de cards */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 40px;
      width: 100%;
      max-width: 1500px;
    }

    .card {
      background: var(--card-bg);
      border-radius: 12px;
      padding: 18px;
      box-shadow: var(--shadow);
      position: relative;
      min-height: 140px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border: 1px solid rgba(11,59,90,0.06);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    }

    .top {
      display: flex;
      align-items: flex-start;
      gap: 14px;
    }

    .icon-box {
      width: 54px;
      height: 54px;
      border-radius: 10px;
      background: linear-gradient(180deg,#eef7ff,#dff3ff);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 10px rgba(11,59,90,0.04);
      flex-shrink: 0;
    }

    .card h3 {
      margin: 0;
      font-size: 16px;
      color: var(--blue);
      font-weight: 600;
    }

    .badge {
      position: absolute;
      right: 14px;
      top: 14px;
      background: #fff7d6;
      color: #8a6a00;
      padding: 6px 12px;
      border-radius: 999px;
      font-weight: 600;
      font-size: 12px;
      border: 1px solid rgba(0,0,0,0.05);
    }

    .card .meta {
      color: var(--muted);
      font-size: 13px;
      margin-top: 14px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .btn {
      display: inline-block;
      padding: 8px 14px;
      background: linear-gradient(180deg,var(--accent),#0b5fa0);
      color: #fff;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      font-size: 13px;
      box-shadow: 0 6px 14px rgba(11,59,90,0.12);
      transition: background 0.2s ease;
    }

    .btn:hover {
      background: linear-gradient(180deg,#0c8bdb,#0b5fa0);
    }




    /* MODAL FUNDO */
.modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
    z-index: 10000;
}

/* CONTEÚDO DO MODAL */
.modal-content {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    min-width: 350px;
    max-width: 500px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    position: relative;
}

/* BOTAO FECHAR */
.close {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 24px;
    cursor: pointer;
}

/* FORMULARIO */
.modal-content form label {
    display: block;
    margin-top: 15px;
    font-weight: 600;
    color: #333;
}

.modal-content form input,
.modal-content form textarea {
    width: 100%;
    padding: 8px 10px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
}

/* BOTOES */
.modal-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.modal-buttons .cancel {
    background-color: #ccc;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.modal-buttons .agendar {
    background-color: #0066cc;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.modal-buttons .cancel:hover {
    background-color: #999;
}

.modal-buttons .agendar:hover {
    background-color: #004999;
}
  </style>
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