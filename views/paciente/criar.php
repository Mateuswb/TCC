<?php
  session_start();

  if (isset($_SESSION['existeEmail'])) {
      echo "<p class='error'>" . $_SESSION['existeEmail'] . "</p>";
      unset($_SESSION['existeEmail']);
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cadastro Paciente</title>

<style>
  :root {
  --azul: #004aad;
  --azul-escuro: #003b88;
  --cinza: #cfcfcf;
}

* {
  box-sizing: border-box;
}

body {
  font-family: "Poppins", sans-serif;
  margin: 0;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: radial-gradient(1200px 400px at 10% 40%, rgba(0,74,173,0.25), transparent 20%),
              linear-gradient(90deg, #cfe7ff 0%, #eaf4ff 50%, #f8fbff 100%);
}


.container {
  width: 1100px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 8px 40px rgba(5,20,40,0.12);
  display: flex;
  overflow: hidden;
}


.lateral {
  width: 120px;
  background-color: #01538aff;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  padding: 24px 12px;
  gap: 28px;
  position: relative;
}


.lateral::after {
  display: none;
}

.etapa {
  width: 54px;
  height: 54px;
  border-radius: 50%;
  background: transparent;
  color: #fff;
  border: 2px solid rgba(255,255,255,0.9);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 25px;
  transition: all 0.3s ease;
}

.etapa.ativa {
  background: #fff;
  color: #004aad;
  border-color: #fff;
  transform: scale(1.1);
  box-shadow: 0 0 10px rgba(255,255,255,0.6);
}

.form {
  flex: 1;
  padding: 40px 56px;
  position: relative;
}

#title {
  text-align: center;
  font-size: 22px;
  font-weight: 700;
  margin: 6px 0 26px;
  color: #111;
}

.contador{
  margin: 0px;
}

.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 18px 48px;
  align-items: start;
}

.form-control {
  display: flex;
  flex-direction: column;
  position: relative;
  min-height: 56px;
}

label {
  font-size: 15px;
  color: #222;
  margin-bottom: 6px;
  font-weight: 600;
}


input[type="text"],
input[type="tel"],
input[type="number"],
input[type="date"],
select{
    border: none;
    border-bottom: 3px solid #013F5C;
    padding: 12px 6px;
    font-size: 17px;
    outline: none;
    background: transparent;
    color: #222;
    transition: border-color .18s, box-shadow .18s, font-size .15s;
    font-family: "Poppins", sans-serif;
}
#observacoes {
  border: 3px solid #013F5C;
  padding: 5px;
  outline: none;
  resize: none; 
  border-radius: 10px;
  font-size: 17px;
  font-family: "Poppins", sans-serif;
}


.form-control.error input,
.form-control.error select,
.form-control.error textarea {
    background: #fff;
    color: #222;
    border-bottom-color: #e63946;
    font-size: 17px; 
}


.form-control.error small {
    font-size: 16px;
}

textarea {
  resize: vertical;
  min-height: 86px;
  padding-top: 8px;
}


.img_success, .img_error{ 
  width: 18px; 
  height: 18px; 
  position: absolute; 
  right: 6px; top: 34px;
  display:none; 
}

small {
  color: #e63946;
  margin-top: 6px;
  font-size: 15px;
  visibility: hidden;
}

.form-control.error input,
.form-control.error select,
.form-control.error textarea {
  border-bottom-color: #e63946;
  font-size: 18px;
}

.form-control.error small {
  visibility: visible;
  font-size: 16px; 
  font-weight: 500;
}

.form-control.full {
  grid-column: 1 / -1;
}

.contador {
  text-align: center;
  font-size: 20px;
  color: #6b6b6b;
  margin-top: 10px;
  width: 100%;
  display: block;
}

.botoes-back-next {
  margin-top: 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 12px;
}

.botoes-back-next button,
input[type="submit"] {
  background: linear-gradient(180deg, var(--azul), var(--azul-escuro));
  color: #fff;
  border: none;
  padding: 10px 24px;
  border-radius: 10px;
  font-weight: 600;
  cursor: pointer;
  box-shadow: 0 6px 18px rgba(4,48,100,0.12);
}

.btn-voltar {
  background: transparent;
  color: var(--azul);
  border: 1px solid #d7dff2;
  padding: 8px 20px;
  border-radius: 8px;
  box-shadow: none;
}

.step {
  display: none;
}
.step.active {
  display: block;
}

#inputEnviar {
  display: block;
  margin-left: auto;
  margin-top: 20px;
}


