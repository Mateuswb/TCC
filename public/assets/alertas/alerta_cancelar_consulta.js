// confirmar.js
function confirmarCancelamentoConsulta(url) {
  Swal.fire({
    title: 'Confirmar Cancelamento da Consulta',
    icon: 'warning',
    iconHtml: '⚠️',
    html: `
      <div style="text-align: left; font-size: 14px;">
        <p style="font-size: 17px; font-weight: bold;">Atenção:</p>
        <ul style="margin: 8px 0 12px 20px; padding: 0;">
          <li style="font-size: 17px;">📆 Ao cancelar, essa consulta será automaticamente removido da sua agenda.</li>
          <li style="font-size: 17px;">🚫 A consulta <strong>não será realizada</strong>. </li>
          <li style="font-size: 17px;">📞 Se desejar remarcar, será necessário fazer um novo agendamento.</li>
        </ul>
        <p style="font-size: 15px; font-weight: bold;">Tem certeza de que deseja cancelar esta consulta?</p>
      </div>
    `,
    showCancelButton: true,
    confirmButtonText: 'Sim, cancelar consulta',
    cancelButtonText: 'Manter agendamento',
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    width: '500px',
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}
