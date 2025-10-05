<?php
    require_once "../../autentica/verifica_login.php";
    require_once "../../controllers/PacienteController.php";

    $idPaciente = $_SESSION['idPaciente'];
    $nomePaciente = $_SESSION['nomePaciente'];
    $idUsuario = $_SESSION['idUsuario'];


    $controller = new PacienteController($conn);
    $profissionais = $controller->listarProfissionaisDisponiveis();

    $icones = [
        'cardiologista' => '../../public/assets/imgs/cardiologista.jpg',
        'ortopedista' => '../assets/imgs/ortopedista.jpg',
        'oftamologista' => '../assets/imgs/oftamologista.webp',
        'neurologista' => '../public/assets/imgs/neurologista.jpg'
    ];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Página Inicial</title>

    <!-- CSS -->
    <link rel="stylesheet" href="/tcc/public/assets/css/style_home.css" />

    <!-- Alertas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/tcc02/public/assets/alertas/alerta_entrada.js"></script>
    <script src="../../public/assets/alertas/alerta_padrao_pos.js"></script>
    <script src="../../public/assets/js/"></script>
    <script src="../../public/assets/js/recarrega_pagina.js"></script>

</head>


<body>
    <header>
        <div class="interface">
            <div class="logo">
                <a href="#"><img src="../assets/imgs/logo_site.avif" alt="Logo site" class="logo"></a>
            </div>
            <nav class="menu">
                <ul>
                    <li><a href="encaminhamento/listar_encaminhamentos.php">Contatos</a></li>
                    <li><a href="#">Serviços</a></li>
                    <li><a href="../agendamento/agendar.html">Consultas Agendadas</a></li>
                    <li><a href="historico_consultas.php">Histórico de Consultas</a></li>
                </ul>
            </nav>
            <div class="avatar" id="avatar">GGG</div>
        </div>
    </header>

    <!-- SUB-MENU -->
    <div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
            <div class="user-info">
                <div class="avatar-sub-menu">TESTE</div>
                <h2>Teste</h2>
            </div>
            <hr>
            <a href="perfil.php" class="sub-menu-link">
                <img class="img-sub-menu" src="../../public/assets/icones/editar.png" alt="Editar Perfil">
                <p>Editar Perfil</p>
                <span>></span>
            </a>
            <a href="historico_consultas.php" class="sub-menu-link">
                <img class="img-sub-menu" src="../../public/assets/icones/editar.png" alt="Editar Perfil">
                <p>Histórico de consultas</p>
                <span>></span>
            </a>
            <a href="../logout/logout.php" class="sub-menu-link">
                <img class="img-sub-menu" src="../../public/assets/icones/sair.png" alt="Sair">
                <p>Sair</p>
                <span>></span>
            </a>
        </div>
    </div>

    <p>ID do Paciente logado: <?php echo $idPaciente; ?></p>
    <p>nomePaciente: <?php echo $nomePaciente; ?></p>
    <p>idUsuario: <?php echo $idUsuario; ?></p>


    <!-- SEÇÃO PRINCIPAL -->
    <section class="main-top">
        <h1>Agende suas consultas de forma rápida</h1>
        <p>Simplifique sua rotina de saúde com nosso sistema inteligente, agende suas consultas de <br> forma rápida e sem complicações</p>
    </section>

    <h2 class="sub-title">Profissionais qualificados prontos para cuidar de você.</h2>

    <!-- CARDS DE PROFISSIONAIS -->
    <section class="cards-container">
        <?php foreach($profissionais as $profissional){
            $img_card = $icones[$profissional['especialidade']] ?? '';
        ?>
            <div class="card-servico">
                <img src="<?php echo $img_card ?>" class="imagem-topo">
                <div class="conteudo">
                    <h3><?php echo $profissional['nome']; ?></h3>
                    <h3 class="titulos">Especialidade: <?php echo $profissional['especialidade'] ?></h3>
                    <p><?php echo $profissional['observacoes']; ?></p>
                    <a href="../agendamento/agendar_consulta.php?idProfissional=<?php echo $profissional['id_profissional']; ?>" class="btn-agendar">
                        Agendar Consulta
                    </a>
                </div>
            </div>
        <?php }?>
    </section>

    <!-- SCRIPT SUB-MENU -->
    <script>
        const subMenu = document.getElementById("subMenu");
        const avatar = document.getElementById("avatar");

        avatar.addEventListener('click', (e) => {
            e.stopPropagation();
            subMenu.classList.toggle("open-menu");
        });

        document.addEventListener('click', (event) => {
            if (!subMenu.contains(event.target) && event.target !== avatar) {
                subMenu.classList.remove('open-menu');
            }
        });
    </script>

    <!-- FOOTER -->
    <footer id="sobre" class="rodape">
        <p>&copy; 2025 - Projeto desenvolvido por Henrique Luiz e Mateus Warmling. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
