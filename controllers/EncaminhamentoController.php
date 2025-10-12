<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . '/models/Encaminhamento.php';

    class EncaminhamentoController {
        private $encaminhamentoModel;

        public function __construct($conn) {
            $this->encaminhamentoModel = new Encaminhamento($conn);
        }
       
        function listarEncaminhamentosPorPaciente($pacienteId){
            return $this->encaminhamentoModel->listarEncaminhamentosPorPaciente($pacienteId);
        }

    }
?>