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

       public function agendarConsulta(){
            session_start();

            try {
                $idProfissional        = $_POST['idProfissional'];
                $idPaciente            = $_POST['idPaciente'];
                $tipoConsulta          = $_POST['tipoConsulta'];
                $horarioAgendamento    = explode(' - ', $_POST['horarioAgendamento'])[0];
                $diaAgendamento        = $_POST['diaAgendamento'];
                $observacao            = $_POST['observacao'] ?? null;

                // Recupera o ID do horário do profissional
                $idHorarioProfissional = $this->horarioModel->recuperaIdHorario($diaAgendamento, $idProfissional);

                $anexo = null;

                // Só salva anexo se for retorno
                if ($tipoConsulta === "r" && !empty($_FILES['anexo']) && $_FILES['anexo']['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES['anexo']['name'], PATHINFO_EXTENSION));
                    $permitidas = ['pdf', 'jpg', 'jpeg', 'png'];

                    if (!in_array($ext, $permitidas)) {
                        throw new Exception("Tipo de arquivo inválido. Use PDF ou imagem.");
                    }

                    $anexo = file_get_contents($_FILES['anexo']['tmp_name']);
                }

                $agendar = $this->agendamentoConsultaModel->criarAgendamento(
                    $idPaciente,
                    $idHorarioProfissional,
                    $tipoConsulta,
                    $anexo,
                    $horarioAgendamento,
                    $diaAgendamento,
                    $observacao
                );

                if ($agendar) { 
                    $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Consulta Agendada com sucesso'
                    ];
                } 
                else {
                    $_SESSION['flash'] = [ 
                    'type' => 'error', 
                    'message' => 'Erro ao agendar Consulta, Tente novamente' 
                ]; }

            } catch (Exception $e) {
                $_SESSION['flash'] = [
                    'type' => 'error', 
                    'message' => "Erro ao agendar consulta: " . $e->getMessage()
                ];
            }
            header("Location: ../views/paciente/consultas/listar_profissionais.php");
            exit;
        }

        
       
        public function editarConsulta() {
            $idAgendamento         = $_POST['idAgendamentoConsulta'];
            $tipoConsulta          = $_POST['tipoConsulta'];
            $horarioAgendamento    = $_POST['horarioAgendamento'];
            $diaAgendamento        = $_POST['diaAgendamento'];
            $observacao            = $_POST['observacao'] ?? null;
            $anexo = null;

            // Só salva anexo se for retorno
           if ($tipoConsulta === "r" && !empty($_FILES['anexo']) && $_FILES['anexo']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['anexo']['name'], PATHINFO_EXTENSION));
                $permitidas = ['pdf', 'jpg', 'jpeg', 'png'];
                if (!in_array($ext, $permitidas)) {
                    throw new Exception("Tipo de arquivo inválido. Use PDF ou imagem.");
                }

                $anexo = file_get_contents($_FILES['anexo']['tmp_name']);
            }

            $editar = $this->agendamentoConsultaModel->editarConsulta(
                $idAgendamento,
                $tipoConsulta,
                $anexo,     
                $horarioAgendamento,
                $diaAgendamento,
                $observacao
            );

            session_start();
            if ($editar) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Consulta editada com sucesso!'
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao editar consulta.'
                ];
            }

            header("Location: ../views/paciente/consultas/consultas_agendadas.php");
            exit;
        }

        public function cancelarConsulta(){
            $idAgendamento = $_POST['idAgendamento'];

            $cancelar = $this->agendamentoConsultaModel->cancelarAgendamentoConsulta($idAgendamento);

            if($cancelar){
                echo "Cancelado";
            }
            else{
                echo "erro";
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
            case 'editarConsulta':
                $controller->editarConsulta();
                break;
            case 'cancelarConsulta':
                $controller->cancelarConsulta();
                break;
            default:
                echo "Ação inválida";
                break;
        }
    }
?>
