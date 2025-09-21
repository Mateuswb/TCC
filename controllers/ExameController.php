<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/models/Exame.php";

    class ExameController {
        private $exameModel;

        public function __construct($conn) {
            $this->exameModel = new Exame($conn);
        }

        public function listarExames(){
            return $this->exameModel->listarExames();
        }

        public function pegarExame(){
            return $this->exameModel->pegarExame();
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
?>