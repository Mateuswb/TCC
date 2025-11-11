<?php
    class Usuario {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function buscarPorCPF($cpfUsuario) {
            $sql = "SELECT u.*, pr.especialidade,
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

        public function inativarUsuario($cpf) {
            try {
                $queryUser = $this->conn->prepare("
                    UPDATE usuarios 
                    SET status = 'inativo' 
                    WHERE login = :cpf
                ");
                $queryUser->execute([':cpf' => $cpf]);

                if ($queryUser->rowCount() == 0) {
                    throw new Exception("Erro ao inativar a conta do usuário.");
                }

                return true; 
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function excluirUsuario($idUsuario, $login) {
            try {
                $query = $this->conn->prepare("SELECT tipo_usuario FROM usuarios WHERE id_usuario = :id");
                $query->execute([':id' => $idUsuario]);
                $usuario = $query->fetch(PDO::FETCH_ASSOC);

                if (!$usuario) {
                    throw new Exception("Usuário não encontrado.");
                }

                $this->conn->beginTransaction();

                switch($usuario['tipo_usuario']) {
                    case 'paciente':
                        $stmt = $this->conn->prepare("DELETE FROM pacientes WHERE cpf = :cpf");
                        $stmt->execute([':cpf' => $login]);
                        break;

                    case 'profissional':
                        $stmt = $this->conn->prepare("DELETE FROM profissionais WHERE cpf = :cpf");
                        $stmt->execute([':cpf' => $login]);
                        break;

                    case 'admin':
                        break;
                }

                $stmtUser = $this->conn->prepare("DELETE FROM usuarios WHERE id_usuario = :id");
                $stmtUser->execute([':id' => $idUsuario]);

                $this->conn->commit();
                return true;

            } catch (Exception $e) {
                $this->conn->rollBack();
                throw $e;
            }
        }

        public function bloquearUsuario($usuarioId){
            $sql = "UPDATE usuarios SET status = 'bloqueado' WHERE id_usuario = :idUsuario";
            $query = $this->conn->prepare($sql);
            
            return $query->execute([
                ':idUsuario' => $usuarioId
            ]);
        }

    }
?>
