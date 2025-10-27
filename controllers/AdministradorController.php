<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/models/Usuario.php";
    require_once dirname(__DIR__) . "/models/Paciente.php";
    require_once dirname(__DIR__) . "/models/AgendamentoConsulta.php";
    require_once dirname(__DIR__) . "/models/Profissional.php";
    require_once dirname(__DIR__) . "/models/Exame.php";
    require_once dirname(__DIR__) . "/models/Relatorio.php";
    
    require_once dirname(__DIR__) . "/controllers/UsuarioController.php";

    class AdministradorController {
        private $usuarioModel;
        private $pacienteModel;
        private $profissionalModel;
        private $agendamentoConsultaModel;
        private $exameModel;
        private $relatorioModel;

        private $usuarioController;

        public function __construct($conn) {
            $this->usuarioModel = new Usuario($conn);
            $this->pacienteModel = new Paciente($conn);
            $this->profissionalModel = new Profissional($conn);
            $this->agendamentoConsultaModel = new AgendamentoConsulta($conn);
            $this->exameModel = new Exame($conn);
            $this->relatorioModel = new Relatorio($conn);
            $this->usuarioController = new UsuarioController($conn);
        }

        # Pacientes
        public function listarPacientes() {
            return $this->pacienteModel->listarPaciente();
        }

        public function listarDadosPaciente() {
            $idPaciente = $_GET['idPaciente'];
            return $this->pacienteModel->listarDadosPaciente($idPaciente);
        }

        public function editarDadosPaciente() {
            $idPaciente     = $_POST['idPaciente'];
            $nome           = $_POST['nome'];
            $email          = $_POST['email'];
            $dataNascimento = $_POST['dataNascimento'];
            $telefone       = $_POST['telefone'];
            $sexo           = $_POST['sexo'];
            $altura         = $_POST['altura'];
            $peso           = $_POST['peso'];
            $estadoCivil    = $_POST['estadoCivil'];
            $tipoSanguineo  = $_POST['tipoSanguineo'];
            $numCasa        = $_POST['numeroCasa'];
            $endereco       = $_POST['endereco'];
            $bairro         = $_POST['bairro'];
            $cidade         = $_POST['cidade'];
            $observacoes    = $_POST['observacoes'];

            $editar = $this->pacienteModel->editarDadosPaciente(
                $idPaciente, $nome, $email, $dataNascimento, 
                $telefone, $sexo, $altura, $peso, $estadoCivil,
                $tipoSanguineo, $endereco, $numCasa, $bairro,
                $cidade, $observacoes
            );

            session_start();
            if($editar){
                $_SESSION['flash'] = [
                    'type' => 'success', 
                    'message' => "Dados atualizados com sucesso."
                ];
            }
            else{
                $_SESSION['flash'] = [
                    'type' => 'error', 
                    'message' => "Erro ao editar dados do paciente."
                ];
            }
            header("Location: ../views/administrador/paciente/listar_pacientes.php");
            exit;

        }

        # Usuarios
        public function listarUsuarios() {
            return $this->usuarioModel->listarUsuarios();
        }

        public function listarDadosUsuario() {
            $usuarioId = $_GET['idUsuario'];
            return $this->usuarioModel->listarDadosUsuario($usuarioId);
        }

        # Profissionais
        public function cadastrarProfissional() {
            $nome           = $_POST['nome'];
            $rg             = $_POST['rg'];
            $email          = $_POST['email'];
            $dataNascimento = $_POST['dataNascimento'];
            $telefone       = preg_replace('/[^\d]/', '', $_POST['telefone']);
            $sexo           = $_POST['sexo'];
            $estadoCivil    = $_POST['estadoCivil'];
            $crmCrp         = $_POST['crmCrp'];
            $especialidade  = $_POST['especialidades'] ?? [];
            $endereco       = $_POST['endereco'];
            $numeroCasa     = $_POST['numCasa'];
            $bairro         = $_POST['bairro'];
            $cidade         = $_POST['cidade'];
            $observacoes    = $_POST['observacoes'];

            $cpf = $this->usuarioController->cadastrar();

            if ($cpf) {
                $criouProfissional = $this->profissionalModel->cadastrarProfissional(
                    $nome, $cpf, $rg, $email, $dataNascimento, $telefone, 
                    $sexo, $estadoCivil, $crmCrp, $especialidade, 
                    $endereco, $numeroCasa, $bairro, $cidade, $observacoes
                );

                if ($criouProfissional) {
                    unset($_SESSION['cadastroTemp']);
                    header("Location: ../views/administrador/home.php");
                    exit;
                } else {
                    $_SESSION['error'] = "Erro ao criar os dados do profissional.";
                    header("Location: ../views/administrador/cadastroProfissional.php");
                    exit;
                }
            } else {
                $_SESSION['error'] = "Erro ao criar o usuário.";
                header("Location: ../views/administrador/cadastroProfissional.php");
                exit;
            }
        }

        public function listarProfissionais() {
            return $this->profissionalModel->listarProfissionais();
        }

        public function listarDadosProfissional() {
            $idProfissional = $_GET['idProfissional'];
            return $this->profissionalModel->listarDadosProfissional($idProfissional);
        }

        public function editarDadosProfissional() {
            $idProfissional = $_POST['idProfissional'];
            $nome           = $_POST['nome'];
            $rg             = $_POST['rg'];
            $email          = $_POST['email'];
            $dataNascimento = $_POST['dataNascimento'];
            $telefone       = $_POST['telefone'];
            $sexo           = $_POST['sexo'];
            $estadoCivil    = $_POST['estadoCivil'];
            $crmCrp         = $_POST['crmCrp'];
            $especialidade  = $_POST['especialidades'] ?? [];
            $endereco       = $_POST['endereco'];
            $numCasa        = $_POST['numeroCasa'];
            $bairro         = $_POST['bairro'];
            $cidade         = $_POST['cidade'];
            $observacoes    = $_POST['observacoes'];

            $resultado = $this->profissionalModel->editarDadosProfissional(
                $idProfissional, $nome, $rg, $email, $dataNascimento, 
                $telefone, $sexo, $estadoCivil, $crmCrp, $especialidade,
                $endereco, $numCasa, $bairro, $cidade, $observacoes
            );

            echo $resultado ? "Dados atualizados com sucesso." : "Erro ao atualizar dados.";
        }

        # agendamentos
        public function listarAgendamentos(){
            return $this->agendamentoConsultaModel->listarAgendamentos();
        }   


        public function cadastrarExame() {
            $categoria = $_POST['categoria'];
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $tempoMinutos = $_POST["tempoMinutos"];

            session_start();
            //  verifica se tem pelo menos 1 profissional cadastrado
            if(!$this->exameModel->existeProfissionalParaCategoria($nome)) {
                $_SESSION['error'] = "Não é possível cadastrar este exame. Nenhum profissional na clínica tem essa especialidade.";
                header("Location: ../views/administrador/exame/listar_exames.php");
                exit;
            }

            if ($this->exameModel->exameJaCadastrado($nome)) {
                $_SESSION['error'] = "Este exame já está cadastrado!";
                header("Location: ../views/administrador/exame/listar_exames.php");
                exit;
            }

            // Se existe profissional, cadastra normalmente
            $nomeTratado = ucwords(strtolower($nome));
            $cadastro = $this->exameModel->cadastrarExame($categoria, $nomeTratado, $descricao, $tempoMinutos);

            if($cadastro){
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Exame cadastrado com sucesso.'
                ];
            } else {
                 $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao cadastrar exame. Tente novamente.'
                ];
            }
            header("Location: ../views/administrador/exame/listar_exames.php");
            exit;
        }


        public function listarExames(){
            return $this->exameModel->listarExames();
        }

        public function editarExame(){
            $idExame = $_POST['idExame'];
            $nome = $_POST['nome'];
            $categoria = $_POST['categoria'];
            $descricao = $_POST['descricao'];
            $tempoMinutos = $_POST["tempoMinutos"];

            $editar = $this->exameModel->editarExame($idExame,  $nome, $categoria, $descricao, $tempoMinutos);

            if($editar){
                echo "editado";
            } else {
                echo "Erro ao editar exame";
            }

        }

        public function deletarExame(){
            $idExame = $_POST['idExame'];
            $deletar = $this->exameModel->deletarExame($idExame);

            if($deletar){
                echo "deletado";
            } else {
                echo "Erro ao deletar exame";
            }

        }


        #validar exclusão do profissional
        public function excluirProfissional() {
            $idProfissional = $_POST['idProfissional'];
            $cpf            = $_POST['cpf'];

            session_start();
            try {
                $temAgendamento = $this->profissionalModel->temAgendamentoAtivo($idProfissional);
                if ($temAgendamento) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => "O profissional possui agendamentos ativos, ele não pode ser excluído."
                    ];
                    header("Location: ../views/administrador/profissional/listar_profissionais.php");
                    exit;
                }

                $this->profissionalModel->excluirProfissionalComUsuario($idProfissional, $cpf);

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "Profissional e usuário excluídos com sucesso."
                ];
                header("Location: ../views/administrador/profissional/listar_profissionais.php");
                exit;

            } catch (Exception $e) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ];
                header("Location: ../views/administrador/profissional/listar_profissionais.php");
                exit;
            }
        }

        #validar exclusão do paciente
        public function excluirPaciente() {
            $idPaciente     = $_POST['idPaciente'];
            $cpf            = $_POST['cpf'];

            session_start();
            try {
                $temAgendamento = $this->pacienteModel->temAgendamentoAtivoPaciente($idPaciente);
                if ($temAgendamento) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => "O paciente possui agendamentos ativos, ele não pode ser excluído."
                    ];
                    header("Location: ../views/administrador/paciente/listar_pacientes.php");
                    exit;
                }

                $this->pacienteModel->excluirPacienteComUsuario($idPaciente, $cpf);

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "Paciente e usuário excluídos com sucesso."
                ];
                header("Location: ../views/administrador/paciente/listar_pacientes.php");
                exit;

            } catch (Exception $e) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ];
                header("Location: ../views/administrador/paciente/listar_pacientes.php");
                exit;
            }
        }
    }

    $controller = new AdministradorController($conn);
    if (isset($_GET['acao'])) {
        switch ($_GET['acao']) {
            case 'editarDadosPaciente':
                $controller->editarDadosPaciente();
                break;
            case 'editarDadosProfissional':
                $controller->editarDadosProfissional();
                break;
            case 'cadastrarProfissional':
                $controller->cadastrarProfissional();
                break;
            case 'cadastrarExame':
                $controller->cadastrarExame();
                break;
            case 'editarExame':
                $controller->editarExame();
                break;
            case 'deletarExame':
                $controller->deletarExame();
                break;
            case 'excluirProfissional':
                $controller->excluirProfissional();
                break;
            case 'excluirPaciente':
                $controller->excluirPaciente();
                break;
            default:
                echo "Ação inválida";
                break;
        }
    }
?>