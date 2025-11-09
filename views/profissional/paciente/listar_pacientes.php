<?php
  include '../../../autentica/verifica_login.php';
  include '../../../public/includes/profissional/sidebar.php';
  include '../../../public/includes/profissional/header.php';
  include '../../../public/includes/profissional/footer.html';
  require_once "../../../controllers/ProfissionalController.php";

  #modal
  include '../../../public/modals/profissional/exibir_paciente.html';

  $controller = new ProfissionalController($conn);
  $pacientes = $controller->listarPacientesPorProfissional();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel - Pacientes</title>

  <!-- IMPORT DO CSS-->
  <link rel="stylesheet" href="../../../public/assets/css/profissional/listar_pacientes.css">

</head>
<body>

  <div class="content">
    <h1>Seus pacientes estão aqui</h1>
    <p>Visualize e gerencie todos os pacientes que já realizaram uma consulta com você</p>

    <div id="filters">
      <input type="text" placeholder="Buscar por nome...">
      <select>
        <option>Todos</option>
      </select>
      <button>Filtros</button>
    </div>

    <table>
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
              data-nome="<?= htmlspecialchars($paciente['nome']) ?>"
              data-cpf="<?= htmlspecialchars($paciente['cpf']) ?>"
              data-idade="<?= htmlspecialchars($paciente['idade']) ?>"
              data-telefone="<?= htmlspecialchars($paciente['telefone']) ?>"
              data-email="<?= htmlspecialchars($paciente['email']) ?>"
              data-ultima="<?= !empty($paciente['ultima_consulta']) ? date('d/m/Y', strtotime($paciente['ultima_consulta'])) : '-' ?>"
              data-consultas="<?= htmlspecialchars($paciente['total_agendamentos'] ?? '-') ?>"
              data-observacoes="<?= htmlspecialchars($paciente['observacoes'] ?? 'Sem observações.') ?>">

      <td><?= htmlspecialchars($paciente['nome']) ?></td>
      <td><?= htmlspecialchars($paciente['cpf']) ?></td>
      <td><?= $paciente['idade'] ?> anos</td>
      <td><?= htmlspecialchars($paciente['telefone']) ?></td>
      <td>
        <span class="status <?= $paciente['status'] == 'ativo' ? 'ativo' : 'inativo' ?>">
          <?= ucfirst($paciente['status']) ?>
        </span>
      </td>
      <td><?= !empty($paciente['ultima_consulta']) ? date('d/m/Y', strtotime($paciente  ['ultima_consulta'])) : '-' ?></td>
    </tr>
          <?php } ?>
      </tbody>
    </table>
  </div>

</body>
</html>
