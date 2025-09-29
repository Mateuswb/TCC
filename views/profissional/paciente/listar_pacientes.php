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
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f4f6fa;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
    }

    /* Topbar */
    .topbar {
      margin-left: 220px;
      height: 60px;
      background: white;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      border-bottom: 1px solid #ddd;
    }

    .menu-icon {
      font-size: 20px;
      cursor: pointer;
    }

    .search-bar {
      flex: 1;
      margin: 0 20px;
    }

    .search-bar input {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 20px;
    }

    .profile {
      font-weight: bold;
    }

    /* Conteúdo */
    .content {
      margin-left: 270px;
      padding: 20px;
    }

    .content h1 {
      margin-bottom: 5px;
    }

    .content p {
      color: #666;
      margin-bottom: 20px;
    }

   /* Filtros */
.filters {
  width: 98%;
  background: #fff;
  padding: 10px;
  border-radius: 10px;
  display: flex;
  border: 1px solid #696969;
  align-items: center;
  margin-bottom: 15px;
  gap: 25px;
}

.filters input {
  flex: 3;
  padding: 12px 12px ;
  border: 1px solid #d8d8d8ff;
  border-radius: 5px;
  font-size: 15px;
  font-weight: 600;
}

.filters select {
  flex: 0.8;
  padding: 12px 12px ;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 15px;
  font-weight: 600;
}

.filters button {
  flex: 0.6;
  margin-left: auto;
  padding: 12px 12px ;
  background: #2563eb;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
    font-size: 15px;
  font-weight: 600;
}

.filters button:hover {
  background: #1d4ed8;
}



  /* Tabela */
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 8px;
      overflow: hidden;
    }

    table thead {
      background: #f0f0f0;
    }

    table th,
    table td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    tbody tr {
      cursor: pointer;
    }

    tbody tr:hover {
      background: #e6f0ff; 
      box-shadow: inset 0 0 5px #6596ff55;
    }

    /* Status */
    .status {
      padding: 4px 10px;
      border-radius: 5px;
      color: white;
      font-size: 0.9em;
    }

    .ativo {
      background: #22c55e;
    }

    .inativo {
      background: #ef4444;
    }

  </style>
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
