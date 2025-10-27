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
                    WHERE YEARWEEK(dia_agendamento, 1) = YEARWEEK(CURDATE(), 1)
                    GROUP BY DATE(dia_agendamento)
                    ORDER BY data_agendamento;
                    ";
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
                    ORDER BY FIELD(DAYNAME(dia_agendamento), 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";
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

        # agendamentos consulta
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

            if ($total > 0) {
                $taxaCancelamento = round(($cancelados / $total) * 100, 2);
            } else {
                $taxaCancelamento = 0;
            }

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
                        LIMIT 1";
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
                    WHERE hp.id_profissional = :idProfissional AND ac.status = 'realizada';";
            $query = $this->conn->prepare($sql);
            $query->execute([':idProfissional' => $idProfissional]);
            return $query->fetch(PDO::FETCH_ASSOC)['total'];
        }

        # profissional 
        public function compararAtendimentosSemanais($idProfissional) {
            // Essa Semana
            $sqlSemanaAtual = " SELECT 
                                DAYNAME(ac.dia_agendamento) AS dia_semana,
                                COUNT(ac.id_agendamento) AS total_agendamentos
                            FROM 
                                agendamentos_consultas ac
                            INNER JOIN 
                                horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                            WHERE 
                                hp.id_profissional = :idProfissional
                                AND ac.dia_agendamento BETWEEN 
                                    DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)
                                    AND DATE_ADD(CURDATE(), INTERVAL (6 - WEEKDAY(CURDATE())) DAY)
                            GROUP BY 
                                DAYNAME(ac.dia_agendamento)
                            ORDER BY 
                                ac.dia_agendamento";
            $querySemanaAtual = $this->conn->prepare($sqlSemanaAtual);
            $querySemanaAtual->execute([':idProfissional' => $idProfissional]);
            $essaSemana = $querySemanaAtual->fetchAll(PDO::FETCH_ASSOC);

            // Semana passada
            $sqlSemanaPassada = "SELECT 
                    DAYNAME(ac.dia_agendamento) AS dia_semana,
                    COUNT(ac.id_agendamento) AS total_agendamentos
                FROM 
                    agendamentos_consultas ac
                INNER JOIN 
                    horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                WHERE 
                    hp.id_profissional = :idProfissional
                    AND ac.dia_agendamento BETWEEN 
                        DATE_SUB(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL 7 DAY)
                        AND DATE_SUB(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL 1 DAY)
                GROUP BY 
                    DAYNAME(ac.dia_agendamento)
                ORDER BY 
                    ac.dia_agendamento ";

            $querySemanaPassada = $this->conn->prepare($sqlSemanaPassada);
            $querySemanaPassada->execute([':idProfissional' => $idProfissional]);
            $semanaPassada = $querySemanaPassada->fetchAll(PDO::FETCH_ASSOC);

            // configuração para o gráfico
            $dias = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

            $dadosSemanaAtual = array_fill(0, 7, 0);
            $dadosSemanaPassada = array_fill(0, 7, 0);

            foreach ($essaSemana as $linha) {
                $index = array_search($linha['dia_semana'], $dias);
                if ($index !== false) $dadosSemanaAtual[$index] = (int)$linha['total_agendamentos'];
            }

            foreach ($semanaPassada as $linha) {
                $index = array_search($linha['dia_semana'], $dias);
                if ($index !== false) $dadosSemanaPassada[$index] = (int)$linha['total_agendamentos'];
            }

            return [
                'labels' => ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                'essaSemana' => $dadosSemanaAtual,
                'semanaPassada' => $dadosSemanaPassada
            ];
        }

        public function contarConsultasERetornos($idProfissional) {
            // total de primeiras consultas
            $sqlConsulta = "
                SELECT COUNT(*) AS total_consultas
                FROM agendamentos_consultas ac
                INNER JOIN horarios_profissionais hp 
                    ON ac.id_horario_profissional = hp.id_horario
                WHERE hp.id_profissional = :idProfissional
                AND ac.tipo_consulta = 'c'
            ";

            $stmt1 = $this->conn->prepare($sqlConsulta);
            $stmt1->bindParam(':idProfissional', $idProfissional, PDO::PARAM_INT);
            $stmt1->execute();
            $consulta = $stmt1->fetch(PDO::FETCH_ASSOC)['total_consultas'] ?? 0;

            // total de retornos
            $sqlRetorno = "
                SELECT COUNT(*) AS total_retorno
                FROM agendamentos_consultas ac
                INNER JOIN horarios_profissionais hp 
                    ON ac.id_horario_profissional = hp.id_horario
                WHERE hp.id_profissional = :idProfissional
                AND ac.tipo_consulta = 'r'
            ";

            $stmt2 = $this->conn->prepare($sqlRetorno);
            $stmt2->bindParam(':idProfissional', $idProfissional, PDO::PARAM_INT);
            $stmt2->execute();
            $retorno = $stmt2->fetch(PDO::FETCH_ASSOC)['total_retorno'] ?? 0;

            return [
                'consultas' => (int)$consulta,
                'retornos' => (int)$retorno
            ];
        }

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

        #paciente
        public function totalExamesPaciente($pacienteId){
            $sql = "SELECT COUNT(ae.id_agendamento) AS total_agendamentos_exame
                    FROM agendamentos_exames ae
                    INNER JOIN encaminhamentos e ON ae.id_encaminhamento = e.id_encaminhamento
                    INNER JOIN agendamentos_consultas ac ON e.id_agendamento_consulta = ac.id_agendamento
                    INNER JOIN pacientes p ON ac.id_paciente = p.id_paciente
                    WHERE p.id_paciente = :idPaciente
                    AND ae.status != 'agendado'";
            
            $query = $this->conn->prepare($sql);
            $query->execute([
                'idPaciente' => $pacienteId
            ]);

            return $query->fetch(PDO::FETCH_ASSOC)['total_agendamentos_exame'];
        }

        public function exameMaisRecorrente($pacienteId){
            $sql = "SELECT 
                        te.nome AS exame
                    FROM agendamentos_exames ae
                    INNER JOIN encaminhamentos e ON ae.id_encaminhamento = e.id_encaminhamento
                    INNER JOIN agendamentos_consultas ac ON e.id_agendamento_consulta = ac.id_agendamento
                    INNER JOIN pacientes p ON ac.id_paciente = p.id_paciente
                    INNER JOIN tipos_exames te ON e.id_exame = te.id_exame
                    WHERE p.id_paciente = :idPaciente
                    GROUP BY te.nome
                    ORDER BY COUNT(ae.id_agendamento) DESC
                    LIMIT 1";
            
            $query = $this->conn->prepare($sql);
            $query->execute([
                'idPaciente' => $pacienteId
            ]);

            return $query->fetch(PDO::FETCH_ASSOC)['exame'];
        }

        public function totalExamesCancelados($pacienteId){
            $sql = "SELECT 
                        COUNT(ae.id_agendamento) AS total_cancelados
                    FROM agendamentos_exames ae
                    INNER JOIN encaminhamentos e ON ae.id_encaminhamento = e.id_encaminhamento
                    INNER JOIN agendamentos_consultas ac ON e.id_agendamento_consulta = ac.id_agendamento
                    INNER JOIN pacientes p ON ac.id_paciente = p.id_paciente
                    WHERE p.id_paciente = :idPaciente
                    AND ae.status = 'cancelado'"; 

            $query = $this->conn->prepare($sql);
            $query->execute([
                'idPaciente' => $pacienteId
            ]);

            return $query->fetch(PDO::FETCH_ASSOC)['total_cancelados'];
        }

    }
?>