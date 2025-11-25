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

        public function deletarHorario($horarioId){
            $sql = "DELETE FROM horarios_profissionais WHERE id_horario = :idHorario";
            $query = $this->conn->prepare($sql);
            return $query->execute([
                ':idHorario' => $horarioId
            ]);
        }


        public function buscarLimitesDeHorario($idProfissional) {
            $sql = "SELECT 
                    MIN(hora_inicio) AS horario_inicio, 
                    MAX(hora_fim) AS horario_fim
                FROM horarios_profissionais
                WHERE id_profissional = :idProfissional;
            ";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':idProfissional' => $idProfissional
            ]);
            $horario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Retorna já com as chaves corretas
            return [
                'horario_inicio' => $horario['horario_inicio'],
                'horario_fim' => $horario['horario_fim']
            ];
        }

        public function editarHorario(
            $horaInicio, $horaFim, $inicioIntervalo, 
            $fimIntervalo, $horarioId
        ){
            $sql = "UPDATE horarios_profissionais SET
                hora_inicio = :horaInicio,
                hora_fim = :horaFim,
                inicio_intervalo = :inicioIntervalo,
                fim_intervalo = :fimIntervalo
            WHERE id_horario = :idHorario";

            $query = $this->conn->prepare($sql);

            $resultado = $query->execute([
                ':horaInicio'     => $horaInicio,
                ':horaFim'        => $horaFim,
                ':inicioIntervalo'=> $inicioIntervalo,
                ':fimIntervalo'   => $fimIntervalo,
                ':idHorario'      => $horarioId
            ]);
            return $resultado;
        }

        public function pacientePossuiAgendamentoNoDia($idPaciente, $data, $idAgendamentoAtual) {
            $sql = "
                SELECT COUNT(*) as total FROM (
                    -- Consultas do paciente
                    SELECT id_agendamento
                    FROM agendamentos_consultas
                    WHERE id_paciente = :idPaciente
                    AND dia_agendamento = :data
                    AND status != 'cancelado'
                    " . ($idAgendamentoAtual ? "AND id_agendamento != :idAgendamentoAtual" : "") . "

                    UNION ALL

                    -- Exames do paciente (conta todos, mesmo vinculados à consulta sendo editada)
                    SELECT ae.id_agendamento
                    FROM agendamentos_exames ae
                    JOIN encaminhamentos e ON ae.id_encaminhamento = e.id_encaminhamento
                    JOIN agendamentos_consultas ac ON e.id_agendamento_consulta = ac.id_agendamento
                    WHERE ac.id_paciente = :idPaciente
                    AND ae.dia_agendamento = :data
                    AND ae.status != 'cancelado'
                ) AS total_agendamentos
            ";

            $stmt = $this->conn->prepare($sql);

            $params = [
                'idPaciente' => $idPaciente,
                'data' => $data
            ];

            if ($idAgendamentoAtual) {
                $params['idAgendamentoAtual'] = $idAgendamentoAtual;
            }

            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['total'];
        }


        # horarios disponiveis para agendamento da consulta
        public function listarHorariosDisponiveis($dataSelecionada, $profissionalId, $pacienteId, $idAgendamentoAtual) {
            date_default_timezone_set('America/Sao_Paulo'); 

            $dataSelecionada = date("Y-m-d", strtotime($dataSelecionada));
            $dataAtual       = date("Y-m-d");
            $horaAtual       = date("H:i");

            $limiteMaximo = date("Y-m-d", strtotime("+90 days"));
            if ($dataSelecionada > $limiteMaximo) {
                return json_encode([
                    "erro" => "Não é possível agendar consultas com mais de 90 dias de antecedência."
                ]);
            }
            if ($dataSelecionada < $dataAtual) {
                return json_encode([
                    "erro" => "Não é possível realizar agendamentos em dias já passados."
                ]);
            }
            
            if ($this->pacientePossuiAgendamentoNoDia($pacienteId, $dataSelecionada, $idAgendamentoAtual)) {
                return json_encode([
                    "erro" => "Você já possui um  agendamento neste dia."
                ]);
            }

            $mesmoDia = $dataSelecionada == $dataAtual;

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

            $sql = "SELECT id_horario, hora_inicio, hora_fim, inicio_intervalo, fim_intervalo
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

            $horarios = [];

            if (empty($horariosBd1)) {
                return json_encode(["erro" => "Profissional não atende neste dia."]);
            }

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

                    if($proximaHora > $horaFim){
                        continue;
                    }

                    // Pula o intervalo
                    if ($proximaHora <= $inicioIntervalo || $hora >= $fimIntervalo) {
                        if (!$mesmoDia || $hora > strtotime($horaAtual)) {
                            $horarios[] = [
                            'entrada' => $hora, 
                            'saida' => $proximaHora
                        ];
                        }
                    }
                }
            }

            $sql2 = "SELECT horario_agendamento,
                            p.nome,
                            30 as duracao
                        FROM agendamentos_consultas ac
                        JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                        JOIN profissionais p ON hp.id_profissional = p.id_profissional
                        WHERE id_horario_profissional = :idHorario and dia_agendamento = :dataSelecionada

                        UNION

                        SELECT ae.horario_agendamento,
                            p.nome,
                            te.tempo_minutos as duracao
                        FROM agendamentos_exames ae
                        JOIN encaminhamentos e ON ae.id_encaminhamento = e.id_encaminhamento
                        JOIN tipos_exames te ON e.id_exame = te.id_exame
                        JOIN agendamentos_consultas ac ON e.id_agendamento_consulta = ac.id_agendamento
                        JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                        JOIN profissionais p ON hp.id_profissional = p.id_profissional
                        WHERE (SELECT sub.id_horario
                                FROM horarios_profissionais sub
                                WHERE sub.id_profissional = p.id_profissional
                                AND dia_semana = (CASE 
                                    WHEN DAYOFWEEK(ae.dia_agendamento) = 1 THEN 'domingo'
                                    WHEN DAYOFWEEK(ae.dia_agendamento) = 2 THEN 'segunda'
                                    WHEN DAYOFWEEK(ae.dia_agendamento) = 3 THEN 'terca'
                                    WHEN DAYOFWEEK(ae.dia_agendamento) = 4 THEN 'quarta'
                                    WHEN DAYOFWEEK(ae.dia_agendamento) = 5 THEN 'quinta'
                                    WHEN DAYOFWEEK(ae.dia_agendamento) = 6 THEN 'sexta'
                                    WHEN DAYOFWEEK(ae.dia_agendamento) = 7 THEN 'sabado'
                                    ELSE null
                                END)) = :idHorario and ae.dia_agendamento = :dataSelecionada
                        ORDER BY 1;

            ";
            $query2 = $this->conn->prepare($sql2);
            $query2->execute([
                'idHorario' => $idHorario,
                'dataSelecionada' => $dataSelecionada
                ]);
            $agendas = $query2->fetchAll(PDO::FETCH_ASSOC);

            $horariosLivres = [];
            foreach ($horarios as $h) {
                $inicioDisponivel = $h['entrada'];
                $fimDisponivel = $h['saida'];
                $ocupado = false;
                
                foreach ($agendas as $agenda) {
                    $inicioAgenda = strtotime($agenda['horario_agendamento']);
                    $fimAgenda = strtotime($agenda['horario_agendamento']) + ($agenda['duracao'] * 60);
                    
                    if ($inicioAgenda < $fimDisponivel && $fimAgenda > $inicioDisponivel) {
                        $ocupado = true;
                        break;
                    }
                }
                
                if (!$ocupado) {
                    $horariosLivres[] = date("H:i", $inicioDisponivel) . " - " . date("H:i", $fimDisponivel);
                }
            }
            if (empty($horariosLivres)) {
                return json_encode(["erro" => "Nenhum horário disponivel neste momento. Agende outro dia"]);
            }
            
            return json_encode($horariosLivres);
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
            date_default_timezone_set('America/Sao_Paulo');

            $dataSelecionada = date("Y-m-d", strtotime($dataSelecionada));
            $dataAtual       = date("Y-m-d");
            $horaAtual       = date("H:i");

            $limiteMaximo = date("Y-m-d", strtotime("+90 days"));
            if ($dataSelecionada > $limiteMaximo) {
                return json_encode([
                    "erro" => "Não é possível agendar exames com mais de 90 dias de antecedência."
                ]);
            }
            if ($dataSelecionada < $dataAtual) {
                return json_encode([
                    "erro" => "Não é possível realizar agendamentos em dias já passados."
                ]);
            }

            $mesmoDia = $dataSelecionada == $dataAtual;

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
            "Gemoglobina Glicada"       => "exame_hemoglobina_glicada",

            // Exames de imagem
            "Raio-x"                    => "exame_raio_x",
            "Ressonância Magnética"     => "exame_ressonancia_magnetica",
            "Tomografia"                => "exame_tomografia",
            "Ultrassonografia"          => "exame_ultrassonografia",
            "Mamografia"                => "exame_mamografia",
            "Densitometria óssea"       => "exame_densitometria_ossea",

            //  Exames cardiológicos
            "Eletrocardiograma"         => "exame_eletrocardiograma",
            "Ecocardiograma"            => "exame_ecocardiograma",
            "Teste Ergométrico"         => "exame_teste_ergometrico",

            //  Exames de urina
            "Urocultura"                => "exame_urocultura",
            "Exame De Urina"            => "exame_exame_de_urina",

            //  Exames hormonais
            "Tsh"                       => "exame_tsh",
            "Testosterona"              => "exame_testosterona",
            "Estradiol"                 => "exame_estradiol",
            "Cortisol"                  => "exame_cortisol",
            "Progesterona"              => "exame_progesterona",

            //  Exames infecciosos
            "Hiv"                       => "exame_hiv",
            "Hepatite B"                => "exame_hepatite_b",
            "Hepatite C"                => "exame_hepatite_c",
            "Sífilis"                   => "exame_sifilis",

            //  Exames respiratórios
            "Espirometria"              => "exame_espirometria",
            "Gasometria Arterial"       => "exame_gasometria_arterial"
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

            if (empty($horariosBd1)) {
                return json_encode(["erro" => "Profissional não atende neste dia."]);
            }

            $horarios = [];
            $sql =  "SELECT tempo_minutos from tipos_exames WHERE nome = :nomeExame";
            $query = $this->conn->prepare($sql);
            $query->execute([
                'nomeExame' => $exame
            ]);
            $tempoMinutos = $query->fetchColumn();
        
            $intervaloMinutos = 30;

            $sobraTempoExame = ceil($tempoMinutos / $intervaloMinutos);

            foreach ($horariosBd1 as $h) {
                $entrada           = $h['hora_inicio'];
                $saida             = $h['hora_fim'];
                $inicioIntervaloBd = $h['inicio_intervalo'];
                $fimIntervaloBd    = $h['fim_intervalo'];
                $nomeProfissional  = $h['nome'];

                $horaInicio      = strtotime($entrada);
                $horaFim         = strtotime($saida);
                $inicioIntervalo = strtotime($inicioIntervaloBd);
                $fimIntervalo    = strtotime($fimIntervaloBd);

                for ($hora = $horaInicio; $hora < $horaFim; $hora += ($intervaloMinutos * 60 * $sobraTempoExame)) {
                    $proximaHora = $hora + ($intervaloMinutos * 60 * $sobraTempoExame);

                    if($proximaHora > $horaFim){
                        continue;
                    }
                    // Pula o intervalo
                    if ($proximaHora <= $inicioIntervalo || $hora >= $fimIntervalo) {
                        if (!$mesmoDia || $hora > strtotime($horaAtual)) {
                           $horarios[$nomeProfissional][] = [
                            'entrada' => $hora, 
                            'saida' => $proximaHora
                        ];
                        }
                    }
                }
            }

            $sql2 = "SELECT horario_agendamento,
                            p.nome,
                            30 as duracao
                        FROM agendamentos_consultas ac
                        JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                        JOIN profissionais p ON hp.id_profissional = p.id_profissional
                        WHERE p.id_profissional in (SELECT id_profissional
                                                    FROM profissionais 
                                                    WHERE JSON_CONTAINS(especialidade, JSON_QUOTE(:nomeExame)))
                            and dia_agendamento = :dataSelecionada

                        UNION

                        SELECT ae.horario_agendamento,
                            p.nome,
                            te.tempo_minutos as duracao
                        FROM agendamentos_exames ae
                        JOIN encaminhamentos e ON ae.id_encaminhamento = e.id_encaminhamento
                        JOIN tipos_exames te ON e.id_exame = te.id_exame
                        JOIN agendamentos_consultas ac ON e.id_agendamento_consulta = ac.id_agendamento
                        JOIN horarios_profissionais hp ON ac.id_horario_profissional = hp.id_horario
                        JOIN profissionais p ON hp.id_profissional = p.id_profissional
                        WHERE p.id_profissional in (SELECT id_profissional
                                                    FROM profissionais 
                                                    WHERE JSON_CONTAINS(especialidade, JSON_QUOTE(:nomeExame)))
                            and ae.dia_agendamento = :dataSelecionada
                        ORDER BY 1;

            ";
            $query2 = $this->conn->prepare($sql2);
            $query2->execute([
                'nomeExame' => $nomeExames[$exame],
                'dataSelecionada' => $dataSelecionada
            ]);
            $agendas = $query2->fetchAll(PDO::FETCH_ASSOC);

            $horariosLivres = [];
            foreach ($horarios as $nomeProfissional => $disponiveis) {
                $horariosLivres[$nomeProfissional] = [];
                
                foreach ($disponiveis as $disponivel) {
                    $inicioDisponivel = $disponivel['entrada'];
                    $fimDisponivel = $disponivel['saida'];
                    $ocupado = false;
                    
                    foreach ($agendas as $agenda) {
                        $inicioAgenda = strtotime($agenda['horario_agendamento']);
                        $fimAgenda = strtotime($agenda['horario_agendamento']) + ($agenda['duracao'] * 60);
                    
                        if ($inicioAgenda < $fimDisponivel && $fimAgenda > $inicioDisponivel) {
                            $ocupado = true;
                            break;
                        }
                    }
                    
                    if (!$ocupado) {
                        $horariosLivres[$nomeProfissional][] = date("H:i", $inicioDisponivel) . " - " . date("H:i", $fimDisponivel);;
                    }
                }
            }

            if (empty($horariosLivres[$nomeProfissional])) {
                return json_encode(["erro" => "Nenhum horário disponível neste momento. Agende outro dia"]);
            }
            
            return json_encode($horariosLivres);
        }

    }
?>
