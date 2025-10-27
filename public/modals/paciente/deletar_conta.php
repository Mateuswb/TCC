<div id="modalExcluir" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
    background: rgba(0,0,0,0.55); align-items:center; justify-content:center;">
    <div style="background:#fff; padding:20px; border-radius:8px; width:400px; text-align:center; position:relative;">
        <h3 id="modalMensagem">Tem certeza que deseja excluir sua conta?</h3>
        
        <form action="../../controllers/PacienteController.php?acao=excluirContaPaciente" method="post">
            <input type="int" name="idPaciente" id="idPaciente">
            <input type="int" name="cpf" id="cpf">
            
            <div style="margin-top:20px; display:flex; justify-content: space-between;">
                <button type="button" onclick="fecharModalExcluir()" 
                    style="padding:10px 20px; background:#ccc; border:none; border-radius:5px; cursor:pointer;">
                    Cancelar
                </button>
                <input type="submit" value="Excluir Conta" 
                    style="padding:10px 20px; background:#d9534f; color:#fff; border:none; border-radius:5px; cursor:pointer;">
            </div>
        </form>
        
        <span onclick="fecharModalExcluir()" 
              style="position:absolute; top:10px; right:15px; cursor:pointer; font-weight:bold;">&times;</span>
    </div>
</div>

<script>
    function abrirModalExclusao(btn) {
        const dados = btn.dataset;

        document.getElementById('idPaciente').value = dados.id;
        document.getElementById('cpf').value = dados.cpf;
        document.getElementById('modalExcluir').style.display = 'flex';
    }

    function fecharModalExcluir() {
        document.getElementById('modalExcluir').style.display = 'none';
    }
</script>
