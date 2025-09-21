function confirmarInativarConta(url) {
  Swal.fire({
    title: 'Confirmar inativação da conta',
    icon: 'warning',
    iconHtml: '⚠️',
    html: `
      <div style="text-align: left; font-size: 14px;">
        <p style="font-size: 17px; font-weight: bold;">Esta ação é Permanete:</p>
        <ul style="margin: 8px 0 12px 20px; padding: 0;">
          <li style="font-size: 17px;">🗂️ Seu dados ficaram salvos no sistema.</li>
          <li style="font-size: 17px;">🚫 Sua conta será <strong> inativada </strong>, você não poderá reativar sem a permissão de um admin.</li>        </ul>
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
