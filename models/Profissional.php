<?php
class Profissional {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function listarProfissionais() {
        $sql = "SELECT * FROM profissionais";
        $query = $this->conn->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
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


    public function listarDadosProfissional($idProfissional) {
        $sql = "SELECT * FROM profissionais WHERE id_profissional = :id_profissional";
        $query = $this->conn->prepare($sql);
        $query->execute([':id_profissional' => $idProfissional]);
        return $query->fetch(PDO::FETCH_ASSOC);
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
            ':especialidade' => $especialidade,
            ':endereco' => $endereco,
            ':numero_casa' => $numeroCasa,
            ':bairro' => $bairro,
            ':cidade' => $cidade,
            ':observacoes' => $observacoes
        ]);
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
}
?>
