<?php
  require '../../autentica/verifica_login.php';
  include '../../public/includes/paciente/sidebar.php';
  include '../../public/includes/paciente/header.php';
  include '../../public/includes/paciente/footer.php';
  include '../../controllers/UsuarioController.php';
  
  require_once "../../controllers/PacienteController.php";
  require_once "../../public/modals/paciente/deletar_conta.php";
  require_once "../../public/modals/paciente/inativar_conta.html";

  $controllerPaciente = new PacienteController($conn);
  $paciente = $controllerPaciente->exibirDadosPaciente();

  $controllerUsuario = new UsuarioController($conn);
  $usuario = $controllerUsuario->exibirPerfil();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Perfil do Profissional</title>
  
  <!-- IMPORT DO CSS -->
  <link rel="stylesheet" href="../../public/assets/css/paciente/perfil.css">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
   rel="stylesheet">
</head>


<style>
.form-control {
  display: flex;
  flex-direction: column;
  margin-bottom: 18px;
  position: relative;
}

.form-control input,
.form-control select,
.form-control textarea {
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 15px;
  transition: 0.2s ease;
}

.form-control.success input,
.form-control.success select,
.form-control.success textarea {
  border-color: #0022b9ff;
}

.form-control.error input,
.form-control.error select,
.form-control.error textarea {
  border-color: #c42736ff;
}

.form-control small {
  display: none;
  color: #dc3545;
  position: absolute;
  bottom: -22px;
  left: 5px;
  font-size: 15px;
}

.form-control.error small {
  display: block;
}



