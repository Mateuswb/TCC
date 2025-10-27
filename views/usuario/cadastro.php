<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Import do CSS -->
    <link rel="stylesheet" href="../../public/assets/css/usuario/criar_conta.css">
    <!-- <link rel="stylesheet" href="../../public/assets/css/efect_surgindo.css"> -->

    <!-- inport dos Icones-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 

</head>
<body >
    <div class="container">
        <div class="container-left">
            <a href="../inicio/index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            <h2>Bem Vindo</h2>
            <p>Organize atendimentos com mais agilidade e segurança. Aqui, sua saúde é prioridade.</p>
            <a href="../inicio/index.php"><button id="btn-logar">Login</button></a>
            
        </div>
        <form action="../../controllers/UsuarioController.php" method="POST" class="form" id="form" >
            <h1 id="title-cadastra">Cadastre-se</h1>
                <input type="hidden" name="tipoUsuario" value="paciente">
                <input type="hidden" name="status" value="ativo">
                <input type="hidden" name="acao" value="salvarUsuario">

                <div class="form-control" >
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Digite seu cpf">
                    <img class="img_success" src="../assets/icones/check.png" alt="">
                    <img class="img_error" src="../assets/icones/exclamation.png"alt="">
                    <small>Msg de erro</small>
                </div>

                <div class="form-control" >
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" placeholder="Digite sua senha">
                     <img class="img_success" src="../assets/icones/check.png" alt="">
                    <img class="img_error" src="../assets/icones/exclamation.png"alt="">
                    <small>Msg de erro</small>
                </div>

                <div class="form-control" >
                    <label for="password-confirmation">Confirme sua senha</label>
                    <input type="password" id="passwordConfirmation" name="passwordConfirmation" placeholder="Confirme sua senha">
                    <img class="img_success" src="../assets/icones/check.png" alt="">
                    <img class="img_error" src="../assets/icones/exclamation.png"alt="">
                    <small>Msg de erro</small>
                </div>

                <input type="submit" id="btn-criar-conta" value="Criar conta" >
                <a href="../inicio/index.php" id="tenho-conta">Já tenho uma conta</a>
        </form>
    </div>

    <script src="../assets/js/validar_usuario.js"></script>
    
</body>
</html>
