<?php
    class AgendamentoExame {
        private $conn;

        public function __construct($conn){
            $this->conn = $conn;
        }

        public function criarAgendamento(
            $idEncaminhamento, $horarioAgendamento, $diaAgendamento, $observacoes
        ) {
            $status = "agendado";
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

        public function editarAgendamentoExame(
            $idEncaminhamento, $status, 
            $horarioAgendamento, $diaAgendamento, $observacoes
        ) {
            $sql = "UPDATE agendamentos_exames SET
                        status = :status,
                        horario_agendamento = :horarioAgendamento,
                        dia_agendamento  = :diaAgendamento,
                        observacoes
                        WHERE id_encaminhamento = :idEncaminhamento";
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
