<div id="modalAgendamento" class="modal">
  <div class="modal-content">
    
    <span class="fechar-modal" id="fecharModalAgendamento">&times;</span>

    <div class="modal-header">
      <div class="header-left">
        <img src="../../../../public/assets/icones/medico.png" alt="Foto do Profissional">
        <div class="header-info">
          <h2 id="nomeProfissional">Nome do Profissional</h2>
        </div>
      </div>
      <div class="header-title">
        <h3>Agendar Exame</h3>
        <span>Informe os detalhes necessários para realizar o agendamento</span>
      </div>
    </div>


    <div class="container-modal">
      <h3>Confirme os dados para o agendamento</h3>

      <form action="../../../../controllers/AgendamentoExameController.php?acao=agendarExame" 
            method="post" id="formAgendar" enctype="multipart/form-data">

        <input type="hidden" name="idEncaminhamento" id="id_encaminhamento">
        <input type="hidden" name="nomeExame" id="exame">

        <div class="form-control">
          <label for="diaAgendamento">Dia do Exame</label>
          <input type="date" id="diaAgendamento" name="diaAgendamento" required>
        </div>

        

        <div class="form-control">
          <label for="profissionais">Profissional</label>
          <select name="profissional" id="profissionais">
            <option value="">Selecione um profissional</option>
          </select>
        </div>

        <div id="mensagemErro" class="mensagem-erro" style="display:none;"></div>

        <div class="form-control">
          <label for="horarioAgendamento">Escolha o Horário</label>
          <div id="mensagemHorario">Selecione um dia e um profissional para ver os horários disponíveis.</div>
          <div id="times" class="times"></div>
        </div>

        <div class="form-control">
          <label for="observacao">Observações</label>
          <textarea id="observacao" name="observacao" placeholder="Escreva alguma observação..."></textarea>
        </div>

        <input type="submit" class="btn-agendarConsulta" value="Agendar">
      </form>

    </div>
      <div class="modal-footer">
        <p><strong>Clínica MedHub</strong><br>
        Av. Santa, 9999 - Centro, Santa Catarina - SC</p>
      </div>

  </div>
</div>
<style>

.mensagem-erro {
  color: #842029;
  background-color: #f8d7da;
  border: 1px solid #f5c2c7;
  padding: 10px;
  border-radius: 6px;
  margin-bottom: 15px;
  text-align: center;
  font-weight: 500;
}

.modal {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.45);
  backdrop-filter: blur(3px);
  z-index: 9999;
  overflow-y: auto;
  padding: 40px 20px;
}

.modal-content {
  background: #fff;
  margin: auto;
  width: 100%;
  max-width: 1100px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.25);
  overflow: hidden;
  position: relative;
  display: flex;
  flex-direction: column;
  animation: slideIn 0.3s ease;
}

