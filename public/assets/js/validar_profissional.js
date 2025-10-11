const form = document.getElementById('form');

const username = document.getElementById('nome');
const rg = document.getElementById('rg');
const crm = document.getElementById('crmCrp');

const dataNascimento = document.getElementById('dataNascimento');
const telefone = document.getElementById('telefone');
const sexo = document.getElementById('sexo');
const estadoCivil = document.getElementById('estadoCivil');

const endereco = document.getElementById('endereco');
const numCasa = document.getElementById('numCasa');
const bairro = document.getElementById('bairro');
const cidade = document.getElementById('cidade');


const steps = document.querySelectorAll('.step');
let etapaAtual = 0;

// Função para exibir etapa atual
function exibirEtapa() {
    steps.forEach((step, i) => step.classList.toggle('active', i === etapaAtual));
}
exibirEtapa();

// Próximo botão
document.getElementById('btnProx1').addEventListener('click', () => {
    if (validaCamposEtapa1()) {
        etapaAtual++;
        exibirEtapa();
    }
});

// Anterior botão
document.getElementById('btnAnt2').addEventListener('click', () => {
    etapaAtual--;
    exibirEtapa();
});

// Validação de envio do formulário
form.addEventListener('submit', function(e) {
    if (!validaCamposEtapa1() || !validaCamposEtapa2()) {
        e.preventDefault(); // bloqueia envio se algum campo estiver inválido
        alert('Preencha todos os campos corretamente.');
    }
});

// Funções de validação
function validaCamposEtapa1() {
    let valido = true;

    if (username.value.trim() === '') {
        errorValidation(username, 'Preencha o nome.');
        valido = false;
    } else if (!validateFullName(username.value)) {
        errorValidation(username, 'Nome inválido. Digite seu nome completo.');
        valido = false;
    } else {
        successValidation(username);
    }

    if (rg.value.trim() === '') {
        errorValidation(rg, 'Preencha o RG.');
        valido = false;
    } else {
        successValidation(rg);
    }

    if (crm.value.trim() === '') {
        errorValidation(crm, 'Preencha o CRM.');
        valido = false;
    } else {
        successValidation(crm);
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

    return valido;
}

function validaCamposEtapa2() {
    let valido = true;

    if (endereco.value.trim() === '') {
        errorValidation(endereco, 'Preencha o endereço.');
        valido = false;
    } else {
        successValidation(endereco);
    }

    if (numCasa.value.trim() === '') {
        errorValidation(numCasa, 'Preencha o número da casa.');
        valido = false;
    } else {
        successValidation(numCasa);
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

    return valido;
}

// Valida telefone
function validaTelefone(telefone) {
    const numeros = telefone.replace(/\D/g, '');
    return numeros.length === 11;
}

// Exibir erro
function errorValidation(input, message) {
    const formControl = input.parentElement;
    const small = formControl.querySelector('small');
    small.innerText = message;
    formControl.className = 'form-control error';
}

// Exibir sucesso
function successValidation(input) {
    const formControl = input.parentElement;
    formControl.className = 'form-control success';
}

// Valida nome completo
function validateFullName(usernameValue) {
    const trimmedName = usernameValue.trim();
    const nameRegex = /^[A-Za-zÀ-ÿ]+(?:\s+[A-Za-zÀ-ÿ]+)+$/;
    return nameRegex.test(trimmedName);
}
