// confirmar.js
function confirmarDeletarUsuario(url) {
  Swal.fire({
    title: 'Deletar Conta',
    html: `
      <div style="text-align: left; font-size: 14px;">
        <p style="font-size: 17px; font-weight: bold;">Atenção:</p>
        <ul style="margin: 8px 0 12px 20px; padding: 0;">
          <li style="font-size: 17px;">❌ Essa ação é <strong>irreversível</strong>.</li>
          <li style="font-size: 17px;">🗂️ Todos os dados serão <strong>permanentemente apagados do sistema</strong>.</li>
          <li style="font-size: 17px;">⚠️ O usuário precisará criar uma nova conta.</li>
        </ul>
        <p style="font-size: 15px; font-weight: bold;">Tem certeza de que deseja deletar essa conta?</p>
      </div>
    `,
    showCancelButton: true,
    confirmButtonText: 'Sim, deletar conta',
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
