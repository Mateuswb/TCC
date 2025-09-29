<?php
    session_start();
    include '../../../public/includes/profissional/sidebar.php';

    require_once "../../../controllers/ProfissionalController.php";

    $controller = new ProfissionalController($conn);
    $pacientes = $controller->listarPacientesPorProfissional();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Poppins", sans-serif; }

    body {
      background: #f5f6fa;
      min-height: 100vh;
      display: flex;
    }

   

    /* Main */
    .main {
      margin-left: 250px;
      flex: 1;
      display: flex;
      flex-direction: column;
      transition: margin-left 0.3s;
    }

    /* Header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #085274ff;
      color: #fff;
      padding: 15px 30px;
    }
    .header input {
      padding: 8px 12px;
      border: none;
      border-radius: 20px;
      outline: none;
      width: 200px;
    }
    .profile {
    display: flex;
    align-items: center;
    gap: 10px;
    }

    .profile img {
      width: 35px;
      height: 35px;
      border-radius: 2  0%;
    }

    /* Conteúdo */
    .content { padding: 20px; }

    h1 { margin-bottom: 20px; color: #2980b9; }

    /* Grid Cards Pacientes */
    .grid-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 20px;
    }

    .card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      padding: 20px;
      transition: transform 0.2s;
    }
    .card:hover { transform: translateY(-5px); }
    .card h2 {
      margin-bottom: 14px;
      font-size: 20px;
      color: #2980b9;
      border-bottom: 2px solid #2980b9;
      padding-bottom: 6px;
    }

    .info-list { list-style: none; margin-bottom: 15px; }
    .info-list li { margin-bottom: 6px; font-size: 14px; color: #333; }
    .info-list li strong { color: #2980b9; margin-right: 5px; }

    .footer { text-align: right; }
    .btn-edit, .btn-delete {
      padding: 8px 14px;
      border-radius: 6px;
      font-weight: 600;
      text-decoration: none;
      color: #fff;
      margin-left: 8px;
      transition: background 0.2s;
    }
    .btn-edit { background: #2980b9; }
    .btn-edit:hover { background: #1f6391; }
    .btn-delete { background: #c0392b; }
    .btn-delete:hover { background: #a8281d; }
  </style>

<body>
     <!-- Conteúdo -->
    <div class="content">
      <h1>Lista de todos os Paciente que já realizaram consultas</h1>

      <div class="grid-container">
        <?php foreach ($pacientes as $paciente) { ?>
          <div class="card">
            <h2><?php echo $paciente['nome']; ?></h2>
            <ul class="info-list">
              <li><strong>CPF:</strong> <?php echo $paciente['cpf']; ?></li>
              <li><strong>Email:</strong> <?php echo $paciente['email']; ?></li>
              <li><strong>Data Nasc.:</strong> <?php echo $paciente['data_nascimento']; ?></li>
              <li><strong>Telefone:</strong> <?php echo $paciente['telefone']; ?></li>
              <li><strong>Sexo:</strong> <?php echo $paciente['sexo']; ?></li>
              <li><strong>Estado Civil:</strong> <?php echo $paciente['estado_civil']; ?></li>
              <li><strong>Tipo Sanguíneo:</strong> <?php echo $paciente['tipo_sanguineo']; ?></li>
              <li><strong>Altura:</strong> <?php echo $paciente['altura']; ?></li>
              <li><strong>Peso:</strong> <?php echo $paciente['peso']; ?></li>
              <li><strong>Bairro:</strong> <?php echo $paciente['bairro']; ?></li>
              <li><strong>Cidade:</strong> <?php echo $paciente['cidade']; ?></li>
              <li><strong>ID:</strong> <?php echo $paciente['id_paciente']; ?></li>
              <li><strong>Observações:</strong> <?= substr($paciente['observacoes'],0,10) ?>...</li>
            </ul>

            <div class="footer">
              <a href="editar_paciente.php?idPaciente=<?php echo $paciente['id_paciente']; ?>" class="btn-edit">Editar</a>
              <a class="btn-delete"
                href="deletar.php?idPaciente=<?php echo $paciente['id_paciente']; ?>&cpf=<?php echo $paciente['cpf']; ?>"
                onclick="confirmarExclusao(this.href); return false;">
                Excluir
              </a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
</body>
</html>