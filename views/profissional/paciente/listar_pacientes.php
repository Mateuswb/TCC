<?php
  session_start();
  include '../../../public/includes/profissional/sidebar.php';

  require_once "../../../controllers/ProfissionalController.php";

  $controller = new ProfissionalController($conn);
  $pacientes = $controller->listarPacientesPorProfissional();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel - Pacientes</title>

  <!-- STYLE  CSS-->
  <link rel="stylesheet" href="../../../public/assets/css/profissional/listar_pacientes.css">

</head>
<body>

  <!-- Topbar -->
  <div class="topbar">
    <span class="menu-icon">&#9776;</span>
    <div class="search-bar">
      <input type="text" placeholder="Pesquisar">
    </div>
    <div class="profile">Dr. João da Silva Santos</div>
  </div>

  <!-- Conteúdo -->
  <div class="content">
    <h1>Seus pacientes estão aqui</h1>
    <p>Visualize e gerencie todos os pacientes que já realizaram uma consulta com você</p>

    <!-- Filtros -->
    <div class="filters">
      <input type="text" placeholder="Buscar por nome...">
      <select>
        <option>Todos</option>
      </select>
      <button>Filtros</button>
    </div>

    <!-- Tabela -->
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
            <tr>
              <td><?= htmlspecialchars($paciente['nome']) ?></td>
              <td><?= htmlspecialchars($paciente['cpf']) ?></td>
              <td><?= $paciente['idade'] ?> anos</td>
              <td><?= htmlspecialchars($paciente['telefone']) ?></td>
              <td>
                <span class="status <?= $paciente['status'] == 'ativo' ? 'ativo' : 'inativo' ?>">
                  <?= ucfirst($paciente['status']) ?>
                </span>
              </td>
              <td><?= !empty($paciente['ultima_consulta']) ? date('d/m/Y', strtotime($paciente['ultima_consulta'])) : '-' ?></td>
            </tr>
          <?php } ?>
      </tbody>
    </table>
  </div>

</body>
</html>
