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
                $inicio  = trim($horaInicio[$i] ?? '');
                $fim     = trim($horaFim[$i] ?? '');
                $iInicio = trim($inicioIntervalo[$i] ?? '');
                $iFim    = trim($fimIntervalo[$i] ?? '');

                if (empty($inicio) && empty($fim) && empty($iInicio) && empty($iFim)) {
                    continue;
                }

                if (empty($inicio) || empty($fim)) {
                    continue;
                }

                $cadastro = $this->horarioModel->cadastrarHorario(
                    $idProfissional,
                    $diaSemana[$i],
                    $inicio,
                    $fim,
                    $iInicio ?: null,
                    $iFim ?: null
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
            $idHorario        = $_POST['idHorario'] ?? [];
            $diaSemana        = $_POST['diaSemana'] ?? [];
            $horaInicio       = $_POST['horaInicio'] ?? [];
            $horaFim          = $_POST['horaFim'] ?? [];
            $inicioIntervalo  = $_POST['inicioIntervalo'] ?? [];
            $fimIntervalo     = $_POST['fimIntervalo'] ?? [];

            $sucesso = true;

            session_start();
            for ($i = 0; $i < count($diaSemana); $i++) {

                $id = $idHorario[$i] ?? null;
                $inicio = $horaInicio[$i] ?? null;
                $fim = $horaFim[$i] ?? null;
                $iInicio = $inicioIntervalo[$i] ?? null;
                $iFim = $fimIntervalo[$i] ?? null;

                if (empty($inicio) && empty($fim) && empty($iInicio) && empty($iFim)) {
                    if ($id) {
                        $ok = $this->horarioModel->deletarHorario($id);
                        if (!$ok) {
                            $sucesso = false;
                            break;
                        }
                    }
                    continue;
                }

                if (!empty($id)) {
                    $ok = $this->horarioModel->editarHorario(
                        $inicio, $fim, $iInicio, $iFim, $id
                    );
                }
                // cadastra o novo horario
                else {
                    $ok = $this->horarioModel->cadastrarHorario(
                        $idProfissional,
                        $diaSemana[$i],
                        $inicio,
                        $fim,
                        $iInicio,
                        $iFim
                    );
                }

                if (!$ok) {
                    $sucesso = false;
                    break;
                }
            }

            if($ok){
                
                 $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "Horários atualizados com sucesso."
                ];
            }
            else{
                 $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => "Erro ao atualizar horarios. Tente novamente"
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