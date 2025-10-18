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

    <link rel="stylesheet" href="../../../public/assets/css/paciente/consultas/listar_profissionais.css">

    <!-- fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>

<body>
    <main class="conteudo-principal">

        <!-- barra da pesquisa -->
        <div class="barra-pesquisa">
            <input type="text" placeholder="Pesquise por especialidade ou profissional...">
            <button>🔍</button>
        </div>

        <div class="filtros-especialidade">
            <button class="btn-especialidade" data-especialidade="cardiologia">Cardiologistas</button>
            <button class="btn-especialidade" data-especialidade="ortopedista">Ortopedistas</button>
            <button class="btn-especialidade" data-especialidade="Neurologistas">Neurologistas</button>
            <button class="btn-especialidade" data-especialidade="Oftalmologistas">Oftalmologistas</button>
        </div>

        <div class="info-profissionais">
            <p><strong><?php echo $profissionais['total']; ?></strong> Profissionais encontrados</p>
            <span class="disponiveis">🟢 Disponíveis agora</span>
        </div>

        <!-- cards -->
        <section id="cards-profissionais">
        </section>
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

  // Mostrar ou ocultar campo de anexo
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
                            <button class="btn-agendar" 
                                onclick="abrirModalAgendamento(
                                    '${p.id_profissional}',
                                    '${p.nome}'
                                )">
                                Agendar consulta
                            </button>
                            <button class="btn-info"><i class="fa-solid fa-calendar-check"></i></button>
                        </div>
                    </div>
                `;
            });
        });
    });
</script>

</body>
</html>
