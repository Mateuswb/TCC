<?php
    $parts = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
    $root = $parts[0]; 
    define("BASE_URL", "/$root");

    session_start();
    $erro = $_SESSION['error'] ?? null;
    unset($_SESSION['error']);
?>
<div class="modal-bg" id="modal-login">
    <div class="modal-box">
        <button class="close-btn" onclick="fecharModal()">&times;</button>

        <!-- Lado esquerdo -->
        <div class="container-left">
            <h2>Bem-vindo</h2>
            <p>Organize atendimentos com mais agilidade e segurança. Aqui, sua saúde é prioridade.</p>
        </div>

        <!-- Lado direito -->
        <form action="<?= BASE_URL ?>/controllers/UsuarioController.php" method="post" class="form" id="form-login">
            <h1 class="titleLogin">Login</h1>
            <input type="hidden" name="acao" value="login">

            <div class="form-control">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF">
                <img class="img_success" src="<?= BASE_URL ?>/public/assets/icones/check.png" alt="">
                <img class="img_error" src="<?= BASE_URL ?>/public/assets/icones/exclamation.png" alt="">
                <small>Msg de erro</small>
            </div>

            <div class="form-control">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" placeholder="Digite sua senha">
                <img class="img_success" src="<?= BASE_URL ?>/public/assets/icones/check.png" alt="">
                <img class="img_error" src="<?= BASE_URL ?>/public/assets/icones/exclamation.png" alt="">
                <small>Msg de erro</small>
            </div>

            <input type="submit" id="btn-criar-conta" value="Entrar">
            <a href="usuario/cadastro.php" id="tenho-conta">Ainda não tenho uma conta</a>
            <small>Msg de erro</small>
        </form>
    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

/* ===== MODAL BASE ===== */
.modal-bg {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.55);
    backdrop-filter: blur(8px);
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

/* ===== CAIXA PRINCIPAL ===== */
.modal-box {
    display: flex;
    max-width: 1200px;
    min-height: 550px;
    background: rgba(255,255,255,0.85);
    border-radius: 18px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 8px 30px rgba(0,0,0,0.35);
    animation: fadeIn 0.3s ease-in-out;
}

/* Fundo azulado borrado dentro do modal */
.modal-box::before {
    content: "";
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 80% 20%, rgba(0,80,180,0.35), transparent 60%),
                radial-gradient(circle at 20% 80%, rgba(0,60,150,0.35), transparent 60%);
    filter: blur(80px);
    z-index: 0;
}

/* Conteúdo acima do blur */
.modal-box > * {
    position: relative;
    z-index: 1;
}

/* ===== BOTÃO FECHAR ===== */
.close-btn {
    position: absolute;
    top: 18px;
    right: 25px;
    font-size: 30px;
    color: #333;
    background: none;
    border: none;
    cursor: pointer;
    transition: 0.3s;
    z-index: 10;
}
.close-btn:hover {
    color: #000;
    transform: scale(1.15);
}

