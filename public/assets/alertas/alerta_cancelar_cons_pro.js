// confirmar-profissional.js
function confirmarCancelamento(url) {
  Swal.fire({
    title: 'Cancelar Consulta do Paciente',
    icon: 'warning',
    iconHtml: '⚠️',
    html: `
      <div style="text-align: left; font-size: 14px;">
        <p style="font-size: 17px; font-weight: bold;">Atenção:</p>
        <ul style="margin: 8px 0 12px 20px; padding: 0;">
          <li style="font-size: 17px;">👤 Você irá a cancelar a consulta de um paciente.</li>
          <li style="font-size: 17px;">📆 Esse agendamento será removido da agenda do paciente.</li>
          <li style="font-size: 17px;">📢 O paciente poderá remarcar, mas será necessário criar um novo agendamento.</li>
          <li style="font-size: 17px;">⚠️ Esta ação é irreversível.</li>
        </ul>
        <p style="font-size: 15px; font-weight: bold;">Tem certeza de que deseja cancelar esta consulta?</p>
      </div>
    `,
    showCancelButton: true,
    confirmButtonText: 'Sim, cancelar consulta',
    cancelButtonText: 'Não cancelar',
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    width: '500px',
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}
