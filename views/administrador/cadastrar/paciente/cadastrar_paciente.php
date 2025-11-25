   
<?php
  require '../../../../autentica/verifica_login.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cadastro Paciente</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 


  <!-- IMPORT DO CSS -->
  <link rel="stylesheet" href="../../../../public/assets/css/administrador/cadastrar/cadastrar_paciente.css">
  
</head>

<body>
  <div class="container">
    <div class="lateral">
      <a href="../cadastrar.php" class="btn-back">
        <i class="fas fa-arrow-left"></i> Voltar
      </a>
      <div class="etapa ativa" id="etapa1">1</div>
      <div class="etapa" id="etapa2">2</div>
    </div>

    <form action="../../../../controllers/PacienteController.php?acao=cadastrarPaciente" method="POST" class="form" id="form">
      <h1 id="title">Complete seu cadastro</h1>

      <!-- Etapa 1 -->
      <div class="step active" id="step1">
        <div class="form-grid">
          <!-- Nome --> 
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
<script src="../../../../public/assets/js/validar_paciente.js"></script>

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
