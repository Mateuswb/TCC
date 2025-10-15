<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modal Login</title>
<style>
    /* Reset básico */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: #f0f2f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    /* Modal */
    .modal-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-box {
        width: 800px;
        max-width: 90%;
        display: flex;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        background: #fff;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: scale(0.9);}
        to {opacity: 1; transform: scale(1);}
    }

    .container-left {
        background: #0D47A1;
        color: #fff;
        padding: 40px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 20px;
        position: relative;
    }

    .container-left h2 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .container-left p {
        font-size: 16px;
        line-height: 1.4;
    }

    .container-left img {
        position: absolute;
        bottom: 20px;
        right: 20px;
        width: 150px;
    }

    .container-right {
        flex: 1;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .container-right h2 {
        font-size: 28px;
        margin-bottom: 30px;
        text-align: center;
    }

    .container-right input {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
    }

    .container-right button {
        width: 100%;
        padding: 12px;
        background: #0D47A1;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }

    .container-right button:hover {
        background: #08306b;
    }

    .container-right .links {
        margin-top: 15px;
        text-align: center;
    }

    .container-right .links a {
        color: #0D47A1;
        text-decoration: none;
        margin: 0 5px;
        font-size: 14px;
    }

    .close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 24px;
        background: none;
        border: none;
        cursor: pointer;
        color: #fff;
    }

    @media(max-width: 768px) {
        .modal-box {
            flex-direction: column;
        }

        .container-left, .container-right {
            flex: none;
            width: 100%;
        }

        .container-left img {
            position: static;
            margin-top: 20px;
            width: 100px;
            align-self: center;
        }
    }
</style>
</head>
<body>

<div class="modal-bg" id="modal-login">
    <div class="modal-box">
        <div class="container-left">
            <button class="close-btn" onclick="fecharModal()">&times;</button>
            <h2>Seja Bem Vindo</h2>
            <p>Atendimentos ágeis e seguros. Sua saúde em primeiro lugar.</p>
            <!-- Substitua pelo seu SVG ou imagem -->
            <img src="https://cdn-icons-png.flaticon.com/512/2920/2920112.png" alt="Ilustração">
        </div>
        <div class="container-right">
            <h2>Login</h2>
            <input type="text" placeholder="Digite seu CPF" id="cpf">
            <input type="password" placeholder="Digite sua Senha" id="senha">
            <button onclick="login()">Login</button>
            <div class="links">
                <a href="#">Esqueci minha senha</a> | <a href="#">Criar Conta</a>
            </div>
        </div>
    </div>
</div>

<script>
    function fecharModal() {
        document.getElementById('modal-login').style.display = 'none';
    }

    function login() {
        const cpf = document.getElementById('cpf').value;
        const senha = document.getElementById('senha').value;
        alert(`CPF: ${cpf}\nSenha: ${senha}`);
        // Aqui você pode integrar com seu backend
    }
</script>

</body>
</html>
