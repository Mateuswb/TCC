function confirmarInativacaoConta(url) {
  Swal.fire({
    title: 'Confirmar inativação da conta',
    icon: 'warning',
    iconHtml: '⚠️',
    html: `
      <div style="text-align: left; font-size: 14px;">
        <p style="font-size: 17px; font-weight: bold;">Esta ação é Permanete:</p>
        <ul style="margin: 8px 0 12px 20px; padding: 0;">
          <li style="font-size: 17px;">🗑️ Todos seus <strong>dados de paciente</strong> serão permanentemente excluídos.</li>
          <li style="font-size: 17px;">🚫 Sua conta será <strong> inativada</strong>, você poderá reativar quando desejar.</li>
          <li style="font-size: 17px;">📆 Todos os seus <strong>agendamentos</strong> serão removidos do sistema.</li>
        </ul>
        <p style="font-size: 15px; font-weight: bold;">Tem certeza de que deseja continuar?</p>
      </div>
    `,
    showCancelButton: true,
    confirmButtonText: 'Sim, inativar conta',
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
