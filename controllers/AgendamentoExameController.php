<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/models/AgendamentoExame.php"; 
    require_once dirname(__DIR__) . "/models/Encaminhamento.php"; 


    class AgendamentoExameController {
        private $agendamentoExameModel;
        private $encaminhamentoModel;

        public function __construct($conn){
            $this->agendamentoExameModel = new AgendamentoExame($conn);
            $this->encaminhamentoModel = new Encaminhamento($conn);
        }

        public function agendarExame(){
            $idEncaminhamento = $_POST['idEncaminhamento']; 
            $horarioAgendamento = $_POST['horarioAgendamento']; 
            $diaAgendamento = $_POST['diaAgendamento']; 
            $observacao = $_POST['observacao']; 

            $agendar = $this->agendamentoExameModel->criarAgendamento(
                $idEncaminhamento, $horarioAgendamento,
                $diaAgendamento, $observacao
            );

            session_start();
            if($agendar){
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Exame agendado com sucesso'
                    ];
                $encaminhamento = $this->encaminhamentoModel->trocarStatus($idEncaminhamento);
            }
            else{
                $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Erro ao realizar agendamento. Tente novamente.'
                ];
            }
            header("Location: ../views/paciente/exames/encaminhamento/listar_encaminhamentos.php");
            exit;
        }

        public function editarExame(){
            $idEncaminhamento = $_POST['idEncaminhamento']; 
            $status = $_POST['status']; 
            $horarioAgendamento = $_POST['horarioAgendamento']; 
            $diaAgendamento = $_POST['diaAgendamento']; 
            $observacoes = $_POST['observacoes']; 

            $editar = $this->agendamentoExameModel->editarAgendamentoExame(
                $idEncaminhamento, $status, $horarioAgendamento,
                $diaAgendamento, $observacoes
            );

            if($editar){
                echo "editado";
            }
            else{
                echo "erro ao editar";
            }
        }

        public function cancelarExame(){
            $idAgendamento = $_POST['idAgendamento'];

            $cancelar = $this->agendamentoExameModel->cancelarAgendamentoExame($idAgendamento);

            session_start();
            if($cancelar){
                $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Exame cancelado com sucesso'
                ];
            }
            else{
                $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Erro cancelar exame. Tente novamente.'
                ];
            }
            header("Location: ../views/paciente/exames/exames_agendados/listar_agendamentos.php");
            exit;
        }

        public function finalizarAgendamentoExame(){
            $idExame = $_POST['idExame'];

            $finalizar = $this->agendamentoExameModel->finalizarAgendamentoConsulta($idExame);
            if($finalizar){
                echo "Exame finalizado";
            }
            else{
                echo "Erro ao finalizar Exmae";
            }
        }

    }

    $controller = new AgendamentoExameController($conn);
    if (isset($_GET['acao'])) {
        switch ($_GET['acao']) {
            case 'agendarExame':
                $controller->agendarExame();
                break;
            case 'editarExame':
                $controller->editarExame();
                break;
            case 'cancelarExame':
                $controller->cancelarExame();
                break;
            case 'finalizarAgendamentoExame':
                $controller->finalizarAgendamentoExame();
                break;
            default:
                echo "Ação inválida";
                break;
        }
    }
?>