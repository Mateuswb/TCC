<?php
  include("../../login/verifica.php");
  include("../../conexao_bd/conexao.php");

  $sql = "SELECT * FROM usuarios WHERE tipo_usuario = 'admin' ";
  $res = mysqli_query($id, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Usuários</title>

    <!-- IMPORT DO CSS -->
    <link rel="stylesheet" href="../../../public/assets/css/style_listar_usuario.css">

    <!-- Import dos Icones-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Import do alerta -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/alertas/alerta_bloquear_admin.js"></script>
    <script src="../../assets/alertas/alerta_padrao_pos.js"></script>

</head>

<body>
  <aside class="sidebar">
    <h2>Clínica</h2>
    <a href="../home/home.php"><i class="fas fa-home"></i> Home</a>
    <a href="../cadastrar_usuario/form_cadastrar.html"><i class="fas fa-user-plus"></i> Cadastrar Usuário</a>
    <a href="../profissionais/form_listar.php"><i class="fas fa-user-md"></i> Profissionais</a>
    <a href=""><i class="fas fa-user-shield"></i> Administradores</a>
    <a href="../pacientes/form_listar.php"><i class="fas fa-user-injured"></i> Pacientes</a>
    <a href="../usuarios/form_listar.php"><i class="fas fa-users"></i> Usuários</a>
    <a href="../agenda/form_listar.php"><i class="fas fa-calendar-check"></i> Agendamentos</a>
    <a href="../form_logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
  </aside>
    
  <h1 id="title">Administradores</h1>
    <div class="main-container">
      

      <div class="table-wrapper">
        <table class="styled-table">

            <tr>
              <th>Login</th>
              <th>Tipo</th>
              <th>Status</th>
              <th>Data Criação</th>
              <th>Editar</th>
              <th>Bloquear</th>
            </tr>

          <?php while ($linha = mysqli_fetch_array($res)) { ?>
            <tr>
              <td><?php echo $linha['login']; ?></td>
              <td><?php echo $linha['tipo_usuario']; ?></td>
              <td>
                <span class="status <?php echo $linha['status']; ?>">
                    <?php echo $linha['status']; ?>
                </span>
              </td>

              <td><?php echo $linha['data_criacao']; ?></td>

              <td>
                <a href="form_editar.php?id_usuario=<?php echo $linha['id_usuario']; ?>" class="btn edit">
                  <i class="fas fa-edit"></i>
                </a>
              </td>

              <td>
                <a href="bloquear.php?id_usuario=<?php echo $linha['id_usuario']; ?>" class="btn delete" 
                onclick="confirmarBloqueio(this.href); return false;">
                  <i class="fas fa-user-slash"></i>
                </a>
              </td>

            </tr>
          <?php } ?>
        </table>
      </div>
    </div>


    <?php
      if (isset($_GET['alerta'])) {
          if ($_GET['alerta'] == 0) {
              $tipo = 'sucesso';
              $titulo = 'Atualizado';
              $mensagem = 'Administrador bloqueado com sucesso.';
          } 
          elseif($_GET['alerta'] == 1) {
              $tipo = 'erro';
              $titulo = 'Erro';
              $mensagem = 'Erro ao bloquear administrador. Tente novamente';
          } 
          echo "<script>
              window.addEventListener('DOMContentLoaded', () => {
                  alertaPadraoPos('$tipo', '$titulo', '$mensagem');
              });
          </script>";
      }
    ?>
</body>
</html>