</style>
<body>

  <div class="main">
    <?php  include '../../public/assets/alerta/flash.php' ?>


    <div class="profile-header">
      <div class="info">
        <i class="fa fa-user-md"></i>
        <div>
          <h2><?php echo $paciente['nome']; ?></h2>
        </div>
      </div>
    </div>

    <div class="tabs">
      <div class="tab-buttons">
        <button class="active" data-tab="dados-pessoais">Dados Pessoais</button>
        <button data-tab="dados-medicos">Dados médicos</button>
        <button data-tab="endereco">Endereço</button>
        <button data-tab="conta">Conta</button>
      </div>

      <form method="POST" action="../../controllers/PacienteController.php?acao=editarDadosPaciente" id="form">
      <input type="hidden" name="idPaciente" value="<?php echo $paciente['id_paciente']; ?>">

      <!-- DADOS PESSOAIS -->
      <div id="dados-pessoais" class="tab-content active">
        <div class="info-grid">
          <div class="form-control">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="<?php echo $paciente['email']; ?>">
            <small></small>
          </div>


          <div class="form-control">
            <label for="nome">Nome Completo</label>
            <input id="nome" type="text" name="nome" value="<?php echo $paciente['nome']; ?>">
            <small></small>
          </div>


          <div class="form-control">
            <label for="dataNascimento">Data de Nascimento</label>
            <input id="dataNascimento" type="date" name="dataNascimento" value="<?php echo $paciente['data_nascimento']; ?>">
            <small></small>
          </div>

          <div class="form-control">
            <label for="telefone">Telefone</label>
            <input id="telefone" type="text" name="telefone" value="<?php echo $paciente['telefone']; ?>">
            <small></small>
          </div>

          <div class="form-control">
            <label for="estadoCivil">Estado Civil</label>
            <select id="estadoCivil" name="estadoCivil">
              <option value="C" <?php if($paciente['estado_civil']=='C') echo 'selected'; ?>>Casado</option>
              <option value="S" <?php if($paciente['estado_civil']=='S') echo 'selected'; ?>>Solteiro</option>
              <option value="V" <?php if($paciente['estado_civil']=='V') echo 'selected'; ?>>Viúvo</option>
            </select>
            <small></small>
          </div>

          <div class="form-control">
            <label for="observacoes">Observações</label>
            <textarea id="observacoes" name="observacoes" rows="4">
              <?php echo $paciente['observacoes']; ?></textarea>
            <small></small>
          </div>
        </div>


        <div style="margin:20px 0;">
          <input type="submit" value="Salvar" class="btn-salvar">
        </div>
      </div>



        <!-- Dados Médicos -->
      <div id="dados-medicos" class="tab-content">
        <div class="info-grid">
          <div class="form-control">
            <label for="altura">Altura</label>
            <input id="altura" type="text" name="altura" value="<?php echo $paciente['altura']; ?>">
            <small></small>
          </div>


      <div class="form-control">
        <label for="sexo">Sexo</label>
        <select id="sexo" name="sexo">
          <option value="M" <?php if($paciente['sexo']=='M') echo 'selected'; ?>>Masculino</option>
          <option value="F" <?php if($paciente['sexo']=='F') echo 'selected'; ?>>Feminino</option>
          <option value="O" <?php if($paciente['sexo']=='O') echo 'selected'; ?>>Outro</option>
        </select>
        <small></small>
      </div>
      
      <div class="form-control">
        <label for="peso">Peso</label>
        <input id="tt" type="text" name="peso" value="<?php echo $paciente['peso']; ?>">
        <small></small>
      </div>

      <div class="form-control">
        <label for="tipoSanguineo">Tipo sanguíneo</label>
        <select id="tipoSanguineo" name="tipoSanguineo">
          <option value="A+" <?php if($paciente['tipo_sanguineo']=='A+') echo 'selected'; ?>>A+</option>
          <option value="A-" <?php if($paciente['tipo_sanguineo']=='A-') echo 'selected'; ?>>A-</option>
          <option value="B+" <?php if($paciente['tipo_sanguineo']=='B+') echo 'selected'; ?>>B+</option>
          <option value="B-" <?php if($paciente['tipo_sanguineo']=='B-') echo 'selected'; ?>>B-</option>
          <option value="AB+" <?php if($paciente['tipo_sanguineo']=='AB+') echo 'selected'; ?>>AB+</option>
          <option value="AB-" <?php if($paciente['tipo_sanguineo']=='AB-') echo 'selected'; ?>>AB-</option>
          <option value="O+" <?php if($paciente['tipo_sanguineo']=='O+') echo 'selected'; ?>>O+</option>
          <option value="O-" <?php if($paciente['tipo_sanguineo']=='O-') echo 'selected'; ?>>O-</option>
        </select>
        <small></small>
      </div>
    </div>

    <div style="margin:20px 0;" >
        <input type="submit" value="Salvar">
        <small></small>
      </div>
    </div>

    <!-- Endereço -->
    <div id="endereco" class="tab-content">
      <div class="info-grid">
        <div class="form-control">
          <label for="endereco">Endereço</label>
          <input id="endereco" type="text" name="endereco" value="<?php echo $paciente['endereco']; ?>">
          <small></small>
        </div>

        <div class="form-control">
          <label for="numCasa">Número</label>
          <input id="numCasa" type="text" name="numCasa" value="<?php echo $paciente['numero_casa']; ?>">
          <small></small>
        </div>

        <div class="form-control">
          <label for="bairro">Bairro</label>
          <input id="bairro" type="text" name="bairro" value="<?php echo $paciente['bairro']; ?>">
          <small></small>
        </div>

        <div class="form-control">
          <label for="cidade">Cidade</label>
          <input id="cidade" type="text" name="cidade" value="<?php echo $paciente['cidade']; ?>">
          <small></small>
        </div>
      </div>

    <div style="margin:20px 0;">
      <input type="submit" value="Salvar">
    </div>
  </div>

      </form>

      <!-- Conta -->
      <form action="../../controllers/UsuarioController.php?" method="POST">
        <input type="hidden" name="idUsuario" value="<?php echo $usuario['id_usuario']; ?>">
        <input type="hidden" name="tipoUsuario" value="<?php echo $usuario['tipo_usuario']; ?>">
        <input type="hidden" name="acao" value="editarUsuario">
        <div id="conta" class="tab-content">
          <h4>Conta do Usuário</h4>
          <div class="info-grid">
            <div><label>Login (CPF)</label><input type="text" name="cpf" value="<?php echo $usuario['login']; ?>"></div>
            <div><label>Senha</label><input type="password" name="password"></div>
          </div>
          <div class="botoes-acoes">
            <input type="submit" value="Salvar" class="btn-salvar">
            <div class="botoes-direita">

              <button type="button" class="btn-inativar"
                onclick="abrirModalInativar(this)" 
                data-id="<?php echo $paciente['id_paciente']; ?>" 
                data-cpf="<?php echo $usuario['login']; ?>">
                Inativar
              </button>

              <button type="button" class="btn-deletar"
                onclick="abrirModalExclusao(this)" 
                data-id="<?php echo $paciente['id_paciente']; ?>" 
                data-cpf="<?php echo $usuario['login']; ?>">
                Deletar Conta
              </button>

            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="../../public/assets/js/validar_perfil.js"></script>

  <script>
    const buttons = document.querySelectorAll(".tab-buttons button");
    const contents = document.querySelectorAll(".tab-content");
    buttons.forEach(btn => {
      btn.addEventListener("click", () => {
        buttons.forEach(b => b.classList.remove("active"));
        contents.forEach(c => c.classList.remove("active"));
        btn.classList.add("active");
        document.getElementById(btn.dataset.tab).classList.add("active");
      });
    });
  </script>
</body>
</html>
