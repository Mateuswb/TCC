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
        return $query->execute([
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
    }

    public function listarPaciente(){
        $sql = "SELECT * FROM pacientes";
        $query = $this->conn->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } 

    public function listarDadosPaciente($idPaciente){
        $sql = "SELECT * FROM pacientes WHERE id_paciente = :idPaciente";
        $query = $this->conn->prepare($sql);
        $query->execute([':idPaciente' => $idPaciente]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function pegarPaciente($idPaciente) {
        $stmt = $this->conn->prepare("SELECT * FROM pacientes WHERE id_paciente = :id");
        $stmt->execute(['id' => $idPaciente]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    # validações paciente
    public function temAgendamentoAtivoPaciente($idPaciente) {
        $sql = "SELECT COUNT(*) FROM (
                    SELECT a.id_agendamento
                    FROM agendamentos_consultas a
                    WHERE a.id_paciente = :idPaciente
                    AND a.status = 'agendada'

                    UNION ALL

                    SELECT e.id_agendamento
                    FROM agendamentos_exames e
                    JOIN encaminhamentos enc ON e.id_encaminhamento = enc.id_encaminhamento
                    JOIN agendamentos_consultas a2 ON enc.id_agendamento_consulta = a2.id_agendamento
                    WHERE a2.id_paciente = :idPaciente
                    AND e.status = 'agendado'
                ) AS total";

        $query = $this->conn->prepare($sql);
        $query->execute([':idPaciente' => $idPaciente]);
        return $query->fetchColumn() > 0;
    }


    public function excluirPacienteComUsuario($idPaciente, $cpf) {
        try {
            $this->conn->beginTransaction();
            
            $queryPac = $this->conn->prepare("DELETE FROM pacientes WHERE id_paciente = :idPaciente");
            $queryPac->execute([':idPaciente' => $idPaciente]);
            if ($queryPac->rowCount() == 0) {
                throw new Exception("Erro ao excluir dados conta.");
            }

            $queryUser = $this->conn->prepare("DELETE FROM usuarios WHERE login = :cpf");
            $queryUser->execute([':cpf' => $cpf]);
            if ($queryUser->rowCount() == 0) {
                throw new Exception("Erro ao excluir dados da conta de usuário.");
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
