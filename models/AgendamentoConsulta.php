<?php
    class AgendamentoConsulta {
        private $conn;

        public function __construct($conn){
            $this->conn = $conn;
        }

        public function criarAgendamento(
            $idPaciente, $idHorarioProfissional, 
            $tipoConsulta, $anexo, 
            $horarioAgendamento, $diaAgendamento, $observacoes
        ) {
            $status = "agendada";
            $sql = "INSERT INTO agendamentos_consultas (
                        id_paciente, id_horario_profissional, tipo_consulta, anexo, 
                        status, horario_agendamento, dia_agendamento, observacoes
                    ) VALUES (
                        :idPaciente, :idHorarioProfissional, :tipoConsulta, :anexo, 
                        :status, :horarioAgendamento, :diaAgendamento, :observacoes
                    )";

            $query = $this->conn->prepare($sql);

            return $query->execute([
                ':idPaciente' => $idPaciente,
                ':idHorarioProfissional' => $idHorarioProfissional,
                ':tipoConsulta' => $tipoConsulta,
                ':anexo' => $anexo,
                ':status' => $status,
                ':horarioAgendamento' => $horarioAgendamento,
                ':diaAgendamento' => $diaAgendamento,
                ':observacoes' => $observacoes
            ]);
            // $query->debugDumpParams();
        }

        public function listarAgendamentosDoProfissional($idProfissional) {
            $hoje = date('Y-m-d');
            $sql = "SELECT a.id_agendamento,
                    a.status,
                    a.dia_agendamento AS dia,
                    a.horario_agendamento AS horario,
                    p.nome AS nome_paciente,
                    a.tipo_consulta AS servico
                FROM agendamentos_consultas a
                JOIN pacientes p 
                    ON a.id_paciente = p.id_paciente
                JOIN horarios_profissionais h 
                    ON a.id_horario_profissional = h.id_horario 
                WHERE h.id_profissional = :idProfissional
                AND a.status = 'agendada'
                ORDER BY a.dia_agendamento ASC, a.horario_agendamento ASC";
            $query = $this->conn->prepare($sql);
            $query->execute([
                ':idProfissional' => $idProfissional
            ]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function cancelarAgendamentoConsulta($idConsulta) {
            $sql = "UPDATE agendamentos_consultas 
                    SET status = 'cancelada' 
                    WHERE id_agendamento = :idConsulta";
            $query = $this->conn->prepare($sql);

            return $query->execute([
                'idConsulta' => $idConsulta
            ]);
        }

        public function finalizarAgendamentoConsulta($idConsulta) {
            $sql = "UPDATE agendamentos_consultas 
                    SET status = 'realizada' 
                    WHERE id_agendamento = :idConsulta";
            $query = $this->conn->prepare($sql);

            return $query->execute([
                'idConsulta' => $idConsulta
            ]);
        }

        public function getAgendamento($idAgendamento) {
            $stmt = $this->conn->prepare("
                    SELECT 
                        a.*, 
                        p.nome AS paciente_nome, 
                        p.email AS paciente_email,
                        e.id_encaminhamento,
                        e.id_exame,
                        e.observacoes AS encaminhamento_observacoes
                    FROM agendamentos_consultas a
                    INNER JOIN pacientes p 
                        ON a.id_paciente = p.id_paciente
                    INNER JOIN encaminhamentos e
                        ON e.id_agendamento_consulta = a.id_agendamento
                    WHERE a.id_agendamento = :idAgendamento");
            $stmt->execute(['idAgendamento' => $idAgendamento]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

    }
?>
