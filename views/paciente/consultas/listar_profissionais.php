<?php
    require_once '../../../autentica/verifica_login.php';
    require_once "../../../controllers/PacienteController.php";
    require_once "../../../controllers/ProfissionalController.php";

    require '../../../public/includes/paciente/sidebar.php';
    require '../../../public/includes/paciente/header.php';
    require '../../../public/includes/paciente/footer.php';
    require '../../../public/modals/paciente/agendar_consulta.php';
    
    $idPaciente   = $_SESSION['idPaciente'];
    $nomePaciente = $_SESSION['nomePaciente'];
    $idUsuario    = $_SESSION['idUsuario'];

    $controller    = new PacienteController($conn);
    $profissionais = $controller->listarProfissionaisDisponiveis();
    
    $controllerProfissional   = new ProfissionalController($conn);
    $principaisEspecialidades = $controllerProfissional->principaisEspecialidades();

    $icones = [
       'cardiologista' => '../../../public/assets/imgs/cardiologista.jpg',
       'ortopedista'   => '../../../public/assets/imgs/ortopedista.jpg',
       'oftamologista' => '../../../public/assets/imgs/oftamologista.webp',
       'neurologista'  => '../../../public/assets/imgs/neurologista.jpg'
    ];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MedHub — Página Inicial</title>

    <!-- IMPORT DO CSS -->
    <link rel="stylesheet" href="../../../public/assets/css/paciente/consultas/listar_profissionais.css">

</head>
<body>
    
    <main class="conteudo-principal">
        <?php  include '../../../public/assets/alerta/flash.php' ?>

        <div class="barra-pesquisa">
            <input type="text" id="searchInput" placeholder="Pesquise por especialidade ou profissional...">
            <button id="btnSearch"><i class="fas fa-magnifying-glass"></i></button>
        </div>

        <div class="filtros-especialidade">
            <?php foreach ($principaisEspecialidades as $p): 

            $especialidade = $p['especialidade_principal'];
            $especialidade = str_replace('_', ' ', $especialidade);
            $especialidadeFormatada = ucwords($especialidade); ?>
            <button class="btn-especialidade" data-especialidade="<?= $p['especialidade_principal'] ?>">
                <?= $especialidadeFormatada ?>
            </button>
        <?php endforeach; ?>
        </div>

        <div class="info-profissionais">
            <p><strong id="totalEncontrados">0</strong> Profissionais encontrados</p>
            <span class="disponiveis" id="disponiveisAgora">🟢 Disponíveis agora</span>
        </div>

        <!-- cards -->
        <section id="cards-profissionais"></section>
            
    </main>

