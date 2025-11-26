<div id="modalAviso" class="modalDeletar">
  <div id="modal-content">
    <h3 id="aviso">Aviso</h3>
    <p id="modalMensagem"></p>
    <form id="formExclusao" method="POST" action="../../../controllers/AdministradorController.php?acao=excluirProfissional">
      <input type="hidden" name="idProfissional" id="idProfissional">
      <input type="hidden" name="cpf" id="cpf">
      <input type="submit" value="Confirmar Exclusão" id="bnt-cancelar">
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
    padding:30px;
    border-radius:12px;
    text-align:center;
    width: 420px;
}
#modal-content button {
    margin: 10px;
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid black;
    cursor: pointer;
}
#modal-content button:hover{
  background-color: #dbdbdbff;
}
#aviso{
  font-size: 22px;
  margin-bottom: 10px;
}
#bnt-cancelar{
  margin: 5px;
  padding: 8px 12px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  color: white;
  background-color: #BF2312;
}
#bnt-cancelar:hover{
  background-color: #e41700ff;
}
</style>

<script>
function abrirModalExclusao(btn) {
    const dados = btn.dataset;

    document.getElementById('idProfissional').value = dados.id;
    document.getElementById('cpf').value = dados.cpf;
    document.getElementById('modalMensagem').innerText = "Tem certeza que deseja excluir este profissional?";
    document.getElementById('modalAviso').style.display = 'flex';
}

function fecharModalAviso() {
    document.getElementById('modalAviso').style.display = 'none';
}
</script>