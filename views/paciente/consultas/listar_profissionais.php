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

<style>
  #overlay-fundo {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(6px);
    background-color: rgba(0,0,0,0.3); 
    opacity: 0; 
    visibility: hidden;
    z-index: 900;
    transition: opacity 0.4s ease, backdrop-filter 0.4s ease;
  }

  #overlay-fundo.ativo {
    opacity: 1;
    visibility: visible;
  }

  .card-profissional {
    transition: transform 0.4s ease, width 0.4s ease, height 0.4s ease, box-shadow 0.4s ease;
  }

  .card-profissional.expandido {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(1.2);
    width: 500px;
    height: 550px;
    z-index: 1000;
    box-shadow: 0 20px 40px rgba(0,0,50,0.5);
  }


  .card-profissional.expandido .overlay-card {
      
    padding: 35px;
  }


  .info-extra {
    display: none; 
    margin-top: 15px;
    font-size: 0.95rem;
    color: #333;
    text-align: justify;
    line-height: 1.3;
  }

  .card-profissional.expandido .info-extra {
    display: block;
    animation: fadeIn 0.4s ease;
  }
  .info-extra strong {
    color: #00236eff; 
    font-weight: 650;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

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

const fundos = [
  "../../../public/assets/fundos/fundo1.jpg",
  "../../../public/assets/fundos/fundo2.jpeg",
  "../../../public/assets/fundos/fundo3.avif"
];

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
  if (e.target === modalAgendamento) modalAgendamento.style.display = 'none';
});


document.getElementById('tipoConsulta')?.addEventListener('change', function() {
  const boxAnexo = document.getElementById('box-anexo');
  if (boxAnexo) boxAnexo.style.display = this.value === 'r' ? 'block' : 'none';
});

const botoes = document.querySelectorAll('.btn-especialidade');
const resultado = document.getElementById('cards-profissionais');
const dados = <?php echo json_encode($profissionais['dados']); ?>;

// mostraR os cards
function mostrarProfissionais(lista) {
  resultado.innerHTML = '';

  document.getElementById('totalEncontrados').textContent = lista.length;

  if (lista.length === 0) {
    resultado.innerHTML = '<p>Nenhum profissional encontrado.</p>';
    return;
  }

  lista.forEach(p => {
    const coresFundo = ['001F3F', '003F7D', '0066CC'];


    const coresTexto = ['ffffff'];

    const avatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(p.nome)}&background=${coresFundo[Math.floor(Math.random() * coresFundo.length)]}&color=${coresTexto[Math.floor(Math.random() * coresTexto.length)]}&size=128`;

    const imgFundo = fundos[Math.floor(Math.random() * fundos.length)];

    resultado.innerHTML += `
      <div class="card-profissional" style="background-image: url('${imgFundo}');">
        <div class="overlay-card">
          <div class="foto-container">
            <img src="${avatar}" alt="Foto de ${p.nome}">
          </div>
          <h3>${p.nome}</h3>
          <p class="descricao">${p.observacoes || ''}</p>

          <div class="info-extra">
            <p><strong>Idade:</strong> ${p.idade} anos</p>
            <p><strong>CRM:</strong> ${p.crm_crp}</p>
            <p><strong>Especialidades adicionais:</strong> 
              ${p.exames_atendidos ? p.exames_atendidos : 'Nenhum'}
            </p>
            <p><strong>Consultas realizadas:</strong> ${p.total_agendamentos}</p>
            <p><strong>Tempo médio de consulta:</strong> 30 minutos</p>
          </div>
          
          <div class="botoes">
            <button class="btn-agendar" onclick="abrirModalAgendamento('${p.id_profissional}', '${p.nome}')">
              <i class="fa-solid fa-calendar-check"></i> Agendar consulta
            </button>
             <button class="btn-info" onclick="toggleCard(this)">
                <i class="fa-solid fa-circle-info"></i>
            </button>
          </div>
        </div>
      </div>
    <div id="overlay-fundo"></div>
    `;
  });
}

function toggleCard(btn) {
  const card = btn.closest('.card-profissional');
  const overlay = document.getElementById('overlay-fundo');

  card.classList.toggle('expandido');

  if(card.classList.contains('expandido')) {
    overlay.classList.add('ativo');
  } else {
    overlay.classList.remove('ativo');
  }

  overlay.onclick = () => {
    card.classList.remove('expandido');
    overlay.classList.remove('ativo');
  }
}


// Filtro por especialidade
function filtrarPorEspecialidade(especialidade) {
  const filtrados = dados.filter(d => {
    const especialidades_medico = JSON.parse(d.especialidade || '[]').map(e => e.toLowerCase());
    return especialidades_medico.includes(especialidade.toLowerCase());
  });
  mostrarProfissionais(filtrados);
}

// Pesquisa
const searchInput = document.getElementById('searchInput');
const btnSearch = document.getElementById('btnSearch');

function pesquisar() {
  const query = searchInput.value.toLowerCase().trim();
  if (!query) return;

  const profissionais_filtrados = dados.filter(p => {
    const especialidades_medico = JSON.parse(p.especialidade || '[]').map(e => e.toLowerCase());
    const nome = p.nome.toLowerCase();
    const especialidade_str = especialidades_medico.join(' ');
    return nome.includes(query) || especialidade_str.includes(query);
  });

  mostrarProfissionais(profissionais_filtrados);
}

btnSearch.addEventListener('click', pesquisar);
searchInput.addEventListener('keydown', (e) => {
  if (e.key === 'Enter') {
    e.preventDefault();
    pesquisar();
  }
});

// Inicialização
const primeiroBotao = document.querySelector(".btn-especialidade");
if (primeiroBotao) {
  const primeiraEspecialidade = primeiroBotao.dataset.especialidade;
  filtrarPorEspecialidade(primeiraEspecialidade);
  botoes.forEach(b => b.classList.remove("ativo"));
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
