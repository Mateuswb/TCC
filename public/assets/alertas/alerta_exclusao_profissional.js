function confirmarExclusaoProfissional(url) {
  Swal.fire({
    title: 'Excluir Profissional',
    html: `
      <div style="text-align: left; font-size: 14px;">
        <p style="font-size: 17px; font-weight: bold;">Atenção:</p>
        <ul style="margin: 8px 0 12px 20px; padding: 0;">
        <li style="font-size: 16px;">🧑O profissional será <strong>removido permanentemente</strong> do sistema.</li>
        <li style="font-size: 16px;">🔒O usuário desse profissional será bloqueado. E não poderá fazer login</li>
        <li style="font-size: 16px;">❌O profissional não poderá reativar a conta sem a permissão de um admin.</li>
        <li style="font-size: 16px;">📅 Todos os agendamentos vinculados serão cancelados.</li>
        </ul>
        <p style="font-size: 15px; font-weight: bold;">Tem certeza de que deseja excluir este profissional?</p>
      </div>
    `,
    showCancelButton: true,
    confirmButtonText: 'Sim, excluir profissional',
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
