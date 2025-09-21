function alertaEntrada(tipo) {
  let corFundo, corTexto, borda, mensagem;

  if (tipo === 'sucesso') {
    corFundo = '#f2fff8';
    corTexto = '#256029';
    borda = '#28a745';
    mensagem = '☑️ Logado com sucesso';
  } else {
    corFundo = '#ffeceb';
    corTexto = '#842029';
    borda = '#dc3545';
    mensagem = '❌ Erro ao logar';
  }

  // Cria o container
  let alerta = document.getElementById('alerta-topo');
  if (!alerta) {
    alerta = document.createElement('div');
    alerta.id = 'alerta-topo';
    document.body.appendChild(alerta);
  }

  Object.assign(alerta.style, {
    position: 'fixed',
    top: '20px',
    left: '50%',
    transform: 'translateX(-50%)',
    padding: '15px 40px',
    borderRadius: '10px',
    fontFamily: 'Poppins, sans-serif',
    fontSize: '17px',
    boxShadow: '0 4px 12px rgba(0, 0, 0, 0.1)',
    zIndex: '9999',
    opacity: '0',
    transition: 'all 0.6s ease',
    backgroundColor: corFundo,
    color: corTexto,
    pointerEvents: 'none',
  });

  alerta.textContent = mensagem;

  // Mostra suavemente
  setTimeout(() => {
    alerta.style.opacity = '1';
    alerta.style.pointerEvents = 'auto';
  }, 100);

  setTimeout(() => {
    alerta.style.opacity = '0';
    alerta.style.pointerEvents = 'none';
  }, 2700);

  // Remove a msg da URL
  const url = new URL(window.location);
  url.searchParams.delete('logar');
  history.replaceState(null, '', url);
}
