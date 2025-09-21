const form = document.getElementById('form');
const username = document.getElementById('username');
const email = document.getElementById('email');
const cpf = document.getElementById('cpf');
const password = document.getElementById('password');
const passwordConfirmation = document.getElementById('passwordConfirmation');

form.addEventListener('submit', (e) => {
    e.preventDefault();
    checkInputs();
});

function checkInputs() {
    const usernameValue = username.value.trim();
    const emailValue = email.value.trim();
    const cpfValue = cpf.value.trim();
    const passwordValue = password.value.trim();
    const passwordConfirmationValue = passwordConfirmation.value.trim();


    const tipoUsuarioSelecionado = document.querySelector('input[name="tipo_usuario"]:checked');
    const tipoUsuarioContainer = document.querySelector(".tipo-usuario");

    let formValido = true;

    if (usernameValue === '') {
        errorValidation(username, 'Preencha esse campo');
        formValido = false;
    } else if (!validateFullName(username)) {
        errorValidation(username, 'Digite seu nome completo');
        formValido = false;
    } else {
        successValidation(username);
    }

    if (emailValue === '') {
        errorValidation(email, 'Preencha esse campo');
        formValido = false;
    } else if (!validaEmail(emailValue)) {
        errorValidation(email, 'Email inválido.');
        formValido = false;
    } else {
        successValidation(email);
    }

    if (cpfValue === '') {
        errorValidation(cpf, 'Preencha esse campo');
        formValido = false;
    } else if (!validaCPF(cpfValue)) {
        errorValidation(cpf, 'Digite um cpf válido.');
        formValido = false;
    } else {
        successValidation(cpf);
    }

    if (passwordValue === '') {
        errorValidation(password, 'Preencha esse campo');
        formValido = false;
    } else if (passwordValue.length < 8) {
        errorValidation(password, 'A senha deve ter no mínimo 8 caracteres.');
        formValido = false;
    } else {
        successValidation(password);
    }

    if (passwordConfirmationValue === '') {
        errorValidation(passwordConfirmation, 'Preencha esse campo');
        formValido = false;
    } else if (passwordValue !== passwordConfirmationValue) {
        errorValidation(passwordConfirmation, 'As senhas não conferem.');
        formValido = false;
    } else {
        successValidation(passwordConfirmation);
    }
   
    if (!tipoUsuarioSelecionado) {
    errorValidationRadio(tipoUsuarioContainer, 'Selecione um tipo de usuário.');
    formValido = false;
    } else {
        successValidationRadio(tipoUsuarioContainer);
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
    formControl.className = 'form-control success';
}


function errorValidationRadio(container, message) {
    container.classList.add('error');
    container.classList.remove('success');
    const small = container.querySelector('small');
    if (small) small.innerText = message;
}

function successValidationRadio(container, message) {
    container.classList.add('success');
    container.classList.remove('error');
    const small = container.querySelector('small');
    if (small) small.innerText = message;
}

// Validação de nome completo
function validateFullName(input) {
    const nameValue = input.value.trim();
    const nameRegex = /^[A-Za-zÀ-ÿ]+(?: [A-Za-zÀ-ÿ]+)+$/;
    return nameRegex.test(nameValue);
}

// Validação de CPF
function validaCPF(cpf) {
    var Soma = 0;
    var Resto;
    var strCPF = String(cpf).replace(/[^\d]/g, '');

    if (strCPF.length !== 11) return false;

    if (['00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888', '99999999999'].indexOf(strCPF) !== -1)
        return false;

    for (let i = 1; i <= 9; i++) {
        Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
    }

    Resto = (Soma * 10) % 11;

    if ((Resto === 10) || (Resto === 11)) Resto = 0;

    if (Resto !== parseInt(strCPF.substring(9, 10))) return false;

    Soma = 0;

    for (let i = 1; i <= 10; i++) {
        Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
    }

    Resto = (Soma * 10) % 11;

    if ((Resto === 10) || (Resto === 11)) Resto = 0;

    if (Resto !== parseInt(strCPF.substring(10, 11))) return false;

    return true;
}

// Validação de email
function validaEmail(email) {
    const caracteresInvalidos = /[^a-zA-Z0-9@._%+-]/;

    if (caracteresInvalidos.test(email)) return false;

    const formatoValido = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!formatoValido.test(email)) return false;

    const dominiosPermitidos = [
        'gmail.com',
        'hotmail.com',
        'outlook.com',
        'yahoo.com',
        'live.com',
        'icloud.com'
    ];

    const dominio = email.split('@')[1].toLowerCase();

    return dominiosPermitidos.includes(dominio);
}
