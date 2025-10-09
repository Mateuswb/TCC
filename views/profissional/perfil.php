<?php
    include '../../public/includes/profissional/sidebar.php';
    include '../../controllers/UsuarioController.php';
    
    session_start();
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
  <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        display: flex;
        background: #f5f8fa;
        height: 100vh;
    }

    /* Sidebar */
    .menu {
        flex: 1;
        padding: 10px 0;
    }

    .menu a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #333;
        text-decoration: none;
        font-size: 15px;
        transition: background 0.2s;
    }

    .menu a i {
        margin-right: 10px;
        color: #007B8F;
    }

    .menu a:hover,
    .menu a.active {
        background: #e6f7f9;
        color: #007B8F;
        border-left: 4px solid #007B8F;
    }

    /* Main content */
    .main {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .topbar {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        background: #fff;
        padding: 10px 20px;
        border-bottom: 1px solid #ddd;
    }

    .topbar i {
        margin-left: 20px;
        font-size: 18px;
        cursor: pointer;
    }

    /* Profile header */
    .profile-header {
        background: #007B8F;
        color: #fff;
        padding: 20px;
        border-radius: 8px;
        margin: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .profile-header .info {
        display: flex;
        align-items: center;
    }

    .profile-header .info i {
        font-size: 50px;
        margin-right: 15px;
    }

    .profile-header button {
        background: #0ca4b9;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
    }

    /* Tabs */
    .tabs {
        margin: 0 20px;
        background: #fff;
        border-radius: 8px;
        padding: 15px;
    }

    .tab-buttons {
        display: flex;
        border-bottom: 1px solid #ddd;
        margin-bottom: 15px;
    }

    .tab-buttons button {
        background: none;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        font-weight: 500;
        color: #555;
    }

    .tab-buttons button.active {
        border-bottom: 3px solid #007B8F;
        color: #007B8F;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Form sections */
    .section {
        margin-bottom: 20px;
    }

    .section h4 {
        color: #007B8F;
        margin-bottom: 10px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .info-grid div {
        display: flex;
        flex-direction: column;
    }

    .info-grid label {
        font-size: 13px;
        color: #666;
        margin-bottom: 4px;
    }

    .info-grid input,
    .info-grid select,
    .info-grid textarea {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #f9f9f9;
    }

    textarea {
        resize: none;
    }

    input[type="submit"] {
        background: #0ca4b9;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
    }

    input[type="submit"]:hover {
        background: #0991a0;
    }

  </style>
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
