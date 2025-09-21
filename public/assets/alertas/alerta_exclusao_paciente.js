// confirmar.js
function confirmarExclusao(url) {
  Swal.fire({
    title: 'Confirmar exclusão',
    icon: 'warning',
    iconHtml: '⚠️',
    html: `
      <div style="text-align: left; font-size: 14px;">
        <p style="font-size: 17px; font-weight: bold;">O que acontecerá:</p>
        <ul style="margin: 8px 0 12px 20px; padding: 0;">
          <li style="font-size: 17px;">🗑️ Os dados do paciente serão removidos.</li>
          <li style="font-size: 17px;">🔒 A conta do usuário será bloqueada.</li>
          <li style="font-size: 16px;">📅 Todos os agendamentos vinculados serão cancelados.</li>
          <li style="font-size: 17px;">🔁 O usuário não poderá reativar a conta sem a permissão de um admin.</li>
        </ul>
        <p style="font-size: 15px; font-weight: bold;">Deseja continuar?</p>
      </div>
    `,
    showCancelButton: true,
    confirmButtonText: 'Sim, excluir',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    width: '450px',
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
}
