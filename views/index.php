<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Página Principal</title>
    
    <!-- Import do CSS -->
    <link rel="stylesheet" href="../public/assets/css/style_inicio.css">
    <link rel="stylesheet" href="../public/assets/css/style_modal.css">

    <!-- Import do efeito -->
    <script src="../public/assets/js/efeito_fade_in.js"></script>

    <!-- Import do alerta -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/alertas/alerta_logout.js"></script>
    <script src="../assets/alertas/alerta_padrao_pos.js"></script>
</head>
<body>

    <header>
        <div class="interface">
            <div class="logo">
                <a href="#"><img src="../assets/imgs/logo_site.avif" alt="Logo site" class="logo"></a>
            </div>

            <nav class="menu">
                <ul>
                    <li><a href="#inicio">Início</a></li>
                    <li><a href="#servicos">Serviços</a></li>
                    <li><a href="#conheca">Conheça-nos</a></li>
                    <li><a href="#sobre">Sobre</a></li>
                </ul>
            </nav> 
            
            <a href="#" onclick="abrirModal()" id="user-login"> 
                <img src="../assets/icones/icon_user.png" alt="Usuário" class="img-logar">Login
            </a>
        </div>
    </header>

    <!-- Modal de Login -->
    <div class="modal-bg" id="modal-login">
        <div class="modal-box">
            <button class="close-btn" onclick="fecharModal()">&times;</button>
            <div class="container-left">
                <h2>Bem Vindo</h2>
                <p>Organize atendimentos com mais agilidade e segurança. Aqui, sua saúde é prioridade.</p>
            </div>

            <form action="../controllers/UsuarioController.php" method="post" class="form" id="form">
                <h1 class="titleLogin">Login</h1>
                <?php
                    if (isset($_GET['erro'])) {
                        echo '<script> abrirModal(); </script>';
                        echo "
                        <div id='error-message'>
                            <span class='error-text'>".$_GET['erro']."</span>
                            <span class='close-btn2' onclick='fecharMensagemErro()'>&times;</span>
                        </div>
                        <script>
                            if (window.history.replaceState) {
                                window.history.replaceState(null, null, window.location.pathname);
                            }
                        </script>";
                    } else {
                        echo "<div id='error-message' style='visibility: hidden; margin-bottom: -15px;'></div>";
                    }
                ?>
                <input type="hidden" name="acao" value="login">
                <div class="form-control">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF">             
                    <img class="img_success" src="../assets/icones/check.png" alt="">
                    <img class="img_error" src="../assets/icones/exclamation.png" alt="">
                    <small>Msg de erro</small>
                </div>

                <div class="form-control">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" placeholder="Digite sua senha">
                    <img class="img_success" src="../assets/icones/check.png" alt="">
                    <img class="img_error" src="../assets/icones/exclamation.png" alt="">
                    <small>Msg de erro</small>
                </div>

                <input type="submit" id="btn-criar-conta" value="Login">
                <a href="usuario/cadastro.php" id="tenho-conta">Ainda não tenho uma conta</a>
            </form>
        </div>
        <script src="../public/assets/js/validar_login.js"></script>
    </div>

    <div class="conteudo">
    <!-- Seções da página -->
    <section id="inicio" class="fundo-inicial">
        <img src="../public/assets/imgs/fundo_1.png" alt="Início">
    </section>

    <section id="servicos" class="secao-imagem">
        <img src="../public/assets/imgs/servicos.png" alt="Serviços">
    </section>

    <section id="conheca" class="secao-imagem">
        <img src="../public/assets/imgs/conheçanos.png" alt="Conheça-nos">
    </section>

    <footer id="sobre" class="rodape">
        <p>&copy; 2025 - Projeto desenvolvido por Henrique Luiz e Mateus Warmling. Todos os direitos reservados.</p>
    </footer>
    </div>
    <!-- Scroll suave -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(ancora => {
            ancora.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('href');
                const destino = document.querySelector(id);
                destino.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
    </script>

    <?php
        if (isset($_GET['logar']) && $_GET['logar'] == 0) {
        echo "<script>window.addEventListener('DOMContentLoaded', () => {
            alertaEntrada('sucesso');
        });</script>";
        }

        if (isset($_GET['logar']) && $_GET['logar'] == 1) {
        echo "<script>window.addEventListener('DOMContentLoaded', () => {
            alertaEntrada('erro');
        });</script>";
        }


        // alerta exclusao de conta
        if (isset($_GET['alerta'])) {
            if ($_GET['alerta'] == 0) {
                $tipo = 'sucesso';
                $titulo = 'Cancelado';
                $mensagem = 'Paciene excluído e conta inativada com sucesso.';
            }

            if ($_GET['alerta'] == 1) {
                $tipo = 'erro';
                $titulo = 'Erro';
                $mensagem = 'Erro ao reativar a conta. Tente novamente';
            }

            elseif ($_GET['alerta'] == 3) {
                $tipo = 'sucesso';
                $titulo = 'Deletado';
                $mensagem = 'Conta deletada com sucesso.';
            }

            elseif ($_GET['alerta'] == 5) {
                $tipo = 'sucesso';
                $titulo = 'Deletado';
                $mensagem = 'Profissional excluído e conta inativada com sucesso.';
            }

            elseif ($_GET['alerta'] == 2) {
                $tipo = 'sucesso';
                $titulo = 'Sucesso';
                $mensagem = 'Conta inativada com sucesso.';
            }
            
            elseif ($_GET['alerta'] == 4) {
                $tipo = 'erro';
                $titulo = 'Erro';
                $mensagem = 'Erro ao criar a conta. Tente novamente.';
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