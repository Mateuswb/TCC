function abrirModal() {
    const modalBg = document.getElementById('modal-login');
    const modalBox = modalBg.querySelector('.modal-box');

    modalBg.style.display = 'flex';
    modalBox.classList.remove('fade-out');
    modalBox.classList.add('fade-in');
}

function fecharModal() {
    const modalBg = document.getElementById('modal-login');
    const modalBox = modalBg.querySelector('.modal-box');

    modalBox.classList.remove('fade-in');
    modalBox.classList.add('fade-out');

    setTimeout(() => {
        modalBg.style.display = 'none';
    }, 350); 
}