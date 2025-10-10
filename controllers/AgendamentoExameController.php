<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/models/AgendamentoExame.php"; 


    class AgendamentoExameController {
        private $agendamentoExameModel;

        public function __construct($conn){
            $this->agendamentoExameModel = new AgendamentoExame($conn);
     
        }

        public function agendarExame(){
            $idEncaminhamento = $_POST['idEncaminhamento']; 
            $status = $_POST['status']; 
            $horarioAgendamento = $_POST['horarioAgendamento']; 
            $diaAgendamento = $_POST['diaAgendamento']; 
            $observacoes = $_POST['observacoes']; 

            $agendar = $this->agendamentoExameModel->criarAgendamento(
                $idEncaminhamento, $status, $horarioAgendamento.
                $diaAgendamento, $observacoes
            );

            if($agendar){
                echo "Exame agendado";
            }
            else{
                echo "Errooo no agendamento";
            }
        }

        public function editarExame(){
            $idEncaminhamento = $_POST['idEncaminhamento']; 
            $status = $_POST['status']; 
            $horarioAgendamento = $_POST['horarioAgendamento']; 
            $diaAgendamento = $_POST['diaAgendamento']; 
            $observacoes = $_POST['observacoes']; 

            $editar = $this->agendamentoExameModel->editarAgendamentoExame(
                $idEncaminhamento, $status, $horarioAgendamento.
                $diaAgendamento, $observacoes
            );

            if($ediar){
                echo "editado";
            }
            else{
                echo "erro ao editar";
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
            default:
                echo "Ação inválida";
                break;
        }
    }
?>