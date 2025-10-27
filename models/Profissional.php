<?php
class Profissional {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function cadastrarProfissional(
        $nome, $cpf, $rg, $email, $dataNascimento, $telefone,
        $sexo, $estadoCivil, $crmCrp, $especialidade,
        $endereco, $numeroCasa, $bairro, $cidade, $observacoes
    ) {
        $sql = "INSERT INTO profissionais (
                    nome, cpf, rg, email, data_nascimento, telefone, sexo, estado_civil, 
                    crm_crp, especialidade, endereco, numero_casa, bairro, cidade, observacoes
                ) VALUES (
                    :nome, :cpf, :rg, :email, :data_nascimento, :telefone, :sexo, :estado_civil, 
                    :crm_crp, :especialidade, :endereco, :numero_casa, :bairro, :cidade, :observacoes
                )";
    
        $query = $this->conn->prepare($sql);
        return $query->execute([
            ':nome' => $nome,
            ':cpf' => $cpf,
            ':rg' => $rg,
            ':email' => $email,
            ':data_nascimento' => $dataNascimento,
            ':telefone' => $telefone,
            ':sexo' => $sexo,
            ':estado_civil' => $estadoCivil,
            ':crm_crp' => $crmCrp,
            ':especialidade' => json_encode($especialidade),
            ':endereco' => $endereco,
            ':numero_casa' => $numeroCasa,
            ':bairro' => $bairro,
            ':cidade' => $cidade,
            ':observacoes' => $observacoes
        ]);
    }
    
    public function editarDadosProfissional(
        $idProfissional, $nome, $rg, $email, $dataNascimento, 
        $telefone, $sexo, $estadoCivil, $crmCrp, $especialidade,
        $endereco, $numeroCasa, $bairro, $cidade, $observacoes
    ) {
        $sql = "UPDATE profissionais SET 
                    nome = :nome,
                    rg = :rg,
                    email = :email,
                    data_nascimento = :data_nascimento,
                    telefone = :telefone,
                    sexo = :sexo,
                    estado_civil = :estado_civil,
                    crm_crp = :crm_crp,
                    especialidade = :especialidade,
                    endereco = :endereco,
                    numero_casa = :numero_casa,
                    bairro = :bairro,
                    cidade = :cidade,
                    observacoes = :observacoes
                WHERE id_profissional = :id_profissional";

        $query = $this->conn->prepare($sql);
        return $query->execute([
            ':id_profissional' => $idProfissional,
            ':nome' => $nome,
            ':rg' => $rg,
            ':email' => $email,
            ':data_nascimento' => $dataNascimento,
            ':telefone' => $telefone,
            ':sexo' => $sexo,
            ':estado_civil' => $estadoCivil,
            ':crm_crp' => $crmCrp,
            ':especialidade' => json_encode($especialidade), // array para JSON
            ':endereco' => $endereco,
            ':numero_casa' => $numeroCasa,
            ':bairro' => $bairro,
            ':cidade' => $cidade,
            ':observacoes' => $observacoes
        ]);
    }

    public function listarProfissionais() {
        $sql = "SELECT * FROM profissionais";
        $query = $this->conn->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarDadosProfissional($idProfissional) {
        $sql = "SELECT * FROM profissionais WHERE id_profissional = :id_profissional";
        $query = $this->conn->prepare($sql);
        $query->execute([':id_profissional' => $idProfissional]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function listarProfissionaisDisponiveis() {
        $sql = "SELECT DISTINCT p.*
                FROM profissionais p
                INNER JOIN usuarios u ON u.login = p.cpf
                INNER JOIN horarios_profissionais h ON h.id_profissional = p.id_profissional
                WHERE u.status = 'ativo'";

        $query = $this->conn->query($sql);
        $resultados = $query->fetchAll(PDO::FETCH_ASSOC);

        return [
            'dados' => $resultados,
            'total' => count($resultados)
        ];
    }

    public function principaisEspecialidades(){
        $sql = "SELECT DISTINCT 
            TRIM(BOTH '\"' FROM JSON_UNQUOTE(JSON_EXTRACT(p.especialidade, '$[0]'))) AS especialidade_principal
            FROM profissionais p
            INNER JOIN horarios_profissionais h ON h.id_profissional = p.id_profissional
            WHERE JSON_UNQUOTE(JSON_EXTRACT(p.especialidade, '$[0]')) NOT LIKE 'exame_%'

            UNION

            SELECT DISTINCT TRIM(BOTH '\"' FROM JSON_UNQUOTE(JSON_EXTRACT(p.especialidade, '$[1]'))) AS especialidade_principal
            FROM profissionais p
            INNER JOIN horarios_profissionais h ON h.id_profissional = p.id_profissional
            WHERE JSON_UNQUOTE(JSON_EXTRACT(p.especialidade, '$[1]')) NOT LIKE 'exame_%'

            LIMIT 4
        ";

        $query = $this->conn->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    #validações profissional
    public function temAgendamentoAtivo($idProfissional) {
        $sql = "SELECT COUNT(*) FROM (
                -- Agendamentos de consultas ativos
                SELECT a.id_agendamento
                FROM agendamentos_consultas a
                JOIN horarios_profissionais h ON a.id_horario_profissional = h.id_horario
                WHERE h.id_profissional = :idProfissional
                AND a.status = 'agendada'

                UNION ALL

                -- Agendamentos de exames ativos
                SELECT e.id_agendamento
                FROM agendamentos_exames e
                JOIN encaminhamentos enc ON e.id_encaminhamento = enc.id_encaminhamento
                JOIN agendamentos_consultas a2 ON enc.id_agendamento_consulta = a2.id_agendamento
                JOIN horarios_profissionais h2 ON a2.id_horario_profissional = h2.id_horario
                WHERE h2.id_profissional = :idProfissional
                AND e.status = 'agendado'
            ) AS total";
        
        $query = $this->conn->prepare($sql);
        $query->execute([
            ':idProfissional' => $idProfissional
        ]);
        return $query->fetchColumn() > 0;
    }

    public function excluirProfissionalComUsuario($idProfissional, $cpf) {
        try {
            $this->conn->beginTransaction();

            $queryProf = $this->conn->prepare("DELETE FROM profissionais WHERE id_profissional = :idProfissional");
            $queryProf->execute([':idProfissional' => $idProfissional]);
            if ($queryProf->rowCount() == 0) {
                throw new Exception("Erro ao excluir o profissional.");
            }

            $queryUser = $this->conn->prepare("DELETE FROM usuarios WHERE login = :cpf");
            $queryUser->execute([':cpf' => $cpf]);
            if ($queryUser->rowCount() == 0) {
                throw new Exception("Erro ao excluir o usuário associado.");
            }

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e; 
        }
    }

}
?>
