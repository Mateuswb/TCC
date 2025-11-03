<?php
  include '../../../autentica/verifica_login.php';
  include "../../../public/includes/administrador/sidebar.php"; 
  include "../../../public/includes/administrador/header.php"; 
  include "../../../public/includes/administrador/footer.php"; 
  require_once "../../../controllers/AdministradorController.php";

  require "../../../public/modals/administrador/usuario/editar_usuario.html";
  require "../../../public/modals/administrador/usuario/deletar_usuario.html";
  require "../../../public/modals/administrador/usuario/bloquear_usuario.html";

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
      <?php
        include '../../../public/assets/alerta/flash.php';
      ?>
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
                  <button class="btn edit" 
                      data-id="<?= $usuario['id_usuario']; ?>" 
                      data-login="<?= $usuario['login']; ?>" 
                      data-tipo="<?= $usuario['tipo_usuario']; ?>"
                      onclick="abrirModalEditarUsuario(this)">
                      <i class="fas fa-edit"></i>
                  </button>
                </td>

                <td>
                  <a href="bloquear_user.php?id_usuario=<?= $usuario['id_usuario'];?>" class="btn bloq"
                    onclick="confirmarBloqueio(this.href); return false;">
                    <i class="fas fa-user-slash"></i>
                  </a>
                </td>
                <td>
                  <button class="btn delete" 
                      data-id="<?= $usuario['id_usuario']; ?>" 
                      data-cpf="<?= $usuario['login']; ?>" 
                      onclick="abrirModalDeletarUsuario(this)">
                      <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("collapsed");
    }
  </script>
</body>
</html>

