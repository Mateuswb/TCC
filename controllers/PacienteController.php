<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/controllers/UsuarioController.php";
    require_once dirname(__DIR__) . "/models/Paciente.php";
    require_once dirname(__DIR__) . "/models/Profissional.php";
    require_once dirname(__DIR__) . "/models/HorarioProfissional.php";
    require_once dirname(__DIR__) . "/models/AgendamentoConsulta.php"; 
    require_once dirname(__DIR__) . "/models/AgendamentoExame.php"; 

    class PacienteController {
        private $usuarioController;
        private $pacienteModel;
        private $profissionalModel;
        private $horarioModel;
        private $agendamentoConsultaModel;
        private $agendamentoExameModel;

        public function __construct($conn) {
            $this->usuarioController = new UsuarioController($conn);
            $this->pacienteModel = new Paciente($conn);
            $this->profissionalModel = new Profissional($conn);
            $this->horarioModel = new Horario($conn);
            $this->agendamentoConsultaModel = new AgendamentoConsulta($conn);
            $this->agendamentoExameModel = new AgendamentoExame($conn);
        }

        public function cadastrarPaciente() {
            session_start();
        
            if (!isset($_SESSION['cadastroTemp'])) {
                $_SESSION['error'] = "Por favor, complete primeiro os dados de login.";
                header("Location: ../views/usuario/cadastro.php");
                exit;
            }

            // Dados do formulário
            $nome           = $_POST['nome'];
            $email          = $_POST['email'];
            $dataNascimento = $_POST['dataNascimento'];
            $telefone       = $_POST['telefone'];
            $sexo           = $_POST['sexo'];
            $altura         = $_POST['altura'];
            $peso           = $_POST['peso'];
            $estadoCivil    = $_POST['estadoCivil'];
            $tipoSanguineo  = $_POST['tipoSanguineo'];
            $numeroCasa     = $_POST['numCasa'];
            $endereco       = $_POST['endereco'];
            $bairro         = $_POST['bairro'];
            $cidade         = $_POST['cidade'];
            $observacoes    = $_POST['observacoes'];

            $usuarioLogadoTipo = $_SESSION['tipoUsuario'];

            // Cria o usuário
            $cpf = $this->usuarioController->cadastrar();

            if ($cpf) {
                $criouPaciente = $this->pacienteModel->criarPaciente(
                    $nome, $cpf, $email, $dataNascimento, $telefone, $sexo,
                    $altura, $peso, $estadoCivil, $tipoSanguineo,
                    $endereco, $numeroCasa, $bairro, $cidade,
                    $observacoes
                );

                unset($_SESSION['cadastroTemp']); // limpa temporário

                if ($usuarioLogadoTipo == 'admin') {
                    if ($criouPaciente) {
                        header("Location: ../views/administrador/home.php");
                        exit;
                    } else {
                        $_SESSION['error'] = "Erro ao criar paciente";
                        header("Location: ../views/administrador/home.php");
                        exit;
                    }
                } else {
                    header("Location: ../views/index.php"); // paciente comum
                    exit;
                }
            } else {
                $_SESSION['error'] = "Erro ao criar o usuário.";
                header("Location: ../views/index.php");
                exit;
            }
        }

        public function editarDadosPaciente() {
            $idPaciente      = $_POST['idPaciente'];
            $nome            = $_POST['nome'];
            $email           = $_POST['email'];
            $dataNascimento  = $_POST['dataNascimento'];
            $telefone        = $_POST['telefone'];
            $sexo            = $_POST['sexo'];
            $altura          = $_POST['altura'];
            $peso            = $_POST['peso'];
            $estadoCivil     = $_POST['estadoCivil'];
            $tipoSanguineo   = $_POST['tipoSanguineo'];
            $endereco        = $_POST['endereco'];
            $numeroCasa      = $_POST['numeroCasa'];
            $bairro          = $_POST['bairro'];
            $cidade          = $_POST['cidade'];
            $observacoes     = $_POST['observacoes'];

            $resultado = $this->pacienteModel->editarDadosPaciente(
                $idPaciente, $nome, $email, $dataNascimento,
                $telefone, $sexo, $altura, $peso, $estadoCivil,
                $tipoSanguineo, $endereco, $numeroCasa, $bairro,
                $cidade, $observacoes
            );

            session_start();
            if ($resultado) {
                $_SESSION['flash'] = [
                    'type' => 'success', 
                    'message' => "Dados atualizados com sucesso" 
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error', 
                    'message' => "Erro ao editar dados." 
                ];
            }
            header("Location: ../views/paciente/perfil.php");
        }

        public function exibirDadosPaciente() {
            $idPaciente = $_SESSION['idPaciente'];
            $paciente = $this->pacienteModel->listarDadosPaciente($idPaciente);
            return $paciente;
        }

        public function listarProfissionaisDisponiveis() {
            $profissionais = $this->profissionalModel->listarProfissionaisDisponiveis();
            return $profissionais;
        }

        public function exibirHorarios($dataSelecionada, $profissionalId) {
            $horariosDisponiveis = $this->horarioModel->listarHorariosDisponiveis($dataSelecionada, $profissionalId);
            header('Content-Type: application/json');
            echo json_encode($horariosDisponiveis);
        }

        #consultas
        public function listarAgendamentosConsulta($idPaciente) {
            $agendametos = $this->agendamentoConsultaModel->listarAgendamentosConsulta($idPaciente);
            return $agendametos;
        }

        public function historicoAgendamentosConsulta($idPaciente) {
            $agendametos = $this->agendamentoConsultaModel->historicoAgendamentosConsulta($idPaciente);
            return $agendametos;
        }
        
        public function totalConsultasRealizadas($idPaciente) {
            return $this->agendamentoConsultaModel->totalConsultasRealizadas($idPaciente);
        }
        public function totalConsultasRetorno($idPaciente) {
            return $this->agendamentoConsultaModel->totalConsultasRetorno($idPaciente);
        }
        public function totalConsultasCanceladas($idPaciente) {
            return $this->agendamentoConsultaModel->totalConsultasCanceladas($idPaciente);
        }


        
        #exames
        public function listarAgendamentosExame($idPaciente) {
            $agendametos = $this->agendamentoExameModel->listarAgendamentosExame($idPaciente);
            return $agendametos;
        }

        public function historicoAgendamentosExame($idPaciente) {
            $agendametos = $this->agendamentoExameModel->historicoAgendamentosExame($idPaciente);
            return $agendametos;
        }
        
    }

    
    $controller = new PacienteController($conn);

    if (isset($_GET['acao'])) {
        switch ($_GET['acao']) {
            case 'cadastrarPaciente':
                $controller->cadastrarPaciente();
                break;
            case 'editarDadosPaciente':
                $controller->editarDadosPaciente();
                break;
            default:
                echo "Ação inválida";
                break;
        }
    }

    if (isset($_POST['data'])) {
        $dataSelecionada = $_POST['data'];
        $idProfissional  = $_POST['idProfissional'];
        $controller->exibirHorarios($dataSelecionada, $idProfissional);
    }
?>
