<?php
    session_start();
    require_once "../../../controllers/PacienteController.php";
    

    include '../../../public/includes/paciente/sidebar.php';
    include '../../../public/includes/paciente/header.php';
    include '../../../public/includes/paciente/footer.php';
    include 'agendar_consulta.php';
    
    $idPaciente = $_SESSION['idPaciente'];
    $nomePaciente = $_SESSION['nomePaciente'];
    $idUsuario = $_SESSION['idUsuario'];

    $controller = new PacienteController($conn);
    $profissionais = $controller->listarProfissionaisDisponiveis();

    $icones = [
       'cardiologista' => '../../../public/assets/imgs/cardiologista.jpg',
       'ortopedista' => '../../../public/assets/imgs/ortopedista.jpg',
       'oftamologista' => '../../../public/assets/imgs/oftamologista.webp',
       'neurologista' => '../../../public/assets/imgs/neurologista.jpg'
    ];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MedHub — Página Inicial</title>

    <!-- Fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ===== RESET ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: #f5f6fa;
            min-height: 100vh;
            display: flex;
        }

        .conteudo-principal {
            flex: 1;
            padding: 2rem 3rem;
            background: #f5f6fa;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 70px;
            margin-bottom: 70px;
        }

        /* ===== BARRA DE PESQUISA ===== */
        .barra-pesquisa {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: .5rem;
            margin-bottom: 2rem;
            width: 100%;
            max-width: 800px;
        }

        .barra-pesquisa input {
            width: 100%;
            padding: .8rem 1rem;
            border: 1px solid #ccc;
            border-radius: 25px;
            outline: none;
            transition: border-color .2s;
        }

        .barra-pesquisa input:focus {
            border-color: #085274;
        }

        .barra-pesquisa button {
            background: #085274;
            border: none;
            padding: .8rem 1.2rem;
            border-radius: 25px;
            color: #fff;
            cursor: pointer;
        }

        .barra-pesquisa button:hover {
            background: #0a6d98;
        }

        /* ===== FILTROS ===== */
        .filtros-especialidade {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .filtros-especialidade button {
            border: none;
            background: #e1e9ee;
            color: #085274;
            padding: .6rem 1.2rem;
            border-radius: 20px;
            font-weight: 500;
            cursor: pointer;

        }

        .filtros-especialidade button:hover {
            background: #c5dae8;
        }

        .filtros-especialidade .ativo {
            background: #085274;
            color: #fff;
        }

        /* ===== INFO ===== */
        .info-profissionais {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0 2rem;
            color: #333;
        }

        .info-profissionais .disponiveis {
            color: #2ecc71;
            font-weight: 500;
        }

        /* ===== CARDS ===== */
        .cards-profissionais {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.8rem;
            width: 100%;
            max-width: 1200px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-info {
            padding: 1rem;
            text-align: center;
        }

        .card-info h3 {
            color: #085274;
            font-size: 1.2rem;
            margin-bottom: .4rem;
        }

        .card-info .especialidade {
            color: #2980b9;
            font-weight: 600;
            margin-bottom: .6rem;
        }

        .card-info .descricao {
            font-size: 0.9rem;
            color: #555;
            line-height: 1.4;
            margin-bottom: 1rem;
            width: 100%;              /* ocupa toda a largura do container */
            word-wrap: break-word;    /* quebra palavras muito longas */
            white-space: normal;      /* permite quebra de linha */
        }


        .btn-agendar {
            background: #085274;
            border: none;
            color: white;
            padding: .6rem 1.2rem;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-info {
            background: #000000ff;
            border: 1px solid black;
            color: white;
            padding: .6rem 1.2rem;
            font-size: 18px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-agendar:hover {
            background: #0b6a91;
        }

        /* ===== RESPONSIVIDADE ===== */
        @media (max-width: 768px) {
            .conteudo-principal {
                padding: 1.5rem;
            }

            .barra-pesquisa {
                flex-direction: column;
                max-width: 100%;
            }

            .barra-pesquisa input {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <main class="conteudo-principal">

        <!-- Barra de Pesquisa -->
        <div class="barra-pesquisa">
            <input type="text" placeholder="Pesquise por especialidade ou profissional...">
            <button>🔍</button>
        </div>

        <!-- Filtros -->
        <div class="filtros-especialidade">
            <button class="ativo">Todos</button>
            <button>Cardiologistas</button>
            <button>Ortopedistas</button>
            <button>Neurologistas</button>
            <button>Oftalmologistas</button>
        </div>

        <!-- Info -->
        <div class="info-profissionais">
            <p><strong><?php echo $profissionais['total']; ?></strong> Profissionais encontrados</p>
            <span class="disponiveis">🟢 Disponíveis agora</span>
        </div>

        <!-- Cards -->
        <section class="cards-profissionais">
            <?php foreach($profissionais['dados'] as $profissional){ ?>
            <div class="card">
                <img src="../../../public/assets/imgs/cardiologista.jpg" alt="Dr. Luiz">
                <div class="card-info">
                    <h3><?php echo $profissional['nome']; ?></h3>
                    <p class="especialidade"><?php echo $profissional['especialidade']; ?></p>
                    <p class="descricao"><?php echo $profissional['observacoes']; ?></p>
                    <button class="btn-agendar" 
                        onclick="abrirModalAgendamento(
                        '<?= $profissional['id_profissional'] ?>', 
                        '<?= $profissional['nome'] ?>', 
                        '<?= $profissional['especialidade'] ?>')">
                        Agendar consulta
                    </button>

                    <button class="btn-info"><i class="fa-solid fa-calendar-check"></i></button>
                </div>
            </div>
            <?php } ?>
        </section>
    </main>


<script>
  const modalAgendamento = document.getElementById('modalAgendamento');
  const fecharModalAgendamento = document.getElementById('fecharModalAgendamento');

  // Função para abrir o modal (chame quando clicar em um profissional)
  function abrirModalAgendamento(idProfissional, nome, especialidade) {
    document.getElementById('idProfissional').value = idProfissional;
    document.getElementById('nomeProfissional').textContent = nome;
    document.getElementById('especialidadeProfissional').textContent = especialidade;
    modalAgendamento.style.display = 'flex';
  }



  // Fecha o modal ao clicar no "X"
  fecharModalAgendamento.addEventListener('click', () => {
    modalAgendamento.style.display = 'none';
  });

  // Fecha ao clicar fora do conteúdo
  window.addEventListener('click', (e) => {
    if (e.target === modalAgendamento) {
      modalAgendamento.style.display = 'none';
    }
  });

  // Mostrar ou ocultar campo de anexo
  document.getElementById('tipoConsulta').addEventListener('change', function() {
    const boxAnexo = document.getElementById('box-anexo');
    boxAnexo.style.display = this.value === 'r' ? 'block' : 'none';
  });
</script>

</body>
</html>