<script>
  const modalAgendamento = document.getElementById('modalAgendamento');
  const fecharModalAgendamento = document.getElementById('fecharModalAgendamento');


  function abrirModalAgendamento(idProfissional, nome) {
    document.getElementById('idProfissional').value = idProfissional;
    document.getElementById('nomeProfissional').textContent = nome;
    modalAgendamento.style.display = 'flex';
  }



  fecharModalAgendamento.addEventListener('click', () => {
    modalAgendamento.style.display = 'none';
  });

  window.addEventListener('click', (e) => {
    if (e.target === modalAgendamento) {
      modalAgendamento.style.display = 'none';
    }
  });

  // mostra ou oculta campo de anexo
  document.getElementById('tipoConsulta').addEventListener('change', function() {
    const boxAnexo = document.getElementById('box-anexo');
    boxAnexo.style.display = this.value === 'r' ? 'block' : 'none';
  });

    const botoes = document.querySelectorAll('.btn-especialidade');
    const resultado = document.getElementById('cards-profissionais');
    const dados = <?php echo json_encode($profissionais['dados']); ?>;

    botoes.forEach(botao => {
        botao.addEventListener('click', () => {
            const especialidade = botao.getAttribute('data-especialidade');
            const profissionais_filtrados = [];
            filtrarPorEspecialidade(especialidade);

            dados.forEach(d => {
                const especialidades_medico = JSON.parse(d.especialidade || '[]');
                if(especialidades_medico.includes(especialidade)){
                    profissionais_filtrados.push(d);
                }
            });

            resultado.innerHTML = "";
            profissionais_filtrados.forEach(p => {
                resultado.innerHTML += `
                    <div class="card">
                        <img src="../../../public/assets/imgs/cardiologista.jpg" alt="Dr. Luiz">
                        <div class="card-info">
                            <h3> ${p.nome} </h3>
                            <p class="especialidade">
                            <p class="descricao"> ${p.observacoes} </p>
                            
                        <div class="btn-container">
                            <button class="btn-agendar" 
                                onclick="abrirModalAgendamento(
                                    '${p.id_profissional}',
                                    '${p.nome}'
                                )">
                                <i class="fa-solid fa-calendar-check"></i> Agendar consulta
                            </button>

                            <button class="btn-info">
                                <i class="fa-solid fa-circle-info"></i>
                            </button>
                        </div>
                        </div>
                    </div>
                `;
            });
        });
    });


    // barra de pesquisa
    const especialidadesMap = {
        clinico_geral: "Clínico Geral",
        pediatria: "Pediatria",
        cardiologia: "Cardiologia",
        ortopedia: "Ortopedia",
        dermatologia: "Dermatologia",
        ginecologia: "Ginecologia",
        obstetricia: "Obstetrícia",
        endocrinologia: "Endocrinologia",
        neurologia: "Neurologia",
        oftalmologia: "Oftalmologia",
        otorrinolaringologia: "Otorrinolaringologia",
        psiquiatria: "Psiquiatria",
        urologia: "Urologia",
        psicologia_clinica: "Psicologia Clínica"
    };

    const searchInput = document.getElementById('searchInput');
    const btnSearch = document.getElementById('btnSearch');

    function pesquisar() {
    const query = searchInput.value.toLowerCase().trim();
    if (!query) {
        mostrarProfissionais(dados);
        return;
    }

    const profissionais_filtrados = dados.filter(p => {
        const especialidades_medico = JSON.parse(p.especialidade || '[]');

        const especialidades_labels = especialidades_medico.map(v =>
        (especialidadesMap[v] || v).toLowerCase()
        );

        const nome = p.nome.toLowerCase();
        const especialidade_str = especialidades_labels.join(' ');

        // verifica se o nome ou a especialidade 
        return nome.includes(query) || especialidade_str.includes(query);
    });

    mostrarProfissionais(profissionais_filtrados);
    }

    btnSearch.addEventListener('click', pesquisar);

    //  Pesquisa ao pressionar Enter
    searchInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault(); 
        pesquisar();
    }
    });


    // mostra os cards
    function mostrarProfissionais(lista) {
        resultado.innerHTML = '';

        document.getElementById('totalEncontrados').textContent = lista.length;
        const principais = dados.slice(0, 4); // pega apenas os 4 primeiros
        const container = document.getElementById('principaisProfissionais');

        if (lista.length === 0) {
            resultado.innerHTML = '<p>Nenhum profissional encontrado.</p>';
            return;
        }

        lista.forEach(p => {
            const especialidades_medico = JSON.parse(p.especialidade || '[]');
            resultado.innerHTML += `
                <div class="card">
                    <img src="../../../public/assets/imgs/cardiologista.jpg" alt="${p.nome}">
                    <div class="card-info">
                        <h3>${p.nome}</h3>
                        <p class="descricao">${p.observacoes || ''}</p>

                        <div class="btn-container">
                            <button class="btn-agendar" 
                                onclick="abrirModalAgendamento(
                                    '${p.id_profissional}',
                                    '${p.nome}'
                                )">
                                <i class="fa-solid fa-calendar-check"></i> Agendar consulta
                            </button>

                            <button class="btn-info">
                                <i class="fa-solid fa-circle-info"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
    }


    function filtrarPorEspecialidade(especialidade) {
        const profissionais_filtrados = [];

        dados.forEach(d => {
            const especialidades_medico = JSON.parse(d.especialidade || '[]')
                                        .map(e => e.toLowerCase()); // garante lowercase
            if (especialidades_medico.includes(especialidade.toLowerCase())) {
                profissionais_filtrados.push(d);
            }
        });

        mostrarProfissionais(profissionais_filtrados);
    }

    const primeiroBotao = document.querySelector(".btn-especialidade");
    if (primeiroBotao) {
        const primeiraEspecialidade = primeiroBotao.dataset.especialidade;
        filtrarPorEspecialidade(primeiraEspecialidade);

        botoes.forEach(botao => botao.classList.remove("ativo"));
        primeiroBotao.classList.add("ativo");
    }

    botoes.forEach(botao => {
        botao.addEventListener("click", () => {

            botoes.forEach(b => b.classList.remove("ativo"));
            botao.classList.add("ativo");

            filtrarPorEspecialidade(botao.dataset.especialidade);
        });
    });

</script>

</body>
</html>