@media (max-width: 820px) {
  .container {
    flex-direction: column;
    width: 95%;
  }
  .lateral {
    width: 100%;
    height: 92px;
    flex-direction: row;
    gap: 16px;
    border-radius: 16px 16px 0 0;
    justify-content: center;
  }
  .form {
    padding: 20px;
  }
  .form-grid {
    grid-template-columns: 1fr;
    gap: 14px 12px;
  }
  .botoes-back-next {
    flex-direction: column;
    align-items: stretch;
  }
  #inputEnviar {
    width: 100%;
    margin: 20px 0 0 0;
  }
}

#inputEnviar{
    margin-bottom: 15px;

}
</style>
</head>

<body>
  <div class="container">
    <div class="lateral">
      <div class="etapa ativa" id="etapa1">1</div>
      <div class="etapa" id="etapa2">2</div>
    </div>

    <form action="../../controllers/PacienteController.php?acao=cadastrarPaciente" method="POST" class="form" id="form">
      <h1 id="title">Complete seu cadastro</h1>

      <!-- Etapa 1 -->
      <div class="step active" id="step1">
        <div class="form-grid">
          <div class="form-control"> 
            <label for="nome">Nome Completo</label> 
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo"> 
            <img class="img_success" src="../assets/icones/check.png" alt="ok"> 
            <img class="img_error" src="../assets/icones/exclamation.png" alt="erro"> 
            <small>Msg de erro</small> 
          </div>

          <div class="form-control">
            <label for="dataNascimento">Data de Nascimento</label>
            <input type="date" id="dataNascimento" name="dataNascimento">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="telefone">Telefone</label>
            <input type="tel" id="telefone" name="telefone" placeholder="(99) 99999-9999">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="sexo">Sexo</label>
            <select name="sexo" id="sexo">
              <option value="">Selecione</option>
              <option value="M">Masculino</option>
              <option value="F">Feminino</option>
              <option value="O">Outro</option>
            </select>
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="estadoCivil">Estado Civil</label>
            <select name="estadoCivil" id="estadoCivil">
              <option value="">Selecione</option>
              <option value="C">Casado</option>
              <option value="S">Solteiro</option>
              <option value="V">Viúvo</option>
            </select>
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Digite seu Email">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="endereco">Endereço</label>
            <input type="text" id="endereco" name="endereco" placeholder="Endereço">
            <small>Msg de erro</small>
          </div>
        </div>

        <p class="contador">1/2</p>

        <div class="botoes-back-next">
          <div></div>
          <button type="button" id="btnProx1">Próximo</button>
        </div>
      </div>

      <!-- Etapa 2 -->
      <div class="step" id="step2">
        <div class="form-grid">
          <div class="form-control">
            <label for="numCasa">Número da casa</label>
            <input type="text" id="numCasa" name="numCasa" placeholder="Número da casa">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="bairro">Bairro</label>
            <input type="text" id="bairro" name="bairro" placeholder="Bairro">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" placeholder="Cidade">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="tipoSanguineo">Tipo de sangue</label>
            <select name="tipoSanguineo" id="tipoSanguineo">
              <option value="">Selecione</option>
              <option value="A+">A+</option>
              <option value="A-">A-</option>
              <option value="B+">B+</option>
              <option value="B-">B-</option>
              <option value="AB+">AB+</option>
              <option value="AB-">AB-</option>
              <option value="O+">O+</option>
              <option value="O-">O-</option>
            </select>
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="altura">Altura</label>
            <input type="number" id="altura" name="altura" step="0.01" min="0" max="3" placeholder="Altura">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="peso">Peso</label>
            <input type="number" id="peso" name="peso" step="0.01" min="0" max="500" placeholder="Peso">
            <small>Msg de erro</small>
          </div>

          <div class="form-control full">
            <label for="observacoes">Observações</label>
            <textarea id="observacoes" name="observacoes" placeholder="Escreva alguma observação..."></textarea>
            <small>Msg de erro</small>
          </div>
        </div>

        <p class="contador">2/2</p>
        <div class="botoes-back-next" style="margin-top:18px;">
          <button type="button" id="btnAnt2" class="btn-voltar">Anterior</button>
          <input type="submit" id="inputEnviar" value="Enviar">
        </div>
        
      </div>
    </form>
  </div>
<script src="../../public/assets/js/validar_paciente.js"></script>

<script>
    const step2 = document.getElementById("step2");
    const etapa1 = document.getElementById("etapa1");
    const etapa2 = document.getElementById("etapa2");
    const btnProx1 = document.getElementById("btnProx1");
    const btnAnt2 = document.getElementById("btnAnt2");

    btnProx1.addEventListener("click", () => {
        if (validaCamposEtapa1()) {
            step2.classList.add("active");
            etapa1.classList.remove("ativa");
            etapa2.classList.add("ativa");
        }
    });

    btnAnt2.addEventListener("click", () => {
        step2.classList.remove("active");
        step1.classList.add("active");
        etapa2.classList.remove("ativa");
        etapa1.classList.add("ativa");
    });

</script>

</body>
</html>
