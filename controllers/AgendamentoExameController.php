<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/models/AgendamentoExame.php"; 


    class AgendamentoConsultaController {
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
    }
?>