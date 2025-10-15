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
                         id_encaminhamento, status, horario_agendamento, 
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

        public function cancelarAgendamentoExame($idExame) {
            $sql = "UPDATE agendamentos_exames
                    SET status = 'cancelada' 
                    WHERE id_agendamento = :idExame";
            $query = $this->conn->prepare($sql);

            return $query->execute([
                'idExame' => $idExame
            ]);
        }

        public function listarAgendamentosExame($idPaciente){
            $sql = "SELECT 
                    ae.id_agendamento,
                    te.nome AS nome_exame,
                    te.descricao AS descricao_exame,
                    ae.status AS status_agendamento,
                    ae.dia_agendamento,
                    ae.horario_agendamento,
                    ae.observacoes AS observacoes_agendamento,
                    p.nome AS nome_paciente,
                    pr.nome AS nome_profissional,
                    pr.email AS email_profissional
                FROM agendamentos_exames ae
                INNER JOIN encaminhamentos e ON ae.id_encaminhamento = e.id_encaminhamento
                INNER JOIN tipos_exames te ON e.id_exame = te.id_exame
                INNER JOIN agendamentos_consultas ac ON e.id_agendamento_consulta = ac.id_agendamento
                INNER JOIN pacientes p ON ac.id_paciente = p.id_paciente
                INNER JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                INNER JOIN profissionais pr ON hp.id_profissional = pr.id_profissional
                WHERE p.id_paciente = :idPaciente AND ae.status = 'agendado'
                ORDER BY ae.dia_agendamento DESC, ae.horario_agendamento ASC";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'idPaciente' => $idPaciente
            ]);

            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function historicoAgendamentosExame($idPaciente){
            $sql = "SELECT 
                    ae.id_agendamento,
                    te.nome AS nome_exame,
                    te.categoria AS nome_categoria,
                    te.descricao AS descricao_exame,
                    ae.status AS status_agendamento,
                    ae.dia_agendamento,
                    ae.horario_agendamento,
                    ae.observacoes AS observacoes_agendamento,
                    p.nome AS nome_paciente,
                    pr.nome AS nome_profissional,
                    pr.email AS email_profissional
                FROM agendamentos_exames ae
                INNER JOIN encaminhamentos e ON ae.id_encaminhamento = e.id_encaminhamento
                INNER JOIN tipos_exames te ON e.id_exame = te.id_exame
                INNER JOIN agendamentos_consultas ac ON e.id_agendamento_consulta = ac.id_agendamento
                INNER JOIN pacientes p ON ac.id_paciente = p.id_paciente
                INNER JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                INNER JOIN profissionais pr ON hp.id_profissional = pr.id_profissional
                WHERE p.id_paciente = :idPaciente AND ae.status != 'agendado'
                ORDER BY ae.dia_agendamento DESC, ae.horario_agendamento ASC";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'idPaciente' => $idPaciente
            ]);

            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        

    }
?>
