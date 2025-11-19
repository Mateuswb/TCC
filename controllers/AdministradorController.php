<?php
    require_once dirname(__DIR__) . "/config/conexao.php";
    require_once dirname(__DIR__) . "/models/Usuario.php";
    require_once dirname(__DIR__) . "/models/Paciente.php";
    require_once dirname(__DIR__) . "/models/AgendamentoConsulta.php";
    require_once dirname(__DIR__) . "/models/AgendamentoExame.php";
    require_once dirname(__DIR__) . "/models/Profissional.php";
    require_once dirname(__DIR__) . "/models/Exame.php";
    require_once dirname(__DIR__) . "/models/Relatorio.php";
    require_once dirname(__DIR__) . "/models/Encaminhamento.php";
    require_once dirname(__DIR__) . "/controllers/Email.php";
    
    require_once dirname(__DIR__) . "/controllers/UsuarioController.php";

    class AdministradorController {
        private $usuarioModel;
        private $pacienteModel;
        private $profissionalModel;
        private $agendamentoConsultaModel;
        private $agendamentoExameModel;
        private $exameModel;
        private $encaminhamentoModel;
        private $emailController;

        private $usuarioController;

        public function __construct($conn) {
            $this->usuarioModel = new Usuario($conn);
            $this->pacienteModel = new Paciente($conn);
            $this->profissionalModel = new Profissional($conn);
            $this->agendamentoConsultaModel = new AgendamentoConsulta($conn);
            $this->agendamentoExameModel = new AgendamentoExame($conn);
            $this->exameModel = new Exame($conn);
            $this->encaminhamentoModel = new Encaminhamento($conn);
            $this->usuarioController = new UsuarioController($conn);
            $this->usuarioController = new UsuarioController($conn);
            $this->emailController = new Email();
        }

        # Pacientes
        public function listarPacientes() {
            return $this->pacienteModel->listarPaciente();
        }

        public function listarDadosPaciente() {
            $idPaciente = $_GET['idPaciente'];
            return $this->pacienteModel->listarDadosPaciente($idPaciente);
        }

        public function editarDadosPaciente() {
            $idPaciente     = $_POST['idPaciente'];
            $nome           = $_POST['nome'];
            $email          = $_POST['email'];
            $dataNascimento = $_POST['dataNascimento'];
            $telefone       = $_POST['telefone'];
            $sexo           = $_POST['sexo'];
            $altura         = $_POST['altura'];
            $peso           = $_POST['peso'];
            $estadoCivil    = $_POST['estadoCivil'];
            $tipoSanguineo  = $_POST['tipoSanguineo'];
            $numCasa        = $_POST['numeroCasa'];
            $endereco       = $_POST['endereco'];
            $bairro         = $_POST['bairro'];
            $cidade         = $_POST['cidade'];
            $observacoes    = $_POST['observacoes'];

            $editar = $this->pacienteModel->editarDadosPaciente(
                $idPaciente, $nome, $email, $dataNascimento, 
                $telefone, $sexo, $altura, $peso, $estadoCivil,
                $tipoSanguineo, $endereco, $numCasa, $bairro,
                $cidade, $observacoes
            );

            session_start();
            if($editar){
                $_SESSION['flash'] = [
                    'type' => 'success', 
                    'message' => "Dados atualizados com sucesso."
                ];
            }
            else{
                $_SESSION['flash'] = [
                    'type' => 'error', 
                    'message' => "Erro ao editar dados do paciente."
                ];
            }
            header("Location: ../views/administrador/paciente/listar_pacientes.php");
            exit;

        }

        # Usuarios
        public function listarUsuarios() {
            return $this->usuarioModel->listarUsuarios();
        }

        public function listarDadosUsuario() {
            $usuarioId = $_GET['idUsuario'];
            return $this->usuarioModel->listarDadosUsuario($usuarioId);
        }

        # Profissionais
        public function cadastrarProfissional() {
            $nome           = $_POST['nome'];
            $rg             = $_POST['rg'];
            $email          = $_POST['email'];
            $dataNascimento = $_POST['dataNascimento'];
            $telefone       = preg_replace('/[^\d]/', '', $_POST['telefone']);
            $sexo           = $_POST['sexo'];
            $estadoCivil    = $_POST['estadoCivil'];
            $crmCrp         = $_POST['crmCrp'];
            $especialidade  = $_POST['especialidades'] ?? [];
            $endereco       = $_POST['endereco'];
            $numeroCasa     = $_POST['numCasa'];
            $bairro         = $_POST['bairro'];
            $cidade         = $_POST['cidade'];
            $observacoes    = $_POST['observacoes'];

            $cpf = $this->usuarioController->cadastrar();

            session_start();
            if ($cpf) {
                $criouProfissional = $this->profissionalModel->cadastrarProfissional(
                    $nome, $cpf, $rg, $email, $dataNascimento, $telefone, 
                    $sexo, $estadoCivil, $crmCrp, $especialidade, 
                    $endereco, $numeroCasa, $bairro, $cidade, $observacoes
                );

                if ($criouProfissional) {
                    unset($_SESSION['cadastroTemp']);
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => "Profissional cadastrado com sucesso"
                    ];
                } else {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => "Erro ao criar os dados do profissional."
                    ];
                }
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => "Erro ao criar o usuário."
                ];
            }
            header("Location: ../views/administrador/home.php");
        }

        public function listarProfissionais() {
            return $this->profissionalModel->listarProfissionais();
        }

        public function listarDadosProfissional() {
            $idProfissional = $_GET['idProfissional'];
            return $this->profissionalModel->listarDadosProfissional($idProfissional);
        }

        public function editarDadosProfissional() {
            $idProfissional = $_POST['idProfissional'];
            $nome           = $_POST['nome'];
            $rg             = $_POST['rg'];
            $email          = $_POST['email'];
            $dataNascimento = $_POST['dataNascimento'];
            $telefone       = $_POST['telefone'];
            $sexo           = $_POST['sexo'];
            $estadoCivil    = $_POST['estadoCivil'];
            $crmCrp         = $_POST['crmCrp'];
            $especialidade  = $_POST['especialidades'] ?? [];
            $endereco       = $_POST['endereco'];
            $numCasa        = $_POST['numeroCasa'];
            $bairro         = $_POST['bairro'];
            $cidade         = $_POST['cidade'];
            $observacoes    = $_POST['observacoes'];

            $editar = $this->profissionalModel->editarDadosProfissional(
                $idProfissional, $nome, $rg, $email, $dataNascimento, 
                $telefone, $sexo, $estadoCivil, $crmCrp, $especialidade,
                $endereco, $numCasa, $bairro, $cidade, $observacoes
            );

            session_start();
            if($editar){
                 $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Dados atualizados com sucesso.'
                ];
            }
            else{
                 $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao atualizar dados. Tente novamente'
                ];
            }
            header("Location: ../views/administrador/profissional/listar_profissionais.php");
            exit;
        }

        # agendamentos
        public function listarAgendamentos(){
            return $this->agendamentoConsultaModel->listarAgendamentos();
        }   

        # tipos exames 
        public function listarExames(){
            return $this->exameModel->listarExames();
        }
        
        public function cadastrarExame() {
            $categoria = substr($_POST['categoria'], 0, 2);
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $tempoMinutos = $_POST["tempoMinutos"];

            session_start();
            if(!$this->exameModel->existeProfissionalParaCategoria($nome)) {
                $_SESSION['error'] = "Não é possível cadastrar este exame. Nenhum profissional na clínica tem essa especialidade.";
                header("Location: ../views/administrador/exame/listar_exames.php");
                exit;
            }

            if ($this->exameModel->exameJaCadastrado($nome)) {
                $_SESSION['error'] = "Este exame já está cadastrado!";
                header("Location: ../views/administrador/exame/listar_exames.php");
                exit;
            }

            $nomeTratado = ucwords(strtolower($nome));
            $cadastro = $this->exameModel->cadastrarExame($categoria, $nomeTratado, $descricao, $tempoMinutos);

            if($cadastro){
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Exame cadastrado com sucesso.'
                ];
            } else {
                 $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao cadastrar exame. Tente novamente.'
                ];
            }
            header("Location: ../views/administrador/exame/listar_exames.php");
            exit;
        }
        
        public function editarExame(){
            $idExame = $_POST['idExame'];
            $nome = $_POST['nome'];
            $categoria = $_POST['categoria'];
            $descricao = $_POST['descricao'];
            $tempoMinutos = $_POST["tempoMinutos"];

            $editar = $this->exameModel->editarExame($idExame,  $nome, $categoria, $descricao, $tempoMinutos);

            session_start();
            if($editar){
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Exame editado com sucesso.'
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao editar exame. Tente novamente'
                ];
            }
            header("Location: ../views/administrador/exame/listar_exames.php");
            exit;

        }

       public function deletarExame() {
            $idExame = $_POST['idExame'];

            session_start();
            if ($this->exameModel->temAgendamentoAtivoExame($idExame)) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Este exame possui agendamentos ou encaminhamentos ativos e não pode ser deletado no momento. Cancele todos os agendamentos e encaminhamentos com este exame primeiro.'
                ];
                header("Location: ../views/administrador/exame/listar_exames.php");
                exit;
            }

            $deletar = $this->exameModel->deletarExame($idExame);

            if ($deletar) {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Exame deletado com sucesso'
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao deletar exame. Tente novamente'
                ];
            }

            header("Location: ../views/administrador/exame/listar_exames.php");
            exit;
        }
        
        # agedamento consultas
        public function cancelarAgendamentoConsulta(){
            $idConsulta = $_POST['idConsulta'];

            $dados = $this->agendamentoConsultaModel->getAgendamento($idConsulta);
            $cancelar = $this->agendamentoConsultaModel->cancelarAgendamentoConsulta($idConsulta);
            
            $mensagem = '
                <!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                <meta charset="UTF-8">
                <title>Cancelamento de Exame</title>
                </head>
                <body style="font-family: Arial, sans-serif; background-color:#f4f6f8; margin:0; padding:0;">
                <table align="center" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background:#123068; color:#ffffff; text-align:center; padding:20px;">
                            <h1 style="margin:0; font-size:22px;">Cancelamento de Exame</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px; color:#333333; font-size:15px; line-height:1.6;">
                            <p>Olá <strong>' . $dados['paciente_nome'] . '</strong>,</p>
                            <p>Informamos que o exame que havia sido agendado foi <strong>cancelado</strong>.</p>
                            
                            <table width="100%" cellpadding="8" cellspacing="0" style="margin:15px 0; border:1px solid #ddd; border-radius:6px;">
            
                                <tr>
                                    <td><strong>Profissional:</strong></td>
                                    <td>'. $dados['nome_profissional'] . '</td>
                                </tr>
                                <tr style="background:#f4f6f8;">
                                    <td><strong>Clínica:</strong></td>
                                    <td>MedHub</td>
                                </tr>
                            </table>
                            
                            <p>Se desejar reagendar o exame, clique no botão abaixo e siga as instruções:</p>
                            
                            <p style="text-align:center; margin:30px 0;">
                                <a href="http://localhost/tcc/views/paciente/consultas/listar_profissionais.php" 
                                style="background:#123068; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-size:16px; display:inline-block;">
                                Reagendar Exame
                                </a>
                            </p>
                            
                            <p style="font-size:13px; color:#777;">Se o botão não funcionar, copie e cole este link no navegador:<br>
                            <a href="http://localhost/tcc02/views/paciente/teste.html" style="color:#123068;">
                                http://localhost/tcc/views/paciente/consultas/listar_profissionais.php
                            </a></p>
                            
                            <p style="margin-top:20px;">Atenciosamente,<br><strong>Equipe Clínica MedHub</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f4f6f8; text-align:center; font-size:12px; color:#888; padding:15px;">
                            © ' . date("Y") . ' Clínica MedHub. Todos os direitos reservados.
                        </td>
                    </tr>
                </table>
                </body>
                </html>
                ';


            session_start();
            if($cancelar){
                try {
                    $this->emailController->enviarEmail($dados['paciente_email'], $dados['paciente_nome'], 'Consulta Cancelada.', $mensagem);
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Exame cancelado e email enviado'
                    ];
                } catch (Exception $e) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => "Erro ao enviar email: {$e->getMessage()}"
                    ];
                }
            }
            else{
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao cancelar consulta'
                ];
            }
            header("Location: ../views/administrador/agendamento/agendamentos.php");
            exit;
        }

        public function realizarEncaminhamento(){

            $idExame = $_POST['idExame'];
            $observacoes = $_POST['observacoes'];
            $idAgendamentoConsulta = $_POST['idAgendamentoConsulta'];

            $encaminhar = $this->encaminhamentoModel->cadastrarEncaminhamento($idExame, $observacoes, $idAgendamentoConsulta);

            $trocarStatus = $this->agendamentoConsultaModel->finalizarAgendamentoConsulta($idAgendamentoConsulta);

            $dados = $this->agendamentoConsultaModel->getAgendamento($idAgendamentoConsulta);
            
            $mensagem = '
                <!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                <meta charset="UTF-8">
                <title>Encaminhamento de Exame</title>
                </head>
                <body style="font-family: Arial, sans-serif; background-color:#f4f6f8; margin:0; padding:0;">
                <table align="center" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                    <tr>
                    <td style="background:#123068; color:#ffffff; text-align:center; padding:20px;">
                        <h1 style="margin:0; font-size:22px;">Encaminhamento de Exame</h1>
                    </td>
                    </tr>
                    <tr>
                    <td style="padding:20px; color:#333333; font-size:15px; line-height:1.6;">
                        <p>Olá <strong>' . $dados['paciente_nome'] . '</strong>,</p>
                        <p>Você recebeu um encaminhamento para realizar um exame solicitado por um de nossos profissionais.</p>
                        
                        <table width="100%" cellpadding="8" cellspacing="0" style="margin:15px 0; border:1px solid #ddd; border-radius:6px;">
                        <tr style="background:#f4f6f8;">
                            <td><strong>Exame:</strong></td>
                            <td>'. $dados['nome_exame'] . '</td>
                        </tr>
                        <tr>
                            <td><strong>Profissional:</strong></td>
                            <td>'. $dados['nome_profissional'] .'</td>
                        </tr>
                        <tr style="background:#f4f6f8;">
                            <td><strong>Clínica:</strong></td>
                            <td>MedHub</td>
                        </tr>
                        </table>
                        
                        <p>Para realizar o exame, clique no botão abaixo e siga as instruções:</p>
                        
                        <p style="text-align:center; margin:30px 0;">
                        <a href="http://localhost/tcc/views/paciente/exames/encaminhamento/listar_encaminhamentos.php" 
                            style="background:#123068; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-size:16px; display:inline-block;">
                            Acessar Exame
                        </a>
                        </p>
                        
                        <p style="font-size:13px; color:#777;">Se o botão não funcionar, copie e cole este link no navegador:<br>
                        <a href="http://localhost/tcc/views/paciente/exames/encaminhamento/listar_encaminhamentos.php" style="color:#123068;">
                        http://localhost/tcc/views/paciente/exames/encaminhamento/listar_encaminhamentos.php
                        </a></p>
                        
                        <p style="margin-top:20px;">Atenciosamente,<br><strong>Equipe Clínica MedHub</strong></p>
                    </td>
                    </tr>
                    <tr>
                    <td style="background:#f4f6f8; text-align:center; font-size:12px; color:#888; padding:15px;">
                        © ' . date("Y") . ' Clínica MedHub. Todos os direitos reservados.
                    </td>
                    </tr>
                </table>
                </body>
                </html>
            ';
            
            session_start();
            if($encaminhar){
                try {
                    $this->emailController->enviarEmail($dados['paciente_email'], 
                    $dados['paciente_nome'], 
                    'Encaminhamento de exame', 
                    $mensagem);
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Exame encaminhado e email enviado'
                    ];
                } catch (Exception $e) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => 'Erro ao eviar email.'
                    ];
                }
            }
            else{
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao encaminhar exame. Tente novamente'
                ];
            }
            header("Location: ../views/administrador/agendamento/agendamentos.php");
            exit;
        }

        # agedamento exame
        public function cancelarExame()
        {
            $idAgendamentoExame = $_POST['idAgendamentoExame'];
            $idAgendamentoExame = $_POST['idAgendamentoExame'];

            // Busca dados relacionados à consulta e ao paciente
            $dados = $this->agendamentoExameModel->getAgendamentoExame($idAgendamentoExame);

            // Cancela o exame
            $cancelarExame = $this->agendamentoExameModel->cancelarAgendamentoExame($idAgendamentoExame);

            $mensagem = '
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
                <meta charset="UTF-8">
                <title>Cancelamento de Exame</title>
            </head>
            <body style="font-family: Arial, sans-serif; background-color:#f4f6f8; margin:0; padding:0;">
                <table align="center" width="600" cellpadding="0" cellspacing="0" 
                    style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background:#004080; color:#ffffff; text-align:center; padding:20px;">
                            <h1 style="margin:0; font-size:22px;">Cancelamento de Exame</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px; color:#333333; font-size:15px; line-height:1.6;">
                            <p>Olá <strong>' . $dados['paciente_nome'] . '</strong>,</p>

                            <p>Informamos que o seu exame <strong>' . $dados['nome_exame'] . '</strong> foi 
                            <strong>cancelado</strong> pelo profissional responsável.</p>

                            <table width="100%" cellpadding="8" cellspacing="0" 
                                style="margin:15px 0; border:1px solid #ddd; border-radius:6px;">
                                <tr>
                                    <td><strong>Exame:</strong></td>
                                    <td>' . $dados['nome_exame'] . '</td>
                                </tr>
                                <tr>
                                    <td><strong>Profissional responsável:</strong></td>
                                    <td>' . $dados['nome_profissional'] . '</td>
                                </tr>
                                <tr style="background:#f4f6f8;">
                                </tr>
                                <tr>
                                    <td><strong>Clínica:</strong></td>
                                    <td>MedHub</td>
                                </tr>
                            </table>

                            <p>Se o cancelamento ocorreu por engano ou desejar reagendar, entre em contato com a clínica 
                            ou acesse sua área do paciente.</p>

                            <p style="text-align:center; margin:30px 0;">
                                <a href="http://localhost/tcc/views/paciente/exames/exames_agendados/listar_agendamentos.php" 
                                style="background:#004080; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:6px; font-size:16px; display:inline-block;">
                                    Acessar Meus Exames
                                </a>
                            </p>

                            <p style="font-size:13px; color:#777;">Se o botão não funcionar, copie e cole este link no navegador:<br>
                                <a href="http://localhost/tcc/views/paciente/exames/exames_agendados/listar_agendamentos.php" style="color:#004080;">
                                    http://localhost/tcc/views/paciente/exames/exames_agendados/listar_agendamentos.php
                                </a>
                            </p>

                            <p style="margin-top:20px;">Atenciosamente,<br><strong>Equipe Clínica MedHub</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f4f6f8; text-align:center; font-size:12px; color:#888; padding:15px;">
                            © ' . date("Y") . ' Clínica MedHub. Todos os direitos reservados.
                        </td>
                    </tr>
                </table>
            </body>
            </html>
            ';

            // Garante que a sessão está ativa
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Se o cancelamento for bem-sucedido, envia o e-mail
            if ($cancelarExame) {
                try {
                    $this->emailController->enviarEmail(
                        $dados['paciente_email'],
                        $dados['paciente_nome'],
                        'Cancelamento de Exame',
                        $mensagem
                    );

                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Exame cancelado com sucesso. E-mail enviado ao paciente.'
                    ];
                } catch (Exception $e) {
                    $_SESSION['flash'] = [
                        'type' => 'warning',
                        'message' => 'Exame cancelado, mas ocorreu um erro ao enviar o e-mail.'
                    ];
                }
            } else {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao cancelar o exame.'
                ];
            }

            header("Location: ../views/administrador/agendamento/agendamentos.php");
            exit;
        }


        #validar exclusão do profissional
        public function excluirProfissional() {
            $idProfissional = $_POST['idProfissional'];
            $cpf            = $_POST['cpf'];

            session_start();
            try {
                $temAgendamento = $this->profissionalModel->temAgendamentoAtivo($idProfissional);
                if ($temAgendamento) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => "O profissional possui agendamentos ativos, ele não pode ser excluído."
                    ];
                    header("Location: ../views/administrador/profissional/listar_profissionais.php");
                    exit;
                }

                $this->profissionalModel->excluirProfissionalComUsuario($idProfissional, $cpf);

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "Profissional e usuário excluídos com sucesso."
                ];
                header("Location: ../views/administrador/profissional/listar_profissionais.php");
                exit;

            } catch (Exception $e) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ];
                header("Location: ../views/administrador/profissional/listar_profissionais.php");
                exit;
            }
        }

        #validar exclusão do paciente
        public function excluirPaciente() {
            $idPaciente     = $_POST['idPaciente'];
            $cpf            = $_POST['cpf'];

            session_start();
            try {
                $temAgendamento = $this->pacienteModel->temAgendamentoAtivoPaciente($idPaciente);
                if ($temAgendamento) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => "O paciente possui agendamentos ativos, ele não pode ser excluído."
                    ];
                    header("Location: ../views/administrador/paciente/listar_pacientes.php");
                    exit;
                }

                $this->pacienteModel->excluirPacienteComUsuario($idPaciente, $cpf);

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "Paciente e usuário excluídos com sucesso."
                ];
                header("Location: ../views/administrador/paciente/listar_pacientes.php");
                exit;

            } catch (Exception $e) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ];
                header("Location: ../views/administrador/paciente/listar_pacientes.php");
                exit;
            }
        }

        #validar exclusão usuario
        public function deletarUsuario() {
            $idUsuario = $_POST['idUsuario'] ?? null;
            $cpf = $_POST['cpf'] ?? null;

            session_start();
            try {
                $this->usuarioModel->excluirUsuario($idUsuario, $cpf);

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "Usuário deletado com sucesso"
                ];
            } catch (Exception $e) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => "Erro ao deletar usuário: " . $e->getMessage()
                ];
            }

            header("Location: ../views/administrador/usuario/listar_usuarios.php");
            exit;
        }
    
        public function bloquearUsuario(){
            $idUsuario = $_POST['idUsuario'];

            $bloquear = $this->usuarioModel->bloquearUsuario($idUsuario);

            session_start();
            if($bloquear){
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Usuário bloqueado com sucesso'
                ];
            }
            else{
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao bloquear usuário. Tente Novamente.'
                ];
            }
            header("Location: ../views/administrador/usuario/listar_usuarios.php");
            exit;
        }   

        public function desbloquearUsuario(){
            $idUsuario = $_POST['idUsuario'];

            $bloquear = $this->usuarioModel->desbloquearUsuario($idUsuario);

            session_start();
            if($bloquear){
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Usuário desbloqueado com sucesso'
                ];
            }
            else{
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao desbloquear usuário. Tente Novamente.'
                ];
            }
            header("Location: ../views/administrador/usuario/listar_usuarios.php");
            exit;
        }   

      public function editarUsuario() {
            try {
                session_start();

                $idUsuario = $_POST['id_usuario'];
                $cpfNovo = str_replace(['.', '-'], '', trim($_POST['cpf']));
                $senhaNova = isset($_POST['senha']) ? trim($_POST['senha']) : '';

                $usuarioAtual = $this->usuarioModel->buscarPorId($idUsuario);

                if (!$usuarioAtual) {
                    throw new Exception("Usuário não encontrado.");
                }

                $cpfAntigo = $usuarioAtual['login'];
                $tipoUsuario = $usuarioAtual['tipo_usuario'];
                $senhaAntiga = $usuarioAtual['senha'];

                if (empty($senhaNova)) {
                    $senhaFinal = $senhaAntiga;
                } else {
                    $senhaFinal = password_hash($senhaNova, PASSWORD_DEFAULT);
                }

                $atualizado = $this->usuarioModel->editarUsuario($idUsuario, $cpfNovo, $senhaFinal);

                if (!$atualizado) {
                    throw new Exception("Erro ao atualizar os dados do usuário.");
                }

                if ($cpfAntigo !== $cpfNovo) {
                    switch ($tipoUsuario) {
                        case 'paciente':
                            $this->pacienteModel->atualizarCpfPaciente($cpfAntigo, $cpfNovo);
                            break;

                        case 'profissional':
                            $this->profissionalModel->atualizarCpfProfissional($cpfAntigo, $cpfNovo);
                            break;

                        case 'admin':

                            break;
                    }
                }

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Dados atualizados com sucesso.'
                ];

                header("Location: ../views/administrador/usuario/listar_usuarios.php");
                exit;

            } catch (Exception $e) {
                session_start();
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Erro ao editar dados: ' . $e->getMessage()
                ];
                header("Location: ../views/administrador/usuario/listar_usuarios.php");
                exit;
            }
        }
    }

    $controller = new AdministradorController($conn);
    if (isset($_GET['acao'])) {
        switch ($_GET['acao']) {
            case 'editarDadosPaciente':
                $controller->editarDadosPaciente();
                break;
            case 'editarDadosProfissional':
                $controller->editarDadosProfissional();
                break;
            case 'cadastrarProfissional':
                $controller->cadastrarProfissional();
                break;
            case 'cadastrarExame':
                $controller->cadastrarExame();
                break;
            case 'editarExame':
                $controller->editarExame();
                break;
            case 'deletarExame':
                $controller->deletarExame();
                break;
            case 'excluirProfissional':
                $controller->excluirProfissional();
                break;
            case 'excluirPaciente':
                $controller->excluirPaciente();
                break;
            case 'cancelarAgendamentoConsulta':
                $controller->cancelarAgendamentoConsulta();
                break;
            case 'encaminharPaciente':
                $controller->realizarEncaminhamento();
                break;
            case 'deletarUsuario':
                $controller->deletarUsuario();
                break;
            case 'cancelarExame':
                $controller->cancelarExame();
                break;
            case 'bloquearUsuario':
                $controller->bloquearUsuario();
                break;
            case 'desbloquearUsuario':
                $controller->desbloquearUsuario();
                break;
            case 'editarUsuario':
                $controller->editarUsuario();
                break;
            default:
                echo "Ação inválida";
                break;
        }
    }
?>