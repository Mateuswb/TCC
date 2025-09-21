<?php

    class Encaminhamento{
        private $conn;

        public function __construct($conn){
            $this->conn = $conn;
        }

        public function cadastrarEncaminhamento($exameID, $observacoes, $agendamentoConsultaId) {
            // Coloque o nome da tabela no INSERT INTO
            $sql = "INSERT INTO encaminhamentos (id_exame, observacoes, id_agendamento_consulta) 
                    VALUES (:idExame, :observacoes, :idAgendamentoConsulta)";

            $query = $this->conn->prepare($sql);

            $resultado = $query->execute([
                'idExame' => $exameID,
                'observacoes' => $observacoes,
                'idAgendamentoConsulta' => $agendamentoConsultaId
            ]);

            return $resultado;
        }

    }

?>