<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/models/Exame.php";
    require_once dirname(__DIR__) . "/models/HorarioProfissional.php";

    class ExameController {
        private $exameModel;
        private $horarioModel;

        public function __construct($conn) {
            $this->exameModel = new Exame($conn);
            $this->horarioModel = new Horario($conn);
        }

        public function listarExames(){
            return $this->exameModel->listarExames();
        }

        public function pegarExame(){
            return $this->exameModel->pegarExame();
        }

        public function exibirHorarios($dataSelecionada, $exame) {
            $horariosDisponiveis = $this->horarioModel->listarHorariosDisponiveisExame($dataSelecionada, $exame);
            header('Content-Type: application/json');
            echo $horariosDisponiveis;
        }

    }

    $controller = new ExameController($conn);

    if (isset($_GET['acao'])) {
        switch ($_GET['acao']) {
            default:
                echo "Ação inválida";
                break;
        }
    }

    if (isset($_POST['data'])) {
        $dataSelecionada = $_POST['data'];
        $exame = $_POST['exame'];
        $controller->exibirHorarios($dataSelecionada, $exame);
    }
?>