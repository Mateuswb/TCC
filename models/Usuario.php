<?php
    class Usuario {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function buscarPorCPF($cpfUsuario) {
            $sql = "SELECT u.id_usuario, u.login, u.senha, u.tipo_usuario, pr.especialidade,
                        p.nome AS paciente_nome, p.id_paciente,
                        pr.nome AS profissional_nome, pr.id_profissional
                    FROM usuarios u
                    LEFT JOIN pacientes p ON p.cpf = u.login
                    LEFT JOIN profissionais pr ON pr.cpf = u.login
                    WHERE u.login = :cpf";
            
            $query = $this->conn->prepare($sql);
            $query->execute([
                'cpf' => $cpfUsuario
            ]);
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        public function criarUsuario($cpfUsuario, $senhaHash, $tipoUsuario, $statusUsuario, $dataCriacao) {
            $sql = "INSERT INTO usuarios (login, senha, tipo_usuario, status, data_criacao) 
                    VALUES (:login, :senha, :tipoUsuario, :status, :dataCriacao)";
            $query = $this->conn->prepare($sql);
            $resultado = $query->execute([
                ':login' => $cpfUsuario,
                ':senha' => $senhaHash,
                ':tipoUsuario' => $tipoUsuario,
                ':status' => $statusUsuario,
                ':dataCriacao' => $dataCriacao
            ]);

            return $resultado;
        }

        public function editarUsuario($idUsuario, $cpfUsuario, $senhaUsuario) {
            $sql = "UPDATE usuarios SET
                    login = :cpf,
                    senha = :senha
                    WHERE id_usuario = :idUsuario";
            
            $query = $this->conn->prepare($sql);
            
            return $query->execute([
                ':cpf' => $cpfUsuario,
                ':senha' => $senhaUsuario,
                ':idUsuario' => $idUsuario
            ]);
        }

        public function listarDadosUsuario($idUsuario) {
            $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
            $query = $this->conn->prepare($sql);
            $query->execute([':id_usuario' => $idUsuario]);
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        public function listarUsuarios() {
            $sql = "SELECT * FROM usuarios";
            $query = $this->conn->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
