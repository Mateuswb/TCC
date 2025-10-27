<?php
  session_start();
  $idProfissional = $_SESSION['idProfissional'];

?>

<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Planilha de Horários</title>
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

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        background: linear-gradient(180deg, var(--bg), #f8fbff);
        color: #111827;
        padding: 40px 20px;
    }

    .page {
        max-width: 1200px;
        margin: 0 auto 40px;
    }

    .header {
        text-align: center;
        margin-bottom: 18px;
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
        margin-bottom: 14px;
    }

    .save-btn {
        background: linear-gradient(180deg, #4f46e5, #3b82f6);
        color: #fff;
        padding: 10px 16px;
        border-radius: 10px;
        border: 0;
        box-shadow: 0 8px 18px rgba(59, 130, 246, 0.18);
        cursor: pointer;
        font-weight: 600;
        display: inline-flex;
        gap: 10px;
        align-items: center;
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
        padding: 8px 10px;
        border-radius: 8px;
        min-width: 96px;
    }

    .time-input input {
        border: 0;
        outline: none;
        background: transparent;
        font-size: 14px;
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

</style>
</head>
<body>
  <div class="page">
    <div class="header">
      <h1>Planilha de Horários</h1>
      <p class="subtitle">Cadastre seus horários de atendimento aqui.</p>
      <div class="prof-id">Profissional ID: <strong>12345</strong></div>
    </div>

    <form id="formHorarios" action="../../../controllers/HorarioController.php?acao=cadastrarHorarios" method="POST">
      <input type="hidden" name="idProfissional" value="<?php echo $idProfissional; ?>">

      <div class="sheet">
        <div class="sheet-header">
          <div></div>
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

        <div class="sheet-footer">
          <div class="period-counter" id="periodCounter">Total de períodos: 0</div>
        </div>
      </div>
    </form>
  </div>

  <div id="toast" class="toast"></div>

  <div class="sheet" style="padding:16px;width:70%;margin-left:250px;">
    <strong>Como usar a planilha:</strong>
    <p class="small-muted" style="margin:6px 0 0">
      Preencha os campos <em>Início</em> e <em>Fim</em> dos dias desejados.
      Use <strong>⎘</strong> para clonar horários para todos os dias.
      Clique <strong>Salvar Planilha</strong> para enviar.
    </p>
  </div>

<script>
(function(){
  const weekdays = [
    { short:'SEG', full:'Segunda', color:'#ef4444' },
    { short:'TER', full:'Terça', color:'#f97316' },
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

  let rows = [];
  function uid(){ return 'r' + Math.random().toString(36).slice(2,9); }

  function initRows(){
    weekdays.forEach((d, idx) => {
      rows.push({ id: uid(), dayIndex: idx, start:'', end:'', iStart:'', iEnd:'' });
    });
  }

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
        </div>
      `;

      function inputCell(value, name, fieldName){
        const td = document.createElement('td');
        td.className = 'col-time';
        td.innerHTML = `
          <div class="time-card">
            <div class="time-input">
              <input type="time" name="${fieldName}[]" value="${value}" data-field="${name}">
            </div>
          </div>`;
        td.querySelector('input').addEventListener('input', e => r[name] = e.target.value);
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
    toast.textContent = msg;
    toast.classList.add('show');
    setTimeout(()=>toast.classList.remove('show'),3000);
  }

  document.getElementById('btnSave').addEventListener('click', ()=>{
    form.submit();
  });

  initRows();
  render();
})();
</script>
</body>
</html>
