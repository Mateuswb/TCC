<?php
  include '../../../autentica/verifica_login.php';
  include '../../../public/includes/profissional/sidebar.php'; 
  include '../../../public/includes/profissional/header.php';
  include '../../../public/includes/profissional/footer.html';
  include '../../../controllers/ResultadoExameController.php'; 

  $idProfissional = $_SESSION['idProfissional'];

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
    grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
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


.no-exames {
    font-size: 1.1rem;
    color: #475569;
    padding: 60px 0;
    line-height: 1.6;
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



.btn-cancelar {
  background: #d1d5db;
  border: none;
  padding: 10px 18px;
  border-radius: 8px;
  cursor: pointer;
}

.btn-salvar {
  background: #1e3a8a;
  color: white;
  border: none;
  padding: 10px 18px;
  border-radius: 8px;
  cursor: pointer;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.55);
    z-index: 9999;
}

.modal-content.edit-modal {
    background: #ffffff;
    width: 450px;
    padding: 35px;
    border-radius: 18px;
    position: relative;
    box-shadow: 0 10px 32px rgba(0, 0, 0, 0.28);
    animation: fadeIn .25s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(.95); }
    to { opacity: 1; transform: scale(1); }
}


.modal-title {
    margin-bottom: 24px;
    font-size: 20px;
    text-align: center;
    gap: 10px;
    color: #1e3a8a;
    font-weight: 700;
}

.label-title {
    font-weight: 600;
    margin-bottom: 6px;
    display: block;
     text-align: center;
    color: #334155;
}

.file-drop {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 18px;
    background: #f1f5f9;
    border: 2px dashed #94a3b8;
    border-radius: 12px;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: .2s ease;
}

.file-drop:hover {
    background: #e2e8f0;
    border-color: #64748b;
}

.modal-actions {
    margin-top: 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}


.btn-cancelar,
.btn-salvar {
    padding: 15px 30px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: .2s ease;
}

.btn-cancelar {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
}

.btn-cancelar:hover {
    background: #e2e8f0;
}

.btn-salvar {
    background: #1e3a8a;
    color: white;
    box-shadow: 0 2px 6px rgba(30, 58, 138, 0.25);
}

.btn-salvar:hover {
    background: #243da8;
    box-shadow: 0 3px 10px rgba(30, 58, 138, 0.35);
}

.btn-salvar:hover {
  background: #10285a;
}

.btn-baixar {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 5px 18px;
    background: #1652d1ff;
    color: white;
    font-size: 15px;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
    transition: 0.25s ease;
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.15);
}

.btn-baixar:hover {
    background: #1446c4ff;
    transform: translateY(-2px);
    box-shadow: 0px 5px 12px rgba(0, 0, 0, 0.2);
}

.btn-baixar i {
    font-size: 16px;
}


@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.92); }
  to { opacity: 1; transform: scale(1); }
}

</style>
</head>
<body>
  <div class="page-content">
    <?php include '../../../public/assets/alerta/flash.php'; ?>
  <div class="container">
    <h2 id="title" style="margin-top:40px;"><i class="fa-solid fa-file-medical"></i> Histórico De Exames Já Enviados</h2>

    <?php if (count($examesEnviados) > 0): ?>
      <div class="exames-grid">
        <?php foreach ($examesEnviados as $exame): ?>
          <div class="exame-card">
  <div class="exame-header">
    <h3><i class="fa-solid fa-user"></i> <?= htmlspecialchars($exame['nome_paciente']) ?></h3>
    <span style="color:#64748b;">
      <i class="fa-solid fa-calendar-days"></i> <?= date('d/m/Y', strtotime($exame['data_exame'])) ?>
    </span>
  </div>

  <div class="exame-info">
    <p><strong>Exame:</strong> <?= htmlspecialchars($exame['nome_exame']) ?></p>
    <p><strong>Horário do Exame:</strong> <?= htmlspecialchars($exame['horario_agendamento']) ?></p>
  </div>

  <a href="download_resultado.php?idResultado=<?= $exame['id_resultado']; ?>" class="btn-baixar">
    <i class="fa-solid fa-file-arrow-down"></i> Baixar Resultado
  </a>

  <button class="btn-lancar btn-editar" 
          data-id="<?= $exame['id_resultado'] ?>">
    <i class="fa-solid fa-pen-to-square"></i> Editar Resultado
  </button>
</div>

        <?php endforeach; ?>
      </div>

    <?php else: ?>
      <p class="no-exames"><i class="fa-regular fa-file"></i> Nenhum exame enviado ainda.</p>
    <?php endif; ?>
  </div>

  
<div id="modalEditarResultado" class="modal-overlay">
    <div class="modal-content edit-modal">
        <h2 class="modal-title">
            <i class="fa-solid fa-pen-to-square"></i>
            Editar Resultado
        </h2>
        
        <form id="formEditarResultado" action="../../../controllers/ResultadoExameController.php?acao=editar" method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="idResultado" id="idResultado">

            <label class="label-title">Selecionar novo Resultado:</label>

            <label for="arquivoEditar" class="file-drop">
                <i class="fa-solid fa-file-arrow-up"></i> Escolher Arquivo
            </label>

            <input id="arquivoEditar" type="file" name="arquivo" accept="application/pdf" required style="display:none;">

            <p id="nomeArquivoEditar" class="file-name"></p>

            <div class="modal-actions">
                <button type="button" id="btnCancelarEditar" class="btn-cancelar">Cancelar</button>
                <button type="submit" class="btn-salvar">Salvar</button>
            </div>
        </form>
    </div>
</div>

</div>
<script>
  document.querySelectorAll('.btn-editar').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.getAttribute('data-id');
      document.getElementById('idResultado').value = id;
      document.getElementById('modalEditarResultado').style.display = 'flex';
    });
  });

  document.getElementById('btnCancelarEditar').addEventListener('click', () => {
    document.getElementById('modalEditarResultado').style.display = 'none';
  });

  window.addEventListener('click', e => {
    const modal = document.getElementById('modalEditarResultado');
    if (e.target === modal) modal.style.display = 'none';
  });

  const inputFile = document.getElementById('arquivoEditar');
  const nomeArquivo = document.getElementById('nomeArquivoEditar');

  inputFile.addEventListener('change', function () {
    if (this.files.length > 0) {
      nomeArquivo.textContent = this.files[0].name;
    } else {
      nomeArquivo.textContent = '';
    }
  });
</script>



</body>
</html>
