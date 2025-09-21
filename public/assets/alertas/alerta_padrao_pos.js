function alertaPadraoPos(tipo, titulo, mensagem) {
  let corFundo, corTexto, borda;

  if (tipo === 'sucesso') {
    corFundo = '#ebf9f1';
    corTexto = '#256029';
    borda = '#28a745';
  } else if(tipo === 'erro'){
    corFundo = '#ffeceb';
    corTexto = '#842029';
    borda = '#dc3545';
  }
  else{
    corFundo = '#fff4e5';
    corTexto = '#a35c00';
    borda = '#ff9900';
  }

  Swal.fire({
    title: titulo,
    text: mensagem,
    timer: 2000,
    showConfirmButton: false,
    background: corFundo,
    color: corTexto,
    customClass: {
      popup: 'popup-alerta'
    },
    didOpen: () => {
      const popup = document.querySelector('.popup-alerta');
      popup.style.borderLeft = `6px solid ${borda}`;
      popup.style.borderRadius = '12px';
      popup.style.fontFamily = 'Poppins, sans-serif';
    }
  }).then(() => {
    const url = new URL(window.location);
    url.searchParams.delete('alerta');
    history.replaceState(null, '', url);
  });
}
