<?php
session_start();
include '../../../../public/includes/paciente/sidebar.php';
include '../../../../public/includes/paciente/header.php';
include '../../../../public/includes/paciente/footer.php';

$idPaciente = $_SESSION['idPaciente'];

require_once "../../../../controllers/EncaminhamentoController.php";

$controller = new EncaminhamentoController($conn);
$encaminhamentos = $controller->listarEncaminhamentosPorPaciente($idPaciente);
?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>MedHub — Exames Agendados</title>

  <!-- Fonte e ícones -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
   rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    :root {
      --blue: #003366;
      --accent: #0b7fc1;
      --muted: #6c757d;
      --card-bg: #fff;
      --shadow: 0 4px 12px rgba(0,0,0,0.08);
      --success: #28a745;
      --success-bg: #d4edda;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #f4f6fa;
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    main {
      flex: 1;
      margin-top: 60px;
      padding: 30px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 50px;
    }

    main h1 {
      font-size: 28px;
      color: var(--blue);
      font-weight: 700;
      margin-bottom: 30px;
      text-align: center;
    }

    /* Grid de cards */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(370px, 1fr));
      gap: 25px;
      width: 100%;
      max-width: 1600px;
    }

    .card {
      background: var(--card-bg);
      border-radius: 12px;
      padding: 18px;
      box-shadow: var(--shadow);
      position: relative;
      min-height: 160px;
      display: flex;
      flex-direction: column;
      border: 1px solid rgba(11,59,90,0.06);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    }

    .card h3 {
      margin: 0;
      font-size: 18px;
      color: var(--blue);
      font-weight: 600;
    }

    .badge {
      position: absolute;
      right: 14px;
      top: 14px;
      background: var(--success-bg);
      color: var(--success);
      padding: 6px 12px;
      border-radius: 999px;
      font-weight: 600;
      font-size: 13px;
      border: 1px solid rgba(0,0,0,0.05);
    }

    .meta {
      margin-top: 10px;
      color: var(--muted);
      font-size: 14px;
    }

    .meta i {
      margin-right: 6px;
    }

    .btns {
      margin-top: 16px;
      display: flex;
      justify-content: space-between;
      gap: 12px;
    }

    .btn {
      flex: 1;
      display: inline-block;
      padding: 10px;
      text-align: center;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      font-size: 13px;
      transition: background 0.2s ease;
    }

    .btn-primary {
      background: linear-gradient(180deg,var(--accent),#0b5fa0);
      color: #fff;
      box-shadow: 0 6px 14px rgba(11,59,90,0.12);
    }

    .btn-primary:hover {
      background: linear-gradient(180deg,#0c8bdb,#0b5fa0);
    }

    .btn-danger {
      background: #dc3545;
      color: #fff;
    }

    .btn-danger:hover {
      background: #c82333;
    }
  </style>
</head>

<body>
  <main>
    <h1>Exames Agendados</h1>

    <section class="cards" aria-live="polite" id="cardsContainer">
      <?php if (!empty($encaminhamentos)): ?>
        <?php foreach ($encaminhamentos as $p): ?>
          <article class="card">
            <span class="badge">Agendado</span>
            <h3><?php echo htmlspecialchars($p['exame']); ?></h3>

            <div class="meta">
              <div><i class="fas fa-user-md"></i> Encaminhado por: <strong><?php echo htmlspecialchars($p['profissional_encaminhou']); ?></strong></div>
              <div><i class="fas fa-calendar"></i> <?php echo htmlspecialchars($p['data_exame'] ?? '----/--/--'); ?></div>
              <div><i class="fas fa-clock"></i> <?php echo htmlspecialchars($p['hora_exame'] ?? '--:--'); ?></div>
            </div>

            <div class="btns">
                <!-- colocar o id aq -->
              <a class="btn btn-primary" href="editar.php?id=">Editar Dados do Exame</a>
              <a class="btn btn-danger" href="cancelar.php?id=">Cancelar</a>
            </div>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align:center;color:var(--muted);font-size:15px;">Nenhum exame agendado no momento.</p>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>
