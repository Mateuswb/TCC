<div id="modalExcluir">
    <div class="modal-box">
        <h3 id="modalMensagem">Tem certeza que deseja excluir sua conta?</h3>
        
        <form action="../../controllers/PacienteController.php?acao=excluirContaPaciente" method="post">
            <input type="hidden" name="idPaciente" id="idPaciente">
            <input type="hidden" name="cpf" id="cpf">
            
            <div class="modal-botoes">
                <button type="button" onclick="fecharModalExcluir()" class="btn-cancelar">
                    Cancelar
                </button>
                <input type="submit" value="Excluir Conta" id="btn-excluir">
            </div>
        </form>
        
        <span onclick="fecharModalExcluir()" class="modal-fechar">&times;</span>
    </div>
</div>

<link rel="stylesheet" href="../../public/assets/css/geral/deletar_conta.css">

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
