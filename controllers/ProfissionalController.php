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

            // $encaminhar = $this->encaminhamentoModel->cadastrarEncaminhamento($idExame, $observacoes, $idAgendamentoConsulta);
            
            try {
                $this->emailController->enviarEmail('mateusbertiwarmling@gmail.com', 
                'teste',
                'Encaminhamento de exame', 
                "Olá mates, clique <a href='http://localhost/tcc02/views/paciente/teste.html'>aqui</a> para agendar seu exame.");
                echo "Exame encaminhado e email enviado";
            } catch (Exception $e) {
                echo "Erro ao enviar email: {$mail->ErrorInfo}";
            }
        }

        public function cancelarAgendamentoConsulta(){
            $idConsulta = $_POST['idConsulta'];

            $cancelar = $this->agendamentoConsultaModel->cancelarAgendamentoConsulta($idConsulta);
            
            if($cancelar){
                try {
                    $this->emailController->enviarEmail('mateusbertiwarmling@gmail.com', 'teste', 'Consulta Cancelada.', 'tertertter');
                    echo "Exame encaminhado e email enviado";
                } catch (Exception $e) {
                    echo "Erro ao enviar email: {$mail->ErrorInfo}";
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
