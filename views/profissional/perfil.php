<?php
    include '../../autentica/verifica_login.php';
    
    include '../../public/includes/profissional/sidebar.php';
    include '../../public/includes/profissional/header.php';
    include '../../public/includes/profissional/footer.html';
    include '../../controllers/UsuarioController.php';
    
    #modals
    include '../../public/modals/profissional/inativar_conta.html';
    include '../../public/modals/profissional/deletar_conta.html';

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

  <!-- IMPORT CHOICES.JS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
  <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

  
  <style>
    
  .choices__inner {
    border-radius: 5px !important;
    font-size: 17px !important;
    color: #222 !important;
    font-family: "Poppins", sans-serif;
  }
   .choices__list--multiple .choices__item {
    background-color: var(--azul);
    border-radius: 8px;
    color: black;
    font-size: 14px;
    padding: 4px 10px;
    border: none;
  }

  .choices__input {
    background: transparent !important;
    font-size: 17px !important;
  }
  
  .choices__input {
    display: none !important;
  }

     .botoes-acoes {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 20px 0;
}

.botoes-direita {
  display: flex;
  gap: 10px;
}

.botoes-acoes input[type="submit"],
.botoes-acoes button {
  padding: 10px 18px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  transition: background 0.3s ease;
}


.btn-salvar {
  background-color: #2ecc71;
  color: white;
}

.btn-salvar:hover {
  background-color: #27ae60;
}

.btn-inativar {
  background-color: #f1c40f;
  color: #fff;
}

.btn-inativar:hover {
  background-color: #d4ac0d;
}

.btn-deletar {
  background-color: #e74c3c;
  color: white;
}

.btn-deletar:hover {
  background-color: #c0392b;
}


  </style>
</head>
<body>
  <div class="main">
    <?php include '../../public/assets/alerta/flash.php'; ?>

    <div class="profile-header">
      <div class="info">
        <i class="fa fa-user-md"></i>
        <div>
          <h2><?php echo $profissional['nome']; ?></h2>
          <p>
            <?php 
                  $dados = json_decode($profissional['especialidade'], true);
                  if (is_array($dados)) {
                     $formatado = array_map(function($item) {
                        $item = preg_replace('/^exame_/', '', $item);
                        $item = str_replace('_', ' ', $item);

                        return ucwords(trim($item)); 
                    }, $dados);


                      echo implode(', ', $formatado);
                  } else {
                      echo "Não informado";
                  }
                ?>
          </p>
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

          <div class="full">
            <label>Especialidade</label>
            <select id="multiple" name="especialidades[]" multiple>
                <hr />
                <optgroup label="ESPECIALIDADES">
                    <option value="clinico_geral">Clínico Geral</option>
                    <option value="pediatria">Pediatria</option>
                    <option value="cardiologia">Cardiologia</option>
                    <option value="ortopedia">Ortopedia</option>
                    <option value="dermatologia">Dermatologia</option>
                    <option value="ginecologia">Ginecologia</option>
                    <option value="obstetricia">Obstetrícia</option>
                    <option value="endocrinologia">Endocrinologia</option>
                    <option value="neurologia">Neurologia</option>
                    <option value="oftalmologia">Oftalmologia</option>
                    <option value="otorrinolaringologia">Otorrinolaringologia</option>
                    <option value="psiquiatria">Psiquiatria</option>
                    <option value="urologia">Urologia</option>
                    <option value="psicologia_clinica">Psicologia Clínica</option>
                </optgroup>

                <hr />
                <optgroup label="Exames de sangue">
                    <option value="exame_hemograma">Hemograma</option>
                    <option value="exame_colesterol">Colesterol</option>
                    <option value="exame_glicemia">Glicemia</option>
                    <option value="exame_triglicerideos">Triglicerídeos</option>
                    <option value="exame_hemoglobina_glicada">Hemoglobina Glicada</option>
                </optgroup>

                <optgroup label="Exames de imagem">
                    <option value="exame_raio_x">Raio-X</option>
                    <option value="exame_ressonancia_magnetica">Ressonância Magnética</option>
                    <option value="exame_tomografia">Tomografia</option>
                    <option value="exame_ultrassonografia">Ultrassonografia</option>
                    <option value="exame_mamografia">Mamografia</option>
                    <option value="exame_densitometria_ossea">Densitometria Óssea</option>
                </optgroup>

                <optgroup label="Exames cardiológicos">
                    <option value="exame_eletrocardiograma">Eletrocardiograma</option>
                    <option value="exame_ecocardiograma">Ecocardiograma</option>
                    <option value="exame_teste_ergometrico">Teste Ergométrico</option>
                </optgroup>

                <optgroup label="Exames de urina">
                    <option value="exame_urocultura">Urocultura</option>
                    <option value="exame_exame_de_urina">Exame de Urina</option>
                </optgroup>

                <optgroup label="Exames hormonais">
                    <option value="exame_tsh">TSH</option>
                    <option value="exame_testosterona">Testosterona</option>
                    <option value="exame_estradiol">Estradiol</option>
                    <option value="exame_cortisol">Cortisol</option>
                    <option value="exame_progesterona">Progesterona</option>
                </optgroup>

                <optgroup label="Exames infecciosos">
                    <option value="exame_hiv">HIV</option>
                    <option value="exame_hepatite_b">Hepatite B</option>
                    <option value="exame_hepatite_c">Hepatite C</option>
                    <option value="exame_sifilis">Sífilis</option>
                </optgroup>

                <optgroup label="Exames respiratórios">
                    <option value="exame_espirometria">Espirometria</option>
                    <option value="exame_gasometria_arterial">Gasometria Arterial</option>
                </optgroup>
            </select>
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
        <input type="hidden" name="tipoUsuario" value="<?php echo $usuario['tipo_usuario']; ?>">
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
            <div class="botoes-acoes">

              <input type="submit" value="Salvar" class="btn-salvar">

            <div class="botoes-direita">

              <button type="button" class="btn-inativar"
                onclick="abrirModalInativar(this)" 
                data-id="<?php echo $profissional['id_profissional']; ?>" 
                data-cpf="<?php echo $usuario['login']; ?>">
                Inativar
              </button>

              <button type="button" class="btn-deletar"
                onclick="abrirModalExclusao(this)" 
                data-id="<?php echo $profissional['id_profissional']; ?>" 
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
  // Seleciona o select
  const select = document.getElementById('multiple');

  // Inicializa o Choices
  const choicesInstance = new Choices(select, {
    removeItemButton: true,
    searchEnabled: true,
    shouldSort: false,
    placeholderValue: 'Selecione as especialidades'
  });

  const dadosEspecialidades = <?php echo json_encode($profissional['especialidade']); ?>;

  let selecionadas = [];
  try {

    selecionadas = JSON.parse(dadosEspecialidades || '[]');
    if (!Array.isArray(selecionadas)) selecionadas = [];
  } catch (err) {
    console.error('JSON inválido em especialidades:', dadosEspecialidades, err);
    selecionadas = [];
  }

  function formatLabel(value) {
    let label = value.replace(/^exame_/, '').replace(/_/g, ' ');
    return label.charAt(0).toUpperCase() + label.slice(1);
  }

  selecionadas.forEach(value => {
    const strValue = String(value);

    const optionExists = Array.from(select.options).some(o => o.value === strValue);
    if (optionExists) {
      choicesInstance.setChoiceByValue(strValue);
    } else {
  
      const newOption = new Option(formatLabel(strValue), strValue, true, true);
      select.appendChild(newOption);
      choicesInstance.setChoiceByValue(strValue);
    }
  });

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
