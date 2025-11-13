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
            $dataResultado = date('Y-m-d H:i:s');
            $arquivo = $_FILES['resultado_exame'];

            $resultadoExame = $this->resultadoExameModel->criarResultado(
                $idAgendamento, $dataResultado, $arquivo
            );
            
            session_start();
            if($resultadoExame){
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "Resultado do exame encaminhado com sucesso."
                ];
            }
            else{
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => "Erro ao enviar Resultado. Tente novamente."
                ];
            }
            header("Location: ../views/profissional/lancar_resultado_exames/listar_exames.php");
            exit;
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