@keyframes slideIn {
  from { transform: translateY(-30px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}


.fechar-modal {
  position: absolute;
  top: 15px;
  right: 20px;
  font-size: 1.8rem;
  color: #fff;
  cursor: pointer;
  z-index: 100;
  transition: 0.3s;
}
.fechar-modal:hover { color: #ddd; }


.modal-header {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  position: relative;
  background: #005baa;
  color: #fff;
  padding: 10px 10px;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.header-left img {
  width: 60px;
  height: 60px;
  border-radius: 8px;
}

.header-info {
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 10px;
}

.header-info h2 {
  font-size: 1rem;
  margin-left: -15px;
}

.header-info p {
  font-size: 0.8rem;
  margin: 2px 0;
}

.header-title {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.header-title h3 { font-size: 20px; margin: 0; }
.header-title span { font-size: 15px; }


.container-modal { padding: 20px 30px; }
.form-control { margin-bottom: 20px; }
label { font-weight: 600; color: #333; display: block; margin-bottom: 6px; }
select, input[type="date"], input[type="file"], textarea {
  width: 100%;
  padding: 12px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 15px;
  transition: all 0.3s;
}
textarea { resize: vertical; min-height: 80px; }
#observacao { resize: none; }
select:focus, input:focus, textarea:focus {
  border-color: #005baa;
  box-shadow: 0 0 3px rgba(0,91,170,0.4);
  outline: none;
}

#anexo {
  display: none;
}


.times {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 12px;
  margin-top: 10px;
  justify-content: center;
  align-items: start;
}

.time-slot {
  background: #eaf3ff;
  color: #333;
  border: 1px solid #005baa;
  border-radius: 8px;
  padding: 12px;
  cursor: pointer;
  font-weight: 600;
  transition: 0.3s;
  text-align: center;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 45px;
}

.time-slot:hover,
.time-slot.selected {
  background: #005baa;
  color: #fff;
}

.time-slot:has(input[type="radio"]:checked) {
  background: #005baa;
  color: #fff;
  border-color: #00468a;
  box-shadow: 0 0 0 3px rgba(0,91,170,0.3);
}


.upload-box {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-wrap: wrap;
  padding: 8px 10px; 
  border: 1px solid #ccc; 
  border-radius: 12px; 
  background-color: #ffffffff; 
  transition: all 0.3s;
}

.upload-box:hover {
  border-color: #005baa; /* muda a cor da borda ao passar o mouse */
  box-shadow: 0 1px 8px rgba(0,91,170,0.2); /* sombra suave */
}

.btn-upload {
  background: #005baa;
  color: #fff;
  padding: 10px 20px;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s;
  font-weight: 600;
  border: none;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15); /* sombra leve */
}

.btn-upload:hover {
  background: #00468a; /* cor mais escura ao passar o mouse */
  box-shadow: 0 4px 12px rgba(0,0,0,0.2); /* sombra mais pronunciada */
  transform: translateY(-2px); /* efeito sutil de "levitar" */
}


.btn-upload:hover { background: #00468a; }

.btn-agendarConsulta {
  margin-top: 25px;
  width: 100%;
  padding: 10px;
  border: none;
  background: #005baa;
  color: #fff;
  font-size: 20px;
  font-weight: 600;
  border-radius: 25px;
  cursor: pointer;
  transition: 0.3s;
  text-align: center;
}
.btn-agendarConsulta:hover { background: #00468a; }


.modal-footer {
  background: #f3f4f6;
  text-align: center;
  padding: 18px;
  border-top: 1px solid #ddd;
  font-size: 0.95rem;
  color: #333;
}


@media (max-width: 768px) {
  .modal-header { flex-direction: column; text-align: center; gap: 10px; }
  .header-left { justify-content: center; gap: 10px; }
  .header-title { position: static; transform: none; margin-top: 5px; }
  .container-modal { padding: 25px; }
}


.time-slot input[type="radio"] {
  display: none;
}

</style>

<script>
const diaAgendamento = document.getElementById('diaAgendamento');
const exame = document.getElementById('exame');
const container = document.getElementById('times');
const mensagemHorario = document.getElementById('mensagemHorario');
const mensagemErro = document.getElementById('mensagemErro');
const formAgendar = document.getElementById('formAgendar');

const showError = (msg) => {
  mensagemErro.style.display = 'block';
  mensagemErro.innerText = msg;
};


const resetMensagens = () => {
  mensagemErro.style.display = 'none';
  mensagemErro.innerText = '';
  mensagemHorario.style.display = 'none';
  mensagemHorario.innerText = '';
};

diaAgendamento.addEventListener('change', function() {
  resetMensagens();
  container.innerHTML = '';

  const dataSelecionada = this.value;
  const select = document.getElementById("profissionais");

  // Limpa select de profissionais e horários
  select.innerHTML = '<option value="">Selecione um profissional</option>';
  container.innerHTML = '';

  if (!dataSelecionada) {
    mensagemHorario.style.display = 'block';
    mensagemHorario.innerText = 'Selecione um dia para ver os horários disponíveis.';
    return;
  }

  fetch('../../../../controllers/ExameController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `data=${encodeURIComponent(dataSelecionada)}&exame=${encodeURIComponent(exame.value)}`
  })
  .then(r => r.json())
  .then(retorno => {
    if (retorno.erro) return showError(retorno.erro);

    mensagemHorario.style.display = 'block';
    mensagemHorario.innerText = 'Escolha um horário:';

    for (const profissional in retorno) {
      const option = document.createElement("option");
      option.value = profissional;
      option.textContent = profissional;
      select.appendChild(option);
    }

    const newSelect = select.cloneNode(true);
    select.parentNode.replaceChild(newSelect, select);

    newSelect.addEventListener("change", function() {
      const profissionalSelecionado = this.value;
      const horarios = retorno[profissionalSelecionado] || [];
      container.innerHTML = '';

      if (profissionalSelecionado) {
        for (const h of horarios) {
          container.innerHTML += `
            <label class="time-slot">
              <input type="radio" name="horarioAgendamento" value="${h}">
              <span>${h}</span>
            </label>`;
        }
      }
    });

  })
  .catch(() => showError('Erro ao carregar horários. Tente novamente.'));
});


formAgendar.addEventListener('submit', (e) => {
  const selectProfissional = document.getElementById('profissionais');
  const profissionalSelecionado = selectProfissional.value;
  
  // Reseta mensagens
  resetMensagens();

  // Verifica se selecionou profissional
  if (!profissionalSelecionado) {
    e.preventDefault();
    showError('Por favor, selecione um profissional antes de agendar.');
    return;
  }

  // Verifica se selecionou algum horário
  const horarioSelecionado = document.querySelector('input[name="horarioAgendamento"]:checked');
  if (!horarioSelecionado) {
    e.preventDefault();
    showError('Por favor, selecione um horário antes de agendar.');
    return;
  }

  // Se passou nas validações, o form envia normalmente
});



</script>
