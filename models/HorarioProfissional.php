<?php
    class Horario {
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function verificaHorario($profissionalId) {
            $sql = "SELECT COUNT(*) FROM horarios_profissionais WHERE id_profissional = :profissionalId";
            $query = $this->conn->prepare($sql);
            $query->execute(['profissionalId' => $profissionalId]);
            return $query->fetchColumn() > 0;
        }

        public function cadastrarHorario(
            $idProfissional, $diaSemana, $horaInicio, 
            $horaFim, $inicioIntervalo = null, $fimIntervalo = null) {
            $sql = "INSERT INTO horarios_profissionais 
                    (id_profissional, dia_semana, hora_inicio, hora_fim, inicio_intervalo, fim_intervalo) 
                    VALUES 
                    (:idProfissional, :diaSemana, :horaInicio, :horaFim, :inicioIntervalo, :fimIntervalo)";
            $query = $this->conn->prepare($sql);

            $resultado = $query->execute([
                'idProfissional' => $idProfissional,
                'diaSemana'      => $diaSemana,
                'horaInicio'     => $horaInicio,
                'horaFim'        => $horaFim,
                'inicioIntervalo'=> $inicioIntervalo,
                'fimIntervalo'   => $fimIntervalo
            ]);
            //$query->debugDumpParams();
            return $resultado;
        }

        # lista os horarios de agendamento do profissional
        public function listarHorarios($profissionalId){
            $sql = "SELECT * FROM horarios_profissionais WHERE id_profissional = :idProfissional";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'idProfissional' => $profissionalId
            ]);
            return $query->fetchAll(PDO::FETCH_ASSOC); 
        }

        public function editarHorario(
            $horaInicio, $horaFim, $inicioIntervalo, 
            $fimIntervalo, $profissionalId, $horarioId
        ){
            $sql = "UPDATE horarios_profissionais SET
                hora_inicio = :horaInicio,
                hora_fim = :horaFim,
                inicio_intervalo = :inicioIntervalo,
                fim_intervalo = :fimIntervalo
            WHERE id_horario = :idHorario AND id_profissional = :idProfissional";

            $query = $this->conn->prepare($sql);

            $resultado = $query->execute([
                ':horaInicio'     => $horaInicio,
                ':horaFim'        => $horaFim,
                ':inicioIntervalo'=> $inicioIntervalo,
                ':fimIntervalo'   => $fimIntervalo,
                ':idProfissional' => $profissionalId,
                ':idHorario'      => $horarioId
            ]);

            return $resultado;
        }


        # horarios disponiveis para agendamento da consulta
        public function listarHorariosDisponiveis($dataSelecionada, $profissionalId) {
            $nomeDias = [
                "Sunday"    => "domingo",
                "Monday"    => "segunda",
                "Tuesday"   => "terca",
                "Wednesday" => "quarta",
                "Thursday"  => "quinta",
                "Friday"    => "sexta",
                "Saturday"  => "sabado"
            ];

            $diaSemana = $nomeDias[date("l", strtotime($dataSelecionada))];

            $sql = "
                SELECT id_horario, hora_inicio, hora_fim, inicio_intervalo, fim_intervalo
                FROM horarios_profissionais
                WHERE id_profissional = :profissionalId AND dia_semana = :diaSemana
                ORDER BY hora_inicio
            ";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'profissionalId' => $profissionalId,
                'diaSemana' => $diaSemana    
            ]);
            $horariosBd1 = $query->fetchAll(PDO::FETCH_ASSOC);

            $horarios = [
                "disponiveis" => [],
                "agendamento" => []
            ];

            $intervaloMinutos = 30;
            $idHorario = 0;

            foreach ($horariosBd1 as $h) {
                $entrada           = $h['hora_inicio'];
                $saida             = $h['hora_fim'];
                $inicioIntervaloBd = $h['inicio_intervalo'];
                $fimIntervaloBd    = $h['fim_intervalo'];
                $idHorario         = $h['id_horario'];

                $horaInicio      = strtotime($entrada);
                $horaFim         = strtotime($saida);
                $inicioIntervalo = strtotime($inicioIntervaloBd);
                $fimIntervalo    = strtotime($fimIntervaloBd);

                for ($hora = $horaInicio; $hora < $horaFim; $hora += $intervaloMinutos * 60) {
                    $proximaHora = $hora + $intervaloMinutos * 60;

                    // Pula o intervalo
                    if ($proximaHora <= $inicioIntervalo || $hora >= $fimIntervalo) {
                        $horarios['disponiveis'][] = date("H:i", $hora) . " - " . date("H:i", $proximaHora);
                    }
                }
            }

            $sql2 = "
                SELECT horario_agendamento
                FROM agendamentos_consultas
                WHERE id_horario_profissional = :idHorario and dia_agendamento = :dataSelecionada
                ORDER BY horario_agendamento
            ";
            $query2 = $this->conn->prepare($sql2);
            $query2->execute([
                'idHorario' => $idHorario,
                'dataSelecionada' => $dataSelecionada
                ]);
            $horariosBd2 = $query2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($horariosBd2 as $h) {
                $entrada = $h['horario_agendamento'];

                $horaInicio = strtotime($entrada);
                $proximaHora = $horaInicio + $intervaloMinutos * 60;
                $horarios['agendamento'][] = date("H:i", $horaInicio) . " - " . date("H:i", $proximaHora);
            }

            return $horarios;
        }
        public function recuperaIdHorario($dataSelecionada, $profissionalId) {
            $nomeDias = [
                "Sunday"    => "domingo",
                "Monday"    => "segunda",
                "Tuesday"   => "terca",
                "Wednesday" => "quarta",
                "Thursday"  => "quinta",
                "Friday"    => "sexta",
                "Saturday"  => "sabado"
            ];

            $diaSemana = $nomeDias[date("l", strtotime($dataSelecionada))];

            $sql = "
                SELECT id_horario, hora_inicio, hora_fim, inicio_intervalo, fim_intervalo
                FROM horarios_profissionais
                WHERE id_profissional = :profissionalId AND dia_semana = :diaSemana
                ORDER BY hora_inicio
            ";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'profissionalId' => $profissionalId,
                'diaSemana' => $diaSemana    
            ]);
            $horariosBd1 = $query->fetchAll(PDO::FETCH_ASSOC);

            $idHorario = 0;

            foreach ($horariosBd1 as $h) {
                $idHorario         = $h['id_horario'];
            }

            return $idHorario;
        }


        # horarios disponiveis para agendamento do exame
        public function listarHorariosDisponiveisExame($dataSelecionada, $exame) {
            $nomeDias = [
                "Sunday"    => "domingo",
                "Monday"    => "segunda",
                "Tuesday"   => "terca",
                "Wednesday" => "quarta",
                "Thursday"  => "quinta",
                "Friday"    => "sexta",
                "Saturday"  => "sabado"
            ];

           $nomeExames = [
            // Exames de sangue
            "Hemograma"                 => "exame_hemograma",
            "Colesterol"                => "exame_colesterol",
            "Glicemia"                  => "exame_glicemia",
            "Triglicerídeos"            => "exame_triglicerideos",
            "Plaquetas"                 => "exame_plaquetas",
            "Hemoglobina Glicada"       => "exame_hemoglobina_glicada",

            // Exames de imagem
            "raio-x"                    => "exame_raio_x",
            "Ressonância Magnética"     => "exame_ressonancia_magnetica",
            "Tomografia"                => "exame_tomografia",
            "Ultrassonografia"          => "exame_ultrassonografia",
            "Mamografia"                => "exame_mamografia",
            "Densitometria Óssea"       => "exame_densitometria_ossea",

            //  Exames cardiológicos
            "Eletrocardiograma"         => "exame_eletrocardiograma",
            "Ecocardiograma"            => "exame_ecocardiograma",
            "Holter"                    => "exame_holter",
            "Teste Ergométrico"         => "exame_teste_ergometrico",
            "MAPA"                      => "exame_mapa",

            //  Exames de urina
            "Urina Tipo I"              => "exame_urina_tipo_i",
            "Urocultura"                => "exame_urocultura",
            "Exame de Urina"            => "exame_exame_de_urina",

            //  Exames hormonais
            "TSH"                       => "exame_tsh",
            "T4 Livre"                  => "exame_t4_livre",
            "Testosterona"              => "exame_testosterona",
            "Estradiol"                 => "exame_estradiol",
            "Cortisol"                  => "exame_cortisol",
            "Progesterona"              => "exame_progesterona",

            //  Exames infecciosos
            "HIV"                       => "exame_hiv",
            "Hepatite B"                => "exame_hepatite_b",
            "Hepatite C"                => "exame_hepatite_c",
            "Sífilis"                   => "exame_sifilis",

            //  Exames respiratórios
            "Espirometria"              => "exame_espirometria",
            "Gasometria Arterial"       => "exame_gasometria_arterial",
            "Teste de Função Pulmonar"  => "exame_teste_de_funcao_pulmonar"
        ];




            $diaSemana = $nomeDias[date("l", strtotime($dataSelecionada))];
            $sql = "SELECT id_horario, nome, hora_inicio, hora_fim, inicio_intervalo, fim_intervalo
                    FROM horarios_profissionais hp
                    JOIN profissionais p ON hp.id_profissional = p.id_profissional
                    WHERE p.id_profissional in (SELECT id_profissional FROM profissionais 
                    WHERE JSON_CONTAINS(especialidade, JSON_QUOTE(:nomeExame)))
                                     AND dia_semana = :diaSemana
                    ORDER BY hora_inicio;
            ";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'nomeExame' => $nomeExames[$exame],
                'diaSemana' => $diaSemana    
            ]);

            $horariosBd1 = $query->fetchall(PDO::FETCH_ASSOC);

            $horarios = [
                "disponiveis" => [],
                "agendamento" => []
            ];

            $intervaloMinutos = 30;
            $idHorario = 0;

            foreach ($horariosBd1 as $h) {
                $entrada           = $h['hora_inicio'];
                $saida             = $h['hora_fim'];
                $inicioIntervaloBd = $h['inicio_intervalo'];
                $fimIntervaloBd    = $h['fim_intervalo'];
                $idHorario         = $h['id_horario'];
                $nomeProfissional  = $h['nome'];

                $horaInicio      = strtotime($entrada);
                $horaFim         = strtotime($saida);
                $inicioIntervalo = strtotime($inicioIntervaloBd);
                $fimIntervalo    = strtotime($fimIntervaloBd);

                for ($hora = $horaInicio; $hora < $horaFim; $hora += $intervaloMinutos * 60) {
                    $proximaHora = $hora + $intervaloMinutos * 60;

                    // Pula o intervalo
                    if ($proximaHora <= $inicioIntervalo || $hora >= $fimIntervalo) {
                        $horarios['disponiveis'][$nomeProfissional][] = date("H:i", $hora) . " - " . date("H:i", $proximaHora);
                    }
                }
            }

            $sql2 = "SELECT horario_agendamento, p.nome
                FROM agendamentos_consultas ac
                JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                JOIN profissionais p ON hp.id_profissional = p.id_profissional
                WHERE id_horario_profissional = :idHorario and dia_agendamento = :dataSelecionada
                ORDER BY horario_agendamento
            ";
            $query2 = $this->conn->prepare($sql2);
            $query2->execute([
                'idHorario' => $idHorario,
                'dataSelecionada' => $dataSelecionada
                ]);
            $horariosBd2 = $query2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($horariosBd2 as $h) {
                $entrada = $h['horario_agendamento'];
                $nomeProfissional = $h['nome'];

                $horaInicio = strtotime($entrada);
                $proximaHora = $horaInicio + $intervaloMinutos * 60;
                $horarios['agendamento'][$nomeProfissional][] = date("H:i", $horaInicio) . " - " . date("H:i", $proximaHora);
            }
            
            return json_encode($horarios);
        }
    }
?>
