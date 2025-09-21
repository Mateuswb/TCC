// confirmarDelete.js
function confirmarExclusaoConsulta(url) {
  Swal.fire({
    title: 'Excluir Consulta do Histórico',
    html: `
      <div style="text-align: left; font-size: 14px;">
        <p style="font-size: 17px; font-weight: bold;">Atenção:</p>
        <ul style="margin: 8px 0 12px 20px; padding: 0;">
          <li style="font-size: 17px;">🗑️ Esta ação apagará a consulta do seu histórico permanentemente.</li>
        </ul>
        <p style="font-size: 15px; font-weight: bold;">Deseja realmente excluir essa consulta do seu histórico?</p>
      </div>
    `,
    showCancelButton: true,
    confirmButtonText: 'Sim, excluir do histórico',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    width: '500px',
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}
