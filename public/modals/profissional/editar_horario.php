
<div id="modalPlanilha" class="modal-overlay">
  <div class="modal-content">

    <div class="page">
      <div class="header">
        <h1>Planilha de Horários</h1>
        <p class="subtitle">Cadastre seus horários de atendimento aqui.</p>
      </div>

      
      <form id="formHorarios" action="../../../controllers/HorarioController.php?acao=editarHorario" method="POST">
        <input type="hidden" name="idProfissional" value="<?php echo $idProfissional; ?>">

        <div class="sheet">
            <div class="sheet-header">
                <div></div>

                <div id="msgErroHorarios" class="erro-horario" style="display:none;"></div>
                <div>
                    <input type="submit" class="save-btn" id="btnSave" value="Salvar Planilha">
                </div>
            </div>


          <div style="overflow:auto;">
            <table class="sheet-table" id="sheetTable">
              <thead>
                <tr>
                  <th class="col-day">Dia da Semana</th>
                  <th class="col-time">Início</th>
                  <th class="col-time">Fim</th>
                  <th class="col-time">Início Intervalo</th>
                  <th class="col-time">Fim Intervalo</th>
                  <th class="col-actions">Ações</th>
                </tr>
              </thead>
              <tbody id="tableBody"></tbody>
            </table>
          </div>

        </div>
      </form>
    </div>


    <div class="sheet" style="padding:16px;width:100%;margin:20px auto;">
      <strong>Como usar a planilha:</strong>
      <p class="small-muted" style="margin:6px 0 0">
        Preencha os campos <em>Início</em> e <em>Fim</em> dos dias desejados.
        Use o <strong>botão</strong> de clonar para colocar os mesmo horários para todos os dias.
        Clique <strong>Salvar Planilha</strong> para enviar.
      </p>
    </div>
  </div>
</div>

<!-- Estilos do modal -->
<style>

      :root {
        --bg: #eef6ff;
        --card: #ffffff;
        --primary: #3b82f6;
        --muted: #6b7280;
        --green-400: #34d399;
        --shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        --accent: #4f46e5;
    }

    .page {
        max-width: 1200px;
        margin: 0 auto 40px;
    }

    .header {
        text-align: center;

    }
    .sheet-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #fff; 
    }


    h1 {
        font-size: 22px;
        margin: 8px 0 6px;
    }

    p.subtitle {
        margin: 0;
        color: var(--muted);
        font-size: 13px;
    }

    .prof-id {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 8px;
    }

    .sheet {
        background: var(--card);
        border-radius: 12px;
        padding: 18px;
        box-shadow: var(--shadow);
    }

    .sheet-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    #btnSave {
        background: linear-gradient(180deg, #0939beff, #115dd8ff);
        color: #fff;
        padding: 10px 16px;
        border-radius: 10px;
        border: 0;
        box-shadow: 0 8px 18px rgba(59, 130, 246, 0.18);
        cursor: pointer;
        font-weight: 600;
        display: inline-flex;
        margin-bottom: 10px;
        align-items: center;
    }
    #btnSave:hover{
       background: linear-gradient(90deg, #00268dff, #004ecaff);
    }

    .sheet-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .sheet-table thead th {
        background: #f3f6fb;
        color: #374151;
        padding: 12px 10px;
        text-align: left;
        font-size: 13px;
        border-bottom: 1px solid #e6eefc;
    }
    .erro-horario {
    color: #dc2626; 
    background: #fee2e2; 
    border: 1px solid #fca5a5;
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    text-align: center;
    max-width: 60%;
    margin: 0 auto;
    transition: all 0.2s ease;
    }

    .sheet-table tbody td {
        padding: 10px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .col-day {
        width: 210px;
    }

    .col-time {
        width: 160px;
        text-align: center;
    }

    .col-actions {
        width: 120px;
        text-align: center;
    }

    .day-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .day-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .day-title {
        font-weight: 600;
    }

    .day-sub {
        display: block;
        font-size: 12px;
        color: #7c8a9b;
        margin-top: 4px;
    }

    .time-card {
        display: flex;
        gap: 8px;
        align-items: center;
        justify-content: center;
    }

    .time-input {
        background: #fff;
        border: 1px solid #e6eefc;
        padding: 8px 25px;
        border-radius: 8px;
        min-width: 96px;
    }

    .btn-small {
        border: 0;
        padding: 6px 8px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-clone {
        background: #f97316;
        color: #fff;
    }

    .btn-small:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
    }

    .toast {
        position: fixed;
        right: 20px;
        bottom: 20px;
        background: #111827;
        color: #fff;
        padding: 12px 14px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(2, 6, 23, 0.35);
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.36s;
        z-index: 9999;
    }

    .toast.show {
        opacity: 1;
        transform: translateY(0);
    }

    .sheet-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 14px;
        color: #6b7280;
    }

    .period-counter {
        font-size: 13px;
    }

  .modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(17, 24, 39, 0.65);
    display: none; 
    justify-content: center;
    align-items: flex-start;
    overflow-y: auto;
    z-index: 9999;
    padding: 40px 0;
  }

  .modal-content {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 10px 35px rgba(15, 23, 42, 0.18);
    width: 90%;
    max-width: 1300px;
    padding: 20px;
    animation: fadeInScale 0.3s ease forwards;
  }

  @keyframes fadeInScale {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
  }
