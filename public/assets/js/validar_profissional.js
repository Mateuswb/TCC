const form = document.getElementById('form');

const nome = document.getElementById('nome');
const rg = document.getElementById('rg');
const email = document.getElementById('email');
const crm = document.getElementById('crmCrp');
const dataNascimento = document.getElementById('dataNascimento');
const telefone = document.getElementById('telefone');
const sexo = document.getElementById('sexo');
const estadoCivil = document.getElementById('estadoCivil');
const especialidades = document.getElementById('multiple');

const endereco = document.getElementById('endereco');
const numCasa = document.getElementById('numCasa');
const bairro = document.getElementById('bairro');
const cidade = document.getElementById('cidade');
const observacoes = document.getElementById('observacoes');


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

// ========== VALIDAÇÕES ==========

function validaCamposEtapa1() {
    let valido = true;

    if (nome.value.trim() === '') {
        errorValidation(nome, 'Preencha o nome completo.');
        valido = false;
    } else if (!validateFullName(nome.value)) {
        errorValidation(nome, 'Digite seu nome completo (ex: João da Silva).');
        valido = false;
    } else {
        successValidation(nome);
    }

    if (rg.value.trim() === '') {
        errorValidation(rg, 'Preencha o RG.');
        valido = false;
    } else {
        successValidation(rg);
    }

    if (email.value.trim() === '') {
        errorValidation(email, 'Preencha o email.');
        valido = false;
    } else if (!validateEmail(email.value.trim())) {
        errorValidation(email, 'Digite um email válido.');
        valido = false;
    } else {
        successValidation(email);
    }

    if (crm.value.trim() === '') {
        errorValidation(crm, 'Preencha o CRM/CRP.');
        valido = false;
    } else {
        successValidation(crm);
    }

    if (dataNascimento.value.trim() === '') {
        errorValidation(dataNascimento, 'Informe sua data de nascimento.');
        valido = false;
    } else if (!validaIdade(dataNascimento.value.trim())) {
        errorValidation(dataNascimento, 'Profissional deve ter pelo menos 18 anos.');
        valido = false;
    } else {
        successValidation(dataNascimento);
    }

    if (telefone.value.trim() === '') {
        errorValidation(telefone, 'Preencha o telefone.');
        valido = false;
    } else if (!validaTelefone(telefone.value.trim())) {
        errorValidation(telefone, 'Formato inválido. Use (99) 99999-9999');
        valido = false;
    } else {
        successValidation(telefone);
    }

    if (sexo.value.trim() === '') {
        errorValidation(sexo, 'Preencha o sexo.');
        valido = false;
    } else {
        successValidation(sexo);
    } 

    if (estadoCivil.value.trim() === '') {
        errorValidation(estadoCivil, 'Selecione o estado civil.');
        valido = false;
    } else {
        successValidation(estadoCivil);
    }

    const escolhas = especialidades.selectedOptions;
    if (escolhas.length === 0) {
        errorValidation(especialidades, 'Selecione ao menos uma especialidade.');
        valido = false;
    } else {
        successValidation(especialidades);
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
        errorValidation(numCasa, 'Informe o número da casa.');
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

    // Observações é opcional
    if (observacoes.value.trim() !== '') {
        successValidation(observacoes);
    }

    return valido;
}


function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}


function validateFullName(nomeValue) {
  const re = /^[A-Za-zÀ-ÿ]+(?:\s+[A-Za-zÀ-ÿ]+)+$/;
  return re.test(nomeValue.trim());
}


function validaTelefone(telefone) {
  const numeros = telefone.replace(/\D/g, '');
  return numeros.length === 11;
}

function validaIdade(data) {
  const hoje = new Date();
  const nasc = new Date(data);
  let idade = hoje.getFullYear() - nasc.getFullYear();
  const m = hoje.getMonth() - nasc.getMonth();
  if (m < 0 || (m === 0 && hoje.getDate() < nasc.getDate())) idade--;
  return idade >= 18;
}


function errorValidation(input, message) {
    const formControl = input.closest('.form-control');
    const small = formControl.querySelector('small');
    small.innerText = message;
    small.style.visibility = 'visible';
    formControl.classList.add('error');
    formControl.classList.remove('success');
}

function successValidation(input) {
    const formControl = input.closest('.form-control');
    const small = formControl.querySelector('small');
    small.innerText = '';
    small.style.visibility = 'hidden';
    formControl.classList.add('success');
    formControl.classList.remove('error');
}
