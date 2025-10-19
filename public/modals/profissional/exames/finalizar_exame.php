<!-- Modal de Finalizar Exame -->
<div id="finalizarExameModal" class="modal-overlay" style="display: none;">
  <div class="modal-box">
    <form method="POST" action="../../../controllers/AgendamentoExameController.php?acao=finalizarAgendamentoExame">
        
      <div class="modal-header">
        <h3>Finalizar Exame</h3>
          <span class="close-btn" onclick="document.getElementById('finalizarExameModal').style.display='none'">&times;</span>
      </div>
      <div class="modal-body">
        <p>Tem certeza que deseja <b>finalizar este Exame</b>?</p>
        <input type="int" name="idExame" id="idFinalizarExame">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('finalizarExameModal').style.display='none'">Voltar</button>
        <button type="submit" class="btn btn-success">Finalizar Exame</button>
      </div>
    </form>
  </div>
</div>



<style>

.btn-success {
  background: #27ae60;
  color: #fff;
}

.btn-success:hover {
  background: #1e8449;
}
/* Overlay */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  transition: opacity 0.3s ease;
}

/* Modal box */
.modal-box {
  background: #fff;
  border-radius: 12px;
  width: 400px;
  max-width: 90%;
  box-shadow: 0 8px 20px rgba(0,0,0,0.3);
  animation: slideDown 0.3s ease;
  overflow: hidden;
  font-family: 'Segoe UI', sans-serif;
}

/* Header */
.modal-header {
  padding: 20px;
  background: #f8f8f8;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #eee;
}

.modal-header h3 {
  margin: 0;
  font-size: 20px;
  color: #333;
}

.close-btn {
  cursor: pointer;
  font-size: 24px;
  color: #888;
  transition: color 0.2s ease;
}

.close-btn:hover {
  color: #e74c3c;
}

/* Body */
.modal-body {
  padding: 20px;
  font-size: 16px;
  color: #555;
}

.modal-body b {
  color: #e74c3c;
}

/* Footer */
.modal-footer {
  display: flex;
  justify-content: flex-end;
  padding: 15px 20px;
  gap: 10px;
  background: #f8f8f8;
  border-top: 1px solid #eee;
}

.btn {
  padding: 8px 16px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  font-size: 14px;
  transition: all 0.2s ease;
}

.btn-secondary {
  background: #ccc;
  color: #fff;
}

.btn-secondary:hover {
  background: #999;
}

.btn-danger {
  background: #e74c3c;
  color: #fff;
}

.btn-danger:hover {
  background: #c0392b;
}

/* Slide down animation */
@keyframes slideDown {
  from { transform: translateY(-20px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}
</style>
