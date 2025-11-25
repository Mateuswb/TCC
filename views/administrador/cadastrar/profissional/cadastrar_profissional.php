<?php
require '../../../../autentica/verifica_login.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cadastro Profissional</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 

  <!-- Choices.js -->
  <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>

  <!-- IMPORT DO CSS -->
  <link rel="stylesheet" href="../../../../public/assets/css/administrador/cadastrar/cadastrar_profissional.css">
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

    <form action="../../../../controllers/AdministradorController.php?acao=cadastrarProfissional" method="post" class="form" id="form">
      <h1 id="title">Complete seu cadastro profissional</h1>

      <!-- ETAPA 1 -->
      <div class="step active" id="step1">
        <div class="form-grid">
          <div class="form-control">
            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo">
            <small>Msg de erro</small>
          </div>


          <div class="form-control">
            <label for="rg">RG</label>
            <input type="text" id="rg" name="rg" placeholder="Digite seu RG">
            <small>Msg de erro</small>
          </div>


          <div class="form-control">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Digite seu email">
            <small>Msg de erro</small>
          </div>


          <div class="form-control">
            <label for="crmCrp">CRM/CRP</label>
            <input type="text" id="crmCrp" name="crmCrp" placeholder="Digite seu CRM/CRP">
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

          <div class="form-control full">
            <label for="multiple">Especialidade</label>
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
          <small>Msg de erro</small>
        </div>
        </div>

        <p class="contador">1/2</p>
        <div class="botoes-back-next">
          <div></div>
          <button type="button" id="btnProx1">Próximo</button>
        </div>
      </div>

      <!-- ETAPA 2 -->
      <div class="step" id="step2">
        <div class="form-grid">
          <div class="form-control">
            <label for="endereco">Endereço</label>
            <input type="text" id="endereco" name="endereco" placeholder="Endereço">
            <small>Msg de erro</small>
          </div>


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

  <script src="../../../../public/assets/js/validar_profissional.js"></script>
  <script>

    document.addEventListener('DOMContentLoaded', () => {
      new Choices('#multiple', { removeItemButton: true, searchEnabled: true });
    });

    const step1 = document.getElementById("step1");
    const step2 = document.getElementById("step2");
    const etapa1 = document.getElementById("etapa1");
    const etapa2 = document.getElementById("etapa2");
    const btnProx1 = document.getElementById("btnProx1");
    const btnAnt2 = document.getElementById("btnAnt2");

    btnProx1.addEventListener("click", () => {
      if (validaCamposEtapa1()) {
        step1.classList.remove("active");
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
