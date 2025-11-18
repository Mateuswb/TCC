<?php
  include '../../../autentica/verifica_login.php';
  include '../../../public/includes/profissional/sidebar.php';
  include '../../../public/includes/profissional/header.php';
  include '../../../public/includes/profissional/footer.html';
  require_once "../../../controllers/ProfissionalController.php";
  
  $controller = new ProfissionalController($conn);
  $pacientes = $controller->listarPacientesPorProfissional();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MedHub - Pacientes</title>

  <!-- IMPORT DO CSS-->
  <link rel="stylesheet" href="../../../public/assets/css/profissional/listar_pacientes.css">
</head>
<body>

  <div class="content">
    <h1>Seus pacientes estão aqui</h1>
    <p>Visualize e gerencie todos os pacientes que já realizaram uma consulta com você</p>

    <div id="filters">
      <input type="text" placeholder="Buscar por nome..." name="nome" id="filtro-nome">

      <select name="status" id="filtro-status">
        <option value="">Status do paciente</option>
        <option value="ativo">Ativo</option>
        <option value="inativo">Inativo</option>
      </select>

      <button type="button" id="aplicar-filtros">Aplicar filtros</button>
    </div>

    <table id="tabela-pacientes">
      <thead>
        <tr>
          <th>Nome</th>
          <th>CPF</th>
          <th>Idade</th>
          <th>Contato</th>
          <th>Status</th>
          <th>Última consulta</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($pacientes as $paciente){  ?>
          <tr class="paciente-item"
              data-nome="<?= strtolower(htmlspecialchars($paciente['nome'] ?? '')) ?>"
              data-status="<?= strtolower(htmlspecialchars($paciente['status'] ?? '')) ?>"
              data-cpf="<?= htmlspecialchars($paciente['cpf'] ?? '') ?>"
              data-idade="<?= htmlspecialchars($paciente['idade'] ?? '') ?>"
              data-telefone="<?= htmlspecialchars($paciente['telefone'] ?? '') ?>"
              data-email="<?= htmlspecialchars($paciente['email'] ?? '') ?>"
              data-ultima="<?= !empty($paciente['ultima_consulta']) ? date('d/m/Y', strtotime($paciente['ultima_consulta'])) : '-' ?>"
              data-consultas="<?= htmlspecialchars($paciente['total_agendamentos'] ?? '-') ?>"
              data-observacoes="<?= htmlspecialchars($paciente['observacoes'] ?? 'Sem observações.') ?>"
          >
            <td><?= htmlspecialchars($paciente['nome'] ?? '-') ?></td>
            <td><?= htmlspecialchars($paciente['cpf'] ?? '-') ?></td>
            <td><?= !empty($paciente['idade']) ? (int)$paciente['idade'].' anos' : '-' ?></td>
            <td><?= htmlspecialchars($paciente['telefone'] ?? '-') ?></td>
            <td>
              <span class="status <?= (isset($paciente['status']) && $paciente['status'] == 'ativo') ? 'ativo' : 'inativo' ?>">
                <?= isset($paciente['status']) ? ucfirst($paciente['status']) : '-' ?>
              </span>
            </td>
            <td><?= !empty($paciente['ultima_consulta']) ? date('d/m/Y', strtotime($paciente['ultima_consulta'])) : '-' ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <div id="nenhum-resultado" style="display:none; margin-top:12px;">Nenhum paciente encontrado.</div>
  </div>

  <?php include '../../../public/modals/profissional/exibir_paciente.html'; ?>


<script>
  (function () {
    const inputNome = document.getElementById('filtro-nome');
    const selectStatus = document.getElementById('filtro-status');
    const btn = document.getElementById('aplicar-filtros');
    const tabelaBodySelector = "#tabela-pacientes tbody";
    const msgNenhum = document.getElementById('nenhum-resultado');

    function aplicarFiltros() {
      const nomeFiltro = (inputNome.value || '').trim().toLowerCase();
      const statusFiltro = (selectStatus.value || '').trim().toLowerCase();

      const linhas = document.querySelectorAll(tabelaBodySelector + " tr");
      let anyVisible = false;

      linhas.forEach(linha => {
        const nome = (linha.dataset.nome || '').toLowerCase();
        const status = (linha.dataset.status || '').toLowerCase();

        let mostrar = true;

        if (nomeFiltro && !nome.includes(nomeFiltro)) {
          mostrar = false;
        }

        if (statusFiltro && status !== statusFiltro) {
          mostrar = false;
        }

        linha.style.display = mostrar ? "" : "none";
        if (mostrar) anyVisible = true;
      });

      if (msgNenhum) {
        msgNenhum.style.display = anyVisible ? "none" : "block";
      }
    }

    btn.addEventListener('click', aplicarFiltros);

  })();
</script>
</body>
</html>
