<?php
  include '../../../autentica/verifica_login.php';
  include '../../../public/includes/profissional/sidebar.php'; 
  include '../../../public/includes/profissional/header.php';
  include '../../../public/includes/profissional/footer.html';
  include '../../../controllers/ResultadoExameController.php'; 

  $idProfissional = $_SESSION['idProfissional'];
  $exameController = new ResultadoExameController($conn);
  $exames = $exameController->listarExamesPendentes($idProfissional);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Exames Pendentes</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

  .container {
    width: 100%;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    padding: 40px;
    margin-top: 50px;
    margin-bottom: 50px;
    animation: fadeIn 0.3s ease;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  h2#title {
    text-align: center;
    color: #1e3a8a;
    font-weight: 700;
    margin-bottom: 35px;
    font-size: 1.9rem;
  }

  .exames-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 25px;
  }

  .exame-card {
    background: #f9fafc;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    transition: all 0.2s ease;
    position: relative;
  }

  .exame-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 14px rgba(0,0,0,0.12);
  }

  .exame-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
  }

  .exame-header h3 {
    color: #1e293b;
    font-size: 1.1rem;
    font-weight: 600;
  }

  .exame-info p {
    color: #4b5563;
    font-size: 0.95rem;
    margin: 5px 0;
  }

  .exame-info p strong {
    color: #1e3a8a;
  }

  .btn-lancar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: linear-gradient(90deg, #2563eb, #1d4ed8);
    color: #fff;
    font-weight: 600;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.25s;
    margin-top: 14px;
    width: 100%;
  }

  .btn-lancar:hover {
    background: linear-gradient(90deg, #1d4ed8, #1e40af);
    transform: translateY(-2px);
  }

  /* ===== MODAL ===== */
  .modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }

  .modal-content {
    background: #fff;
    border-radius: 16px;
    padding: 40px 30px;
    width: 420px;
    text-align: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    position: relative;
    animation: modalShow 0.3s ease;
  }

  @keyframes modalShow {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
  }

  .modal-content h3 {
    color: #1d4ed8;
    margin-bottom: 25px;
    font-weight: 700;
  }

  .modal-content input[type="file"] {
    width: 100%;
    border: 2px dashed #a5b4fc;
    border-radius: 10px;
    padding: 18px;
    cursor: pointer;
    transition: 0.2s;
    margin-bottom: 25px;
  }

  .modal-content input[type="file"]:hover {
    border-color: #2563eb;
    background: #f0f4ff;
  }

  .modal-content button {
    background: linear-gradient(90deg, #22c55e, #16a34a);
    color: #fff;
    border: none;
    padding: 12px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    width: 100%;
    font-size: 1rem;
  }

  .modal-content button:hover {
    background: linear-gradient(90deg, #16a34a, #15803d);
    transform: translateY(-2px);
  }

  .modal-close {
    position: absolute;
    top: 10px;
    right: 15px;
    color: #64748b;
    font-size: 26px;
    cursor: pointer;
    transition: 0.2s;
  }

  .modal-close:hover {
    color: #000;
  }

  .no-exames {
    text-align: center;
    font-size: 1.1rem;
    color: #475569;
    padding: 50px 0;
  }
input[type="file"] {
  display: none;
}

.custom-file-upload {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  background: linear-gradient(90deg, #2563eb, #1d4ed8);
  color: white;
  padding: 10px 50px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: 0.2s;
  margin-bottom: 20px;
}

.custom-file-upload:hover {
  background: linear-gradient(90deg, #0a46ebff, #1e40af);
  transform: translateY(-2px);
}


</style>
</head>
<body>

<div class="container">
  <h2 id="title"><i class="fa-solid fa-flask"></i> Exames Pendentes para Lançamento</h2>

  <?php if (count($exames) > 0): ?>
    <div class="exames-grid">
      <?php foreach ($exames as $exame): ?>
        <div class="exame-card">
          <div class="exame-header">
            <h3><i class="fa-solid fa-user"></i> <?= htmlspecialchars($exame['paciente']) ?></h3>
            <span style="color:#64748b;"><i class="fa-solid fa-calendar-days"></i> <?= date('d/m/Y', strtotime($exame['dia_agendamento'])) ?></span>
          </div>
          <div class="exame-info">
            <p><strong>Exame:</strong> <?= htmlspecialchars($exame['exame']) ?></p>
            <p><strong>Horário:</strong> <?= htmlspecialchars($exame['horario_agendamento']) ?></p>
            <p><strong>Observações:</strong> <?= htmlspecialchars($exame['observacoes_exame'] ?? '—') ?></p>
          </div>
          <button class="btn-lancar" data-id="<?= $exame['id_agendamento_exame'] ?>">
            <i class="fa-solid fa-upload"></i> Lançar Resultado
          </button>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="no-exames"><i class="fa-regular fa-circle-check"></i> Nenhum exame pendente no momento.</p>
  <?php endif; ?>
</div>

<!-- MODAL UPLOAD -->
<div class="modal" id="modalUpload">
  <div class="modal-content">
    <span class="modal-close" id="fecharModal">&times;</span>
    <h3><i class="fa-solid fa-file-arrow-up"></i> Enviar Resultado do Exame</h3>
    <form id="formUpload" method="POST" enctype="multipart/form-data" 
          action="../../../controllers/ResultadoExameController.php?acao=enviarResultadoExame">
      <input type="hidden" name="idAgendamento" id="idAgendamento">
      <label for="arquivo" class="custom-file-upload">
  <i class="fa-solid fa-file-arrow-up"></i> Escolher arquivo
  </label>
  <input id="arquivo" type="file" name="resultado_exame" accept=".pdf" required>
      <button type="submit"><i class="fa-solid fa-save"></i> Enviar Resultado</button>
    </form>
  </div>
</div>

<script>
  document.querySelectorAll('.btn-lancar').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.getAttribute('data-id');
      document.getElementById('idAgendamento').value = id;
      document.getElementById('modalUpload').style.display = 'flex';
    });
  });

  document.getElementById('fecharModal').addEventListener('click', () => {
    document.getElementById('modalUpload').style.display = 'none';
  });

  window.addEventListener('click', e => {
    const modal = document.getElementById('modalUpload');
    if (e.target === modal) modal.style.display = 'none';
  });
</script>


</body>
</html>
