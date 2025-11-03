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

      <form method="POST" action="../../controllers/PacienteController.php?acao=editarDadosPaciente">
        <input type="hidden" name="idPaciente" value="<?php echo $paciente['id_paciente']; ?>">

        <!-- Dados Pessoais -->
        <div id="dados-pessoais" class="tab-content active">
          <div class="info-grid">
            <div><label>Nome Completo</label><input type="text" name="nome" value="<?php echo $paciente['nome']; ?>"></div>
            <div><label>Email</label><input type="email" name="email" value="<?php echo $paciente['email']; ?>"></div>
            <div><label>Data de Nascimento</label><input type="date" name="dataNascimento" value="<?php echo $paciente['data_nascimento']; ?>"></div>
            <div><label>Telefone</label><input type="text" name="telefone" value="<?php echo $paciente['telefone']; ?>"></div>

            <div>
              <label>Estado Civil</label>
              <select name="estadoCivil">
                <option value="C" <?php if($paciente['estado_civil']=='C') echo 'selected'; ?>>Casado</option>
                <option value="S" <?php if($paciente['estado_civil']=='S') echo 'selected'; ?>>Solteiro</option>
                <option value="V" <?php if($paciente['estado_civil']=='V') echo 'selected'; ?>>Viúvo</option>
              </select>
            </div>

            <div>
              <label>Observações</label>
              <textarea name="observacoes" rows="5"><?php echo $paciente['observacoes']; ?></textarea>
            </div>
          </div>
          <div style="margin:20px 0;"><input type="submit" value="Salvar"></div>
        </div>

        <!-- Dados Médicos -->
        <div id="dados-medicos" class="tab-content">
          <div class="info-grid">
            <div>
              <label>Altura</label>
              <input type="text" name="altura" value="<?php echo $paciente['altura']; ?>">
            </div>

            <div>
              <label>Sexo</label>
              <select name="sexo">
                <option value="M" <?php if($paciente['sexo']=='M') echo 'selected'; ?>>Masculino</option>
                <option value="F" <?php if($paciente['sexo']=='F') echo 'selected'; ?>>Feminino</option>
                <option value="O" <?php if($paciente['sexo']=='O') echo 'selected'; ?>>Outro</option>
              </select>
            </div>
            
            <div>
              <label>peso</label>
              <input name="peso" value="<?php echo $paciente['peso']; ?>"></input>
            </div>

          <div>
            <label>Tipo sanguíneo</label>
            <select name="tipoSanguineo">
              <option value="A+" <?php if($paciente['tipo_sanguineo']=='A+') echo 'selected'; ?>>A+</option>
              <option value="A-" <?php if($paciente['tipo_sanguineo']=='A-') echo 'selected'; ?>>A-</option>
              <option value="B+" <?php if($paciente['tipo_sanguineo']=='B+') echo 'selected'; ?>>B+</option>
              <option value="B-" <?php if($paciente['tipo_sanguineo']=='B-') echo 'selected'; ?>>B-</option>
              <option value="AB+" <?php if($paciente['tipo_sanguineo']=='AB+') echo 'selected'; ?>>AB+</option>
              <option value="AB-" <?php if($paciente['tipo_sanguineo']=='AB-') echo 'selected'; ?>>AB-</option>
              <option value="O+" <?php if($paciente['tipo_sanguineo']=='O+') echo 'selected'; ?>>O+</option>
              <option value="O-" <?php if($paciente['tipo_sanguineo']=='O-') echo 'selected'; ?>>O-</option>
            </select>
          </div>

          </div>
          <div style="margin:20px 0;"><input type="submit" value="Salvar"></div>
        </div>

        <!-- Endereço -->
        <div id="endereco" class="tab-content">
          <div class="info-grid">
            <div><label>Endereço</label><input type="text" name="endereco" value="<?php echo $paciente['endereco']; ?>"></div>
            <div><label>Número</label><input type="text" name="numeroCasa" value="<?php echo $paciente['numero_casa']; ?>"></div>
            <div><label>Bairro</label><input type="text" name="bairro" value="<?php echo $paciente['bairro']; ?>"></div>
            <div><label>Cidade</label><input type="text" name="cidade" value="<?php echo $paciente['cidade']; ?>"></div>
          </div>
          <div style="margin:20px 0;"><input type="submit" value="Salvar"></div>
        </div>
      </form>

      <!-- Conta -->
      <form action="../../controllers/UsuarioController.php?" method="POST">
        <input type="hidden" name="idUsuario" value="<?php echo $usuario['id_usuario']; ?>">
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
