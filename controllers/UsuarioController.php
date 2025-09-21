<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/models/Usuario.php";
    require_once dirname(__DIR__) . "/models/HorarioProfissional.php";

    class UsuarioController {
        private $usuarioModel;
        private $horarioModel;

        public function __construct($conn) {
            $this->usuarioModel = new Usuario($conn);
            $this->horarioModel = new Horario($conn);
        }

        public function login() {
            session_start();
            $cpf = trim($_POST['cpf']);
            $cpf = str_replace(['.', '-'], '', $cpf);

            $password = $_POST['password'];
            $usuario = $this->usuarioModel->buscarPorCPF($cpf);

            if ($usuario && $password == $usuario['senha']) {
                $_SESSION['idUsuario'] = $usuario['id_usuario'];
                $_SESSION['tipoUsuario'] = $usuario['tipo_usuario'];

                if ($usuario['tipo_usuario'] == 'paciente') {
                    $_SESSION['idPaciente']   = $usuario['id_paciente']; 
                    $_SESSION['nomePaciente'] = $usuario['paciente_nome'];
                    header("Location: ../views/paciente/home.php");
                    exit;

                } else if ($usuario['tipo_usuario'] == 'profissional') {
                    $_SESSION['idProfissional']   = $usuario['id_profissional'];
                    $_SESSION['nomeProfissional'] = $usuario['profissional_nome'];

                    if (!$this->horarioModel->verificaHorario($_SESSION['idProfissional'])) {
                        $_SESSION['msg'] = "Antes de continuar, cadastre seus horários";
                        header("Location: ../views/profissional/horarios/cadastrar_horarios.php");
                        exit;
                    }

                    header("Location: ../views/profissional/home.php");
                    exit;

                } else {
                    header("Location: ../views/administrador/home.php");
                    exit;
                }

            } else {
                $_SESSION['error'] = "CPF ou senha incorretos!";
                header("Location: ../views/index.php");
                exit;
            }
        }

        public function salvar() {
            $cpf = trim($_POST['cpf']);
            $cpf = str_replace(['.', '-'], '', $cpf);
            $password = $_POST['password'];
            $passwordConfirmation = $_POST['passwordConfirmation'];
            $tipoUsuario = $_POST['tipoUsuario'];
            $statusUsuario = $_POST['status'];

            date_default_timezone_set('America/Sao_Paulo');
            $dataCriacao = date('Y-m-d H:i:s');

            if ($password !== $passwordConfirmation) {
                $_SESSION['error'] = "As senhas não coincidem!";
                exit;
            }

            if ($this->usuarioModel->buscarPorCPF($cpf)) {
                $_SESSION['error'] = "CPF já cadastrado!";
                header("Location: ../views/index.php");
                exit;
            }

            session_start();
            $_SESSION['cadastroTemp'] = [
                'cpf' => $cpf,
                'password' => $password,
                'tipoUsuario' => $tipoUsuario,
                'status' => $statusUsuario,
                'dataCriacao' => $dataCriacao
            ];

            $tipoLogado = $_SESSION['tipoUsuario'];

            if ($tipoLogado == 'admin') {
                if ($tipoUsuario == 'profissional') {
                    header("Location: ../views/administrador/cadastrar/profissional/cadastrar_profissional.php");
                    exit;
                } else {
                    header("Location: ../views/administrador/cadastrar/paciente/cadastrar_paciente.php");
                    exit;
                }
            } else {
                header("Location: ../views/paciente/criar.php");
                exit;
            }
        }

        public function cadastrar() {
            session_start();
            $dadosUsuario = $_SESSION['cadastroTemp'];

            $cpf = $dadosUsuario['cpf'];
            $password = $dadosUsuario['password'];
            $tipoUsuario = $dadosUsuario['tipoUsuario'];
            $statusUsuario = $dadosUsuario['status'];
            $dataCriacao = $dadosUsuario['dataCriacao'];

            $senhaHash = $password;
            $criarUsuario = $this->usuarioModel->criarUsuario(
                $cpf, $senhaHash, $tipoUsuario,
                $statusUsuario, $dataCriacao
            );

            return $cpf;
        }

        public function editarUsuario() {
            $idUsuario = $_POST['idUsuario'];
            $cpf = $_POST['cpf'];
            $password = $_POST['password'];
            
            if (empty($cpf) || empty($password)) {
                echo "CPF e senha são obrigatórios!";
                return;
            }

            $resultado = $this->usuarioModel->editarUsuario($idUsuario, $cpf, $password);

            if ($resultado) {
                echo "Dados atualizados com sucesso!";
            } else {
                echo "Nenhuma alteração realizada ou erro ao atualizar.";
            }
        }

        public function exibirPerfil() {
            $idUsuario = $_SESSION['idUsuario'];
            $usuario = $this->usuarioModel->listarDadosUsuario($idUsuario);
            return $usuario;
        }
    }

    $controller = new UsuarioController($conn);

    if (isset($_POST['acao'])) {
        switch ($_POST['acao']) {
            case 'login':
                $controller->login();
                break;
            case 'salvarUsuario':
                $controller->salvar();
                break;
            case 'editarUsuario':
                $controller->editarUsuario();
                break;
            default:
                echo "Ação inválida";
                break;
        }
    }
?>
