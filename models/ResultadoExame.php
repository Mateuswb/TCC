<?php

class ResultadoExame{
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function criarResultado($idAgendamento, $dataResultado, $arquivo) {
        $sql = "INSERT INTO resultados_exames (id_agendamento, data_resultado, arquivo, status)
                VALUES (:idAgendamento, :dataResultado, :arquivo, 'finalizado')";
        
        $query = $this->conn->prepare($sql);

        $conteudoArquivo = file_get_contents($arquivo['tmp_name']);
        $query->execute([
            ':idAgendamento' => $idAgendamento,
            ':dataResultado' => $dataResultado,
            ':arquivo'       => $conteudoArquivo
        ]);

        return $query;
    }

    public function listarExamesPendentes($ProfissionalId) {
        $sql = "SELECT 
                ae.id_agendamento AS id_agendamento_exame,
                p.nome AS paciente,
                te.nome AS exame,
                ae.horario_agendamento,
                ae.dia_agendamento,
                ae.observacoes AS observacoes_exame,
                e.id_encaminhamento
            FROM agendamentos_exames ae
            INNER JOIN encaminhamentos e ON ae.id_encaminhamento = e.id_encaminhamento
            INNER JOIN agendamentos_consultas ac ON e.id_agendamento_consulta = ac.id_agendamento
            INNER JOIN pacientes p ON ac.id_paciente = p.id_paciente
            INNER JOIN tipos_exames te ON e.id_exame = te.id_exame
            INNER JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
            WHERE hp.id_profissional = :idProfissional
            AND ae.status = 'realizado'
            AND ae.id_agendamento NOT IN (
                    SELECT id_agendamento 
                    FROM resultados_exames 
                    WHERE status = 'finalizado'
            )
            ORDER BY ae.dia_agendamento, ae.horario_agendamento
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idProfissional' => $ProfissionalId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizarResultado($idResultado, $arquivo) {
        $sql = "UPDATE resultados_exames 
                SET arquivo = :arquivo, data_resultado = NOW() 
                WHERE id_resultado = :idResultado";

        $conteudoArquivo = file_get_contents($arquivo['tmp_name']);
        $query = $this->conn->prepare($sql);

        return $query->execute([
            ':arquivo' => $conteudoArquivo,
            ':idResultado' => $idResultado
        ]);
    }

    public function listarResultadosPorPaciente($idPaciente) {
        $sql = "
            SELECT 
                r.id_resultado,
                p.nome AS paciente,
                te.nome AS exame,
                pr.nome AS profissional,
                ae.dia_agendamento,
                ae.horario_agendamento,
                r.data_resultado,
                r.status,
                r.arquivo
            FROM resultados_exames r
            INNER JOIN agendamentos_exames ae ON r.id_agendamento = ae.id_agendamento
            INNER JOIN encaminhamentos e ON ae.id_encaminhamento = e.id_encaminhamento
            INNER JOIN tipos_exames te ON e.id_exame = te.id_exame
            INNER JOIN agendamentos_consultas ac ON e.id_agendamento_consulta = ac.id_agendamento
            INNER JOIN pacientes p ON ac.id_paciente = p.id_paciente
            INNER JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
            INNER JOIN profissionais pr ON hp.id_profissional = pr.id_profissional
            WHERE p.id_paciente = :idPaciente
            ORDER BY r.data_resultado DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':idPaciente' => $idPaciente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarArquivoResultado($idResultado) {
        $sql = "SELECT arquivo
                FROM resultados_exames 
                WHERE id_resultado = :idResultado
                LIMIT 1";

        $query = $this->conn->prepare($sql);
        $query->execute([
            'idResultado' => $idResultado
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
   
    public function listarExamesEnviados($idProfissional) {
        $sql = "SELECT 
                te.nome AS nome_exame,
                p.nome AS nome_paciente,
                ae.dia_agendamento AS data_exame,
                ae.horario_agendamento,
                re.id_resultado

            FROM resultados_exames re
            INNER JOIN agendamentos_exames ae
                ON ae.id_agendamento = re.id_agendamento
            INNER JOIN encaminhamentos e
                ON e.id_encaminhamento = ae.id_encaminhamento
            INNER JOIN agendamentos_consultas ac
                ON ac.id_agendamento = e.id_agendamento_consulta
            INNER JOIN horarios_profissionais hp
                ON hp.id_horario = ac.id_horario_profissional
            INNER JOIN profissionais prof
                ON prof.id_profissional = hp.id_profissional
            INNER JOIN tipos_exames te
                ON te.id_exame = e.id_exame
            INNER JOIN pacientes p
                ON p.id_paciente = ac.id_paciente

            WHERE prof.id_profissional = :id
            AND re.status = 'finalizado'
            ORDER BY ae.dia_agendamento DESC;
            ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $idProfissional);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
