<div id="modalEditarConsulta" class="modal">
  <div class="modal-content">

    <span class="fechar-modal" id="fecharModalEditarConsulta">&times;</span>

    <div class="modal-header">
      <div class="header-left">
        <img src="../../../public/assets/icones/medico.png" alt="Foto do Profissional">
        <div class="header-info">
          <h2 id="nomeProfissionalEditar">Nome do Profissional</h2>
          <h2 id="especialidadeProfissionalEditar">Nome do Profissional</h2>
        </div>
      </div>
      <div class="header-title">
        <h3>Editar Consulta</h3>
        <span>Informe os detalhes necessários para realizar o agendamento</span>
      </div>
    </div>

    <div class="container-modal">
      <form action="../../../controllers/AgendamentoConsultaController.php?acao=editarConsulta"
            method="post" id="formAgendar" enctype="multipart/form-data">

        <input type="hidden" name="idAgendamentoConsulta" id="idAgendamentoConsulta">
        <input type="hidden" name="idPaciente" value="<?php echo $_SESSION['idPaciente']; ?>" id="idPaciente">
        <input type="hidden" name="idProfissional" id="idProfissional">

        <div class="form-control">
          <label for="tipoConsulta">Tipo de Consulta</label>
          <select name="tipoConsulta" id="tipoConsulta">
            <option value="c">Consulta</option>
            <option value="r">Retorno</option>
          </select>
        </div>

        <div class="form-control" id="box-anexo" style="display:none;">
          <label for="anexo">Anexar Arquivo (apenas para retorno)</label>
          <div class="upload-box">
            <input type="file" name="anexo" id="anexo" accept=".pdf">
            <label for="anexo" class="btn-upload">Escolher Arquivo</label>
            <span id="file-name">Nenhum arquivo selecionado</span>
          </div>
        </div>

        <div class="form-control">
          <label for="diaAgendamento">Dia da Consulta</label>
          <input type="date" id="diaAgendamento" name="diaAgendamento" required>
        </div>

        <div id="mensagemErro" class="mensagem-erro" style="display:none;"></div>

        <div class="form-control">
          <label for="horarioAgendamento">Horários</label>
          <div id="mensagemHorario">Selecione um dia para ver os horários disponíveis.</div>
          <div id="times" class="times"></div>
        </div>

        <div class="form-control">
          <label for="observacao">Observações</label>
          <textarea id="observacao" name="observacao" placeholder="Escreva alguma observação..."></textarea>
        </div>

        <input type="submit" class="btn-agendarConsulta" value="Editar">
      </form>
    </div>

    <div class="modal-footer">
      <p><strong>Clínica MedHub</strong><br>
      Av. Santa, 9999 - Centro, Santa Catarina - SC</p>
    </div>
  </div>
</div>

<link rel="stylesheet" href="../../../public/assets/css/geral/agendamento_consulta.css">

<script>
  const tipoConsulta = document.getElementById('tipoConsulta');
  const boxAnexo = document.getElementById('box-anexo');
  const inputAnexo = document.getElementById('anexo');
  const formAgendar = document.getElementById('formAgendar');
  const diaAgendamento = document.getElementById('diaAgendamento');
  const container = document.getElementById('times');
  const mensagemErro = document.getElementById('mensagemErro');
  const mensagemHorario = document.getElementById('mensagemHorario');
  const fileNameSpan = document.getElementById('file-name');

  const showError = (msg) => {
    mensagemErro.style.display = 'block';
    mensagemErro.innerText = msg;
  };

  tipoConsulta.addEventListener('change', () => {
    boxAnexo.style.display = tipoConsulta.value === 'r' ? 'block' : 'none';
    if (tipoConsulta.value !== 'r') {
      inputAnexo.value = '';
      fileNameSpan.textContent = 'Nenhum arquivo selecionado';
    }
  });


  inputAnexo.addEventListener('change', () => {
    fileNameSpan.textContent = inputAnexo.files[0]?.name || 'Nenhum arquivo selecionado';
  });


  const buscarHorarios = () => {
    const data = diaAgendamento.value;
    const idProfissional = document.getElementById('idProfissional').value;
    const idPaciente = document.getElementById('idPaciente').value;
    const idAgendamentoConsulta = document.getElementById('idAgendamentoConsulta').value;

    container.innerHTML = '';
    mensagemErro.style.display = mensagemHorario.style.display = 'none';

    fetch('../../../controllers/PacienteController.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
       body: `data=${encodeURIComponent(data)}&idProfissional=${encodeURIComponent(idProfissional)}&idPaciente=${encodeURIComponent(idPaciente)}&idAgendamentoConsulta=${encodeURIComponent(idAgendamentoConsulta)}`
    })
    .then(r => r.json())
    .then(retorno => {
      if (retorno.erro) return showError(retorno.erro);

      if (retorno.length === 0) {
        mensagemHorario.style.display = 'block';
        mensagemHorario.innerText = 'Não há horários disponíveis para este dia.';
        return;
      }

      mensagemHorario.style.display = 'block';
      mensagemHorario.innerText = 'Escolha um horário:';
      container.innerHTML = retorno.map(h => `
        <label class="time-slot">
          <input type="radio" name="horarioAgendamento" value="${h}" required>
          <span>${h}</span>
        </label>
      `).join('');
    })
    .catch(() => showError('Erro ao carregar horários. Tente novamente.'));
  };

  diaAgendamento.addEventListener('change', buscarHorarios);

  document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modalEditarConsulta");
    const closeModal = document.getElementById("fecharModalEditarConsulta");
    const openButtons = document.querySelectorAll(".btn.editar");

    const abrirModal = () => modal.style.display = "flex";
    const fecharModal = () => modal.style.display = "none";

    closeModal.addEventListener("click", fecharModal);
    window.addEventListener("click", e => { if (e.target === modal) fecharModal(); });

    openButtons.forEach(btn => {
      btn.addEventListener("click", () => {
        document.querySelector('input[name="idAgendamentoConsulta"]').value = btn.dataset.idConsulta;
        document.querySelector('select[name="tipoConsulta"]').value = btn.dataset.tipo;
        document.querySelector('input[name="diaAgendamento"]').value = btn.dataset.dia;
        document.querySelector('textarea[name="observacao"]').value = btn.dataset.observacao;
        document.querySelector('input[name="idProfissional"]').value = btn.dataset.idProfissional;

        document.getElementById("nomeProfissionalEditar").innerText = btn.dataset.profissional || "Profissional";
        document.getElementById("especialidadeProfissionalEditar").innerText = btn.dataset.especialidade || "Especialidade";

        abrirModal();
        setTimeout(buscarHorarios, 200);
      });
    });
  });

 
  formAgendar.addEventListener('submit', (e) => {
    const tipo = tipoConsulta.value;
    const horarioSelecionado = document.querySelector('input[name="horarioAgendamento"]:checked');
    const arquivo = inputAnexo.files.length > 0;

    mensagemErro.style.display = 'none';

    if (!horarioSelecionado) {
      e.preventDefault();
      return showError('Por favor, selecione um horário antes de agendar.');
    }

    if (tipo === 'r' && !arquivo) {
      e.preventDefault();
      return showError('Por favor, envie o arquivo de retorno antes de agendar.');
    }
  });
</script>

