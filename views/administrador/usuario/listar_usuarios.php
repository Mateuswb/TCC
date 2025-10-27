<?php
  include "../../../public/includes/administrador/sidebar.php"; 
  include "../../../public/includes/administrador/header.php"; 
  include "../../../public/includes/administrador/footer.php"; 
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

  <!-- IMPORT DO CSS -->
  <link rel="stylesheet" href="../../../public/assets/css/administrador/listar_usuarios.css">
  <link rel="stylesheet" href="../../../public/assets/css/style_padrao.css">


</head>
<body>
  <div class="main">

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
