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
            $diasSemana       = $_POST['diasSemana'] ?? [];
            $horaInicio       = $_POST['horaInicio'][0] ?? null;
            $horaFim          = $_POST['horaFim'][0] ?? null;
            $inicioIntervalo  = $_POST['inicioIntervalo'][0] ?? null;
            $fimIntervalo     = $_POST['fimIntervalo'][0] ?? null;

            $sucesso = true;
            foreach ($diasSemana as $dia) {
                $cadastro = $this->horarioModel->cadastrarHorario(
                    $idProfissional,
                    $dia,
                    $horaInicio,
                    $horaFim,
                    $inicioIntervalo,
                    $fimIntervalo
                );

                if (!$cadastro) {
                    $sucesso = false;
                    break;
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
            case 'cadastrarHorario':
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