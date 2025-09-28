<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/controllers/UsuarioController.php";
    require_once dirname(__DIR__) . "/controllers/Email.php";
    require_once dirname(__DIR__) . "/models/Profissional.php";
    require_once dirname(__DIR__) . "/models/encaminhamento.php";
    require_once dirname(__DIR__) . "/models/AgendamentoConsulta.php";
    require_once dirname(__DIR__) . "/models/Paciente.php";
    require_once dirname(__DIR__) . "/models/Exame.php";


    class ProfissionalController {

        private $usuarioController;
        private $profissionalModel;
        private $encaminhamentoModel;
        private $pacienteModel;
        private $agendamentoConsultaModel;
        private $exameModel;
        private $emailController;

        public function __construct($conn) {
            $this->usuarioController = new UsuarioController($conn);
            $this->profissionalModel = new Profissional($conn);
            $this->encaminhamentoModel = new encaminhamento($conn);
            $this->agendamentoConsultaModel = new AgendamentoConsulta($conn);
            $this->pacienteModel = new Paciente($conn);
            $this->exameModel = new Exame($conn);
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
            $especialidade   = $_POST['especialidade'];
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

            if ($resultado) {
                echo "Dados atualizados com sucesso.";
            } else {
                echo "Erro ao atualizar dados.";
            }
        }

        public function realizarEncaminhamento(){

            $idExame = $_POST['idExame'];
            $observacoes = $_POST['observacoes'];
            $idAgendamentoConsulta = $_POST['idAgendamentoConsulta'];

            
            //$encaminhar = $this->encaminhamentoModel->cadastrarEncaminhamento($idExame, $observacoes, $idAgendamentoConsulta);

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
                            <td>Hemograma Completo</td>
                        </tr>
                        <tr>
                            <td><strong>Profissional:</strong></td>
                            <td>Dr. João da Silva (Clínico Geral)</td>
                        </tr>
                        <tr style="background:#f4f6f8;">
                            <td><strong>Clínica:</strong></td>
                            <td>MedHub</td>
                        </tr>
                        </table>
                        
                        <p>Para realizar o exame, clique no botão abaixo e siga as instruções:</p>
                        
                        <p style="text-align:center; margin:30px 0;">
                        <a href="http://localhost/tcc02/views/paciente/teste.html" 
                            style="background:#123068; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-size:16px; display:inline-block;">
                            Acessar Exame
                        </a>
                        </p>
                        
                        <p style="font-size:13px; color:#777;">Se o botão não funcionar, copie e cole este link no navegador:<br>
                        <a href="http://localhost/tcc02/views/paciente/teste.html" style="color:#123068;">
                        http://localhost/tcc02/views/paciente/teste.html
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

            if($encaminhar){
                try {
                    $this->emailController->enviarEmail($dados['paciente_email'], 
                    $dados['paciente_nome'], 
                    'Encaminhamento de exame', 
                    $mensagem);
                    echo "Exame encaminhado e email enviado";
                } catch (Exception $e) {
                    echo "Erro ao enviar email: {$e->getMessage()}";
                }
            }
            else{
                echo "Erro ao encaminhar exame";
            }
           
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
                            <h1 style="margin:0; font-size:22px;">Cancelamento de Exame</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px; color:#333333; font-size:15px; line-height:1.6;">
                            <p>Olá <strong>' . $dados['paciente_nome'] . '</strong>,</p>
                            <p>Informamos que o exame que havia sido agendado foi <strong>cancelado</strong>.</p>
                            
                            <table width="100%" cellpadding="8" cellspacing="0" style="margin:15px 0; border:1px solid #ddd; border-radius:6px;">
                                <tr style="background:#f4f6f8;">
                                    <td><strong>Exame:</strong></td>
                                    <td>Hemograma Completo</td>
                                </tr>
                                <tr>
                                    <td><strong>Profissional:</strong></td>
                                    <td>Dr. João da Silva (Clínico Geral)</td>
                                </tr>
                                <tr style="background:#f4f6f8;">
                                    <td><strong>Clínica:</strong></td>
                                    <td>MedHub</td>
                                </tr>
                            </table>
                            
                            <p>Se desejar reagendar o exame, clique no botão abaixo e siga as instruções:</p>
                            
                            <p style="text-align:center; margin:30px 0;">
                                <a href="http://localhost/tcc02/views/paciente/teste.html" 
                                style="background:#123068; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-size:16px; display:inline-block;">
                                Reagendar Exame
                                </a>
                            </p>
                            
                            <p style="font-size:13px; color:#777;">Se o botão não funcionar, copie e cole este link no navegador:<br>
                            <a href="http://localhost/tcc02/views/paciente/teste.html" style="color:#123068;">
                                http://localhost/tcc02/views/paciente/teste.html
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



            if($cancelar){
                try {
                    $this->emailController->enviarEmail($dados['paciente_email'],
                    $dados['paciente_nome'],
                     'Consulta Cancelada.', 
                     $mensagem);
                    echo "Exame cancelado e email enviado";
                } catch (Exception $e) {
                    echo "Erro ao enviar email: {$e->getMessage()}";
                }
            }
            else{
                echo "Erro ao cancelar consulta";
            }
        }

        public function finalizarAgendamentoConsulta(){
            $idConsulta = $_POST['idConsulta'];

            $cancelar = $this->agendamentoConsultaModel->finalizarAgendamentoConsulta($idConsulta);
            
            if($cancelar){
                echo "Consuta finalizada";
            }
            else{
                echo "Erro ao cancelar finalizada";
            }
        }

        #relatorio
        // public function totalAgendamentosProfissional(){
        //     $idProfissional = $_SESSION['idProfissional'];
        //     return $this->agendamentoConsultaModel->totalAgendamentosProfissional($idProfissional);
        // }

    }

    $controller = new ProfissionalController($conn);
    
    if (isset($_GET['acao'])) {
        switch ($_GET['acao']) {
            case 'cadastrarProfissional':
                $controller->cadastrarProfissional();
                break;
            case 'editarDadosProfissional':
                $controller->editarDadosProfissional();
                break;
            case 'encaminharPaciente':
                $controller->realizarEncaminhamento();
                break;
            case 'cancelarAgendamentoConsulta':
                $controller->cancelarAgendamentoConsulta();
                break;
            case 'finalizarAgendamentoConsulta':
                $controller->finalizarAgendamentoConsulta();
                break;
            default:
                echo "Ação inválida";
                break;
        }
    }
?>
