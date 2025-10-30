<div id="modalAgendamento" class="modal">
  <div class="modal-content">

    <div class="modal-header">
      <div class="header-left">
        <img src="https://cdn-icons-png.flaticon.com/512/3870/3870822.png" alt="Foto do Profissional">
        <div class="header-info">
          <h2 id="nomeProfissional">Nome do Profissional</h2>
          <p>Atendimento Particular</p>
        </div>
      </div>
      <div class="header-title">
        <h3>Agendar Consulta</h3>
        <span>Informe os detalhes necessários para realizar o agendamento</span>
      </div>
    </div>

    <span class="fechar-modal" id="fecharModalAgendamento">&times;</span>


    <div class="container-modal">
      <h3>Confirme seus dados para o Agendamento</h3>

      <form action="../../../controllers/AgendamentoConsultaController.php?acao=agendarConsulta"
            method="post" id="formAgendar" enctype="multipart/form-data">

        <input type="hidden" name="idPaciente" value="<?php echo $_SESSION['idPaciente']; ?>">
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
          <input type="file" name="anexo" id="anexo" accept=".pdf,.jpg,.png,.jpeg">
        </div>

        <div class="form-control">
          <label for="diaAgendamento">Dia da Consulta</label>
          <input type="date" id="diaAgendamento" name="diaAgendamento" required>
        </div>



        <div class="form-control">
          <div id="mensagemErro" style="display:none; color:#842029; background-color:#f8d7da; padding:10px; border-radius:5px; margin-bottom:10px;"></div>
          <label for="horarioAgendamento">Escolha o Horário</label>
          <div id="times" class="times"></div>
        </div>
        

        <div class="form-control">
          <label for="observacao">Observações</label>
          <textarea id="observacao" name="observacao" placeholder="Escreva alguma observação..."></textarea>
        </div>

        <input type="submit" class="btn-agendarConsulta" value="Agenar">
      </form>
    </div>

    <div class="modal-footer">
      <p><strong>Clínica MedHub</strong><br>
      Av. Santa, 9999 - Centro, Santa Catarina - SC</p>
    </div>
  </div>
</div>

<style>
.modal {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.45);
    backdrop-filter: blur(3px);
  z-index: 9999999999;
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
  animation: slideIn 0.3s ease;
  display: flex;
  flex-direction: column;
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
  padding: 5px 10px;
}


.header-left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.header-left img {
  width: 50px;
  height: 50px;
  border-radius: 8px;
  object-fit: cover;
}

.header-info {
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 10px;
}

.header-info h2 {
  font-size: 1rem;
  margin: 0;
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

.header-title h3 {
  font-size: 20px;
  margin: 0;
}

.header-title span {
  font-size: 15px;
}


.container-modal {
  padding: 20px 30px;
}

.form-control {
  margin-bottom: 20px;
}

label {
  font-weight: 600;
  color: #333;
  display: block;
  margin-bottom: 6px;
}

select, input[type="date"], input[type="file"], textarea {
  width: 100%;
  padding: 12px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 15px;
  transition: all 0.3s;
}
#observacao {
  resize: none; 
}

select:focus, input:focus, textarea:focus {
  border-color: #005baa;
  box-shadow: 0 0 3px rgba(0,91,170,0.4);
  outline: none;
}

textarea {
  resize: vertical;
  min-height: 80px;
}

/* ===== HORÁRIOS ===== */
.times {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-top: 10px;
}

.time-slot {
  background: #eaf3ff;
  color: #333;
  border: 1px solid #005baa;
  border-radius: 8px;
  padding: 10px 20px;
  cursor: pointer;
  font-weight: 600;
  transition: 0.3s;
  user-select: none;
  min-width: 120px;
  text-align: center;
}

.time-slot:hover,
.time-slot.selected {
  background: #005baa;
  color: #fff;
}

.time-slot.selected {
  box-shadow: 0 0 0 3px rgba(0,91,170,0.3);
}

.time-slot-bloqueado {
  background: #f1f1f1;
  color: #999;
  border: 1px dashed #ccc;
  border-radius: 8px;
  padding: 10px 20px;
  min-width: 120px;
  text-align: center;
  cursor: not-allowed;
}


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



.time-slot input[type="radio"] {
  display: none;
}


.time-slot:has(input[type="radio"]:checked) {
  background: #005baa;
  color: #fff;
  border-color: #00468a;
  box-shadow: 0 0 0 3px rgba(0,91,170,0.3);
}


.modal-footer {
  background: #f3f4f6;
  text-align: center;
  padding: 18px;
  border-top: 1px solid #ddd;
  font-size: 0.95rem;
  color: #333;
}

@media (max-width: 768px) {
  .modal-header {
    flex-direction: column;
    text-align: center;
    gap: 10px;
  }

  .header-left {
    justify-content: center;
    gap: 10px;
  }

  .header-title {
    position: static;
    transform: none;
    margin-top: 5px;
  }

  .container-modal {
    padding: 25px;
  }
}

</style>

<script>
  document.getElementById('diaAgendamento').addEventListener('change', function() {
  const data = this.value;
  const idProfissional = document.getElementById('idProfissional').value;
  const container = document.getElementById('times');
  const mensagemErro = document.getElementById('mensagemErro');

  container.innerHTML = '';
  mensagemErro.style.display = 'none';
  mensagemErro.innerText = '';

  fetch('../../../controllers/PacienteController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `data=${encodeURIComponent(data)}&idProfissional=${encodeURIComponent(idProfissional)}`
  })
  .then(r => r.json())
  .then(retorno => {
    if (retorno.erro) {
      mensagemErro.style.display = 'block';
      mensagemErro.innerText = retorno.erro;
      return;
    }
  
    if (!retorno?.disponiveis) return;

    retorno.disponiveis.forEach(h => {
      const bloqueado = retorno.agendamento?.includes(h);
      container.innerHTML += bloqueado
        ? `<label class="time-slot-bloqueado">${h}</label>`
        : `<label class="time-slot"><input type="radio" name="horarioAgendamento" value="${h}" required><span>${h}</span></label>`;
    });
  })
  .catch(err => console.error("Erro:", err));
});

</script>
