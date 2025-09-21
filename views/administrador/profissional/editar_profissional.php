<?php
    require_once "../../../controllers/AdministradorController.php";

    $controller = new AdministradorController($conn);
    $profissional = $controller->listarDadosProfissional();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editra perfil</title>

    <!-- Import do CSS-->
    <link rel="stylesheet" href="../../../public/assets/css/style_editar_conta.css">
    
    <!-- Import dos Icones-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Import do Alerta -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/alertas/alerta_padrao_pos.js"></script>
    <script src="../../assets/alertas/alerta_inativar_profissional.js"></script>
    <script src="../../assets/alertas/alerta_deletar_conta.js"></script>

</head>
<body>

    <div class="container">
        <a href="listar_profissionais.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>

                <form action="../../../controllers/AdministradorController.php?acao=editarDadosProfissional" method="post" id="form2">

                    <input type="hidden" name="idProfissional" value="<?php echo $profissional['id_profissional']; ?>">

                        <div class="form-control">
                            <label for="nome">Nome Completo</label>
                            <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" value="<?php echo $profissional['nome']; ?>">
                            <img class="img_success" src="../../assets/icones/check.png" alt="">
                            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                            <small>Msg de erro</small>
                        </div>

                        <div class="form-control">
                            <label for="rg">RG</label>
                            <input type="text" id="rg" name="rg" value="<?php echo $profissional['rg']; ?>">
                            <img class="img_success" src="../../assets/icones/check.png" alt="">
                            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                            <small>Msg de erro</small>
                        </div>

                        <div class="form-control">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" placeholder="Email" value="<?php echo $profissional['email']; ?>">
                            <img class="img_success" src="../../assets/icones/check.png" alt="">
                            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                            <small>Msg de erro</small>
                        </div>

                        <div class="form-control">
                            <label for="crmCrp">CRM e CRP</label>
                            <input type="text" id="crmCrp" name="crmCrp" value="<?php echo $profissional['crm_crp']; ?>">
                            <img class="img_success" src="../../assets/icones/check.png" alt="">
                            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                            <small>Msg de erro</small>
                        </div>

                        <div class="form-control">
                            <label for="especialidade">Especialidade</label>
                            <input type="text" id="especialidade" name="especialidade" value="<?php echo $profissional['especialidade']; ?>">
                            <img class="img_success" src="../../assets/icones/check.png" alt="">
                            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                            <small>Msg de erro</small>
                        </div>

                        <div class="form-control">
                            <label for="dataNascimento">Data de Nascimento</label>
                            <input type="date" id="dataNascimento" name="dataNascimento" value="<?php echo $profissional['data_nascimento']; ?>">
                            <img class="img_success" src="../../assets/icones/check.png" alt="">
                            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                            <small>Msg de erro</small>
                        </div>

                        <div class="form-control">
                            <label for="telefone">Telefone</label>
                            <input type="tel" id="telefone" name="telefone" placeholder="(99) 99999-9999" value="<?php echo $profissional['telefone']; ?>">
                            <img class="img_success" src="../../assets/icones/check.png" alt="">
                            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                            <small>Msg de erro</small>
                        </div>

                        <div class="form-control">
                            <label for="sexo">Sexo</label>
                            <select name="sexo" id="sexo">
                                <option value=""></option>
                                <option value="M" <?php if($profissional['sexo'] == 'M') echo 'selected'; ?>>Masculino</option>
                                <option value="F" <?php if($profissional['sexo'] == 'F') echo 'selected'; ?>>Feminino</option>
                                <option value="O" <?php if($profissional['sexo'] == 'O') echo 'selected'; ?>>Outro</option>
                            </select>
                            <small>Msg de erro</small>
                        </div>
                        
                        <div class="form-control">
                            <label for="estadoCivil">Estado Civil</label>
                            <select name="estadoCivil" id="estadoCivil">
                                <option value="C" <?php if($profissional['estado_civil'] == 'C') echo 'selected'; ?>>Casado</option>
                                <option value="S" <?php if($profissional['estado_civil'] == 'S') echo 'selected'; ?>>Solteiro</option>
                                <option value="V" <?php if($profissional['estado_civil'] == 'V') echo 'selected'; ?>>Viúvo</option>
                            </select>
                            <small>Msg de erro</small>
                        </div>
            
                        <div class="form-control">
                            <label for="endereco">Endereço</label>
                            <input type="text" id="endereco" name="endereco" placeholder="Endereço" value="<?php echo $profissional['endereco']; ?>">
                            <img class="img_success" src="../../assets/icones/check.png" alt="">
                            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                            <small>Msg de erro</small>
                        </div>
                        
                        <div class="form-control">
                            <label for="numCasa">Número da casa</label>
                            <input type="text" id="numCasa" name="numCasa" placeholder="Número da casa" value="<?php echo $profissional['numero_casa']; ?>">
                            <img class="img_success" src="../../assets/icones/check.png" alt="">
                            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                            <small>Msg de erro</small>
                        </div>
                        
                        <div class="form-control">
                            <label for="bairro">Bairro</label>
                            <input type="text" id="bairro" name="bairro" placeholder="Bairro" value="<?php echo $profissional['bairro']; ?>">
                            <img class="img_success" src="../../assets/icones/check.png" alt="">
                            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                            <small>Msg de erro</small>
                        </div>

                        <div class="form-control">
                            <label for="cidade">Cidade</label>
                            <input type="text" id="cidade" name="cidade" placeholder="Cidade" value="<?php echo $profissional['cidade']; ?>">
                            <img class="img_success" src="../../assets/icones/check.png" alt="">
                            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                            <small>Msg de erro</small>
                        </div>
                        


                        <div class="form-control" style="grid-column: span 2;">
                            <label for="observacoes">Observações</label>
                            <textarea id="observacoes" id="observacoes" name="observacoes"  placeholder="Escreva alguma observação..."><?php echo $profissional['observacoes']; ?></textarea>
                            <img class="img_success" src="../../assets/icones/check.png" alt="">
                            <img class="img_error" src="../../assets/icones/exclamation.png" alt="">
                            <small>Msg de erro</small>
                        </div>
                        
                        <input type="submit" value="Salvar" class="btn-salvar">
                </form>
    </div>
    
    <script type="module" src="../../assets/js/validar_edicao_profissional.js"></script>

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
            $mensagem = 'Erro ao excluir profissional eu inativar conta. Tente novamente.';
        } 

        elseif($_GET['alerta'] == 4) {
            $tipo = 'delete';
            $titulo = 'Erro';
            $mensagem = 'Erro ao deletar conta. Tente novamente.';
        } 

        else{
            $tipo = 'erro';
            $titulo = 'Erro';
            $mensagem = 'Erro ao atualizar dados. Tente novamente.';
        }

        echo "<script>
            window.addEventListener('DOMContentLoaded', () => {
                alertaPadraoPos('$tipo', '$titulo', '$mensagem');
            });
        </script>";
        }
    ?>
</body>
</html>
