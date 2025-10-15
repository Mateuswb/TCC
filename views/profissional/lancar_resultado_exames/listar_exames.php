<?php
session_start();
include '../../../public/includes/profissional/sidebar.php'; 
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
  font-family: "Poppins", sans-serif;
  background-color: #f0f3f8;
  margin: 0;
  padding: 0;
}
.container {
  max-width: 1200px;
  margin: 60px auto;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  padding: 30px;
}
h2 {
  text-align: center;
  color: #2d3748;
  font-weight: 600;
  margin-bottom: 25px;
}
.table-exames {
  width: 100%;
  border-collapse: collapse;
}
.table-exames th {
  background: linear-gradient(90deg, #007bff, #0056d2);
  color: #fff;
  padding: 12px;
  text-align: left;
}
.table-exames td {
  padding: 12px;
  border-bottom: 1px solid #eaeaea;
}
.table-exames tr:hover {
  background-color: #f7f9fc;
}
.btn-lancar {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #28a745;
  color: #fff;
  padding: 8px 14px;
  border-radius: 6px;
  text-decoration: none;
  cursor: pointer;
  transition: 0.2s;
}
.btn-lancar:hover {
  background-color: #218838;
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
  border-radius: 12px;
  padding: 30px;
  width: 400px;
  text-align: center;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  position: relative;
}
.modal-content h3 {
  color: #007bff;
  margin-bottom: 20px;
}
.modal-content input[type="file"] {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 10px;
  margin-bottom: 20px;
}
.modal-content button {
  background: #28a745;
  color: #fff;
  border: none;
  padding: 10px 16px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  width: 100%;
}
.modal-content button:hover {
  background: #218838;
}
.modal-close {
  position: absolute;
  top: 10px;
  right: 15px;
  color: #666;
  font-size: 22px;
  cursor: pointer;
}
.modal-close:hover {
  color: #000;
}
</style>
</head>
<body>

<div class="container">
  <h2><i class="fa-solid fa-flask"></i> Exames Pendentes para Lançamento</h2>

  <?php if (count($exames) > 0): ?>
  <table class="table-exames">
    <thead>
      <tr>
        <th>Paciente</th>
        <th>Exame</th>
        <th>Data</th>
        <th>Horário</th>
        <th>Observações</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($exames as $exame): ?>
      <tr>
        <td><?= htmlspecialchars($exame['paciente']) ?></td>
        <td><?= htmlspecialchars($exame['exame']) ?></td>
        <td><?= date('d/m/Y', strtotime($exame['dia_agendamento'])) ?></td>
        <td><?= htmlspecialchars($exame['horario_agendamento']) ?></td>
        <td><?= htmlspecialchars($exame['observacoes_exame'] ?? '—') ?></td>
        <td>
          <button class="btn-lancar" 
            data-id="<?= $exame['id_agendamento_exame'] ?>">
            <i class="fa-solid fa-upload"></i> Lançar
          </button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p style="text-align:center;">Nenhum exame pendente no momento.</p>
  <?php endif; ?>
</div>

<!-- ===== MODAL UPLOAD ===== -->
<div class="modal" id="modalUpload">
  <div class="modal-content">
    <span class="modal-close" id="fecharModal">&times;</span>
    <h3><i class="fa-solid fa-file-arrow-up"></i> Enviar Resultado do Exame</h3>
    <form id="formUpload" method="POST" enctype="multipart/form-data" action="../../../controllers/ResultadoExameController.php?acao=enviarResultadoExame">
      <input type="int" name="idAgendamento" id="idAgendamento">
      <input type="file" name="resultado_exame" accept=".pdf,.jpg,.png,.jpeg" required>
      <button type="submit"><i class="fa-solid fa-save"></i> Enviar Resultado</button>
    </form>
  </div>
</div>

<script>
// ====== Lógica do Modal ======
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
