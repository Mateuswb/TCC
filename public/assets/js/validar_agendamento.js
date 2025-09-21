const form = document.getElementById('form');
const dataInput = document.getElementById('dia_agendamento');
const horarios = document.querySelectorAll('input[name="horario"]:checked');

form.addEventListener('submit', (e) => {
    e.preventDefault();
    checkInputs();
});

function checkInputs() {
    const dataValue = dataInput.value.trim();
    const hoje = new Date();
    hoje.setHours(0, 0, 0, 0);
    const dataSelecionada = new Date(dataValue);

    let formValido = true;

    
    if (dataValue === '') {
        errorValidation(dataInput, 'Este campo é obrigatório.');
        formValido = false;
    } else if (dataSelecionada < hoje) {
        errorValidation(dataInput, 'A data não pode ser anterior a hoje.');
        formValido = false;
    } else {
        successValidation(dataInput);
    }

    const horarioSelecionado = document.querySelector('input[name="horario"]:checked');
    const erroHorario = document.getElementById('erro-horario');

    if (!horarioSelecionado) {
        erroHorario.innerText = 'Selecione um horário.';
        formValido = false;
    } else {
        erroHorario.innerText = '';
    }

    if (formValido) {
        form.submit();
    }
}


// Função para mostrar erro na validação
function errorValidation(input, message) {
    const formControl = input.parentElement;
    const small = formControl.querySelector('small');
    small.innerText = message;
    formControl.className = 'form-control error';
}

// Função para mostrar sucesso na validação
function successValidation(input) {
    const formControl = input.parentElement;
    const small = formControl.querySelector('small');
    formControl.className = 'form-control success';
    small.innerText = '';
}
