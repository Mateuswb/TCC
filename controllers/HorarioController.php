<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/models/HorarioProfissional.php";

    class HorarioController {
        private $horarioModel;

        public function __construct($conn) {
            $this->horarioModel = new Horario($conn);
        }

        public function cadastrarHorarios() {
            $idProfissional   = $_POST['idProfissional'];
            $diaSemana        = $_POST['diaSemana'] ?? [];
            $horaInicio       = $_POST['horaInicio'] ?? [];
            $horaFim          = $_POST['horaFim'] ?? [];
            $inicioIntervalo  = $_POST['inicioIntervalo'] ?? [];
            $fimIntervalo     = $_POST['fimIntervalo'] ?? [];

            $sucesso = true;
            for ($i = 0; $i < count($diaSemana); $i++) {
                $cadastro = $this->horarioModel->cadastrarHorario(
                    $idProfissional,
                    $diaSemana[$i],
                    $horaInicio[$i] ?? null,
                    $horaFim[$i] ?? null,
                    $inicioIntervalo[$i] ?? null,
                    $fimIntervalo[$i] ?? null
                );

                if (!$cadastro) {
                    $sucesso = false;
                }
            }

            session_start();
            if ($sucesso) {
                 $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "Horários cadastrados com sucesso"
                ];
            } else {
                 $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => "Erro ao cadastrar horarios. Tente novamente"
                ];
            }
            header("Location: ../views/profissional/home.php"); 
            exit;
        }

        public function listarHorarios($idProfissional){
            return $this->horarioModel->listarHorarios($idProfissional);
        }

        public function buscarLimitesDeHorario($idProfissional){
            return $this->horarioModel->buscarLimitesDeHorario($idProfissional);
        }

        public function editarHorarioProfissional() {
            $idProfissional   = $_POST['idProfissional'];
            $idHorario        = $_POST['idHorario'] ?? null;
            $diaSemana        = $_POST['diaSemana'] ?? [];
            $horaInicio       = $_POST['horaInicio'];
            $horaFim          = $_POST['horaFim'];
            $inicioIntervalo  = $_POST['inicioIntervalo'];
            $fimIntervalo     = $_POST['fimIntervalo'];

            if ($idHorario) {
                $sucesso = $this->horarioModel->editarHorario( 
                    $horaInicio, $horaFim,
                    $inicioIntervalo, $fimIntervalo, $idHorario
                );
            } else {
                $sucesso = $this->horarioModel->cadastrarHorario(
                    $idProfissional, $diaSemana, $horaInicio, $horaFim,
                    $inicioIntervalo, $fimIntervalo
                );
            }

            session_start();
            if ($sucesso) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => $idHorario ? "Horário editado com sucesso" : "Horário adicionado com sucesso"
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => "Erro ao salvar horários. Tente novamente"
                ];
            }

            header("Location: ../views/profissional/horarios/listar_horarios.php"); 
            exit;
        }


        public function verificaHorario($profissionalId){
            return $this->horarioModel->verificaHorario($profissionalId);
        }
    }

    $controller = new HorarioController($conn);

    if (isset($_GET['acao'])) {
        switch ($_GET['acao']) {
            case 'cadastrarHorarios':
                $controller->cadastrarHorarios();
                break;
            case 'editarHorario':
                $controller->editarHorarioProfissional();
                break;
            default:
                echo "Ação inválida";
                break;
        }
    }
?>