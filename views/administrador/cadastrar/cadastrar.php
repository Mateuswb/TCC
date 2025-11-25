<?php
    require '../../../autentica/verifica_login.php';
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Conta</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 

  <!-- IMPORT DO CSS -->
  <link rel="stylesheet" href="../../../public/assets/css/administrador/cadastrar/cadastro_usuario.css">
</head>
<body>
  <div class="container">
    <div class="container-left">
      <a href="../home.php" class="btn-back">
        <i class="fas fa-arrow-left"></i> Voltar
      </a>
      <h2>Seja Bem Vindo</h2>
      <p>Agende com facilidade e segurança. Aqui, sua saúde é prioridade.</p>

    </div>

    <form action="../../../controllers/UsuarioController.php" method="POST" class="form" id="form">
      <h1>Criar Conta</h1>

      <input type="hidden" name="status" value="ativo">
                <input type="hidden" name="acao" value="salvarUsuario">

      <?php
        if (isset($_SESSION['error'])) {
          echo "<div class='alert-error'>" . $_SESSION['error'] . "</div>";
          unset($_SESSION['error']);
        }
      ?>
      <div class="form-control">
        <label for="cpf">CPF</label>
        <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF">
        <img class="img_success" src="../../public/assets/icones/check.png" alt="">
        <img class="img_error" src="../../public/assets/icones/exclamation.png" alt="">
        <small>CPF inválido</small>
      </div>

      <div class="form-control">
        <label for="password">Senha</label>
        <input type="password" id="password" name="password" placeholder="Digite sua senha">
        <img class="img_success" src="../../public/assets/icones/check.png" alt="">
        <img class="img_error" src="../../public/assets/icones/exclamation.png" alt="">
        <small>A senha deve ter no mínimo 6 caracteres</small>
      </div>

      <div class="form-control">
        <label for="passwordConfirmation">Confirmar Senha</label>
        <input type="password" id="passwordConfirmation" name="passwordConfirmation" placeholder="Confirme sua senha">
        <img class="img_success" src="../../public/assets/icones/check.png" alt="">
        <img class="img_error" src="../../public/assets/icones/exclamation.png" alt="">
        <small>As senhas não coincidem</small>
      </div>

      <div class="radios">
        <input type="radio" name="tipoUsuario" value="profissional" id="profissional" checked>
        <label for="profissional">Profissional</label>

        <input type="radio" name="tipoUsuario" value="admin" id="admin">
        <label for="admin">Administrador</label>

        <input type="radio" name="tipoUsuario" value="paciente" id="paciente">
        <label for="paciente">Paciente</label>
        </div>

      <input type="submit" id="btn-criar-conta" value="Criar Conta">
    </form>
  </div>

  <script src="../../../public/assets/js/validar_usuario.js"></script>
</body>
</html>
