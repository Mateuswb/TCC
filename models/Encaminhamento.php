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

        public function trocarStatus($idEncaminhamento){
            $sql =  "UPDATE encaminhamentos SET
                        status = 'agendado'
                        WHERE id_encaminhamento = :idEncaminhamento";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'idEncaminhamento' => $idEncaminhamento
            ]);
        }

        public function trocarStatusConcluido($idEncaminhamento) {
            $sql = "UPDATE encaminhamentos 
                    SET status = 'concluido' 
                    WHERE id_encaminhamento = :idEncaminhamento";
            $query = $this->conn->prepare($sql);

            return $query->execute([
                ':idEncaminhamento' => $idEncaminhamento
            ]);
        }
        public function buscarIdEncaminhamentoPorExame($idExame) {
            $sql = "SELECT id_encaminhamento 
                    FROM agendamentos_exames 
                    WHERE id_agendamento = :idAgendamentoExame";
            $query = $this->conn->prepare($sql);
            $query->execute([':idAgendamentoExame' => $idExame]);
            return $query->fetchColumn();
        }


        public function cancelarEncaminhamento($idEncaminhamento) {
            $sql = "UPDATE encaminhamentos 
                    SET status = 'cancelado'
                    WHERE id_encaminhamento = :idEncaminhamento";

            $query = $this->conn->prepare($sql);
            $query->execute([
                'idEncaminhamento' => $idEncaminhamento
            ]);
            return $query;
        }


        public function reencaminharExame($idEncaminhamento, $idExame, $observacoes){
            $sql = " UPDATE encaminhamentos
                        SET id_exame = :idExame,
                        observacoes = :observacoes,
                        status = 'pendente'
                    WHERE id_encaminhamento = :idEncaminhamento";

            $query = $this->conn->prepare($sql);
            $query->execute([
                'idEncaminhamento' => $idEncaminhamento,
                'idExame'          =>  $idExame,
                'observacoes'      => $observacoes
            ]);

            return $query;
        }

        public function listarEncaminhamentosProfissioal($profissionalId){
            $sql = "SELECT 
                    e.id_encaminhamento,
                    e.id_exame,
                    ex.nome AS nome_exame,
                    e.observacoes,
                    e.status AS status_encaminhamento,
                    ac.dia_agendamento,
                    ac.horario_agendamento,
                    p.nome AS nome_paciente,
                    pr.nome AS profissional_encaminhou,
                    ac.id_agendamento,
                    ae.id_agendamento AS id_agendamento_exame
                FROM encaminhamentos e
                INNER JOIN agendamentos_consultas ac 
                    ON e.id_agendamento_consulta = ac.id_agendamento
                INNER JOIN pacientes p 
                    ON ac.id_paciente = p.id_paciente
                INNER JOIN horarios_profissionais hp 
                    ON ac.id_horario_profissional = hp.id_horario
                INNER JOIN profissionais pr 
                    ON hp.id_profissional = pr.id_profissional
                INNER JOIN tipos_exames ex 
                    ON e.id_exame = ex.id_exame
                LEFT JOIN agendamentos_exames ae 
                    ON ae.id_encaminhamento = e.id_encaminhamento
                WHERE pr.id_profissional = :idProfissional
                ORDER BY e.id_encaminhamento DESC";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'idProfissional' => $profissionalId
            ]);

            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>