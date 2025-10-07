<?php
  session_start();
  include '../../../../public/includes/paciente/sidebar.php';
  include '../../../../public/includes/paciente/header.php';
  include '../../../../public/includes/paciente/footer.php';

  require_once "../../../../controllers/RelatorioController.php";

  $idPaciente = $_SESSION['idPaciente'];

  $controller = new RelatorioController($conn);

  $totalExames = $controller->totalExamesPaciente($idPaciente);
  $exameMaisComum = $controller->exameMaisRecorrente($idPaciente);
  $totalExamesCancelados = $controller->totalExamesCancelados($idPaciente);
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

</head>

<style>
     * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }


    .conteudo-principal {
    font-family: "Poppins", sans-serif;
    background-color: #f7f9fb;
    padding: 20px 40px;
    min-height: 100vh;
     margin-left: 250px; /* Ajuste conforme a largura real do seu sidebar */
    }

.titulo-pagina h1 {
  font-size: 1.8rem;
  color: #1e3a8a;
  font-weight: 700;
  margin-bottom: 25px;
}
.sidebar{
    position: fixed;
}

.indicadores {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  margin-bottom: 30px;
}

.card-indicador {
  flex: 1;
  min-width: 250px;
  height: 120px;
  display: flex;
  align-items: center;
  gap: 15px;
  border-radius: 12px;
  color: #fff;
  padding: 15px 20px;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
}

.card-indicador i {
  font-size: 1.8rem;
}

.card-indicador p {
  font-size: 0.9rem;
  margin: 0;
}

.card-indicador h2 {
  margin: 0;
  font-size: 1.4rem;
  font-weight: 600;
}

.card-indicador.azul {
  background: #3b82f6;
}

.card-indicador.cinza {
  background: #6b7280;
}

.card-indicador.vermelho {
  background: #ef4444;
}

/* Cards dos exames */
.cards-exames {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
}

.card-exame {
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease;
}

.card-exame:hover {
  transform: translateY(-4px);
}

.header-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.header-card h3 {
  margin: 0;
  color: #1e3a8a;
  font-size: 1.1rem;
}

.status {
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
  color: #fff;
}

.status.realizado {
  background: #10b981;
}

.status.cancelado {
  background: #ef4444;
}

.categoria {
  color: #6b7280;
  font-size: 0.9rem;
  margin-bottom: 8px;
}

.data {
  color: #374151;
  font-size: 0.9rem;
  margin-bottom: 15px;
}

.acoes {
  display: flex;
  gap: 10px;
}

.btn-ver,
.btn-baixar {
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 0.9rem;
  padding: 8px 14px;
  transition: background 0.3s ease;
}

.btn-ver {
  background: #e5e7eb;
  color: #1e3a8a;
}

.btn-ver:hover {
  background: #d1d5db;
}

.btn-baixar {
  background: #3b82f6;
  color: #fff;
}

.btn-baixar:hover {
  background: #2563eb;
}

</style>

<body>
  <main class="conteudo-principal">
  <div class="titulo-pagina">
    <h1>Histórico de Exames</h1>
  </div>

  <!-- Indicadores -->
  <div class="indicadores">
    <div class="card-indicador azul">
      <i class="fa-solid fa-file-medical"></i>
      <div>
        <p>Total de Exames já efetuados</p>
        <h2><?php echo $totalExames ?></h2>
      </div>
    </div>

    <div class="card-indicador cinza">
      <i class="fa-solid fa-flask"></i>
      <div>
        <p>Exame mais recorrente</p>
        <h2><?php echo $exameMaisComum ?></h2>
      </div>
    </div>

    <div class="card-indicador vermelho">
      <i class="fa-solid fa-ban"></i>
      <div>
        <p>Total de Exames Cancelados</p>
        <h2><?php echo $totalExamesCancelados ?></h2>
      </div>
    </div>
  </div>

  <!-- Cards dos exames -->
  <div class="cards-exames">
    <!-- Exame 1 -->
    <div class="card-exame">
      <div class="header-card">
        <h3>Hemograma Completo</h3>
        <span class="status realizado">Realizado</span>
      </div>
      <p class="categoria">Sangue</p>
      <p class="data">Exame realizado em: <strong>2025-08-01</strong> às <strong>10:30</strong></p>
      <div class="acoes">
        <button class="btn-ver">Ver detalhes</button>
        <button class="btn-baixar">Baixar Resultado</button>
      </div>
    </div>

    <!-- Exame 2 -->
    <div class="card-exame">
      <div class="header-card">
        <h3>Ressonância Magnética</h3>
        <span class="status realizado">Realizado</span>
      </div>
      <p class="categoria">Imagem</p>
      <p class="data">Exame realizado em: <strong>2025-07-03</strong> às <strong>09:00</strong></p>
      <div class="acoes">
        <button class="btn-ver">Ver detalhes</button>
        <button class="btn-baixar">Baixar Resultado</button>
      </div>
    </div>

    <!-- Exame 3 -->
    <div class="card-exame">
      <div class="header-card">
        <h3>Endoscopia Digestiva</h3>
        <span class="status cancelado">Cancelado</span>
      </div>
      <p class="categoria">Clínico</p>
      <p class="data">Exame cancelado em: <strong>2025-09-15</strong> às <strong>11:00</strong></p>
      <div class="acoes">
        <button class="btn-ver">Ver detalhes</button>
      </div>
    </div>
  </div>
</main>

</body>
</html>
