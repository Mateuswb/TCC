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
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      background: 
        radial-gradient(900px 500px at 10% 40%, rgba(0, 36, 83, 0.55), rgba(0,74,173,0.05) 60%, transparent 100%),
        radial-gradient(700px 400px at 85% 70%, rgba(0,40,120,0.45), rgba(0,74,173,0.05) 60%, transparent 100%),
        radial-gradient(1200px 600px at 15% 30%, rgba(0,74,173,0.25), transparent 70%),
        linear-gradient(90deg, #cfe7ff 0%, #eaf4ff 0%, #f8fbff 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }

    /* CONTAINER PRINCIPAL */
    .container {
      display: flex;
      width: 90%;
      max-width: 1300px;
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      overflow: hidden;
      min-height: 70vh;
      flex-wrap: wrap;
    }

    /* LADO AZUL */
    .container-left {
      flex: 1 1 35%;
      background-color: #005F9E;
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: relative;
      padding: 60px 40px;
      min-width: 300px;
    }

    .btn-back {
      position: absolute;
      top: 20px;
      left: 20px;
      color: #fff;
      text-decoration: none;
      font-size: 15px;
    }

    .btn-back i {
      margin-right: 6px;
    }

    .container-left h2 {
      font-size: 42px;
      font-weight: 700;
      margin-bottom: 10px;
      text-align: center;
    }

    .container-left p {
      width: 80%;
      font-size: 18px;
      line-height: 1.6;
      text-align: center;
      margin-bottom: 50px;
    }

    #btn-logar {
      background-color: #fff;
      color: #005F9E;
      font-size: 22px;
      border: none;
      padding: 12px 80px;
      border-radius: 30px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    #btn-logar:hover {
      background-color: #eaf1ff;
      transform: scale(1.05);
    }

    /* LADO BRANCO */
    .form {
      flex: 1 1 60%;
      padding: 60px 90px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      position: relative;
      min-width: 300px;
    }

    .form h1 {
      font-size: 34px;
      font-weight: 700;
      color: #000;
      margin-bottom: 25px;
      text-align: center;
    }
    
.radios{
    margin-bottom: 3%;
}


    /* ALERTA FIXO */
    .alert-error {
      position: absolute;
      top: 15px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 10;
      background-color: #ffe5e5;
      color: #b10000;
      border: 1px solid #e89c9c;
      border-radius: 10px;
      padding: 10px 20px;
      font-size: 15px;
      width: 90%;
      max-width: 600px;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .form-control {
      width: 100%;
      margin-bottom: 25px;
      position: relative;
    }

    .form-control label {
      display: block;
      font-weight: 500;
      margin-bottom: 6px;
      color: #333;
      font-size: 16px;
    }

    .form-control input {
      width: 100%;
      padding: 14px 50px 14px 14px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      outline: none;
      transition: all 0.2s ease;
    }

    .form-control input:focus {
      border-color: #1f67d3;
      box-shadow: 0 0 6px rgba(31,103,211,0.3);
    }

    .form-control img {
      width: 22px;
      height: 22px;
      position: absolute;
      right: 15px;
      top: 42px;
      visibility: hidden;
    }

    .form-control small {
      color: red;
      visibility: hidden;
      font-size: 13px;
      margin-top: 5px;
      display: block;
    }

    /* Estados */
    .form-control.success input {
      border: 1px solid #24C100;
    }

    .form-control.error input {
      border: 1px solid #FF0000;
    }

    .form-control.success .img_success {
      visibility: visible;
    }

    .form-control.error .img_error {
      visibility: visible;
    }

    .form-control.error small {
      visibility: visible;
    }

    #btn-criar-conta {
      width: 100%;
      background-color: #005F9E;
      border: none;
      border-radius: 10px;
      color: #fff;
      font-size: 18px;
      padding: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    #btn-criar-conta:hover {
      background-color: #00426eff;
      transform: scale(1.02);
    }

    #tenho-conta {
      margin-top: 15px;
      font-size: 15px;
      color: #1373f0ff;
      text-decoration: none;
      font-weight: 500;
    }

    #tenho-conta:hover {
      text-decoration: underline;
    }

    /* RESPONSIVO */
    @media (max-width: 1100px) {
      .container {
        flex-direction: column;
        height: auto;
      }

      .container-left, .form {
        width: 100%;
        padding: 50px 30px;
      }

      .form {
        padding: 40px 30px;
      }

      .container-left h2 {
        font-size: 34px;
      }

      .container-left p {
        font-size: 16px;
      }

      .form h1 {
        font-size: 28px;
      }

      .alert-error {
        position: static;
        transform: none;
        margin-bottom: 15px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Lado esquerdo -->
    <div class="container-left">
      <a href="../home.php" class="btn-back">
        <i class="fas fa-arrow-left"></i> Voltar
      </a>
      <h2>Seja Bem Vindo</h2>
      <p>Agende com facilidade e segurança. Aqui, sua saúde é prioridade.</p>

    </div>

    <!-- Lado direito -->
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
