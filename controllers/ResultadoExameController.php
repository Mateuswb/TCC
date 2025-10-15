<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/models/ResultadoExame.php";

    class ResultadoExameController {

        private $resultadoExameModel;

        public function __construct($conn) {
            $this->resultadoExameModel = new ResultadoExame($conn);
        }

        public function listarExamesPendentes($ProfissionalId) {
            return  $this->resultadoExameModel->listarExamesPendentes($ProfissionalId);
        }

        public function enviarResultadoExame() {
            $idAgendamento = $_POST['idAgendamento'];
            $dataResultado = date('Y-m-d H:i:s'); // gera a data atual
            $arquivo = $_FILES['resultado_exame'];

            $resultadoExame = $this->resultadoExameModel->criarResultado(
                $idAgendamento, $dataResultado, $arquivo
            );
            
            if($resultadoExame){
                echo "----encaminhou---";
            }
            else{
                echo "erro";
            }
        }

        public function listarResultadosPorPaciente($PacienteId){
            return $this->resultadoExameModel->listarResultadosPorPaciente($PacienteId);
        }

        public function buscarArquivoResultado($idResultado){
            return $this->resultadoExameModel->buscarArquivoResultado($idResultado);
        }
    }   

    $controller = new ResultadoExameController($conn);

    if (isset($_GET['acao'])) {
        switch ($_GET['acao']) {
            case 'enviarResultadoExame':
                $controller->enviarResultadoExame();
        }
    }
?>