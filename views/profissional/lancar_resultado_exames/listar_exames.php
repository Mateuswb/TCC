<?php
  include '../../../autentica/verifica_login.php';
  include '../../../public/includes/profissional/sidebar.php'; 
  include '../../../public/includes/profissional/header.php';
  include '../../../public/includes/profissional/footer.html';
  include '../../../controllers/ResultadoExameController.php'; 

  $idProfissional = $_SESSION['idProfissional'];
  $exameController = new ResultadoExameController($conn);
  $exames = $exameController->listarExamesPendentes($idProfissional);

  $exameEnciadosController = new ResultadoExameController($conn);
  $examesEnviados = $exameEnciadosController->listarExamesEnviados($idProfissional);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>MedHub - Resultados</title>
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
    height: 83%;
    width: 99%;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    padding: 40px;
    margin-top: 70px;
    margin-bottom: 50px;
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
    background: linear-gradient(90deg, #0049d1ff, #0638c2ff);
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
    background: linear-gradient(90deg, #0e46e2ff, #00218dff);
    transform: translateY(-2px);
  }
/* modal */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 1000;
    padding: 30px;
}

.modal-content {
    background: #ffffff;
    border-radius: 24px;
    padding: 50px 40px;
    max-width: 500px;
    width: 100%;
    text-align: center;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 30px;
    animation: modalShow 0.3s ease;
}

@keyframes modalShow {
    from { transform: translateY(-20px) scale(0.95); opacity: 0; }
    to { transform: translateY(0) scale(1); opacity: 1; }
}


.modal-content h3 {
    color: #1e3a8a; 
    font-weight: 700;
    font-size: 1.75rem;
    margin-bottom: 10px;
}


.custom-file-upload {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: #2563eb;
    color: #ffffff;
    padding: 16px 0;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    font-size: 1rem;
    width: 100%;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
}
.custom-file-upload:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
}

.modal-content input[type="file"] {
    display: none;
}

.modal-content button {
    background: #1e3a8a; 
    color: #fff;
    border: none;
    padding: 16px 0;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 700;
    font-size: 1rem;
    transition: all 0.3s ease;
    width: 100%;
    margin-top: 20px;
    box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
}
.modal-content button:hover {
    background: #1b366f;
    transform: translateY(-2px);
}

.modal-close {
    position: absolute;
    top: 20px;
    right: 20px;
    color: #64748b;
    font-size: 28px;
    cursor: pointer;
    transition: color 0.2s ease, transform 0.2s ease;
}
.modal-close:hover {
    color: #1e3a8a;
    transform: scale(1.1);
}

.no-exames {
    font-size: 1.1rem;
    color: #475569;
    padding: 60px 0;
    line-height: 1.6;
}

.section-scroll {
    max-height: 500px; 
    overflow-y: auto;
    padding-right: 10px;
}

.section-scroll::-webkit-scrollbar {
    width: 8px;
}

.section-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.upload-dropzone {
    border: 2px dashed #cbd5e1;
    border-radius: 16px;
    padding: 30px 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f9fafb;
    color: #1e3a8a;
    font-weight: 600;
    font-size: 1rem;
}
.upload-dropzone:hover {
    border-color: #1e3a8a;
    background: #e0e7ff;
}

.modal-info {
    font-size: 0.95rem;
    color: #64748b;
    line-height: 1.5;
}

.page-content {
    display: flex;
    flex-direction: column;
    width: 100%;
}

</style>
</head>
<body>
  <div class="page-content">

<?php include '../../../public/assets/alerta/flash.php'; ?>

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



<div class="modal" id="modalUpload">
  <div class="modal-content">
    <span class="modal-close" id="fecharModal">&times;</span>
    <h3><i class="fa-solid fa-file-arrow-up"></i> Enviar Resultado do Exame</h3>
    <form id="formUpload" method="POST" enctype="multipart/form-data" 
          action="../../../controllers/ResultadoExameController.php?acao=enviarResultadoExame">
      <input type="hidden" name="idAgendamento" id="idAgendamento">
      
      <span id="nomeArquivo" style="display:block; margin-top:10px; color:#004aad; font-weight:500;"></span>
      <label for="arquivo" class="custom-file-upload">
        <i class="fa-solid fa-file-arrow-up"></i> Escolher arquivo
      </label>
      <input id="arquivo" type="file" name="resultado_exame" accept=".pdf" required>
  
      <button type="submit"><i class="fa-solid fa-save"></i> Enviar Resultado</button>
    </form>
  </div>
</div>
</div> <!-- fecha page-content -->

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

  const inputArquivo = document.getElementById('arquivo');
  const nomeArquivo = document.getElementById('nomeArquivo');

  inputArquivo.addEventListener('change', function() {
    if (this.files.length > 0) {
      nomeArquivo.textContent = this.files[0].name;
    } else {
      nomeArquivo.textContent = '';
    }
  });
</script>

</body>
</html>
