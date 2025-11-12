<div id="modalCancelar" class="modal">
  <div class="modal-content">
    <h2>Cancelar Encaminhamento</h2>
    <p>Tem certeza de que deseja cancelar este encaminhamento? Esta ação não poderá ser desfeita.</p>

    <form id="formCancelarEncaminhamento" action="../../../controllers/ProfissionalController.php?acao=cancelarEncaminhamento" method="POST">
      <input type="hidden" name="idEncaminhamento" id="inputIdEncaminhamento">
      <input type="hidden" name="idConsulta" id="inputIdConsulta">
      <input type="hidden" name="idAgendamentoExame" id="inputIdAgendamentoExame">

      <div class="modal-buttons">
        <button type="button" class="btn btn-secundario" onclick="fecharModalCancelar()">Voltar</button>
        <button type="submit" class="btn btn-perigo">Confirmar Cancelamento</button>
      </div>
    </form>
  </div>
</div>

<style>
  .modal {
  display: none;
  position: fixed;
  z-index: 999;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0,0,0,0.5);
  justify-content: center; align-items: center;
}

.modal-content {
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  text-align: center;
  max-width: 420px;
  width: 90%;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  animation: aparecer 0.3s ease;
}

@keyframes aparecer {
  from { transform: scale(0.9); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}



.modal-buttons {
  margin-top: 20px;
  display: flex;
  justify-content: space-between;
  gap: 10px;
}

.btn {
  border: none;
  padding: 10px 18px;
  border-radius: 8px;
  cursor: pointer;
  transition: 0.3s;
  font-weight: 600;
}

.btn-secundario {
  background: #e0e0e0ff;
}
.btn-secundario:hover {
  background: #b8b8b8ff;
}

.btn-perigo {
  background: #c62828;
  color: white;
}

.btn-perigo:hover {
  background: #a31616;
}

</style>

