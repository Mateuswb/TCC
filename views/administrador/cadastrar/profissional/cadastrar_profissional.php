<?php
require '../../../../autentica/verifica_login.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cadastro Profissional</title>

  <!-- Choices.js -->
  <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>

  <style>
  :root {
    --azul: #004aad;
    --azul-escuro: #003b88;
    --cinza: #cfcfcf;
  }

  * { box-sizing: border-box; }

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

  /* container principal */
  .container {
    width: 1100px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 40px rgba(5,20,40,0.12);
    display: flex;
    overflow: hidden;
  }

  /* Lateral azul */
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

  .lateral::after { display: none; }

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
    color: var(--azul);
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

  .contador {
    text-align: center;
    font-size: 20px;
    color: #6b6b6b;
    margin-top: 10px;
    width: 100%;
    display: block;
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

  /* inputs */
  input[type="text"],
  input[type="tel"],
  input[type="number"],
  input[type="date"],
  select {
    border: none;
    border-bottom: 3px solid #013F5C;
    padding: 12px 2px;
    font-size: 17px;
    outline: none;
    background: transparent;
    color: #222;
    transition: border-color .18s, box-shadow .18s, font-size .15s;
    font-family: "Poppins", sans-serif;
  }

  #observacoes {
     border: 3px solid #013F5C;
  padding: 10px;
  outline: none;
  resize: none; 
  border-radius: 10px;
  font-size: 17px;
  height: 90px;
  font-family: "Poppins", sans-serif;
  }

  /* Choices.js customizado */
  .choices__inner {
    background: transparent !important;
    border: none !important;
    border-bottom: 3px solid #013F5C !important;
    border-radius: 0 !important;
    padding: 12px 6px !important;
    font-size: 17px !important;
    color: #222 !important;
    font-family: "Poppins", sans-serif;
  }

  .choices__list--multiple .choices__item {
    background-color: var(--azul);
    border-radius: 8px;
    color: #fff;
    font-size: 14px;
    padding: 4px 10px;
    border: none;
  }

  .choices__input {
    background: transparent !important;
    font-size: 17px !important;
  }

  small {
    color: #e63946;
    margin-top: 6px;
    font-size: 15px;
    visibility: hidden;
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

  .step { display: none; }
  .step.active { display: block; }

  #inputEnviar {
    display: block;
    margin-left: auto;
    margin-top: 20px;
    margin-bottom: 15px;
  }
  .form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 18px 48px;
  align-items: start;
}

.form-control.full {
  grid-column: span 2;
}



  @media (max-width: 820px) {
    .container { flex-direction: column; width: 95%; }
    .lateral {
      flex-direction: row;
      width: 100%;
      height: 92px;
      justify-content: center;
      border-radius: 16px 16px 0 0;
    }
    .form { padding: 20px; }
    .form-grid { grid-template-columns: 1fr; gap: 14px 12px; }
    .botoes-back-next { flex-direction: column; align-items: stretch; }
    #inputEnviar { width: 100%; margin: 20px 0 0 0; }
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
  </style>
</head>

<body>
  <div class="container">
    <div class="lateral">
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
    // Choices.js
    document.addEventListener('DOMContentLoaded', () => {
      new Choices('#multiple', { removeItemButton: true, searchEnabled: true });
    });

    // Controle de etapas
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
