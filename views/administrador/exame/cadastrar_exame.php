<div class="overlay" id="modalExame">
    <div class="modal">
        <div class="modal-header">
            <h2>Cadastrar Novo Exame</h2>
            <button class="close" id="closeModal">&times;</button>
        </div>

        <div class="modal-body">
            <form action="../../../controllers/AdministradorController.php?acao=cadastrarExame" 
                  method="POST" id="formExame">

                <label>Nome do Exame</label>
                <input type="text" name="nome" placeholder="Ex: Eletrocardiograma" required>

                <label>Categoria</label>
                <input type="text" name="categoria" id="categoriaSugerida" readonly>

                <label>Tempo (min)</label>
                <input type="number" name="tempoMinutos" id="tempoExame" min="1" placeholder="Ex: 30" required>

                <label>Descrição</label>
                <textarea name="descricao" rows="3" placeholder="Descrição do exame" required></textarea>

                <div class="modal-footer">
                    <button type="button" class="btn cancel" id="cancelModal">Cancelar</button>
                    <button type="submit" class="btn primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Overlay e Modal */
.overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal {
    height: 500px;
    width: 900px;
    max-width: 95%;
    background: #fff;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Header e Footer */
.modal-header,
.modal-footer {
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e5e7eb;
}

.modal-footer {
    border-top: 1px solid #e5e7eb;
    border-bottom: none;
}

/* Fechar modal */
.close {
    border: none;
    background: none;
    font-size: 24px;
    cursor: pointer;
}

/* Corpo do Modal */
.modal-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.modal-body input,
.modal-body select,
.modal-body textarea {
    width: 100%;
    padding: 13px;
    border-radius: 8px;
    border: 1px solid #ccc;
    outline: none;
    font-size: 14px;
    margin-bottom: 20px;
}

.modal-body input:focus,
.modal-body select:focus,
.modal-body textarea:focus {
    border-color: #4f46e5;
}

/* Botões */
.btn {
    padding: 10px 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
}

.btn.cancel {
    background: #e5e7eb;
    color: #374151;
}

.btn.primary {
    background: #4f46e5;
    color: #fff;
}

.btn.cancel:hover {
    background: #d1d5db;
}

.btn.primary:hover {
    background: #4338ca;
}
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const openModalBtn = document.getElementById("openModal");
        const modal = document.getElementById("modalExame");
        const closeModalBtn = document.getElementById("closeModal");
        const cancelModalBtn = document.getElementById("cancelModal");

        if(openModalBtn) {
            openModalBtn.addEventListener("click", () => modal.style.display = "flex");
        }

        const fecharModal = () => modal.style.display = "none";
        closeModalBtn.addEventListener("click", fecharModal);
        cancelModalBtn.addEventListener("click", fecharModal);
        window.addEventListener("click", e => { if(e.target === modal) fecharModal(); });

        // API para gerar a categoria e tempo
        const exameInput = document.querySelector("input[name='nome']");
        const categoriaSugeridaInput = document.getElementById("categoriaSugerida");
        const tempoExameInput = document.getElementById("tempoExame");

        const LIMITAR_CONFIANCA = 100;

        exameInput.addEventListener("blur", async () => {
            const exame = exameInput.value.trim();
            if(exame.length < 3) return;

            try {
                const response = await fetch(`https://api-mateus-ca43236e780f.herokuapp.com/mateus?nome=${encodeURIComponent(exame)}`);
                const data = await response.json();

                const confianca = parseFloat(data.confianca);

                if(data.categoria_sugerida !== "Categoria não encontrada" && confianca >= LIMITAR_CONFIANCA) {
                    categoriaSugeridaInput.value = data.categoria_sugerida;
                    tempoExameInput.value = data.tempo_estimado || "";
                } else {
                    categoriaSugeridaInput.value = "Categoria não encontrada";
                    tempoExameInput.value = "";
                }

            } catch(error) {
                console.error("Erro ao consultar API:", error);
                categoriaSugeridaInput.value = "Erro ao consultar API";
                tempoExameInput.value = "";
            }
        });
    });
</script>
