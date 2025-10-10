<?php
    class Encaminhamento{
        private $conn;

        public function __construct($conn){
            $this->conn = $conn;
        }

        public function cadastrarEncaminhamento($exameID, $observacoes, $agendamentoConsultaId) {
            $status = 'pendente';
            $sql = "INSERT INTO encaminhamentos (id_exame, observacoes, id_agendamento_consulta, status) 
                    VALUES (:idExame, :observacoes, :idAgendamentoConsulta, :status)";

            $query = $this->conn->prepare($sql);

            $resultado = $query->execute([
                'idExame' => $exameID,
                'observacoes' => $observacoes,
                'idAgendamentoConsulta' => $agendamentoConsultaId,
                'status' => $status
            ]);

            return $resultado;
        }


        public function listarEncaminhamentosPorPaciente($pacienteID) {
            $sql = "
                SELECT 
                    ac.id_paciente,
                    e.id_encaminhamento,
                    te.nome AS exame,
                    p.nome AS profissional_encaminhou
                FROM encaminhamentos e
                INNER JOIN tipos_exames te 
                    ON e.id_exame = te.id_exame
                INNER JOIN agendamentos_consultas ac 
                    ON e.id_agendamento_consulta = ac.id_agendamento
                INNER JOIN horarios_profissionais hp 
                    ON ac.id_horario_profissional = hp.id_horario
                INNER JOIN profissionais p 
                    ON hp.id_profissional = p.id_profissional
                    WHERE ac.id_paciente = :id_paciente AND
                    e.status = 'pendente'
                ORDER BY ac.id_paciente
            ";

            $query = $this->conn->prepare($sql);
            $query->execute([
                'id_paciente' => $pacienteID
            ]);

            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>