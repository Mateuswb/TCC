function confirmarAlteracaoStatus(formId, statusId) {
    const form = document.getElementById(formId);
    const status = document.getElementById(statusId).value;

    let mensagem = "";

    if (status === "inativo") {
        mensagem = "Deseja realmente inativar esse administrador?";
    } else if (status === "bloqueado") {
        mensagem = "Deseja realmente bloquear esse administrador?";
    } else {
        form.submit(); 
        return;
    }

    Swal.fire({
        title: 'Atenção',
        text: mensagem,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
