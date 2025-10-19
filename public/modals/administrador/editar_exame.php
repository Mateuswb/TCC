<div class="overlay" id="modalEdicao">
    <div class="modal">
        <div class="modal-header">
            <h2>Editar Exame</h2>
            <button class="close" id="closeModalEdicao">&times;</button>
        </div>

        <div class="modal-body">
            <form action="../../../controllers/AdministradorController.php?acao=editarExame" 
                  method="POST" id="formEdicao">

                <!-- id do exame escondido -->
                <input type="hidden" name="idExame" id="idExame">

                <label>Nome do Exame</label>
                <input type="text" name="nome" id="nomeEdicao" readonly>

                <label>Categoria</label>
                <input type="text" name="categoria" id="categoriaEdicao" readonly>

                <label>Tempo (min)</label>
                <input type="number" name="tempoMinutos" id="tempoEdicao" min="1" required>

                <label>Descrição</label>
                <textarea name="descricao" id="descricao" rows="3" required></textarea>

                <div class="footer">
                    <input type="button" class="btn cancel"  id="cancelModalEdicao" value="Cancelar">
                    <input type="submit" class="btn primary" value="Salvar">
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* anicação do modal */
.overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.3); 
    backdrop-filter: blur(1px);
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal {
    width: 900px;
    max-width: 95%;
    background: #fff;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    animation: fadeIn 0.3s ease-in-out;
    overflow: hidden; /* Impede conteúdo de sair da borda */
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}



/* ===== CORPO ===== */
.modal-body {
    padding: 25px 25px 10px 25px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.modal-body label {
    font-weight: 500;
    margin-bottom: 5px;
    color: #333;
}

.modal-body input,
.modal-body textarea {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
    outline: none;
    margin-bottom: 16px;
    resize: none;
    
}


.modal-body input:focus,
.modal-body textarea:focus {
    border-color: #005AC1;
}


/* btns */
.btn.cancel:focus,
.btn.primary:focus {
    border-color: #ffffffff;
}
.btn {
    flex: 1;
    max-width: 150px;
    padding: 10px 24px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    text-align: center;
}

.btn.cancel {
    background: #e5e7eb;
    color: #374151;
}

.btn.cancel:hover {
    background: #d1d5db;
}

.btn.cadastrar {
    background: #005AC1;
    color: #fff;
}

.btn.cadastrar:hover {
    background: #005AC1;
}


.footer {
    display: flex;
    justify-content: space-between; 
    align-items: center; 
    padding: 10px 20px; 
}

</style>


<script>
document.addEventListener("DOMContentLoaded", () => {
    const categoriasMap = {
        'Sa': 'Sangue',
        'Im': 'Imagem',
        'Ca': 'Cardiológicos',
        'Ur': 'Urina',
        'Ho': 'Hormonais',
        'In': 'Infecciosos',
        'Re': 'Respiratórios'
    };

    const modalEdicao = document.getElementById("modalEdicao");
    const closeModalEdicao = document.getElementById("closeModalEdicao");
    const cancelModalEdicao = document.getElementById("cancelModalEdicao");

    const abrirModalEdicao = () => modalEdicao.style.display = "flex";
    const fecharModalEdicao = () => modalEdicao.style.display = "none";

    closeModalEdicao.addEventListener("click", fecharModalEdicao);
    cancelModalEdicao.addEventListener("click", fecharModalEdicao);
    window.addEventListener("click", e => { if(e.target === modalEdicao) fecharModalEdicao(); });

    //  captura clique no ícone de editar
    document.querySelectorAll(".fa-edit").forEach(btn => {
        btn.addEventListener("click", () => {
            // pega os dados
            document.getElementById("idExame").value = btn.dataset.id;
            document.getElementById("nomeEdicao").value = btn.dataset.nome;

            const categoriaCompleta = categoriasMap[btn.dataset.categoria] || btn.dataset.categoria;
            document.getElementById("categoriaEdicao").value = categoriaCompleta;

            document.getElementById("tempoEdicao").value = btn.dataset.tempo;
            document.getElementById("descricao").value = btn.dataset.descricao;

            abrirModalEdicao();
        });
    });
});
</script>
