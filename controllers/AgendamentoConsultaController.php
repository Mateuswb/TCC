<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/models/AgendamentoConsulta.php"; 
    require_once dirname(__DIR__) . "/models/Paciente.php";
    require_once dirname(__DIR__) . "/models/HorarioProfissional.php";

    class AgendamentoConsultaController {
        private $pacienteModel;
        private $agendamentoConsultaModel;
        private $horarioModel;

        public function __construct($conn){
            $this->pacienteModel = new Paciente($conn);
            $this->agendamentoConsultaModel = new AgendamentoConsulta($conn);
            $this->horarioModel = new Horario($conn);
        }

        public function agendarConsulta() {
            $idProfissional        = $_POST['idProfissional'];
            $idPaciente            = $_POST['idPaciente'];
            $tipoConsulta          = $_POST['tipoConsulta'];
            $anexoConteudo         = null;
            $status                = $_POST['status'];
            $horarioAgendamento    = $_POST['horarioAgendamento'];
            $diaAgendamento        = $_POST['diaAgendamento'];
            $observacao            = $_POST['observacao'] ?? null;
            $idHorarioProfissional = $this->horarioModel->recuperaIdHorario($diaAgendamento, $idProfissional);

            // Só salva anexo se for retorno
            if ($tipoConsulta === "r" && isset($_FILES['anexo']) && $_FILES['anexo']['error'] === UPLOAD_ERR_OK){
                $anexoConteudo = file_get_contents($_FILES['anexo']['tmp_name']);
            }

            $agendar = $this->agendamentoModel->criarAgendamento(
                $idPaciente,
                $idHorarioProfissional,
                $tipoConsulta,
                $anexoConteudo,
                $status,
                $horarioAgendamento,
                $diaAgendamento,
                $observacao
            );

            if($agendar){
                echo "Agendou !!!!!!!!!!";
                // header("Location: ../views/paciente/home.php");
                exit;
            }
            else{
                echo "Erro";
            }
        }

        public function listarAgendamentosDoProfissional($idProfissional) {
            return $this->agendamentoConsultaModel->listarAgendamentosDoProfissional($idProfissional);
        }

    }
    
    $controller = new AgendamentoConsultaController($conn);
    if (isset($_GET['acao'])) {
        switch ($_GET['acao']) {
            case 'agendarConsulta':
                $controller->agendarConsulta();
                break;
            default:
                echo "Ação inválida";
                break;
        }
    }
?>
