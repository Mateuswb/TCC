<?php
    require_once "../../../controllers/AdministradorController.php";

    $controller = new AdministradorController($conn);
    $paciente = $controller->listarDadosPaciente();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editra perfil</title>

    <!-- Import do CSS -->
    <link rel="stylesheet" href="../../../public/assets/css/style_editar_conta.css">

    <!-- Import dos Icones-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Import do Alerta -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../../public/assets/alertas/alerta_padrao_pos.js"></script>
</head>
<body>

  <div class="container">
        <a href="listar_pacientes.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>



        <form action="../../../controllers/AdministradorController.php?acao=editarDadosPaciente" method="post" id="form2" class="form2">
          <input type="hidden" name="idPaciente" value="<?php echo $paciente['id_paciente']; ?>">

          <div class="form-control">
            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" value="<?php echo $paciente['nome']; ?>">
            <img class="img_success" src="../../assets/icones/check.png" alt="">
            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Digite seu nome email" value="<?php echo $paciente['email']; ?>">
            <img class="img_success" src="../../assets/icones/check.png" alt="">
            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="dataNascimento">Data de Nascimento</label>
            <input type="date" id="dataNascimento" name="dataNascimento" value="<?php echo $paciente['data_nascimento']; ?>">
            <img class="img_success" src="../../assets/icones/check.png" alt="">
            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="telefone">Telefone</label>
            <input type="tel" id="telefone" name="telefone" placeholder="(99) 99999-9999" value="<?php echo $paciente['telefone']; ?>">
            <img class="img_success" src="../../assets/icones/check.png" alt="">
            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="sexo">Sexo</label>
            <select name="sexo" id="sexo">
              <option value="M" <?php if($paciente['sexo'] == 'M') echo 'selected'; ?> >Masculino</option>
              <option value="F" <?php if($paciente['sexo'] == 'F') echo 'selected'; ?> >Feminino</option>
              <option value="O" <?php if($paciente['sexo'] == 'O') echo 'selected'; ?> >Outro</option>
            </select>
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="estadoCivil">Estado Civil</label>
            <select name="estadoCivil" id="estadoCivil">
              <option value="C"  <?php if($paciente['estado_civil'] == 'C') echo 'selected'; ?>>Casado</option>
              <option value="S" <?php if($paciente['estado_civil'] == 'S') echo 'selected'; ?> >Solteiro</option>
              <option value="V" <?php if($paciente['estado_civil'] == 'V') echo 'selected'; ?> >Viúvo</option>
            </select>
            <small>Msg de erro</small>
          </div>


          <div class="form-control">
            <label for="numCasa">Número da casa</label>
            <input type="text" id="numCasa" name="numCasa" placeholder="Número" value="<?php echo $paciente['numero_casa']; ?>">
            <img class="img_success" src="../../assets/icones/check.png" alt="">
            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="endereco">Endereço</label>
            <input type="text" id="endereco" name="endereco" placeholder="endereco" value="<?php echo $paciente['endereco']; ?>">
            <img class="img_success" src="../../assets/icones/check.png" alt="">
            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="bairro">Bairro</label>
            <input type="text" id="bairro" name="bairro" placeholder="Bairro" value="<?php echo $paciente['bairro']; ?>">
            <img class="img_success" src="../../assets/icones/check.png" alt="">
            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" placeholder="Cidade" value="<?php echo $paciente['cidade']; ?>">
            <img class="img_success" src="../../assets/icones/check.png" alt="">
            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="tipoSanguineo">Tipo sanguíneo</label>
            <select name="tipoSanguineo" id="tipoSanguineo">
              <option value="A+" <?php if($paciente['tipo_sanguineo'] == 'A+') echo 'selected'; ?> >A+</option>
              <option value="A-" <?php if($paciente['tipo_sanguineo'] == 'A-') echo 'selected'; ?> >A-</option>
              <option value="B+" <?php if($paciente['tipo_sanguineo'] == 'B+') echo 'selected'; ?> >B+</option>
              <option value="B-" <?php if($paciente['tipo_sanguineo'] == 'B-') echo 'selected'; ?> >B-</option>
              <option value="AB+" <?php if($paciente['tipo_sanguineo'] == 'AB+') echo 'selected'; ?> >AB+</option>
              <option value="AB-" <?php if($paciente['tipo_sanguineo'] == 'AB-') echo 'selected'; ?> >AB-</option>
              <option value="0+" <?php if($paciente['tipo_sanguineo'] == '0+') echo 'selected'; ?> >O+</option>
              <option value="0-" <?php if($paciente['tipo_sanguineo'] == '0-') echo 'selected'; ?> >O-</option>
            </select>
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="altura">Altura (m)</label>
            <input type="number" id="altura" name="altura" step="0.01" min="0" max="3" placeholder="Ex: 1.75" value="<?php echo $paciente['altura']; ?>">
            <img class="img_success" src="../../assets/icones/check.png" alt="">
            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
            <small>Msg de erro</small>
          </div>

          <div class="form-control">
            <label for="peso">Peso (kg)</label>
            <input type="number" id="peso" name="peso" step="0.01" min="0" max="500" placeholder="Ex: 70.5" value="<?php echo $paciente['peso']; ?>">
            <img class="img_success" src="../../assets/icones/check.png" alt="">
            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
            <small>Msg de erro</small>
          </div>

          <div class="form-control form-full">
            <label for="observacoes">Observações</label>
            <textarea id="observacoes" name="observacoes" placeholder="Escreva alguma observação..." rows="4" value=""><?php echo $paciente['observacoes']; ?></textarea>
            <img class="img_success" src="../../assets/icones/check.png" alt="">
            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
            <small>Msg de erro</small>
          </div>

          <input type="submit" value="Salvar" class="btn-salvar">
        </form>
  </div>

  <script type="module" src="../../assets/js/validar_edicao_paciente.js"></script>

  <?php
  if (isset($_GET['alerta'])) {
      if ($_GET['alerta'] == 0) {
          $tipo = 'sucesso';
          $titulo = 'Atualizado';
          $mensagem = 'Dados atualizados com sucesso.';
      } 
      elseif($_GET['alerta'] == 1) {
          $tipo = 'delete';
          $titulo = 'Erro';
          $mensagem = 'Erro ao editar dados. Tente novamente';
      }
      echo "<script>
          window.addEventListener('DOMContentLoaded', () => {
              alertaPadraoPos('$tipo', '$titulo', '$mensagem');
          });
      </script>";
  }?>
</body>
</html>