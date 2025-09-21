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

    }
?>