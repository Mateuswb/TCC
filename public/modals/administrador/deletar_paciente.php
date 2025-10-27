<div id="modalAviso" class="modalDeletar">
  <div id="modal-content">
    <h3>Aviso</h3>
    <p id="modalMensagem"></p>
    <form id="formExclusao" method="POST" action="../../../controllers/AdministradorController.php?acao=excluirPaciente">
      <input type="hidden" name="idPaciente" id="idPaciente">
      <input type="hidden" name="cpf" id="cpf">
      <button type="submit">Confirmar Exclusão</button>
      <button type="button" onclick="fecharModalAviso()">Cancelar</button>
    </form>
  </div>
</div>

<style>
.modalDeletar {
    display:none;
    position:fixed;
    top:0; left:0; width:100%; height:100%;
    background: rgba(0,0,0,0.5);
    justify-content:center;
    align-items:center;
    z-index:9999;
}
#modal-content {
    background:#fff;
    padding:20px;
    border-radius:12px;
    text-align:center;
    width: 300px;
}
#modal-content button {
    margin: 5px;
    padding: 8px 12px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
}
</style>

<script>
function abrirModalExclusao(btn) {
    const dados = btn.dataset;

    document.getElementById('idPaciente').value = dados.id;
    document.getElementById('cpf').value = dados.cpf;
    document.getElementById('modalMensagem').innerText = "Tem certeza que deseja excluir este paciente?";
    document.getElementById('modalAviso').style.display = 'flex';
}

function fecharModalAviso() {
    document.getElementById('modalAviso').style.display = 'none';
}
</script>