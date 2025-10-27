<!-- Modal customizado de exclusão -->
<div class="modal-overlay" id="modalExcluir">
  <div class="modal-box">
    <form id="formExcluirExame" method="POST" action="../../../controllers/AdministradorController.php?acao=deletarExame">
      <!-- Cabeçalho -->

      <div class="modal-header">
        <h3>Excluir Exame</h3>
        <span class="close-btn" onclick="fecharModalExcluir()">&times;</span>
      </div>

      <!-- Corpo -->
      <div class="modal-body">

        <p>Tem certeza que deseja excluir o exame:</p>
        <h4 id="nomeExameExcluir" class="text-danger"></h4>
        <p class="small-text">Esta ação não pode ser desfeita!</p>
        <input type="hidden" name="idExame" id="idExameExcluir">
      </div>

      <!-- Rodapé -->
      <div class="modal-footer">
        <button type="button" class="btn btn-cancel" onclick="fecharModalExcluir()">Cancelar</button>
        <button type="button" class="btn btn-delete" onclick="abrirConfirmacao()">Excluir</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal de confirmação personalizado -->
<div class="modal-overlay" id="modalConfirmacao">
  <div class="modal-box">
    <div class="modal-header">
      <h3>Confirmação</h3>
      <span class="close-btn" onclick="fecharConfirmacao()">&times;</span>
    </div>
    <div class="modal-body">
      <p id="mensagemConfirmacao"></p>
    </div>
    <div class="modal-footer">
      <button class="btn btn-cancel" onclick="fecharConfirmacao()">Cancelar</button>
      <button class="btn btn-delete" id="btnConfirmarExcluir">Confirmar</button>
    </div>
  </div>
</div>

<style>

    .modal-overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  display: none; /* inicia escondido */
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-box {
  background: #fff;
  border-radius: 12px;
  max-width: 450px;
  width: 90%;
  padding: 20px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.3);
  display: flex;
  flex-direction: column;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #eee;
  margin-bottom: 15px;
}

.modal-header h3 {
  margin: 0;
  color: #c62828;
}

.close-btn {
  font-size: 24px;
  cursor: pointer;
  color: #888;
  transition: color 0.2s;
}

.close-btn:hover {
  color: #c62828;
}

.modal-body h4 {
  margin: 10px 0;
  color: #c62828;
}

.small-text {
  font-size: 12px;
  color: #666;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 15px;
}

.btn {
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
}

.btn-cancel {
  background: #aaa;
  color: #fff;
}


</style>

<script>
   function abrirModalExcluir(btn) {
    const id = btn.dataset.id;
    const nome = btn.dataset.nome;

    document.getElementById("idExameExcluir").value = id;
    document.getElementById("nomeExameExcluir").innerText = nome;

    document.getElementById("modalExcluir").style.display = "flex";
}

// Fechar modal principal
function fecharModalExcluir() {
    document.getElementById("modalExcluir").style.display = "none";
}

// Abrir modal de confirmação
function abrirConfirmacao() {
    const nome = document.getElementById("nomeExameExcluir").innerText;
    document.getElementById("mensagemConfirmacao").innerText = `Deseja realmente excluir o exame "${nome}"? Esta ação não pode ser desfeita.`;
    document.getElementById("modalConfirmacao").style.display = "flex";
}

// Fechar modal de confirmação
function fecharConfirmacao() {
    document.getElementById("modalConfirmacao").style.display = "none";
}

// Confirmar exclusão
document.getElementById("btnConfirmarExcluir").addEventListener("click", () => {
    // document.getElementById("formExcluirExame").sub it();
});

// Fechar clicando fora dos modais
window.addEventListener("click", e => {
    if(e.target === document.getElementById("modalExcluir")) fecharModalExcluir();
    if(e.target === document.getElementById("modalConfirmacao")) fecharConfirmacao();
});


</script>