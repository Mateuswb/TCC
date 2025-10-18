<?php
    include '../../../controllers/ExameController.php';
    
    $controllerExame = new ExameController($conn);
    $exames = $controllerExame->listarExames(); 

?>
<!-- Modal de Encaminhamento -->
<div id="encaminharModal" class="modal">
  <div class="modal-content">
    <h3>Encaminhar Consulta</h3>
    <form action="../../../controllers/ProfissionalController.php?acao=encaminharPaciente" method="POST">
      <!-- Id do agendamento -->
      <input type="hidden" name="idAgendamentoConsulta" id="encaminharId">
      <!-- <input type="hidden" name="acao" value="encaminhar"> -->

      <!-- Seleção do exame -->
      <label for="id_exame">Tipo de exame:</label>
      <select id="id_exame" name="idExame" required>
          <option value="" disabled selected>Selecione o exame</option>
          <?php
          foreach($exames as $ex) {
              // value continua sendo o id do exame (ou nome, se preferir)
              echo "<option value='{$ex['id_exame']}'> {$ex['nome']} </option>";
          }
          ?>
      </select>

      <!-- Observações -->
      <label for="observacoes">Observações:</label>
      <textarea id="observacoes" name="observacoes" placeholder="Observações" rows="4"></textarea>

      <button type="submit" class="btn-encaminhar">📤 Encaminhar</button>
      <button type="button" class="btn-fechar" onclick="fecharEncaminharModal()">Fechar</button>
    </form>
  </div>
</div>

<style>
    

#encaminharModal {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.6);
  justify-content: center;
  align-items: center;
  z-index: 10000;
}

#encaminharModal .modal-content {
  background: #fff;
  padding: 30px;
  border-radius: 15px;
  width: 450px;
  max-width: 90%;
  box-shadow: 0 8px 20px rgba(0,0,0,0.3);
  text-align: left;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

#encaminharModal h3 {
  margin: 0 0 15px 0;
  font-size: 20px;
  text-align: center;
}

#encaminharModal input,
#encaminharModal select,
#encaminharModal textarea {
  width: 100%;
  padding: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 14px;
  box-sizing: border-box;
}

#encaminharModal button {
  padding: 10px;
  border: none;
  border-radius: 8px;
  font-size: 15px;
  cursor: pointer;
  transition: 0.2s;
}

#encaminharModal .btn-encaminhar { background: #f39c12; color: #fff; }
#encaminharModal .btn-fechar { background: #bdc3c7; color: #fff; }
#encaminharModal button:hover { opacity: 0.9; }
</style>