</style>

<script>
(function(){
  const weekdays = [
    { short:'SEG', full:'Segunda', color:'#ef4444' },
    { short:'TER', full:'Terca', color:'#f97316' },
    { short:'QUA', full:'Quarta', color:'#f59e0b' },
    { short:'QUI', full:'Quinta', color:'#10b981' },
    { short:'SEX', full:'Sexta', color:'#06b6d4' },
    { short:'SAB', full:'Sabado', color:'#8b5cf6' },
    { short:'DOM', full:'Domingo', color:'#6366f1' }
  ];

  const body = document.getElementById('tableBody');
  const toast = document.getElementById('toast');
  const form = document.getElementById('formHorarios');
  const periodCounter = document.getElementById('periodCounter');
  const modal = document.getElementById('modalPlanilha');
  const msgErro = document.getElementById('msgErroHorarios');

  let rows = [];

  // 🔹 id vem do backend quando for edição
  function uid(){ return 'r' + Math.random().toString(36).slice(2,9); }


  function initRows(){
    weekdays.forEach((d, idx) => {
      rows.push({
        id: uid(),
        idHorario: null,
        dayIndex: idx,
        start:'',
        end:'',
        iStart:'',
        iEnd:''
      });
    });
  }

  // 🔹 usado pelo backend pra preencher horários no modo edição
  window.preencherHorarios = function(listaHorarios){
    rows = weekdays.map((d, idx) => {
      const existente = listaHorarios.find(h => h.diaSemana === d.full);
      if (existente) {
        return {
          id: uid(),
          idHorario: existente.idHorario,
          dayIndex: idx,
          start: existente.horaInicio || '',
          end: existente.horaFim || '',
          iStart: existente.inicioIntervalo || '',
          iEnd: existente.fimIntervalo || ''
        };
      } else {
        return {
          id: uid(),
          idHorario: null,
          dayIndex: idx,
          start:'',
          end:'',
          iStart:'',
          iEnd:''
        };
      }
    });
    render();
  };

  // 🔹 renderiza tabela
  function render(){
    body.innerHTML = '';
    rows.forEach(r=>{
      const day = weekdays[r.dayIndex];
      const tr = document.createElement('tr');
      tr.dataset.rowId = r.id;

      const dayCell = document.createElement('td');
      dayCell.innerHTML = `
        <div class="day-cell">
          <span class="day-dot" style="background:${day.color}"></span>
          <div>
            <div class="day-title">${day.short}</div>
            <div class="day-sub">${day.full}</div>
          </div>
          <input type="hidden" name="diaSemana[]" value="${day.full}">
          <input type="hidden" name="idHorario[]" value="${r.idHorario || ''}">

        </div>
      `;

      function inputCell(value, name, fieldName){
        const td = document.createElement('td');
        td.className = 'col-time';
        td.innerHTML = `
          <div class="time-card">
            <div class="time-input">
              <input 
                type="time" 
                name="${fieldName}[]" 
                value="${value}" 
                data-field="${name}" 
                step="1800">
            </div>
          </div>`;
        const input = td.querySelector('input');
        input.addEventListener('input', e => r[name] = e.target.value);
        return td;
      }

      const tdStart = inputCell(r.start,'start','horaInicio');
      const tdEnd   = inputCell(r.end,'end','horaFim');
      const tdIS    = inputCell(r.iStart,'iStart','inicioIntervalo');
      const tdIE    = inputCell(r.iEnd,'iEnd','fimIntervalo');

      const tdActions = document.createElement('td');
      tdActions.innerHTML = `<button type="button" class="btn-small btn-clone">⎘</button>`;
      tdActions.querySelector('button').addEventListener('click',()=>cloneRowToAll(r.id));

      tr.append(dayCell, tdStart, tdEnd, tdIS, tdIE, tdActions);
      body.appendChild(tr);
    });
    updatePeriodCount();
  }

  function cloneRowToAll(rowId){
    const src = rows.find(r=>r.id===rowId);
    if(!src) return;
    rows = rows.map(r=>({...r, start:src.start, end:src.end, iStart:src.iStart, iEnd:src.iEnd}));
    render();
    showToast('⏰ Horários clonados para todos os dias');
  }

  function updatePeriodCount(){
    periodCounter.textContent = `Total de períodos: ${rows.length}`;
  }

  function showToast(msg){
    if (!toast) return console.log(msg);
    toast.textContent = msg;
    toast.classList.add('show');
    setTimeout(()=>toast.classList.remove('show'),3000);
  }

  function toMinutes(time){
    if(!time) return null;
    const [h,m] = time.split(':').map(Number);
    return h * 60 + m;
  }

  function isValido(time){
    const [h,m] = time.split(':').map(Number);
    return m === 0 || m === 30;
  }

  function mostrarErro(msg){
    msgErro.textContent = msg;
    msgErro.style.display = 'block';
  }

  function limparErro(){
    msgErro.textContent = '';
    msgErro.style.display = 'none';
  }

  // 🔹 validação ajustada para edição
  form.addEventListener('submit', (e)=>{
    limparErro();

    // Se já existir pelo menos um horário vindo do backend, permite salvar
    const temHorariosExistentes = rows.some(r => r.start || r.end || r.iStart || r.iEnd);
    if (!temHorariosExistentes) {
      e.preventDefault();
      mostrarErro('⚠️ Você precisa cadastrar pelo menos um horário.');
      return;
    }

    for (let i = 0; i < rows.length; i++) {
      const r = rows[i];
      const dia = weekdays[r.dayIndex].full;

      if (!r.start && !r.end && !r.iStart && !r.iEnd) continue;

      const start = toMinutes(r.start);
      const end = toMinutes(r.end);
      const iStart = toMinutes(r.iStart);
      const iEnd = toMinutes(r.iEnd);

      // só valida se houver horário principal
      if (r.start && r.end) {
        if (start >= end) {
          e.preventDefault();
          mostrarErro(`⚠️ Em ${dia}, o horário de início deve ser menor que o de fim.`);
          return;
        }
        if ((iStart && iEnd) && (iStart < start || iEnd > end || iStart >= iEnd)) {
          e.preventDefault();
          mostrarErro(`⚠️ Em ${dia}, o intervalo deve estar dentro do horário de trabalho.`);
          return;
        }
        const all = [r.start, r.end, r.iStart, r.iEnd].filter(Boolean);
        for (const hora of all) {
          if (!isValido(hora)) {
            e.preventDefault();
            mostrarErro(`⚠️ Em ${dia}, os horários devem terminar em :00 ou :30.`);
            return;
          }
        }
      }
    }
  });

  window.abrirModalPlanilha = function(){
    modal.style.display = 'flex';
  };

  initRows();
  render();
})();
</script>
