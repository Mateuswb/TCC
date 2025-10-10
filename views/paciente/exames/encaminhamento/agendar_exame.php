<div class="overlay" id="modalExame">
    <div class="modal">
        <div class="modal-header">
            <h2>Cadastrar Novo Exame</h2>
            <button class="close" id="closeModal">&times;</button>
        </div>

        <div class="modal-body">
            <form action="../../../../controllers/AgendamentoExameController.php?acao=agendarExame" method="POST">
                <input type="hidden" name="idEncaminhamento" value="<?= $idEncaminhamento; ?>">


                <div class="form-control">
                    <label for="diaAgendamento">Dia da Consulta</label>
                    <input type="date" id="diaAgendamento" name="diaAgendamento">
                </div>

                <div class="form-control">
                    <label for="horarioAgendamento">Escolha o Horário</label>
                    <small id="erro-horario" style="color: #e74c3c;"></small>

                    <div class="times" id="times"></div>
                </div>

                <div class="form-control">
                    <label for="observacao">Observações</label>
                    <textarea id="observacao" name="observacao" placeholder="Escreva alguma observação..."></textarea>
                </div>

                <input type="submit" value="Agendar" class="btn-agendar">
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

