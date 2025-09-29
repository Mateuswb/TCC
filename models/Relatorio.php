<?php
    class Relatorio {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        // Método que busca agendamentos por dia
        public function agendamentosPorDia() {
            $sql = "SELECT 
                        DATE(dia_agendamento) AS data_agendamento,
                        COUNT(*) AS total
                    FROM agendamentos_consultas
                    GROUP BY DATE(dia_agendamento)
                    ORDER BY data_agendamento";
            $query = $this->conn->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function relatorioAtendimentosSemana() {
            $sql = "SELECT 
                        DAYNAME(dia_agendamento) AS dia_semana,
                        COUNT(*) AS total_atendimentos
                    FROM agendamentos_consultas
                    GROUP BY dia_semana
                    ORDER BY total_atendimentos DESC;
                    ";
            $query = $this->conn->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function usuariosMaisRecentes() {
            $sql = "
                SELECT 
                    u.id_usuario,
                    u.tipo_usuario,
                    u.status,
                    u.data_criacao,
                    COALESCE(p.nome, pr.nome) AS nome,
                    COALESCE(p.email, pr.email) AS email,
                    COALESCE(p.telefone, pr.telefone) AS telefone
                FROM usuarios u
                LEFT JOIN pacientes p ON p.cpf = u.login AND u.tipo_usuario = 'paciente'
                LEFT JOIN profissionais pr ON pr.cpf = u.login AND u.tipo_usuario = 'profissional'
                ORDER BY u.data_criacao DESC
                LIMIT 10;
            ";
            $query = $this->conn->query($sql);

            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function totalUsuarios(){
            $sql = "SELECT COUNT(*) AS totalUsuario FROM usuarios";
            $query = $this->conn->query($sql);
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        public function totalPacientes(){
            $sql = "SELECT COUNT(*) AS totalPaciente FROM pacientes";
            $query = $this->conn->query($sql);
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        
        public function totalProfissionais(){
            $sql = "SELECT COUNT(*) AS totalProfissional FROM profissionais";
            $query = $this->conn->query($sql);
            return $query->fetch(PDO::FETCH_ASSOC);
        }


        # agendamentos
        public function listarConsultas($idProfissional){
            $sql = "
                SELECT 
                    ac.id_agendamento,
                    p.nome AS nome_paciente,
                    ac.dia_agendamento,
                    ac.horario_agendamento,
                    ac.status,
                    ac.tipo_consulta,
                    ac.observacoes
                FROM agendamentos_consultas ac
                INNER JOIN pacientes p ON ac.id_paciente = p.id_paciente
                INNER JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                WHERE hp.id_profissional = :idProfissional
                ORDER BY ac.dia_agendamento DESC, ac.horario_agendamento ASC
            ";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':idProfissional', $idProfissional, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function totalConsultasProfissional($idProfissional){
            $sql = "SELECT COUNT(*) AS total_agendamentos
                FROM agendamentos_consultas ac
                JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                WHERE hp.id_profissional = :idProfissional";

            $query = $this->conn->prepare($sql);
            $query->execute([
                ':idProfissional' => $idProfissional,
            ]);
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        public function totalConsultasConcluidas($idProfissional) {
            $sql = "SELECT COUNT(*) AS total_concluidas
                    FROM agendamentos_consultas ac
                    JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                    WHERE hp.id_profissional = :idProfissional
                    AND ac.status = 'realizada'";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idProfissional', $idProfissional, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function totalConsultasCanceladas($idProfissional) {
            $sql = "SELECT COUNT(*) AS total_canceladas
                    FROM agendamentos_consultas ac
                    JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                    WHERE hp.id_profissional = :idProfissional
                    AND ac.status = 'cancelada'";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idProfissional', $idProfissional, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        # listar os paciente que já realizaram uma consulta com um profissional
        public function listarPacientesPorProfissional($profissionalId) {
            $sql = "SELECT DISTINCT p.*, 
                TIMESTAMPDIFF(YEAR, p.data_nascimento, CURDATE()) AS idade, 
                u.status,
                MAX(a.dia_agendamento) AS ultima_consulta 
                FROM pacientes p 
                JOIN agendamentos_consultas a ON p.id_paciente = a.id_paciente 
                JOIN horarios_profissionais h ON a.id_horario_profissional = h.id_horario 
                JOIN usuarios u ON u.login = p.cpf 
                WHERE h.id_profissional = :idProfissional AND a.status = 'realizada' 
                GROUP BY p.id_paciente, p.nome, p.cpf, p.data_nascimento, p.telefone, u.status;";

            $query = $this->conn->prepare($sql);
            $query->execute([
                ':idProfissional' => $profissionalId]);
            return $query->fetchALL(PDO::FETCH_ASSOC);
        }


        #profissional home
        public function agendamentosHoje($idProfissional) {
            $sql = "SELECT COUNT(*) AS total
                    FROM agendamentos_consultas ac
                    JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                    WHERE hp.id_profissional = :idProfissional
                    AND ac.dia_agendamento = CURDATE()";
            $query = $this->conn->prepare($sql);
            $query->execute([':idProfissional' => $idProfissional]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        }

        public function agendamentosMes($idProfissional) {
            $sql = "SELECT COUNT(*) AS total
                    FROM agendamentos_consultas ac
                    JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                    WHERE hp.id_profissional = :idProfissional
                    AND MONTH(ac.dia_agendamento) = MONTH(CURDATE())
                    AND YEAR(ac.dia_agendamento) = YEAR(CURDATE())";
            $query = $this->conn->prepare($sql);
            $query->execute([
                ':idProfissional' => $idProfissional
            ]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        }

        public function totalConsultasRetorno($idProfissional) {
            $sql = "SELECT COUNT(*) AS total
                    FROM agendamentos_consultas ac
                    JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                    WHERE hp.id_profissional = :idProfissional
                    AND ac.tipo_consulta = 'r'
                    AND ac.status = 'realizada'";
            $query = $this->conn->prepare($sql);
            $query->execute([':idProfissional' => $idProfissional]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        }

        public function cancelamentos($idProfissional) {
            $sqlTotal = "SELECT COUNT(*) AS total
                            FROM agendamentos_consultas ac
                            JOIN horarios_profissionais hp 
                            ON ac.id_horario_profissional = hp.id_horario
                            WHERE hp.id_profissional = :idProfissional";
            $queryTotal = $this->conn->prepare($sqlTotal);
            $queryTotal->execute([':idProfissional' => $idProfissional]);
            $total = $queryTotal->fetch(PDO::FETCH_ASSOC)['total'];

            // Total de agendamentos cancelados
            $sqlCancelados = "SELECT COUNT(*) AS total
                            FROM agendamentos_consultas ac
                            JOIN horarios_profissionais hp 
                            ON ac.id_horario_profissional = hp.id_horario
                            WHERE hp.id_profissional = :idProfissional
                            AND ac.status = 'cancelada'";
            $queryCancelados = $this->conn->prepare($sqlCancelados);
            $queryCancelados->execute([':idProfissional' => $idProfissional]);
            $cancelados = $queryCancelados->fetch(PDO::FETCH_ASSOC)['total'];

            $taxaCancelamento = round(($cancelados / $total) * 100);

            return $taxaCancelamento; 
        }

        public function principalDiaAgendamento($idProfissional) {
            $sql = "SELECT DAYNAME(ac.dia_agendamento) AS dia, COUNT(*) AS total
                        FROM agendamentos_consultas ac
                        JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                        WHERE hp.id_profissional = :idProfissional
                        GROUP BY dia
                        ORDER BY total DESC
                        LIMIT 1";
            $query = $this->conn->prepare($sql);
            $query->execute([':idProfissional' => $idProfissional]);
            return $query->fetch(PDO::FETCH_ASSOC)['dia'] ?? null;
        }

        public function principalHoraAgendamento($idProfissional) {
            $sql = "SELECT DATE_FORMAT(ac.horario_agendamento, '%H:%i') AS hora, COUNT(*) AS total
                        FROM agendamentos_consultas ac
                        JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                        WHERE hp.id_profissional = :idProfissional
                        GROUP BY hora
                        ORDER BY total DESC
                        LIMIT 1;";
            $query = $this->conn->prepare($sql);
            $query->execute([':idProfissional' => $idProfissional]);
            return $query->fetch(PDO::FETCH_ASSOC)['hora'] ?? null;
        }

        public function novosPacientesMes($idProfissional) {
            $sql = "SELECT COUNT(DISTINCT p.id_paciente) AS total
                    FROM pacientes p
                    JOIN agendamentos_consultas ac ON p.id_paciente = ac.id_paciente
                    JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                    WHERE hp.id_profissional = :idProfissional
                    AND MONTH(ac.dia_agendamento) = MONTH(CURDATE())
                    AND YEAR(ac.dia_agendamento) = YEAR(CURDATE())";
            $query = $this->conn->prepare($sql);
            $query->execute([':idProfissional' => $idProfissional]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        }

        public function totalPacientesPorProfissional($idProfissional) {
            $sql = "SELECT COUNT(DISTINCT p.id_paciente) AS total
                    FROM pacientes p
                    JOIN agendamentos_consultas ac ON p.id_paciente = ac.id_paciente
                    JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                    WHERE hp.id_profissional = :idProfissional";
            $query = $this->conn->prepare($sql);
            $query->execute([':idProfissional' => $idProfissional]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        }
    }
?>