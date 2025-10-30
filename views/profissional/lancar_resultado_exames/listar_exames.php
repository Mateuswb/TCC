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

  <!-- IMPORT DO CSS -->
  <link rel="stylesheet" href="../../../public/assets/css/profissional/listar_resultados_exame.css">

  <!-- IMPORT ICONS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container">
  <h2 id="title"><i class="fa-solid fa-flask"></i> Exames Pendentes para Lançamento</h2>

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

<!-- modal do upload do resultado do exame-->
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
