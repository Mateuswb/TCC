<?php
    include '../../autentica/verifica_login.php';
    
    include '../../public/includes/profissional/sidebar.php';
    include '../../controllers/UsuarioController.php';
    
    $id_profissional = $_SESSION['idProfissional'];

    require_once "../../controllers/ProfissionalController.php";
    $controllerProfissional = new ProfissionalController($conn);
    $profissional = $controllerProfissional->listarDadosProfissional($id_profissional);

    $controllerUsuario = new UsuarioController($conn);
    $usuario = $controllerUsuario->exibirPerfil();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Perfil do Profissional</title>

  <!-- IMPORT DO CSS -->
  <link rel="stylesheet" href="../../public/assets/css/profissional/perfil.css">
  
</head>
<body>

  <div class="main">
    <div class="topbar">
      <i class="fa fa-bell"></i>
      <i class="fa fa-cog"></i>
      <i class="fa fa-user-circle"></i>
    </div>

    <div class="profile-header">
      <div class="info">
        <i class="fa fa-user-md"></i>
        <div>
          <h2><?php echo $profissional['nome']; ?></h2>
          <p><?php echo $profissional['especialidade']; ?></p>
        </div>
      </div>
    </div>

    <div class="tabs">
      <div class="tab-buttons">
        <button class="active" data-tab="dados-pessoais">Dados Pessoais</button>
        <button data-tab="dados-profissionais">Dados Profissionais</button>
        <button data-tab="endereco">Endereço</button>
        <button data-tab="conta">Conta</button>
      </div>

      <!-- Formulário de Dados do Profissional -->
      <form method="POST" action="../../controllers/ProfissionalController.php?acao=editarDadosProfissional">
        <input type="hidden" name="idProfissional" value="<?php echo $profissional['id_profissional']; ?>">

        <!-- Dados Pessoais -->
        <div id="dados-pessoais" class="tab-content active">
          <div class="info-grid">
            <div>
              <label>Nome Completo</label>
              <input type="text" name="nome" value="<?php echo $profissional['nome']; ?>">
            </div>
            <div>
              <label>RG</label>
              <input type="text" name="rg" value="<?php echo $profissional['rg']; ?>">
            </div>
            <div>
              <label>Email</label>
              <input type="email" name="email" value="<?php echo $profissional['email']; ?>">
            </div>
            <div>
              <label>Data de Nascimento</label>
              <input type="date" name="dataNascimento" value="<?php echo $profissional['data_nascimento']; ?>">
            </div>
            <div>
              <label>Telefone</label>
              <input type="text" name="telefone" value="<?php echo $profissional['telefone']; ?>">
            </div>
            <div>
              <label>Sexo</label>
              <select name="sexo">
                <option value="M" <?php if($profissional['sexo']=='M') echo 'selected'; ?>>Masculino</option>
                <option value="F" <?php if($profissional['sexo']=='F') echo 'selected'; ?>>Feminino</option>
                <option value="O" <?php if($profissional['sexo']=='O') echo 'selected'; ?>>Outro</option>
              </select>
            </div>
            <div>
              <label>Estado Civil</label>
              <select name="estadoCivil">
                <option value="C" <?php if($profissional['estado_civil']=='C') echo 'selected'; ?>>Casado</option>
                <option value="S" <?php if($profissional['estado_civil']=='S') echo 'selected'; ?>>Solteiro</option>
                <option value="V" <?php if($profissional['estado_civil']=='V') echo 'selected'; ?>>Viúvo</option>
              </select>
            </div>
            <div>
              <label>Observações</label>
              <textarea name="observacoes" rows="5"><?php echo $profissional['observacoes']; ?></textarea>
            </div>
          </div>

          <div style="margin:20px 0;">
            <input type="submit" value="Salvar">
          </div>
        </div>

        <!-- Dados Profissionais -->
        <div id="dados-profissionais" class="tab-content">
          <div class="info-grid">
            <div>
              <label>CRM / CRP</label>
              <input type="text" name="crmCrp" value="<?php echo $profissional['crm_crp']; ?>">
            </div>
            <div>
              <label>Especialidade</label>
              <input type="text" name="especialidade" value="<?php echo $profissional['especialidade']; ?>">
            </div>
          </div>

          <div style="margin:20px 0;">
            <input type="submit" value="Salvar">
          </div>
        </div>

        <!-- Endereço -->
        <div id="endereco" class="tab-content">
          <div class="info-grid">
            <div>
              <label>Endereço</label>
              <input type="text" name="endereco" value="<?php echo $profissional['endereco']; ?>">
            </div>
            <div>
              <label>Número</label>
              <input type="text" name="numeroCasa" value="<?php echo $profissional['numero_casa']; ?>">
            </div>
            <div>
              <label>Bairro</label>
              <input type="text" name="bairro" value="<?php echo $profissional['bairro']; ?>">
            </div>
            <div>
              <label>Cidade</label>
              <input type="text" name="cidade" value="<?php echo $profissional['cidade']; ?>">
            </div>
          </div>

          <div style="margin:20px 0;">
            <input type="submit" value="Salvar">
          </div>
        </div>
      </form>

      <!-- Formulário de Conta -->
      <form action="../../controllers/UsuarioController.php?" method="POST">
        <input type="hidden" name="idUsuario" value="<?php echo $usuario['id_usuario']; ?>">
        <input type="hidden" name="acao" value="editarUsuario">

            <div id="conta" class="tab-content">
            <h4>Conta do Usuário</h4>
            <div class="info-grid">
                <div>
                    <label>Login (CPF)</label>
                    <input type="text" name="cpf" value="<?php echo $usuario['login']; ?>">
                </div>
                <div>
                    <label>Senha</label>
                    <input type="password" name="password">
                </div>
            </div>

            <div style="margin:20px 0;">
                <input type="submit" value="Salvar">
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
