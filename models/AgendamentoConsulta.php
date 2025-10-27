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
            $resutado = $query->execute([
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
            return $resutado;
        }

        public function editarConsulta(
            $idAgendamento,
            $tipoConsulta,
            $anexo,
            $horarioAgendamento,
            $diaAgendamento,
            $observacoes
        ) {
            $sql = "UPDATE agendamentos_consultas SET
                        tipo_consulta = :tipoConsulta,
                        anexo = :anexo,
                        horario_agendamento = :horarioAgendamento,
                        dia_agendamento = :diaAgendamento,
                        observacoes = :observacoes
                    WHERE id_agendamento = :idAgendamento";

            $query = $this->conn->prepare($sql);

            $result = $query->execute([
                ':idAgendamento' => $idAgendamento,
                ':tipoConsulta' => $tipoConsulta,
                ':anexo' => $anexo,
                ':horarioAgendamento' => $horarioAgendamento,
                ':diaAgendamento' => $diaAgendamento,
                ':observacoes' => $observacoes
            ]);
            
            return $result;
        }

        public function listarAgendamentosDoProfissional($idProfissional) {
            $sql = "SELECT 
                        a.id_agendamento,
                        'consulta' AS tipo,
                        a.status,
                        a.dia_agendamento AS dia,
                        a.horario_agendamento AS horario,
                        p.nome AS nome_paciente,
                        a.tipo_consulta,
                        a.anexo,
                        NULL AS nome_exame
                    FROM agendamentos_consultas a
                    JOIN pacientes p ON a.id_paciente = p.id_paciente
                    JOIN horarios_profissionais h ON a.id_horario_profissional = h.id_horario
                    WHERE h.id_profissional = :idProfissional
                    AND a.status = 'agendada'

                    UNION ALL

                    -- Agendamentos de exames
                    SELECT 
                        e.id_agendamento,
                        'exame' AS tipo,
                        e.status,
                        e.dia_agendamento AS dia,
                        e.horario_agendamento AS horario,
                        p.nome AS nome_paciente,
                        NULL AS tipo_consulta,
                        NULL AS anexo,
                        te.nome AS nome_exame
                    FROM agendamentos_exames e
                    JOIN encaminhamentos enc ON e.id_encaminhamento = enc.id_encaminhamento
                    JOIN agendamentos_consultas a ON enc.id_agendamento_consulta = a.id_agendamento
                    JOIN pacientes p ON a.id_paciente = p.id_paciente
                    JOIN horarios_profissionais h ON a.id_horario_profissional = h.id_horario
                    JOIN tipos_exames te ON enc.id_exame = te.id_exame
                    WHERE h.id_profissional = :idProfissional
                    AND e.status != 'cancelado'";
            $query = $this->conn->prepare($sql);
            $query->execute([
                ':idProfissional' => $idProfissional,
                ':idProfissional' => $idProfissional
            ]);

            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function cancelarAgendamentoConsulta($idConsulta) {
            $sql = "UPDATE agendamentos_consultas 
                    SET status = 'cancelada' 
                    WHERE id_agendamento = :idConsulta";
            $query = $this->conn->prepare($sql);

            $query->execute([
                'idConsulta' => $idConsulta
            ]);
            return $query;
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
                        pr.nome AS nome_profissional,
                        p.email AS paciente_email,
                        e.id_encaminhamento,
                        e.id_exame,
                        te.nome AS nome_exame,
                        e.observacoes AS encaminhamento_observacoes
                    FROM agendamentos_consultas a
                    INNER JOIN pacientes p 
                        ON a.id_paciente = p.id_paciente
                    INNER JOIN horarios_profissionais hp ON a.id_horario_profissional = hp.id_horario
                    INNER JOIN profissionais pr ON hp.id_profissional = pr.id_profissional
                    INNER JOIN encaminhamentos e ON e.id_agendamento_consulta = a.id_agendamento
                    INNER JOIN tipos_exames te ON e.id_exame = te.id_exame
                    WHERE a.id_agendamento = :idAgendamento");
            $stmt->execute(['idAgendamento' => $idAgendamento]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        # agendamentos do admin
        public function listarAgendamentos(){
            $sql = "SELECT 
                    a.id_agendamento,
                    'consulta' AS tipo,
                    a.status,
                    a.dia_agendamento AS dia,
                    a.horario_agendamento AS horario,
                    p.nome AS nome_paciente,
                    a.tipo_consulta,
                    a.anexo,
                    NULL AS nome_exame
                FROM agendamentos_consultas a
                JOIN pacientes p ON a.id_paciente = p.id_paciente
                JOIN horarios_profissionais h ON a.id_horario_profissional = h.id_horario
                WHERE a.status = 'agendada'

                UNION ALL

                -- Agendamentos de exames
                SELECT 
                    e.id_agendamento,
                    'exame' AS tipo,
                    e.status,
                    e.dia_agendamento AS dia,
                    e.horario_agendamento AS horario,
                    p.nome AS nome_paciente,
                    NULL AS tipo_consulta,
                    NULL AS anexo,
                    te.nome AS nome_exame
                FROM agendamentos_exames e
                JOIN encaminhamentos enc ON e.id_encaminhamento = enc.id_encaminhamento
                JOIN agendamentos_consultas a ON enc.id_agendamento_consulta = a.id_agendamento
                JOIN pacientes p ON a.id_paciente = p.id_paciente
                JOIN horarios_profissionais h ON a.id_horario_profissional = h.id_horario
                JOIN tipos_exames te ON enc.id_exame = te.id_exame
                WHERE e.status != 'cancelado'";

            $query = $this->conn->prepare($sql);
            $query->execute(); 

            return $query->fetchAll(PDO::FETCH_ASSOC);
        }


        public function listarAgendamentosConsulta($idPaciente){
            $sql = "SELECT 
                        ac.*, 
                        p.nome AS nome_profissional,
                        p.id_profissional as id_profissional
                    FROM agendamentos_consultas AS ac
                    JOIN horarios_profissionais AS hp 
                        ON ac.id_horario_profissional = hp.id_horario
                    JOIN profissionais AS p 
                        ON hp.id_profissional = p.id_profissional
                    WHERE 
                        ac.id_paciente = :idPaciente
                        AND ac.status = 'agendada'";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'idPaciente'=> $idPaciente
            ]);

            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function historicoAgendamentosConsulta($idPaciente){
            $sql = "SELECT 
                        ac.*, 
                        p.nome AS nome_profissional
                    FROM agendamentos_consultas AS ac
                    JOIN horarios_profissionais AS hp 
                        ON ac.id_horario_profissional = hp.id_horario
                    JOIN profissionais AS p 
                        ON hp.id_profissional = p.id_profissional
                    WHERE 
                        ac.id_paciente = :idPaciente
                        AND ac.status != 'agendada'";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'idPaciente'=> $idPaciente
            ]);

            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function totalConsultasRealizadas($idPaciente){
            $sql = "SELECT COUNT(*) as total_consultas
                    FROM agendamentos_consultas
                    WHERE id_paciente = :idPaciente
                    AND status = 'realizada'";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'idPaciente'=> $idPaciente
            ]);

            return $query->fetch(PDO::FETCH_ASSOC)['total_consultas'];
        }

        public function totalConsultasRetorno($idPaciente){
            $sql = "SELECT COUNT(*) as total_cons_retorno
                    FROM agendamentos_consultas
                    WHERE id_paciente = :idPaciente
                    AND tipo_consulta = 'retorno' ";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'idPaciente'=> $idPaciente
            ]);

            return $query->fetch(PDO::FETCH_ASSOC)['total_cons_retorno'];
        }

        public function totalConsultasCanceladas($idPaciente){
            $sql = "SELECT COUNT(*) as total_cons_canceladas
                    FROM agendamentos_consultas
                    WHERE id_paciente = :idPaciente
                    AND status = 'cancelada'";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'idPaciente'=> $idPaciente
            ]);

            return $query->fetch(PDO::FETCH_ASSOC)['total_cons_canceladas'];
        }
    }
?>
