<?php
session_start();
include '../../../../public/includes/paciente/sidebar.php';
include '../../../../public/includes/paciente/header.php';
include '../../../../public/includes/paciente/footer.php';

require_once "../../../../controllers/ResultadoExameController.php";

$idPaciente = $_SESSION['idPaciente'];

$controller = new ResultadoExameController($conn);
$resultados = $controller->listarResultadosPorPaciente($idPaciente);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resultados de Exames</title>
  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
   rel="stylesheet">

<style>
  
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

body {
  background: #f5f6fa;
  min-height: 100vh;
}

.sidebar {
  position: fixed;
}

main {
  margin-left: 250px;
  padding: 30px 50px;
}

h2 {
  text-align: center;
  color: #001f54;
  font-size: 1.9rem;
  font-weight: 700;
  margin-top: 80px;
  margin-bottom: 35px;
}

/* ===== GRID DE CARDS ===== */
.cards-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
  gap: 25px;
  justify-items: center;
}

/* ===== CARD ===== */
.card {
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
  width: 100%;
  max-width: 380px;
  padding: 20px 25px;
  transition: all 0.25s ease;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.card:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 14px rgba(0, 0, 0, 0.12);
}

/* ===== CABEÇALHO DO CARD ===== */
.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.card-header h3 {
  font-size: 1.1rem;
  color: #222;
  font-weight: 600;
}

.categoria {
  color: #666;
  font-size: 0.9rem;
  margin-bottom: 12px;
}

/* ===== STATUS ===== */
.status {
  padding: 3px 10px;
  border-radius: 6px;
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: capitalize;
}

.status.finalizado {
  background-color: #d1f3d8;
  color: #0b9a38;
}

.status.pendente {
  background-color: #fff4b8;
  color: #8a7200;
}

/* ===== INFORMAÇÕES ===== */
.info {
  font-size: 0.9rem;
  color: #555;
  margin: 6px 0;
  display: flex;
  align-items: center;
  gap: 6px;
}

.info i {
  color: #007bff;
}

/* ===== BOTÕES ===== */
.botoes {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 15px;
}

.btn-detalhes,
.btn-baixar {
  display: flex;
  align-items: center;
  gap: 6px;
  border: none;
  border-radius: 8px;
  padding: 8px 14px;
  cursor: pointer;
  font-size: 0.9rem;
  font-weight: 500;
  transition: 0.2s;
  text-decoration: none;
}

.btn-detalhes {
  background-color: #f1f3f5;
  color: #333;
}

.btn-detalhes:hover {
  background-color: #e0e2e4;
}

.btn-baixar {
  background-color: #0069d9;
  color: white;
}

.btn-baixar:hover {
  background-color: #0056b3;
}

@media (max-width: 768px) {
  main {
    margin-left: 0;
    padding: 25px;
  }
  .cards-container {
    grid-template-columns: 1fr;
  }
}
</style>
</head>
<body>

<main>
  <h2>O Resultado de Seus Exames Estão Aqui</h2>

  <div class="cards-container">
    <?php foreach ($resultados as $resultado): ?>
    <div class="card">
      <div>
        <div class="card-header">
          <div>
            <h3><?= htmlspecialchars($resultado['exame']); ?></h3>
            <p class="categoria"><?= htmlspecialchars($resultado['categoria_exame'] ?? ''); ?></p>
          </div>
          <?php 
            $status = strtolower($resultado['status']);
            $classeStatus = $status === 'finalizado' ? 'finalizado' : 'pendente';
          ?>
          <span class="status <?= $classeStatus; ?>">
            <?= ucfirst($resultado['status']); ?>
          </span>
        </div>

        <p class="info">
          <i class="fa-regular fa-calendar"></i>
          <strong>Data de lançamento:</strong>
          <?= date('d/m/Y', strtotime($resultado['data_resultado'])); ?>
        </p>

        <p class="info">
          <i class="fa-regular fa-calendar-days"></i>
          <strong>Data do exame:</strong>
          <?= date('d/m/Y', strtotime($resultado['dia_agendamento'])); ?>
        </p>
      </div>

      <div class="botoes">
        <a href="#" class="btn-detalhes">
          <i class="fa-regular fa-eye"></i> Ver detalhes
        </a>
        <a href="download_resultado.php?idResultado=<?= $resultado['id_resultado']; ?>" class="btn-baixar">
          <i class="fa-solid fa-file-arrow-down"></i> Baixar Resultado
        </a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</main>

</body>
</html>
