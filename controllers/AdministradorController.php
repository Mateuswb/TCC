<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/models/Usuario.php";
    require_once dirname(__DIR__) . "/models/Paciente.php";
    require_once dirname(__DIR__) . "/models/AgendamentoConsulta.php";
    require_once dirname(__DIR__) . "/models/Profissional.php";
    require_once dirname(__DIR__) . "/models/Exame.php";
    
    require_once dirname(__DIR__) . "/controllers/UsuarioController.php";

    class AdministradorController {
        private $usuarioModel;
        private $pacienteModel;
        private $profissionalModel;
        private $agendamentoConsultaModel;
        private $exameModel;

        private $usuarioController;

        public function __construct($conn) {
            $this->usuarioModel = new Usuario($conn);
            $this->pacienteModel = new Paciente($conn);
            $this->profissionalModel = new Profissional($conn);
            $this->agendamentoConsultaModel = new AgendamentoConsulta($conn);
            $this->exameModel = new Exame($conn);
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
            $numCasa        = $_POST['numCasa'];
            $endereco       = $_POST['endereco'];
            $bairro         = $_POST['bairro'];
            $cidade         = $_POST['cidade'];
            $observacoes    = $_POST['observacoes'];

            $resultado = $this->pacienteModel->editarDadosPaciente(
                $idPaciente, $nome, $email, $dataNascimento, 
                $telefone, $sexo, $altura, $peso, $estadoCivil,
                $tipoSanguineo, $endereco, $numCasa, $bairro,
                $cidade, $observacoes
            );

            echo $resultado ? "Dados atualizados com sucesso." : "Erro ao atualizar dados.";
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
            $especialidade  = $_POST['especialidade'];
            $endereco       = $_POST['endereco'];
            $numCasa        = $_POST['numCasa'];
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

        #consultas
        public function listarConsultas(){
             return $this->agendamentoConsultaModel->listarConsultas();
         }


        public function cadastrarExame() {
            $categoria = $_POST['categoria'];
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $tempoMinutos = $_POST["tempoMinutos"];

            //  verifica se tem pelo menos 1 profissional cadastrado
            if(!$this->exameModel->existeProfissionalParaCategoria($nome)) {
                echo "Não é possível cadastrar este exame. Nenhum profissional na clínica realiza esta especialidade.";
                exit;
            }

            if ($this->exameModel->exameJaCadastrado($nome)) {
                echo "Este exame já está cadastrado!";
                exit;
            }

            // Se existe profissional, cadastra normalmente
            $nomeTratado = ucwords(strtolower($nome));
            $cadastro = $this->exameModel->cadastrarExame($categoria, $nomeTratado, $descricao, $tempoMinutos);

            if($cadastro){
                echo "Exame cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar exame";
            }
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
            default:
                echo "Ação inválida";
                break;
        }
    }
?>