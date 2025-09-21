<?php
class Paciente {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function criarPaciente(
        $nome, $cpf, $email, $dataNascimento, $telefone,
        $sexo, $altura, $peso, $estadoCivil,
        $tipoSanguineo, $endereco, $numCasa, $bairro,
        $cidade, $observacoes
    ) {
        $sql = "INSERT INTO pacientes (
                    nome, cpf, email, data_nascimento, telefone, sexo, altura, peso, 
                    estado_civil, tipo_sanguineo, endereco, numero_casa, bairro, cidade, observacoes
                ) VALUES (
                    :nome, :cpf, :email, :data_nascimento, :telefone, :sexo, :altura, :peso, 
                    :estado_civil, :tipo_sanguineo, :endereco, :numero_casa, :bairro, :cidade, :observacoes
                )";

        $query = $this->conn->prepare($sql);
        $resultado = $query->execute([
            ':nome' => $nome,
            ':cpf' => $cpf,
            ':email' => $email,
            ':data_nascimento' => $dataNascimento,
            ':telefone' => $telefone,
            ':sexo' => $sexo,
            ':altura' => $altura,
            ':peso' => $peso,
            ':estado_civil' => $estadoCivil,
            ':tipo_sanguineo' => $tipoSanguineo,
            ':endereco' => $endereco,
            ':numero_casa' => $numCasa,
            ':bairro' => $bairro,
            ':cidade' => $cidade,
            ':observacoes' => $observacoes
        ]);

        return $resultado;
    }

    public function editarDadosPaciente(
        $idPaciente, $nome, $email, $dataNascimento, 
        $telefone, $sexo, $altura, $peso, $estadoCivil,
        $tipoSanguineo, $endereco, $numCasa, $bairro,
        $cidade, $observacoes
    ) {
        $sql = "UPDATE pacientes SET
                    nome = :nome,
                    email = :email,
                    data_nascimento = :data_nascimento,
                    telefone = :telefone,
                    sexo = :sexo,
                    altura = :altura,
                    peso = :peso,
                    estado_civil = :estado_civil,
                    tipo_sanguineo = :tipo_sanguineo,
                    endereco = :endereco,
                    numero_casa = :numero_casa,
                    bairro = :bairro,
                    cidade = :cidade,
                    observacoes = :observacoes
                WHERE id_paciente = :id_paciente";

        $query = $this->conn->prepare($sql);
        $resultado = $query->execute([
            ':id_paciente' => $idPaciente,
            ':nome' => $nome,
            ':email' => $email,
            ':data_nascimento' => $dataNascimento,
            ':telefone' => $telefone,
            ':sexo' => $sexo,
            ':altura' => $altura,
            ':peso' => $peso,
            ':estado_civil' => $estadoCivil,
            ':tipo_sanguineo' => $tipoSanguineo,
            ':endereco' => $endereco,
            ':numero_casa' => $numCasa,
            ':bairro' => $bairro,
            ':cidade' => $cidade,
            ':observacoes' => $observacoes
        ]);

        return $resultado;
    }

    public function listarDadosPaciente($idPaciente){
        $sql = "SELECT * FROM pacientes WHERE id_paciente = :idPaciente";
        $query = $this->conn->prepare($sql);
        $query->execute([':idPaciente' => $idPaciente]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function listarPaciente(){
        $sql = "SELECT * FROM pacientes";
        $query = $this->conn->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } 

    public function pegarPaciente($idPaciente) {
        $stmt = $this->conn->prepare("SELECT * FROM pacientes WHERE id_paciente = :id");
        $stmt->execute(['id' => $idPaciente]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
?>
