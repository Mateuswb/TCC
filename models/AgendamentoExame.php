<?php
    class AgendamentoExame {
        private $conn;

        public function __construct($conn){
            $this->conn = $conn;
        }

        public function criarAgendamento(
            $idEncaminhamento, $status, 
            $horarioAgendamento, $diaAgendamento, $observacoes
        ) {
            $sql = "INSERT INTO agendamentos_exames (
                         id_encaminhamentos, status, horario_agendamento, 
                         dia_agendamento, observacoes
                    ) VALUES (
                        :idEncaminhamento, :status, :horarioAgendamento, 
                        :diaAgendamento, :observacoes
                    )";

            $query = $this->conn->prepare($sql);

            return $query->execute([
                ':idEncaminhamento' => $idEncaminhamento,
                ':status' => $status,
                ':horarioAgendamento' => $horarioAgendamento,
                ':diaAgendamento' => $diaAgendamento,
                ':observacoes' => $observacoes
            ]);
        }
    }
?>
