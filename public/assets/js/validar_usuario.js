const form = document.getElementById("form");
const cpf = document.getElementById("cpf");
const password = document.getElementById("password");
const passwordConfirmation = document.getElementById("passwordConfirmation");

form.addEventListener("submit", (e) => {
  e.preventDefault();
  checkInputs();
});

function checkInputs() {
  const cpfValue = cpf.value.trim();
  const passwordValue = password.value.trim();
  const passwordConfirmationValue = passwordConfirmation.value.trim();

  let formValido = true;
  if (cpfValue === "") {
    errorValidation(cpf, "Preencha esse campo");
    formValido = false;
  } else if (!validaCPF(cpfValue)) {
    errorValidation(cpf, "Digite um cpf válido.");
    formValido = false;
  } else {
    successValidation(cpf);
  }

  if (passwordValue === "") {
    errorValidation(password, "Preencha esse campo");
    formValido = false;
  } else if (passwordValue.length < 8) {
    errorValidation(password, "A senha deve ter no mínimo 8 caracteres.");
    formValido = false;
  } else {
    successValidation(password);
  }

  if (passwordConfirmationValue === "") {
    errorValidation(passwordConfirmation, "Preencha esse campo");
    formValido = false;
  } else if (passwordValue !== passwordConfirmationValue) {
    errorValidation(passwordConfirmation, "As senhas não conferem.");
    formValido = false;
  } else {
    successValidation(passwordConfirmation);
  }
  
  if (formValido) {
    form.submit();
  }
}

// Função para mostrar erro na validação
function errorValidation(input, message) {
  const formControl = input.parentElement;
  const small = formControl.querySelector("small");
  small.innerText = message;
  formControl.className = "form-control error";
}

// Função para mostrar sucesso na validação
function successValidation(input) {
  const formControl = input.parentElement;
  formControl.className = "form-control success";
}

// Validação de CPF
function validaCPF(cpf) {
  cpf = String(cpf).replace(/[^\d]/g, "");

  if (
    cpf.length !== 11 ||
    [
      "00000000000",
      "11111111111",
      "22222222222",
      "33333333333",
      "44444444444",
      "55555555555",
      "66666666666",
      "77777777777",
      "88888888888",
      "99999999999",
    ].includes(cpf)
  ) {
    return false;
  }

  const calcularDigito = (fator) => {
    let soma = 0;
    for (let i = 0; i < fator - 1; i++) {
      soma += parseInt(cpf[i]) * (fator - i);
    }
    let resto = (soma * 10) % 11;
    return resto === 10 || resto === 11 ? 0 : resto;
  };

  if (calcularDigito(10) !== parseInt(cpf[9])) return false;
  if (calcularDigito(11) !== parseInt(cpf[10])) return false;

  return true;
}
