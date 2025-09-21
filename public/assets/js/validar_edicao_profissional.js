
const form = document.getElementById('form2');

const username = document.getElementById('username');
const rg = document.getElementById('rg');
const crm = document.getElementById('crm');
const especialidade = document.getElementById('especialidade');
const dataNascimento = document.getElementById('data_nascimento');
const telefone = document.getElementById('telefone');
const sexo = document.getElementById('sexo');
const estadoCivil = document.getElementById('estado_civil');

const endereco = document.getElementById('endereco');
const numCasa = document.getElementById('num_casa');
const bairro = document.getElementById('bairro');
const cidade = document.getElementById('cidade');
const naturalidade = document.getElementById('naturalidade');

form.addEventListener('submit', (e) => {
    e.preventDefault();
    validaCampos();
});


function validaCampos(){
    let valido = true;

    if (username.value.trim() === '') {
        errorValidation(username, 'Preencha o nome.');
        valido = false;
    }else if (!validateFullName(username.value)) {
        errorValidation(username, 'Nome inválido. Digite seu nome completo.');
        valido = false;
    }else{
        successValidation(username);
    }

    if (rg.value.trim() === '') {
        errorValidation(rg, 'Preencha o RG.');
        valido = false;
    }else {
        successValidation(rg);
    }

    if (crm.value.trim() === '') {
        errorValidation(crm, 'Preencha o CRM.');
        valido = false;
    } 
    else {
        successValidation(crm);
    }

    if (especialidade.value.trim() === '') {
        errorValidation(especialidade, 'Preencha sua especialidade.');
        valido = false;
    } 
    else {
        successValidation(especialidade);
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

    if (sexo.value === '') {
        errorValidation(sexo, 'Selecione o sexo.');a
        valido = false;
    } else {
        successValidation(sexo);
    }

    if (estadoCivil.value === '') {
        errorValidation(estadoCivil, 'Selecione o estado civil.');
        valido = false;
    } else {
        successValidation(estadoCivil);
    }

    
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

    if (naturalidade.value.trim() === '') {
        errorValidation(naturalidade, 'Preencha sua aturalidade.');
        valido = false;
    } else {
        successValidation(naturalidade);
    }

    if (valido) {
        form.submit();
    }
}


function validaTelefone(telefone) {
    const numeros = telefone.replace(/\D/g, '');
    return numeros.length === 11;
}

// Validação de nome completo
function validateFullName(usernameValue) {
    const trimmedName = usernameValue.trim();
    const nameRegex = /^[A-Za-zÀ-ÿ]+(?:\s+[A-Za-zÀ-ÿ]+)+$/;
    return nameRegex.test(trimmedName);
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
