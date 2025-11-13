<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/controllers/UsuarioController.php";
    require_once dirname(__DIR__) . "/controllers/Email.php";
    require_once dirname(__DIR__) . "/models/Profissional.php";
    require_once dirname(__DIR__) . "/models/encaminhamento.php";
    require_once dirname(__DIR__) . "/models/AgendamentoConsulta.php";
    require_once dirname(__DIR__) . "/models/AgendamentoExame.php";
    require_once dirname(__DIR__) . "/models/Paciente.php";
    require_once dirname(__DIR__) . "/models/Exame.php";
    require_once dirname(__DIR__) . "/models/Relatorio.php";


    class ProfissionalController {

        private $profissionalModel;
        private $encaminhamentoModel;
        private $agendamentoConsultaModel;
        private $agendamentoExameModel;
        private $relatorioModel;
        private $emailController;

        public function __construct($conn) {
            $this->profissionalModel = new Profissional($conn);
            $this->encaminhamentoModel = new encaminhamento($conn);
            $this->agendamentoConsultaModel = new AgendamentoConsulta($conn);
            $this->agendamentoExameModel = new AgendamentoExame($conn);
            $this->relatorioModel = new Relatorio($conn);
            $this->emailController = new Email();
        }


        public function listarDadosProfissional() {
            $idProfissional = $_SESSION['idProfissional'];
            return $this->profissionalModel->listarDadosProfissional($idProfissional);
        }

        public function editarDadosProfissional() {
            $idProfissional  = $_POST['idProfissional'];
            $nome            = $_POST['nome'];
            $rg              = $_POST['rg'];
            $email           = $_POST['email'];
            $dataNascimento  = $_POST['dataNascimento'];
            $telefone        = $_POST['telefone'];
            $sexo            = $_POST['sexo'];
            $estadoCivil     = $_POST['estadoCivil'];
            $crmCrp          = $_POST['crmCrp'];
            $especialidade   = $_POST['especialidades'] ?? [];
            $endereco        = $_POST['endereco'];
            $numeroCasa      = $_POST['numeroCasa'];
            $bairro          = $_POST['bairro'];
            $cidade          = $_POST['cidade'];
            $observacoes     = $_POST['observacoes'];

            $resultado = $this->profissionalModel->editarDadosProfissional(
                $idProfissional, $nome, $rg, $email, $dataNascimento, 
                $telefone, $sexo, $estadoCivil, $crmCrp, $especialidade,
                $endereco, $numeroCasa, $bairro, $cidade, $observacoes
            );

            session_start();
            if ($resultado) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Dados atualizados com sucesso.'
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao editar dados da conta'
                ];
            }
            header("Location: ../views/profissional/perfil.php");
            exit;
        }


        public function realizarEncaminhamento(){

            $idExame = $_POST['idExame'];
            $observacoes = $_POST['observacoes'];
            $idAgendamentoConsulta = $_POST['idAgendamentoConsulta'];

            $encaminhar = $this->encaminhamentoModel->cadastrarEncaminhamento($idExame, $observacoes, $idAgendamentoConsulta);

            $trocarStatus = $this->agendamentoConsultaModel->finalizarAgendamentoConsulta($idAgendamentoConsulta);

            $dados = $this->agendamentoConsultaModel->getAgendamento($idAgendamentoConsulta);
            
            $mensagem = '
                <!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                <meta charset="UTF-8">
                <title>Encaminhamento de Exame</title>
                </head>
                <body style="font-family: Arial, sans-serif; background-color:#f4f6f8; margin:0; padding:0;">
                <table align="center" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                    <tr>
                    <td style="background:#123068; color:#ffffff; text-align:center; padding:20px;">
                        <h1 style="margin:0; font-size:22px;">Encaminhamento de Exame</h1>
                    </td>
                    </tr>
                    <tr>
                    <td style="padding:20px; color:#333333; font-size:15px; line-height:1.6;">
                        <p>Olá <strong>' . $dados['paciente_nome'] . '</strong>,</p>
                        <p>Você recebeu um encaminhamento para realizar um exame solicitado por um de nossos profissionais.</p>
                        
                        <table width="100%" cellpadding="8" cellspacing="0" style="margin:15px 0; border:1px solid #ddd; border-radius:6px;">
                        <tr style="background:#f4f6f8;">
                            <td><strong>Exame:</strong></td>
                            <td>'. $dados['nome_exame'] . '</td>
                        </tr>
                        <tr>
                            <td><strong>Profissional:</strong></td>
                            <td>'. $dados['nome_profissional'] .'</td>
                        </tr>
                        <tr style="background:#f4f6f8;">
                            <td><strong>Clínica:</strong></td>
                            <td>MedHub</td>
                        </tr>
                        </table>
                        
                        <p>Para realizar o exame, clique no botão abaixo e siga as instruções:</p>
                        
                        <p style="text-align:center; margin:30px 0;">
                        <a href="http://localhost/tcc/views/paciente/exames/encaminhamento/listar_encaminhamentos.php" 
                            style="background:#123068; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-size:16px; display:inline-block;">
                            Acessar Exame
                        </a>
                        </p>
                        
                        <p style="font-size:13px; color:#777;">Se o botão não funcionar, copie e cole este link no navegador:<br>
                        <a href="http://localhost/tcc/views/paciente/exames/encaminhamento/listar_encaminhamentos.php" style="color:#123068;">
                        http://localhost/tcc/views/paciente/exames/encaminhamento/listar_encaminhamentos.php
                        </a></p>
                        
                        <p style="margin-top:20px;">Atenciosamente,<br><strong>Equipe Clínica MedHub</strong></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="background:#f4f6f8; text-align:center; font-size:12px; color:#888; padding:15px;">
                        © ' . date("Y") . ' Clínica MedHub. Todos os direitos reservados.
                    </td>
                    </tr>
                </table>
                </body>
                </html>
            ';
            
            session_start();
            if($encaminhar){
                try {
                    $this->emailController->enviarEmail($dados['paciente_email'], 
                    $dados['paciente_nome'], 
                    'Encaminhamento de exame', 
                    $mensagem);
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Exame encaminhado e email enviado'
                    ];
                } catch (Exception $e) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => 'Erro ao enviar email.'
                    ];
                }
            }
            else{
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao encaminhar exame. Tente novamente'
                ];
            }
            header("Location: ../views/profissional/agendamentos/consultas.php");
            exit;
        }

        public function cancelarAgendamentoConsulta(){
            $idConsulta = $_POST['idConsulta'];

            $dados = $this->agendamentoConsultaModel->getAgendamento($idConsulta);
            $cancelar = $this->agendamentoConsultaModel->cancelarAgendamentoConsulta($idConsulta);
            
            $mensagem = '
                <!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                <meta charset="UTF-8">
                <title>Cancelamento de Exame</title>
                </head>
                <body style="font-family: Arial, sans-serif; background-color:#f4f6f8; margin:0; padding:0;">
                <table align="center" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background:#123068; color:#ffffff; text-align:center; padding:20px;">
                            <h1 style="margin:0; font-size:22px;">Cancelamento de Consulta</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px; color:#333333; font-size:15px; line-height:1.6;">
                            <p>Olá <strong>' . $dados['paciente_nome'] . '</strong>,</p>
                            <p>Informamos que a consulta que havia sido agendada foi <strong>cancelada</strong>.</p>
                            
                            <table width="100%" cellpadding="8" cellspacing="0" style="margin:15px 0; border:1px solid #ddd; border-radius:6px;">
            
                                <tr>
                                    <td><strong>Profissional:</strong></td>
                                    <td>'. $dados['nome_profissional'] . '</td>
                                </tr>
                                <tr style="background:#f4f6f8;">
                                    <td><strong>Clínica:</strong></td>
                                    <td>MedHub</td>
                                </tr>
                            </table>
                            
                            <p>Se desejar reagendar sua consulta, clique no botão abaixo e siga as instruções:</p>
                            
                            <p style="text-align:center; margin:30px 0;">
                                <a href="http://localhost/tcc/views/paciente/consultas/listar_profissionais.php" 
                                style="background:#123068; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-size:16px; display:inline-block;">
                                Reagendar Exame
                                </a>
                            </p>
                            
                            <p style="font-size:13px; color:#777;">Se o botão não funcionar, copie e cole este link no navegador:<br>
                            <a href="http://localhost/tcc/views/paciente/consultas/listar_profissionais.php" style="color:#123068;">
                                http://localhost/tcc/views/paciente/consultas/listar_profissionais.php
                            </a></p>
                            
                            <p style="margin-top:20px;">Atenciosamente,<br><strong>Equipe Clínica MedHub</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f4f6f8; text-align:center; font-size:12px; color:#888; padding:15px;">
                            © ' . date("Y") . ' Clínica MedHub. Todos os direitos reservados.
                        </td>
                    </tr>
                </table>
                </body>
                </html>
                ';


            session_start();
            if($cancelar){
                try {
                    $this->emailController->enviarEmail($dados['paciente_email'], $dados['paciente_nome'], 'Consulta Cancelada.', $mensagem);
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Consulta cancelado e email enviado'
                    ];
                } catch (Exception $e) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => 'Erro ao enviar email para: ' . $dados['paciente_nome']. '453'
                    ];
                }
            }
            else{
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao cancelar consulta'
                ];
            }
            header("Location: ../views/profissional/agendamentos/consultas.php");
            exit;
        }

        public function reencaminharExame()
        {
            $idEncaminhamento = $_POST['idEncaminhamento'];
            $idAgendamentoConsulta = $_POST['idAgendamentoConsulta'];
            $idTipoExame = $_POST['idTipoExame'];
            $idAgendamentoExame = $_POST['idAgendamentoExame'] ?? null;
            $observacoes = $_POST['observacoes'];

            $dados = $this->agendamentoConsultaModel->getAgendamento($idAgendamentoConsulta);
            session_start();

            $reencaminhar = $this->encaminhamentoModel->reencaminharExame($idEncaminhamento, $idTipoExame, $observacoes);

            
            try {
            if (!empty($idAgendamentoExame && $idAgendamentoExame !== null)) {
                $cancelado = $this->agendamentoExameModel->cancelarAgendamentoExame($idAgendamentoExame);

                if (!$cancelado) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => 'Erro ao cancelar o agendamento anterior do exame.'
                    ];
                    header("Location: ../views/profissional/historico_encaminhamentos/listar_encaminhamentos.php");
                    exit;
                }
            }

            $reencaminhar = $this->encaminhamentoModel->reencaminharExame($idEncaminhamento, $idTipoExame, $observacoes);
      
            if ($reencaminhar) {
                $mensagem = '
                    <!DOCTYPE html>
                    <html lang="pt-BR">
                    <head>
                    <meta charset="UTF-8">
                    <title>Reencaminhamento de Exame</title>
                    </head>
                    <body style="font-family: Arial, sans-serif; background-color:#f4f6f8; margin:0; padding:0;">
                    <table align="center" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                        <tr>
                        <td style="background:#123068; color:#ffffff; text-align:center; padding:20px;">
                            <h1 style="margin:0; font-size:22px;">Reencaminhamento de Exame</h1>
                        </td>
                        </tr>
                        <tr>
                        <td style="padding:20px; color:#333333; font-size:15px; line-height:1.6;">
                            <p>Olá <strong>' . $dados['paciente_nome'] . '</strong>,</p>
                            <p>Informamos que seu exame foi <strong>reencaminhado</strong>.</p>

                            <table width="100%" cellpadding="8" cellspacing="0" style="margin:15px 0; border:1px solid #ddd; border-radius:6px;">
                            <tr>
                                <td><strong>Exame:</strong></td>
                                <td>' . $dados['nome_exame'] . '</td>
                            </tr>
                            <tr>
                                <td><strong>Novo Profissional:</strong></td>
                                <td>' . $dados['nome_profissional'] . '</td>
                            </tr>
                            <tr style="background:#f4f6f8;">
                                <td><strong>Clínica:</strong></td>
                                <td>MedHub</td>
                            </tr>
                            </table>

                            <p>Você ainda precisa efetuar o agendamento do seu exame. Para continuar, acesse sua conta pelo botão abaixo e finalize o agendamento</p>

                            <p style="text-align:center; margin:30px 0;">
                            <a href="http://localhost/tcc/views/views/paciente/exames/encaminhamento/listar_encaminhamentos.php" 
                            style="background:#123068; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-size:16px; display:inline-block;">
                            Agendar Exame
                            </a>
                            </p>

                            <p style="font-size:13px; color:#777;">Se o botão não funcionar, copie e cole este link no navegador:<br>
                            <a href="http://localhost/tcc/views/paciente/exames/encaminhamento/listar_encaminhamentos.php" style="color:#123068;">
                                http://localhost/tcc/views/paciente/exames/encaminhamento/listar_encaminhamentos.php
                            </a>
                            </p>

                            <p style="margin-top:20px;">Atenciosamente,<br><strong>Equipe Clínica MedHub</strong></p>
                        </td>
                        </tr>
                        <tr>
                        <td style="background:#f4f6f8; text-align:center; font-size:12px; color:#888; padding:15px;">
                            © ' . date("Y") . ' Clínica MedHub. Todos os direitos reservados.
                        </td>
                        </tr>
                    </table>
                    </body>
                    </html>
                ';

                $this->emailController->enviarEmail(
                    $dados['paciente_email'],
                    $dados['paciente_nome'],
                    'Exame Reencaminhado',
                    $mensagem
                );

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Exame reencaminhado e e-mail enviado com sucesso!'
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao reencaminhar exame.'
                ];
            }
            } catch (Exception $e) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro inesperado: ' . $e->getMessage()
                ];
            }

            header("Location: ../views/profissional/historico_encaminhamentos/listar_encaminhamentos.php");
            exit;
        }
    

        public function cancelarEncaminhamentoExame()
        {
            $idEncaminhamento = $_POST['idEncaminhamento'];
            $idAgendamentoExame = $_POST['idAgendamentoExame'] ?? null;
            $idAgendamentoConsulta = $_POST['idConsulta'];

            $dados = $this->agendamentoConsultaModel->getAgendamento($idAgendamentoConsulta);


            $cancelarEncaminhamento = $this->encaminhamentoModel->cancelarEncaminhamento($idEncaminhamento);

            if ($idAgendamentoExame) {
                $cancelarExame = $this->agendamentoExameModel->cancelarAgendamentoExame($idAgendamentoExame);
            } else {
                $cancelarExame = true; 
            }

            $mensagem = '
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
                <meta charset="UTF-8">
                <title>Cancelamento de Encaminhamento</title>
            </head>
            <body style="font-family: Arial, sans-serif; background-color:#f4f6f8; margin:0; padding:0;">
                <table align="center" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background:#8b0000; color:#ffffff; text-align:center; padding:20px;">
                            <h1 style="margin:0; font-size:22px;">Cancelamento de Exame</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px; color:#333333; font-size:15px; line-height:1.6;">
                            <p>Olá <strong>' . $dados['paciente_nome'] . '</strong>,</p>
                            <p>Informamos que o encaminhamento referente ao seu exame foi <strong>cancelado</strong> pelo profissional responsável.</p>

                            <table width="100%" cellpadding="8" cellspacing="0" style="margin:15px 0; border:1px solid #ddd; border-radius:6px;">
                                <tr>
                                    <td><strong>Exame:</strong></td>
                                    <td>' . $dados['nome_exame'] . '</td>
                                </tr>
                                <tr>
                                    <td><strong>Profissional:</strong></td>
                                    <td>' . $dados['nome_profissional'] . '</td>
                                </tr>
                                <tr style="background:#f4f6f8;">
                                    <td><strong>Clínica:</strong></td>
                                    <td>MedHub</td>
                                </tr>
                            </table>

                            <p>Se o cancelamento ocorreu por engano, entre em contato com a clínica para mais informações.</p>

                            <p style="text-align:center; margin:30px 0;">
                                <a href="http://localhost/tcc/views/paciente/exames/encaminhamento/listar_encaminhamentos.php" 
                                style="background:#8b0000; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-size:16px; display:inline-block;">
                                    Ver Meus Encaminhamentos
                                </a>
                            </p>

                            <p style="font-size:13px; color:#777;">Se o botão não funcionar, copie e cole este link no navegador:<br>
                                <a href="http://localhost/tcc/views/paciente/exames/encaminhamento/listar_encaminhamentos.php" style="color:#123068;">
                                    http://localhost/tcc/views/paciente/exames/encaminhamento/listar_encaminhamentos.php
                                </a>
                            </p>

                            <p style="margin-top:20px;">Atenciosamente,<br><strong>Equipe Clínica MedHub</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f4f6f8; text-align:center; font-size:12px; color:#888; padding:15px;">
                            © ' . date("Y") . ' Clínica MedHub. Todos os direitos reservados.
                        </td>
                    </tr>
                </table>
            </body>
            </html>
            ';

            session_start();

            if ($cancelarEncaminhamento && $cancelarExame) {
                try {
                    $this->emailController->enviarEmail(
                        $dados['paciente_email'],
                        $dados['paciente_nome'],
                        'Encaminhamento Cancelado',
                        $mensagem
                    );

                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Encaminhamento e exame cancelados. E-mail enviado ao paciente.'
                    ];
                } catch (Exception $e) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => 'Encaminhado cancelado, mas ocorreu erro ao enviar o e-mail.'
                    ];
                }
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao cancelar o encaminhamento ou exame.'
                ];
            }

            header("Location: ../views/profissional/historico_encaminhamentos/listar_encaminhamentos.php");
            exit;
        }
        
        public function cancelarExame()
        {
            $idAgendamentoExame = $_POST['idAgendamentoExame'];
            $idAgendamentoExame = $_POST['idAgendamentoExame'];

            $dados = $this->agendamentoExameModel->getAgendamentoExame($idAgendamentoExame);
            $cancelarExame = $this->agendamentoExameModel->cancelarAgendamentoExame($idAgendamentoExame);

            $mensagem = '
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
                <meta charset="UTF-8">
                <title>Cancelamento de Exame</title>
            </head>
            <body style="font-family: Arial, sans-serif; background-color:#f4f6f8; margin:0; padding:0;">
                <table align="center" width="600" cellpadding="0" cellspacing="0" 
                    style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background:#004080; color:#ffffff; text-align:center; padding:20px;">
                            <h1 style="margin:0; font-size:22px;">Cancelamento de Exame</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px; color:#333333; font-size:15px; line-height:1.6;">
                            <p>Olá <strong>' . $dados['paciente_nome'] . '</strong>,</p>

                            <p>Informamos que o seu exame <strong>' . $dados['nome_exame'] . '</strong> foi 
                            <strong>cancelado</strong> pelo profissional responsável.</p>

                            <table width="100%" cellpadding="8" cellspacing="0" 
                                style="margin:15px 0; border:1px solid #ddd; border-radius:6px;">
                                <tr>
                                    <td><strong>Exame:</strong></td>
                                    <td>' . $dados['nome_exame'] . '</td>
                                </tr>
                                <tr>
                                    <td><strong>Profissional responsável:</strong></td>
                                    <td>' . $dados['nome_profissional'] . '</td>
                                </tr>
                                <tr style="background:#f4f6f8;">
                                </tr>
                                <tr>
                                    <td><strong>Clínica:</strong></td>
                                    <td>MedHub</td>
                                </tr>
                            </table>

                            <p>Se o cancelamento ocorreu por engano ou desejar reagendar, entre em contato com a clínica 
                            ou acesse sua área do paciente.</p>

                            <p style="text-align:center; margin:30px 0;">
                                <a href="http://localhost/tcc/views/paciente/exames/exames_agendados/listar_agendamentos.php" 
                                style="background:#004080; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-size:16px; display:inline-block;">
                                    Acessar Meus Exames
                                </a>
                            </p>

                            <p style="font-size:13px; color:#777;">Se o botão não funcionar, copie e cole este link no navegador:<br>
                                <a href="http://localhost/tcc/views/paciente/exames/exames_agendados/listar_agendamentos.php" style="color:#004080;">
                                    http://localhost/tcc/views/paciente/exames/exames_agendados/listar_agendamentos.php
                                </a>
                            </p>

                            <p style="margin-top:20px;">Atenciosamente,<br><strong>Equipe Clínica MedHub</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f4f6f8; text-align:center; font-size:12px; color:#888; padding:15px;">
                            © ' . date("Y") . ' Clínica MedHub. Todos os direitos reservados.
                        </td>
                    </tr>
                </table>
            </body>
            </html>
            ';

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if ($cancelarExame) {
                try {
                    $this->emailController->enviarEmail(
                        $dados['paciente_email'],
                        $dados['paciente_nome'],
                        'Cancelamento de Exame',
                        $mensagem
                    );

                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Exame cancelado com sucesso. E-mail enviado ao paciente.'
                    ];
                } catch (Exception $e) {
                    $_SESSION['flash'] = [
                        'type' => 'warning',
                        'message' => 'Exame cancelado, mas ocorreu um erro ao enviar o e-mail.'
                    ];
                }
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao cancelar o exame.'
                ];
            }

            header("Location: ../views/profissional/agendamentos/consultas.php");
            exit;
        }


        public function finalizarAgendamentoConsulta(){
            $idConsulta = $_POST['idConsulta'];

            $finalizar = $this->agendamentoConsultaModel->finalizarAgendamentoConsulta($idConsulta);
            
            session_start();
            if($finalizar){
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Consulta finalizada com sucesso'
                ];
            }
            else{
               $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao cancelar consulta'
                ];
            }
            header("Location: ../views/profissional/agendamentos/consultas.php");
            exit;
        }

        public function listarPacientesPorProfissional(){
            $idProfissional = $_SESSION['idProfissional'];
            return $this->relatorioModel->listarPacientesPorProfissional($idProfissional);
        }

        public function principaisEspecialidades(){
            return $this->profissionalModel->principaisEspecialidades();
        }

        // ProfissionalController.php
        public function finalizarEventosPassados() {
            $qtdeConsultas = $this->agendamentoConsultaModel->finalizarConsultasPassadas();
            $qtdeExames = $this->agendamentoExameModel->finalizarExamesPassados();

            header('Content-Type: application/json');
            echo json_encode([
                'sucesso' => true,
                'consultas_finalizadas' => $qtdeConsultas,
                'exames_finalizados' => $qtdeExames
            ]);
            exit;
        }

        public function inativarContaProfissional() {
            $idProfissional = $_POST['idProfissioanl'];
            $cpf            = $_POST['cpf'];

            session_start();
            try {
                $temAgendamento = $this->profissionalModel->temAgendamentoAtivoProfissional($idProfissional);

                if ($temAgendamento) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => "Você possui agendamentos ativos e não pode inativar sua conta no momento. Cancele seus agendamentos primeiro."
                    ];
                    header("Location: ../views/profissional/perfil.php");
                    exit;
                }

                $this->usuarioModel->inativarUsuario($cpf);

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "Sua conta foi inativada com sucesso."
                ];
                session_destroy();
                header("Location: ../views/index.php");
                exit;

            } catch (Exception $e) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ];
                header("Location: ../views/paciente/perfil.php");
                exit;
            }
        }

        public function excluirContaProfissional() {
            $idProfissional = $_POST['idProfissional'];
            $cpf            = $_POST['cpf'];

            session_start();
            try {
                $temAgendamento = $this->profissionalModel->temAgendamentoAtivoProfissional($idProfissional);

                if ($temAgendamento) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => "Você possui agendamentos ativos e não pode excluir sua conta no momento. Cancele seus agendamentos primeiro."
                    ];
                    header("Location: ../views/profissional/perfil.php");
                    exit;
                }

                $this->profissionalModel->excluirProfissionalComUsuario($idProfissional, $cpf);

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "Sua conta foi excluída com sucesso."
                ];
                session_destroy();
                header("Location: ../views/index.php");
                exit;

            } catch (Exception $e) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ];
                header("Location: ../views/profissional/perfil.php");
                exit;
            }
        }

    }

    $controller = new ProfissionalController($conn);
    
    if (isset($_GET['acao'])) {
        switch ($_GET['acao']) {
            case 'editarDadosProfissional':
                $controller->editarDadosProfissional();
                break;
            case 'encaminharPaciente':
                $controller->realizarEncaminhamento();
                break;
            case 'reencaminharPaciente':
                $controller->reencaminharExame();
                break;
            case 'cancelarAgendamentoConsulta':
                $controller->cancelarAgendamentoConsulta();
                break;
            case 'finalizarAgendamentoConsulta':
                $controller->finalizarAgendamentoConsulta();
                break;
            case 'cancelarEncaminhamento':
                $controller->cancelarEncaminhamentoExame();
                break;
            case 'finalizarEventosPassados':
                $controller->finalizarEventosPassados();
                break;
            case 'cancelarExame':
                $controller->cancelarExame();
                break;
            case 'inativarContaProfissional':
                $controller->inativarContaProfissional();
                break;
            case 'excluirContaProfissional':
                $controller->excluirContaProfissional();
                break;
            default:
                echo "Ação inválida";
                break;
        }
    }
?>
