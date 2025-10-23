<?php

    session_start();
    $erro = $_SESSION['error'] ?? null;
    unset($_SESSION['error']);
?>

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
            
                <div class="footer">
                    <input type="button" class="btn cancel"  id="cancelModal" value="Cancelar">
                    <input type="submit" class="btn primary" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    
/* Style da msg de erro */
#error-message{
    background-color: #ffeef0;
    color: #86181d;
    border: 1px solid #e63042;
    padding: 10px 15px;
    margin-top: 0px;
    border-radius: 6px;
    margin-bottom: 10px;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.form-control img, small{
    visibility: hidden;
}


.close-btn2 {
    background: none;
    border: none;
    font-size: 18px;
    color: #86181d;
    cursor: pointer;
    padding: 0;
}
.close-btn2:hover {
    color: #d73a49;
}

/* anicação do modal */
.overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
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

/* header */
.modal-header {
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e5e7eb;
}

.close {
    border: none;
    background: none;
    font-size: 24px;
    cursor: pointer;
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
    border-color: #4f46e5;
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

.btn.primary {
    background: #005AC1;
    color: #fff;
}

.btn.primary:hover {
    background: #005AC1;
}


.footer {
    display: flex;
    justify-content: space-between; 
    align-items: center; 
    padding: 10px 20px; 
}

.close-btn2 {
    background: none;
    border: none;
    font-size: 18px;
    color: #86181d;
    cursor: pointer;
}

.close-btn2:hover {
    color: #d73a49;
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
<?php if ($erro): ?>
<script>

    const form = document.getElementById("modalExame");
    if (form) {
        const msg = document.createElement("div");
        msg.id = "error-message";
        msg.innerHTML = `
            <span><?= htmlspecialchars($erro) ?></span>
            <button class="close-btn2" onclick="this.parentElement.remove()">×</button>
        `;
        form.prepend(msg);
    }
</script>
<?php endif; ?>