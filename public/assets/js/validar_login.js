const form = document.getElementById('form');
const cpf = document.getElementById('cpf');
const password = document.getElementById('password');

form.addEventListener('submit', (e) =>{
    e.preventDefault();
    checkInputs();
})

function fecharMensagemErro() {
    const msg = document.getElementById('error-message');
    if (msg) {
        msg.style.visibility = 'hidden';
        msg.style.marginTop = '-30px';
    }
}

function checkInputs() {
    const cpfValue = cpf.value.trim();
    const passwordValue = password.value.trim();

    let formValido = true;

    if (cpfValue === '') {
        errorValidation(cpf, 'Esse campo é obrigatório.');
        formValido = false;
    }else if (!validaCPF(cpfValue)){
        errorValidation(cpf, 'Cpf inválido.');
        formValido = false;
    }
    else{
        successValidation(cpf)
    }

    if (passwordValue === '') {
        errorValidation(password, 'Esse campo é obrigatório.');
        formValido = false;
    } else if (passwordValue.length < 8) {
        errorValidation(password, 'Senha incorreta.');
        formValido = false;
    } else {
        successValidation(password);
    }

    
    if(formValido){
        localStorage.setItem('usuario', cpf.value.trim());
        form.submit();
    }
}

function errorValidation(input, message) {
    const formControl = input.parentElement;
    const small = formControl.querySelector('small');
    small.innerText = message;
    formControl.className = 'form-control error';
}

function successValidation(input) {
    const formControl = input.parentElement;
    formControl.className = 'form-control success';
}


//validar cpf
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
