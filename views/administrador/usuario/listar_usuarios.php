<?php
include "../../../public/includes/sidebar.php";
require_once "../../../controllers/AdministradorController.php";

$controller = new AdministradorController($conn);
$usuarios = $controller->listarUsuarios();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lista de Usuários</title>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="<?= BASE_URL ?>/public/assets/alertas/alerta_bloquear_usuario.js"></script>
  <script src="<?= BASE_URL ?>/public/assets/alertas/alerta_deleta_usuario.js"></script>
  <script src="<?= BASE_URL ?>/public/assets/alertas/alerta_padrao_pos.js"></script>

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

    .main {
      margin-left: 250px;
      flex: 1;
      display: flex;
      flex-direction: column;
      transition: margin-left 0.3s;
    }

    .sidebar.collapsed ~ .main {
      margin-left: 80px;
    }

    /* Header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #085274;
      color: #fff;
      padding: 15px 30px;
    }

    .header input {
      padding: 8px 12px;
      border: none;
      border-radius: 20px;
      outline: none;
      width: 200px;
    }

    .profile {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .profile img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }

    .menu-btn {
      cursor: pointer;
      font-size: 20px;
      margin-right: 15px;
    }

    /* Conteúdo */
    .content {
      padding: 30px;
    }

    h1 {
      color: #2980b9;
      text-align: center;
      margin-bottom: 30px;
      font-weight: 700;
    }

    .table-wrapper {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 14px 20px;
      text-align: left;
      font-size: 14px;
    }

    th {
      background: #2980b9;
      color: #fff;
      font-weight: 600;
    }

    tr:nth-child(even) {
      background: #f9f9f9;
    }

    tr:hover {
      background: #e1f0ff;
    }

    .status.active {
      color: green;
      font-weight: bold;
    }

    .status.inativo {
      color: red;
      font-weight: bold;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 6px 10px;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 600;
      color: #fff;
      text-decoration: none;
      transition: 0.3s;
      margin-right: 5px;
    }

    .btn.edit {
      background: #2980b9;
    }
    .btn.edit:hover {
      background: #1f6391;
    }

    .btn.bloq {
      background: #f39c12;
    }
    .btn.bloq:hover {
      background: #d88c0f;
    }

    .btn.delete {
      background: #c0392b;
    }
    .btn.delete:hover {
      background: #b12e22;
    }

    @media (max-width: 768px) {
      th, td {
        padding: 10px 12px;
        font-size: 13px;
      }
      .btn {
        padding: 5px 8px;
        font-size: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="main">
    <!-- Header -->
    <div class="header">
      <div class="menu-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
      </div>
      <input type="text" placeholder="Pesquisar...">
      <div class="profile">
        <img src="https://i.pravatar.cc/100" alt="user">
        <div>
          <strong>Administrador</strong><br>
          <small>Admin</small>
        </div>
      </div>
    </div>

    <!-- Conteúdo -->
    <div class="content">
      <h1>Lista de Usuários</h1>
      <div class="table-wrapper">
        <table>
          <thead>
            <tr>
              <th>Login</th>
              <th>Tipo</th>
              <th>Status</th>
              <th>Data Criação</th>
              <th>Editar</th>
              <th>Bloquear</th>
              <th>Deletar</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($usuarios as $usuario): ?>
              <tr>
                <td><?= $usuario['login']; ?></td>
                <td><?= $usuario['tipo_usuario']; ?></td>
                <td><span class="status <?= $usuario['status']; ?>"><?= $usuario['status']; ?></span></td>
                <td><?= $usuario['data_criacao']; ?></td>
                <td>
                  <a href="editar_usuario.php?id_usuario=<?= $usuario['id_usuario']; ?>" class="btn edit">
                    <i class="fas fa-edit"></i>
                  </a>
                </td>
                <td>
                  <a href="bloquear_user.php?id_usuario=<?= $usuario['id_usuario'];?>" class="btn bloq"
                     onclick="confirmarBloqueio(this.href); return false;">
                    <i class="fas fa-user-slash"></i>
                  </a>
                </td>
                <td>
                  <a href="excluir.php?id_usuario=<?= $usuario['id_usuario']; ?>" class="btn delete"
                     onclick="confirmarDeletarUsuario(this.href); return false;">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("collapsed");
    }
  </script>

  <?php
     if (isset($_GET['alerta'])) {
        $alertas = [
          0 => ['sucesso', 'Atualizado', 'Usuário bloqueado com sucesso.'],
          1 => ['erro', 'Erro', 'Erro ao bloquear usuário. Tente novamente.'],
          2 => ['sucesso', 'Deletado', 'Usuário deletado com sucesso.'],
          3 => ['erro', 'Erro', 'Erro ao deletar usuário. Tente novamente.']
        ];
        [$tipo, $titulo, $mensagem] = $alertas[$_GET['alerta']] ?? ['info', 'Aviso', 'Ação inválida.'];

        echo "<script>
          window.addEventListener('DOMContentLoaded', () => {
              alertaPadraoPos('$tipo', '$titulo', '$mensagem');
          });
        </script>";
     }
  ?>
</body>
</html>
