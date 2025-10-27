<?php
    require_once "../../../controllers/AdministradorController.php";

    $controller = new AdministradorController($conn);
    $usuario = $controller->listarDadosUsuario();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar perfil</title>

  <!-- IMPORT DO CSS -->
  <link rel="stylesheet" href="../../../public/assets/css/style_editar_conta.css">
</head>

<body>
  <div class="container">
      <a href="listar_usuarios.php" class="btn-back">
        <i class="fas fa-arrow-left"></i> Voltar
      </a>
      <h1>Editar dados da conta</h1>
        
      <form action="editar.php" method="post" id="form">
          <input type="hidden" name="idUsuario" value="<?php echo $usuario['id_usuario']; ?>">
          <input type="hidden" name="tipoUsuario" value="<?php echo $usuario['tipo_usuario']; ?>">

          <!-- Dados do usuário -->
          <div class="form-control">
              <label for="cpf">CPF</label>
              <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" value="<?php echo $usuario['login']; ?>">
              <img class="img_success" src="../assets/icones/check.png" alt="">
              <img class="img_error" src="../assets/icones/exclamation.png" alt="">
              <small>Msg de erro</small>
          </div>

          <div class="form-control">
              <label for="password">Senha</label>
              <input type="password" id="password" name="password" placeholder="Digite sua nova senha">
              <img class="img_success" src="../assets/icones/check.png" alt="">
              <img class="img_error" src="../assets/icones/exclamation.png" alt="">
              <small>Msg de erro</small>
          </div>

          <div class="form-control">
              <label for="passwordConfirmation">Confirme sua senha</label>
              <input type="password" id="passwordConfirmation" name="passwordConfirmation" placeholder="Confirme sua nova senha">
              <img class="img_success" src="../assets/icones/check.png" alt="">
              <img class="img_error" src="../assets/icones/exclamation.png" alt="">
              <small>Msg de erro</small>
          </div>

          <div class="form-control">
              <label for="status">Status</label>
              <select name="status" id="status">
                <option value="ativo" <?php if($usuario['status'] == 'ativo') echo 'selected'; ?> >Ativo</option>
                <option value="inativo" <?php if($usuario['status'] == 'inativo') echo 'selected'; ?> >Inativo</option>           
                <option value="bloqueado" <?php if($usuario['status'] == 'bloqueado') echo 'selected'; ?> >Bloqueado</option>           
              </select>
              <small>Msg de erro</small>
          </div>
          <input type="submit" value="Salvar" class="btn-salvar">
      </form>

</body>
</html>
