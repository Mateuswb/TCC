<!-- ===== MODAL AGENDAMENTO ===== -->
<div id="modalAgendamento" class="modal">
  <div class="modal-content">
    <span class="fechar-modal" id="fecharModalAgendamento">&times;</span>

    <div class="container-modal">
      <div class="profile">
        <img src="https://cdn-icons-png.flaticon.com/512/3870/3870822.png" alt="Foto do Profissional">
        <div class="profile-info">
          <h2 id="nomeProfissional">Nome do Profissional</h2>
          <p id="especialidadeProfissional">Especialidade</p>
          <p>Atendimento Particular</p>
        </div>
      </div>

      <h3>Confirme os dados para o agendamento</h3>

      <form action="../../../../controllers/AgendamentoExameController.php?acao=agendarExame" 
            method="post" id="formAgendar" enctype="multipart/form-data">

        <input type="int" name="idPaciente" value="<?php echo $_SESSION['idPaciente']; ?>">
        <input type="hidden" name="nomeExame" id="exame">


        <div class="form-control" id="box-anexo" style="display:none;">
          <label for="anexo">Anexar Arquivo (apenas para retorno)</label>
          <input type="file" name="anexo" id="anexo" accept=".pdf,.jpg,.png,.jpeg">
        </div>

        <div class="form-control">
          <label for="diaAgendamento">Dia da Consulta</label>
          <input type="date" id="diaAgendamento" name="diaAgendamento" required>
        </div>

        <div class="form-control">
          <label for="horarioAgendamento">Escolha o Horário</label>
          <div id="times" class="times"></div>
        </div>

        <div class="form-control">
          <label for="observacao">Observações</label>
          <textarea id="observacao" name="observacao" placeholder="Escreva alguma observação..."></textarea>
        </div>

        <button type="submit" class="btn-agendar">Agendar</button>
      </form>

      <div class="clinic-info">
        <h3>Local da Consulta</h3>
        <p>Clínica Synapse</p>
        <p>Av. Santa, 9999 - Centro, Santa Catarina - SC</p>
      </div>
    </div>
  </div>
</div>

<style>
/* ===== MODAL ===== */
.modal {
  display: none;
  position: fixed;
  z-index: 9999999999;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  overflow-y: auto;
}

.modal-content {
  background: #fff;
  margin: 60px auto;
  width: 100%;
  max-width: 1100px;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.2);
  position: relative;
  padding: 30px;
  height: 800px;
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
  color: #555;
  cursor: pointer;
}
.fechar-modal:hover { color: #000; }

.profile {
  display: flex;
  align-items: center;
  gap: 15px;
  margin-bottom: 15px;
}
.profile img {
  width: 70px;
  height: 70px;
  border-radius: 50%;
}
.profile-info h2 { margin: 0; font-size: 1.4rem; }
.profile-info p { margin: 3px 0; color: #555; }

.form-control {
  margin-top: 20px;
}
label {
  font-weight: 500;
  display: block;
  margin-bottom: 6px;
  color: #333;
}
select, input[type="date"], input[type="file"], textarea {
  width: 100%;
  padding: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 14px;
}
textarea {
  min-height: 80px;
  resize: vertical;
}

.times {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
  gap: 10px;
  margin-top: 10px;
}

.time-slot, .time-slot-bloqueado {
  text-align: center;
  padding: 10px;
  border-radius: 10px;
  font-size: 14px;
  cursor: pointer;
  border: 1px solid #4a90e2;
}
.time-slot { background: #eaf3ff; color: #333; }
.time-slot:hover { background: #4a90e2; color: #fff; }
.time-slot-bloqueado {
  background: #f1f1f1;
  color: #aaa;
  border: 1px dashed #ccc;
  cursor: not-allowed;
}

.btn-agendar {
  margin-top: 25px;
  width: 100%;
  padding: 14px;
  border: none;
  background: #4a90e2;
  color: #fff;
  font-size: 16px;
  border-radius: 25px;
  cursor: pointer;
  transition: 0.3s;
}
.btn-agendar:hover { background: #357abd; }

.clinic-info {
  margin-top: 40px;
  padding: 20px;
  background: #f8f9fc;
  border-radius: 10px;
  border: 1px solid #e1e1e1;
  font-size: 14px;
  line-height: 1.5;
}
</style>

<script>

// Carregar horários disponíveis
document.getElementById('diaAgendamento').addEventListener('change', function() {
  const data = this.value;
  const exame = document.getElementById('exame').value;

  fetch('../../../../controllers/ExameController.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `data=${encodeURIComponent(data)}&exame=${encodeURIComponent(exame)}`
  })
  .then(r => r.json())
  .then(retorno => {
    const container = document.getElementById('times');
    container.innerHTML = '';
    
    if (!retorno?.disponiveis) return;

    retorno.disponiveis.forEach(h => {
      const bloqueado = retorno.agendamento?.includes(h);
      container.innerHTML += bloqueado
        ? `<label class="time-slot-bloqueado">${h}</label>`
        : `<label class="time-slot"><input type="radio" name="horarioAgendamento" value="${h}"><span>${h}</span></label>`;
    });
  })
  .catch(err => console.error("Erro:", err));
});
</script>
