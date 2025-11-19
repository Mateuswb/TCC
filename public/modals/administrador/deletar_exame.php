
<div class="modal-overlay" id="modalExcluir">
  <div class="modal-box">
    <form id="formExcluirExame" method="POST" action="../../../controllers/AdministradorController.php?acao=deletarExame">

      <div class="modal-header">
        <h3>Excluir Exame</h3>
        <span class="close-btn" onclick="fecharModalExcluir()">&times;</span>
      </div>

      <div class="modal-body">

        <p>Tem certeza que deseja excluir o exame:</p>
        <h4 id="nomeExameExcluir" class="text-danger"></h4>
        <p class="small-text">Esta ação não pode ser desfeita!</p>
        <input type="hidden" name="idExame" id="idExameExcluir">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-cancel" onclick="fecharModalExcluir()">Cancelar</button>
        <input type="submit" class="btn btn-delete" value="Excluir">
      </div>
    </form>
  </div>
</div>

<style>

.modal-overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  display: none;
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
  font-size: 16px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
}

.btn-cancel {
  background: #aaa;
  color: #fff;
}
.btn-delete{
  background-color: #c62828;
  color: white;

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


function fecharModalExcluir() {
    document.getElementById("modalExcluir").style.display = "none";
}


window.addEventListener("click", e => {
    if(e.target === document.getElementById("modalExcluir")) fecharModalExcluir();
});


</script>