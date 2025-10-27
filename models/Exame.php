    <?php
        class Exame{
            private $conn;

            public function __construct($conn){
                $this->conn = $conn;
            }

            public function cadastrarExame($categoria, $nome, $descricao, $tempoMinutos) {
                $sql = "INSERT INTO tipos_exames (categoria, nome, descricao, tempo_minutos)
                        VALUES (:categoria, :nome, :descricao, :tempoMinutos)";

                $query = $this->conn->prepare($sql);
                $resultado = $query->execute([
                    'categoria'    => $categoria,
                    'nome'         => $nome,
                    'descricao'    => $descricao,
                    'tempoMinutos' => $tempoMinutos
                ]);

                return $resultado;
            }

            public function listarExames(){
                $sql =  "SELECT * from tipos_exames";
                $query = $this->conn->query($sql);
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }

            public function editarExame($exameId, $nome, $categoria, $descricao, $tempoMinutos) {
                $sql = "UPDATE tipos_exames SET 
                nome = :nome,
                categoria = :categoria,
                descricao = :descricao,
                tempo_minutos = :tempoMinutos
                WHERE id_exame = :idExame";

                $query = $this->conn->prepare($sql);

                $resultado = $query->execute([
                    'nome'         => $nome,
                    'categoria'    => $categoria,
                    'descricao'    => $descricao,
                    'tempoMinutos' => $tempoMinutos,
                    'idExame'     => $exameId
                ]);

                return $resultado;
            }

            public function deletarExame($exameId) {
                $sql = "DELETE FROM tipos_exames WHERE id_exame = :idExame";

                $query = $this->conn->prepare($sql);
                return $query->execute([
                    'idExame' => $exameId
                ]);
            }

            #validaçoes de cadastro de exame
            public function existeProfissionalParaCategoria($nomeExame) {
                $nomeExameTratado = strtolower(str_replace(' ', '_', $nomeExame));
                $valorJson = '"exame_' . $nomeExameTratado . '"';
                
                $sql = "SELECT COUNT(*) as total
                        FROM profissionais
                        WHERE JSON_CONTAINS(especialidade, :nomeExame)";

                $query = $this->conn->prepare($sql);
                $query->execute([
                    ':nomeExame' => $valorJson
                ]);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                return $result['total'] > 0;

            }

            public function exameJaCadastrado($nomeExame) {
                $nomeTratado = ucwords(strtolower($nomeExame));
                $sql = "SELECT COUNT(*) as total
                        FROM tipos_exames
                        WHERE nome = :nomeExame";

                $query = $this->conn->prepare($sql);
                $query->execute([
                    ':nomeExame' => $nomeTratado
                ]);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                return $result['total'] > 0;
            }

            public function pegarExame($idExame) {
                $stmt = $this->conn->prepare("SELECT * FROM tipos_exames WHERE id_exame = :id");
                $stmt->execute(['id' => $idExame]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }

    ?>