/* ===== LADO ESQUERDO ===== */
.container-left {
    width: 40%;
    background: linear-gradient(135deg, #0b3b88 40%, #0e58a3 100%);
    color: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 70px 50px;
    text-align: center;
}
.container-left h2 {
    font-size: 44px;
    font-weight: 700;
    margin-bottom: 15px;
}
.container-left p {
    font-size: 19px;
    font-weight: 400;
    opacity: 0.9;
    line-height: 1.6;
}

/* ===== LADO DIREITO (FORMULÁRIO) ===== */
.form {
    width: 60%;
    padding: 60px 65px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(15px);
    border-left: 1px solid rgba(255,255,255,0.4);
    border-top: 1px solid rgba(255,255,255,0.3);
    border-radius: 12px;
    text-align: center;
}

/* ===== TÍTULO ===== */
.titleLogin {
    font-size: 40px;
    font-weight: 700;
    color: #0b2e6f;
    margin-bottom: 40px;
}

/* ===== CAMPOS ===== */
.form-control {
    position: relative;
    margin-bottom: 25px;
    width: 100%;
    text-align: left;
}
.form-control label {
    display: block;
    margin-bottom: 6px;
    color: #0a0a0a;
    font-size: 17px;
    font-weight: 500;
}
.form-control input {
    width: 100%;
    height: 54px;
    padding: 30px 10px 30px 10px;
    border-radius: 10px;
    border: 1.5px solid #ccc;
    font-size: 18px;
    background: rgba(255,255,255,0.9);
    transition: 0.2s;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    outline: none;
}
.form-control input:focus {
    border-color: #1f67d3;
    box-shadow: 2 1 8px rgba(31,103,211,0.25);
}

/* Ícones de validação */
.form-control img {
    width: 22px;
    height: 22px;
    position: absolute;
    right: 20px;
    top: 50px;
    visibility: hidden;
}
.form-control img_success { visibility: hidden; }
.form-control img_error { visibility: hidden; }

.form-control.success input { border-color: #24C100; }
.form-control.error input { border-color: #FF0000; }
.form-control.success .img_success { visibility: visible; }
.form-control.error .img_error { visibility: visible; }

.form-control img, small{
    visibility: hidden;
}
.form-control.error small{
    visibility: visible;
    color: #FF0000;
}


/* Style da msg de erro */
#error-message{
    background-color: #ffeef0;
    color: #86181d;
    border: 1px solid #e63042;
    padding: 10px 15px;
    margin-top: 0px;
    border-radius: 6px;
    margin-bottom: 10px;
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

/* ===== BOTÕES ===== */
#btn-criar-conta {
    width: 100%;
    height: 56px;
    background: linear-gradient(180deg, #0b3b88, #092b63);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 20px;
    font-weight: 600;
    letter-spacing: 0.6px;
    margin-top: 10px;
    transition: 0.25s;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.25);
}
#btn-criar-conta:hover {
    background: linear-gradient(180deg, #104ca0, #0b3b88);
    transform: translateY(-2px);
}

/* ===== LINK ABAIXO ===== */
#tenho-conta {
    margin-top: 15px;
    font-size: 16px;
    color: #0d47a1;
    text-decoration: none;
}
#tenho-conta:hover {
    text-decoration: underline;
}

/* ===== ERROS GERAIS ===== */
#error-message {
    background-color: #ffeef0;
    color: #86181d;
    border: 1px solid #e63042;
    padding: 12px 18px;
    border-radius: 8px;
    font-size: 15px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    animation: fadeIn 0.3s ease-in-out;
}
.close-btn2 {
    background: none;
    border: none;
    font-size: 18px;
    color: #86181d;
    cursor: pointer;
}
.close-btn2:hover {
    color: #d73a49;
}

/* ===== RESPONSIVIDADE ===== */
@media (max-width: 950px) {
    .modal-box {
        flex-direction: column;
        width: 90%;
        min-height: auto;
    }
    .container-left, .form {
        width: 100%;
        padding: 40px 30px;
    }
    .container-left h2 {
        font-size: 32px;
    }
}

/* ===== ANIMAÇÃO ===== */
@keyframes fadeIn {
    from {opacity: 0; transform: scale(0.95);}
    to {opacity: 1; transform: scale(1);}
}

</style>

<script>
const modal = document.getElementById("modal-login");
function abrirModal() { modal.style.display = "flex"; }
function fecharModal() { modal.style.display = "none"; }

window.onclick = function(e) {
    if (e.target === modal) fecharModal();
};
</script>

<script src="<?= BASE_URL ?>/public/assets/js/validar_login.js"></script>

<?php if ($erro): ?>
<script>
window.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal-login");
    modal.style.display = "flex";
    const form = document.getElementById("form-login");
    if (form) {
        const msg = document.createElement("div");
        msg.id = "error-message";
        msg.innerHTML = `
            <span><?= htmlspecialchars($erro) ?></span>
            <button class="close-btn2" onclick="this.parentElement.remove()">×</button>
        `;
        form.prepend(msg);
    }
});
</script>
<?php endif; ?>