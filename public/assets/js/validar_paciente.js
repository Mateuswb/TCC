const form = document.getElementById('form');

const username = document.getElementById('nome');
const dataNascimento = document.getElementById('dataNascimento');
const telefone = document.getElementById('telefone');
const sexo = document.getElementById('sexo');
const estadoCivil = document.getElementById('estadoCivil');
const email = document.getElementById('email');

const numCasa = document.getElementById('numCasa');
const endereco = document.getElementById('endereco');
const bairro = document.getElementById('bairro');
const cidade = document.getElementById('cidade');
const tipoSanguineo = document.getElementById('tipoSanguineo');
const altura = document.getElementById('altura');
const peso = document.getElementById('peso');


const steps = document.querySelectorAll('.step');
let etapaAtual = 0;

function exibirEtapa() {
    steps.forEach((step, i) => step.classList.toggle('active', i === etapaAtual));
}

// Prox
document.getElementById('btnProx1').addEventListener('click', () => {
    if (validaCamposEtapa1()) {
        etapaAtual++;
        exibirEtapa();
    }
});

// Ant
document.getElementById('btnAnt2').addEventListener('click', () => {
    etapaAtual--;
    exibirEtapa();
});

form.addEventListener('submit', function(e) {
    e.preventDefault();
    if (validaCamposEtapa2()) {
        form.submit();
    }
});


function validaCamposEtapa1() {
    let valido = true;

    if (username.value.trim() === '') {
        errorValidation(username, 'Preencha o nome.');
        valido = false;
    } else if (!validateFullName(username.value)) {
        errorValidation(username, 'Nome inválido. Digite seu nome completo.');
        valido = false;
    }
    else {
        successValidation(username);
    }

    if (dataNascimento.value.trim() === '') {
        errorValidation(dataNascimento, 'Preencha a data de nascimento.');
        valido = false;
    } else {
        successValidation(dataNascimento);
    }

    if (telefone.value.trim() === '') {
        errorValidation(telefone, 'Preencha o telefone.');
        valido = false;
    } else if (!validaTelefone(telefone.value.trim())) {
        errorValidation(telefone, 'Telefone inválido. Formato (99) 99999-9999');
        valido = false;
    } else {
        successValidation(telefone);
    }

    if (email.value.trim() === '') {
        errorValidation(email, 'Preencha o email.');
        valido = false;
    } else {
        successValidation(email);
    }

    return valido;
}

function validaCamposEtapa2() {
    let valido = true;

    if (numCasa.value.trim() === '') {
        errorValidation(numCasa, 'Preencha o número da casa.');
        valido = false;
    } else {
        successValidation(numCasa);
    }

    if (endereco.value.trim() === '') {
        errorValidation(endereco, 'Preencha o endereco');
        valido = false;
    } else {
        successValidation(endereco);
    }

    if (bairro.value.trim() === '') {
        errorValidation(bairro, 'Preencha o bairro.');
        valido = false;
    } else {
        successValidation(bairro);
    }

    if (cidade.value.trim() === '') {
        errorValidation(cidade, 'Preencha a cidade.');
        valido = false;
    } else {
        successValidation(cidade);
    }

    if (tipoSanguineo.value === '') {
        errorValidation(tipoSanguineo, 'Selecione o tipo sanguíneo.');
        valido = false;
    } else {
        successValidation(tipoSanguineo);
    }

    if (altura.value === '') {
        errorValidation(altura, 'Preencha a altura.');
        valido = false;
    } else if (altura.value < 0 || altura.value > 3) {
        errorValidation(altura, 'Altura inválida.');
        valido = false;
    } else {
        successValidation(altura);
    }

    if (peso.value === '') {
        errorValidation(peso, 'Preencha o peso.');
        valido = false;
    } else if (peso.value < 0 || peso.value > 500) {
        errorValidation(peso, 'Peso inválido.');
        valido = false;
    } else {
        successValidation(peso);
    }

    return valido;
}


function validaTelefone(telefone) {
    const numeros = telefone.replace(/\D/g, '');
    return numeros.length === 11;
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

// Validação de nome completo
function validateFullName(usernameValue) {
    const trimmedName = usernameValue.trim();
    const nameRegex = /^[A-Za-zÀ-ÿ]+(?:\s+[A-Za-zÀ-ÿ]+)+$/;
    return nameRegex.test(trimmedName);
}
