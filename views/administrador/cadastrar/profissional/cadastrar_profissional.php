<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Paciente- EM AMDAMENTO</title>

    <!-- Import do CSS -->
    <link rel="stylesheet" href="../../../../public/assets/css/administrador/cadastrar/cadastrar_profissional.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

</head>


<body>

    <div class="container">
        <form action="../../../../controllers/AdministradorController.php?acao=cadastrarProfissional" method="post" class="form" id="form">
            <h1 id="title">Completar Cadastro</h1>
            <div class="step active" id="step">
                <div class="form-grid">

                    <!-- Linha 1 -->
                    <div class="form-control">
                        <label for="nome">Nome Completo</label>
                        <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo">
                        <img class="img_success" src="../../assets/icones/check.png" alt="">
                        <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                        <small>Msg de erro</small>
                    </div>

                    <div class="form-control">
                        <label for="rg">RG</label>
                        <input type="text" id="rg" name="rg">
                        <img class="img_success" src="../../assets/icones/check.png" alt="">
                        <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                        <small>Msg de erro</small>
                    </div>

                    <div class="form-control">
                        <label for="email">email</label>
                        <input type="text" id="email" name="email">
                        <img class="img_success" src="../../assets/icones/check.png" alt="">
                        <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                        <small>Msg de erro</small>
                    </div>

                    <!-- Linha 2 -->
                    <div class="form-control">
                        <label for="crmCrp">CRM</label>
                        <input type="text" id="crmCrp" name="crmCrp">
                        <img class="img_success" src="../../assets/icones/check.png" alt="">
                        <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                        <small>Msg de erro</small>
                    </div>

                    
                    <!-- Linha 3 -->
                    <div class="form-control">
                        <label for="dataNascimento">Data de Nascimento</label>
                        <input type="date" id="dataNascimento" name="dataNascimento">
                        <img class="img_success" src="../../assets/icones/check.png" alt="">
                        <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                        <small>Msg de erro</small>
                    </div>
                    
                    <div class="form-control">
                        <label for="telefone">Telefone</label>
                        <input type="tel" id="telefone" name="telefone" placeholder="(99) 99999-9999">
                        <img class="img_success" src="../../assets/icones/check.png" alt="">
                        <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                        <small>Msg de erro</small>
                    </div>
                    
                    <!-- Linha 4 -->
                    <div class="form-control">
                        <label for="sexo">Sexo</label>
                        <select name="sexo" id="sexo">
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                            <option value="O">Outro</option>
                        </select>
                        <small>Msg de erro</small>
                    </div>
                    
                    <div class="form-contro">
                        <label for="especialidade">Especialidade</label>
                            <select id="multiple" name="especialidades[]" multiple>
                                <hr />
                                <optgroup label="ESPECIALIDADES">
                                    <option value="clinico_geral">Clínico Geral</option>
                                    <option value="pediatria">Pediatria</option>
                                    <option value="cardiologia">Cardiologia</option>
                                    <option value="crtopedia">Ortopedia</option>
                                </optgroup>
                                <hr />
                                <optgroup label="EXAMES">
                                    <option value="exame_radiologia">Radiologia</option>
                                    <option value="exame_neurofisiologia">Neurofisiologia</option>
                                    <option value="exame_patologista">Patologista</option>
                                    <option value="exame_medicina_laboratorial">Medicina Laboratorial</option>

                                </optgroup>

                            </select>
                        <small>Msg de erro</small>
                    </div>
                    
                    <div class="form-control">
                        <label for="estadoCivil">Estado Civil</label>
                        <select name="estadoCivil" id="estadoCivil">
                            <option value="C">Casado</option>
                            <option value="S">Solteiro</option>
                            <option value="V">Viúvo</option>
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

            <!-- etapa 2 -->
            <div class="step" id="step2">
                <div class="form-grid">

                    <!-- Linha 1 -->
                    <div class="form-control">
                        <label for="endereco">Endereço</label>
                        <input type="text" id="endereco" name="endereco" placeholder="Endereço">
                        <img class="img_success" src="../../assets/icones/check.png" alt="">
                        <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                        <small>Msg de erro</small>
                    </div>
                    
                    <div class="form-control">
                        <label for="numCasa">Número da casa</label>
                        <input type="text" id="numCasa" name="numCasa" placeholder="Número da casa">
                        <img class="img_success" src="../../assets/icones/check.png" alt="">
                        <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                        <small>Msg de erro</small>
                    </div>
                    
                    <!-- Linha 2 -->
                    <div class="form-control">
                        <label for="bairro">Bairro</label>
                        <input type="text" id="bairro" name="bairro" placeholder="Bairro">
                        <img class="img_success" src="../../assets/icones/check.png" alt="">
                        <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                        <small>Msg de erro</small>
                    </div>

                    <div class="form-control">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="cidade" name="cidade" placeholder="Cidade">
                        <img class="img_success" src="../../assets/icones/check.png" alt="">
                        <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                        <small>Msg de erro</small>
                    </div>
                    

                    <!-- Linha 4 full -->
                    <div class="form-control" style="grid-column: span 2;">
                        <label for="observacoes">Observações</label>
                        <textarea id="observacoes" id="observacoes" name="observacoes"  placeholder="Escreva alguma observação..."></textarea>
                        <img class="img_success" src="../../assets/icones/check.png" alt="">
                        <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                        <small>Msg de erro</small>
                    </div>
                    
                    <div class="botoes-back-next">
                        <button type="button" id="btnAnt2">Anterior</button>
                        <p class="contador" style="grid-column: span 0;">2/2</p>
                    </div>

                    <input type="submit" id="input_enviar" value="Enviar">
                </div>
            </div>
        </form>
    </div>

    <script src="../../../../public/assets/js/validar_profissional.js"></script>
    <script>
  document.addEventListener('DOMContentLoaded', function() {
    const frutasSelect = document.getElementById('multiple');
    const choices = new Choices(frutasSelect, {
      removeItemButton: true, // mostra botão de remover cada item selecionado
      searchEnabled: true     // habilita busca dentro da lista
    });
  });
</script>

</body>
</html>