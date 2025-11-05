const form = document.getElementById('form');

const nome = document.getElementById('nome');
const dataNascimento = document.getElementById('dataNascimento');
const telefone = document.getElementById('telefone');
const sexo = document.getElementById('sexo');
const estadoCivil = document.getElementById('estadoCivil');
const endereco = document.getElementById('endereco');
const numCasa = document.getElementById('numCasa');
const bairro = document.getElementById('bairro');
const cidade = document.getElementById('cidade');
const tipoSanguineo = document.getElementById('tipoSanguineo');
const altura = document.getElementById('altura');
const peso = document.getElementById('peso'); 


form.addEventListener('submit', function (e) {
  e.preventDefault();
  if (validaCampos()) {
    form.submit();
  }
});


function validaCampos() {
  let valido = true;

  const abaAtiva = document.querySelector('.tab-content.active');
  const campos = abaAtiva.querySelectorAll('input, select, textarea');

  campos.forEach((campo) => {
    const id = campo.id;
    const valor = campo.value.trim();

    switch (id) {
      case 'nome':
        if (valor === '') errorValidation(campo, 'Preencha o nome.');
        else if (!validateFullName(valor))
          errorValidation(campo, 'Nome inválido.');
        else successValidation(campo);
        break;

      case 'dataNascimento':
        if (valor === '') errorValidation(campo, 'Preencha a data de nascimento.');
        else successValidation(campo);
        break;

      case 'telefone':
        if (valor === '') errorValidation(campo, 'Preencha o telefone.');
        else if (!validaTelefone(valor))
          errorValidation(campo, 'Telefone inválido. Use (99) 99999-9999.');
        else successValidation(campo);
        break;

      case 'sexo':
        if (valor === '') errorValidation(campo, 'Selecione o sexo.');
        else successValidation(campo);
        break;

      case 'estadoCivil':
        if (valor === '') errorValidation(campo, 'Selecione o estado civil.');
        else successValidation(campo);
        break;

      case 'endereco':
        if (valor === '') errorValidation(campo, 'Preencha o endereço.');
        else successValidation(campo);
        break;

      case 'numCasa':
        if (valor === '') errorValidation(campo, 'Preencha o número da casa.');
        else successValidation(campo);
        break;

      case 'bairro':
        if (valor === '') errorValidation(campo, 'Preencha o bairro.');
        else successValidation(campo);
        break;

      case 'cidade':
        if (valor === '') errorValidation(campo, 'Preencha a cidade.');
        else successValidation(campo);
        break;

      case 'tipoSanguineo':
        if (valor === '') errorValidation(campo, 'Selecione o tipo sanguíneo.');
        else successValidation(campo);
        break;

      case 'altura':
        if (valor === '') errorValidation(campo, 'Preencha a altura.');
        else if (valor < 0 || valor > 3)
          errorValidation(campo, 'Altura inválida.');
        else successValidation(campo);
        break;

      case 'peso':
        if (valor === '') errorValidation(campo, 'Preencha o peso.');
        else if (valor < 0 || valor > 500)
          errorValidation(campo, 'Peso inválido.');
        else successValidation(campo);
        break;

      default:
        successValidation(campo);
        break;
    }
  });
  const erros = abaAtiva.querySelectorAll('.form-control.error');
  if (erros.length > 0) valido = false;

  return valido;
}


function validaTelefone(telefone) {
  const numeros = telefone.replace(/\D/g, '');
  return numeros.length === 11;
}

function errorValidation(input, message) {
  const formControl = input.parentElement;
  const small = formControl.querySelector('small');
  if (small) small.innerText = message;
  formControl.classList.remove('success');
  formControl.classList.add('error');
}

function successValidation(input) {
  const formControl = input.parentElement;
  const small = formControl.querySelector('small');
  if (small) small.innerText = '';
  formControl.classList.remove('error');
  formControl.classList.add('success');
}

function validateFullName(nomeValue) {
  const trimmed = nomeValue.trim();
  const regex = /^[A-Za-zÀ-ÿ]+(?:\s+[A-Za-zÀ-ÿ]+)+$/;
  return regex.test(trimmed);
}
