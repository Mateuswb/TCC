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

            if ($sucesso) {
                echo "Horários cadastrados com sucesso!";
            } else {
                echo "Erro ao cadastrar os horários.";
            }
        }

        public function listarHorarios($idProfissional){
            return $this->horarioModel->listarHorarios($idProfissional);
        }

         public function editarHorarioProfissional() {
            $idProfissional   = $_POST['idProfissional'];
            $idHorario        = $_POST['idHorario'];
            $horaInicio       = $_POST['horaInicio'];
            $horaFim          = $_POST['horaFim'];
            $inicioIntervalo  = $_POST['inicioIntervalo'];
            $fimIntervalo     = $_POST['fimIntervalo'];


            $editar = $this->horarioModel->editarHorario( 
                    $horaInicio, $horaFim,
                    $inicioIntervalo, $fimIntervalo,
                    $idProfissional, $idHorario
            );
            if ($editar) {
                echo "Horários editados com sucesso!";
            } else {
                echo "Erro ao editadar os horários.";
            }
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