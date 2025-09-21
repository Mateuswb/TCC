<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/models/Relatorio.php";

    class RelatorioController {
        private $relatorioModel;

        public function __construct($conn) {
            $this->relatorioModel = new Relatorio($conn);
        }

        # relatorios agendamentos da semana
        public function agendamentosJson() {
            $resultados = $this->relatorioModel->agendamentosPorDia();

            $labels = [];
            $valores = [];

            foreach ($resultados as $linha) {
                $labels[] = date("d/m", strtotime($linha['data_agendamento']));
                $valores[] = (int)$linha['total'];
            }

            header('Content-Type: application/json');
            echo json_encode([
                "labels" => $labels,
                "valores" => $valores
            ]);
            exit;
        }

        public function atendimentosSemanaJson() {
            $dados = $this->relatorioModel->relatorioAtendimentosSemana();
            header('Content-Type: application/json');
            echo json_encode($dados); 
            exit;
        }

        # relatorio dos 10 usuarios mais recentes
        public function usuariosMaisRecentes() {
            return $this->relatorioModel->usuariosMaisRecentes();
        }

        public function totalUsuarios() {
            return $this->relatorioModel->totalUsuarios();
        }
        
        public function totalPacientes() {
            return $this->relatorioModel->totalPacientes();
        }

        public function totalProfissionais() {
            return $this->relatorioModel->totalProfissionais();
        }


        # agendamentos consultas
        public function listarConsultas($idProfissional) {
            return $this->relatorioModel->listarConsultas($idProfissional);
        }

        public function totalConsultasProfissional($idProfissional) {
            return $this->relatorioModel->totalConsultasProfissional($idProfissional);
        }

        public function totalConsultasConcluidas($idProfissional) {
            return $this->relatorioModel->totalConsultasConcluidas($idProfissional);
        }

        public function totalConsultasCanceladas($idProfissional) {
            return $this->relatorioModel->totalConsultasCanceladas($idProfissional);
        }


    }

    $controller = new RelatorioController($conn);

    if (isset($_GET['acao'])) {
        switch ($_GET['acao']) {
            case 'agendamentosJson':
                $controller->agendamentosJson();
                break;
            case 'atendimentosSemanaJson':
                $controller->atendimentosSemanaJson();
                break;
        }
    }
?>