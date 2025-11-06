<?php
  include '../public/modals/usuario/modal_login.php';
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Med Hub — Agende Consultas e Exames</title>

  <!-- IMPORT FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <!-- IMPORT ICONS -->
  <script src="https://kit.fontawesome.com/4b60c7eafd.js" crossorigin="anonymous"></script>

<style>

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}


html, body {
  height: 100%;
  font-family: "Inter", sans-serif;
  background: #FAFDFF;
  color: #002E53;
  overflow-x: hidden;
  line-height: 1.5;
}

a {
  color: inherit;
  text-decoration: none;
}

img {
  display: block;
  max-width: 100%;
  border-radius: 12px;
}

/* header */
header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  padding: 20px 6%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #015997;
  box-shadow: 0 4px 20px rgba(0, 46, 83, 0.08);
  z-index: 2000;
  transition: all 0.3s ease;
}

header.scrolled {
  background: white;
  box-shadow: 0 10px 28px rgba(0, 0, 0, 0.08);
}

.brand {
  font-weight: 800;
  font-size: 2.3rem;
  color: #002E53;
}

.brand span {
  color: white;
}

nav ul {
  display: flex;
  gap: 60px;
  list-style: none;
}

nav a {
  position: relative;
  font-size: 1.1rem;
  font-weight: 600;
  color: white;
  padding-bottom: 4px;
}

nav a::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -3px;
  height: 3px;
  width: 0;
  background: white;
  border-radius: 4px;
  transition: width 0.25s ease;
}

nav a:hover::after {
  width: 100%;
}

.btn-login {
  background: #0257B8;
  color: white;
  padding: 10px 35px;
  border-radius: 12px;
  font-weight: 700;
  border: 1px solid white;
  transition: all 0.3s ease;
}

.btn-login:hover {
  background: #003879;
  transform: translateY(-3px);
}


.hero {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 40px;
  padding: 160px 6% 80px;
  background: linear-gradient(135deg, #015997, #1C5FAB);
  color: white;
  position: relative;
  
}

.hero-left {
  max-width: 700px;
  text-align: center;
  background: #0a3472;
  padding: 60px 40px;
  border-radius: 5px 190px 150px 200px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
}

.hero-title {
  font-size: 2.8rem;
  font-weight: 800;
  margin-bottom: 15px;
}

.hero-sub {
  font-size: 1.1rem;
  margin-bottom: 25px;
}

.btn-primary {
  background: white;
  color: #015997;
  padding: 14px 32px;
  border-radius: 12px;
  font-weight: 700;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
}

.btn-primary:hover {
  transform: translateY(-3px);
}

.hero-right {
  max-width: 450px;
  position: relative;
}

.hero-wave {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 120px;
  line-height: 0;
}


.agendar-section {
  background-color: #1C5FAB;
  padding: 100px 6%;
  display: flex;
  justify-content: center;

  margin-top: 100px;
}

.agendar-card {
  display: flex;
  align-items: center;
  gap: 60px;
  max-width: 1200px;
}

.agendar-left img {
  max-width: 460px;
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
}

.agendar-right {
  color: white;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.agendar-right h2 {
  font-size: 2.4rem;
  line-height: 1.2;
}

.feature-list {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.feature-list li {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 1.05rem;
}

.feature-list i {
  background: rgba(255, 255, 255, 0.2);
  padding: 10px;
  border-radius: 50%;
}


.exames-section {
  background: white;
  padding: 80px 8%;
  display: flex;
  justify-content: center;
}

.exames-container {
  display: flex;
  align-items: center;
  gap: 60px;
  max-width: 1100px;
}

.exames-imagens img {
  width: 100%;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

.exames-texto h2 {
  font-size: 2rem;
  color: #006699;
  margin-bottom: 10px;
}

.exames-texto p {
  font-size: 1rem;
  color: #333;
  margin-bottom: 15px;
  line-height: 1.6;
}


.session-especialistas {
  width: 100%;
  background: rgba(0, 81, 255, 0.07);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 80px 6%;
}

.especialista-wrap {
  display: flex;
  justify-content: space-between;
  gap: 40px;
  width: 100%;
  max-width: 1700px;
  padding: 60px;
  border-radius: 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  background: white;
}

.especialista-left {
  flex: 1;
}

.especialista-left h2 {
  font-size: 2.2rem;
  margin-bottom: 15px;
  color: #002E53;
}

.especialista-left p {
  margin-bottom: 25px;
  font-size: 1.1rem;
  color: #333;
}

.especialidades-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 15px;
  margin-bottom: 25px;
}

.especialidade-item {
  background: #E8F4FF;
  padding: 12px 20px;
  border-radius: 10px;
  text-align: center;
  font-weight: 600;
  color: #0b4a88;
  transition: all 0.3s ease;
}

.especialidade-item:hover {
  background: #cde6ff;
}

.btn-visualizar {
  background: #1C5FAB;
  color: white;
  padding: 12px 28px;
  border: none;
  border-radius: 10px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-visualizar:hover {
  background: #0a3472;
}

.especialista-right img {
  max-width: 460px;
  border-radius: 16px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}


.footer-medhub {
  background: linear-gradient(180deg, #003366 0%, #00264d 100%);
  color: #fff;
  padding: 20px 8%;
  font-family: "Inter", sans-serif;
}

.footer-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
}

.footer-left,
.footer-right {
  flex: 1;
  min-width: 220px;
}

.footer-right {
  text-align: right;
}

.footer-center {
  flex: 2;
  text-align: center;
}

.footer-left h4,
.footer-right h4 {
  font-size: 1.1rem;
  color: #d8eaff;
  margin-bottom: 8px;
  font-weight: 600;
}

.footer-left p {
  line-height: 1.6;
  color: #bcd8f0;
  font-size: 1rem;
}

.footer-slogan {
  color: #cce6ff;
  font-weight: 500;
  font-size: 1.05rem;
  margin-bottom: 10px;
}

.footer-logo {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 12px;
  margin: 8px 0;
}

.logo-med {
  font-weight: 800;
  font-size: 1.9rem;
  color: #fff;
}

.logo-hub {
  font-weight: 800;
  font-size: 1.9rem;
  color: #6bc3ff;
}

.footer-rights {
  margin-top: 10px;
  font-size: 0.95rem;
  color: #aac9e9;
}

.footer-btn {
  background: #0059AC;
  color: white;
  border: none;
  padding: 12px 22px;
  font-weight: 600;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 1rem;
}

.footer-btn:hover {
  background: #003ccc;
  transform: translateY(-3px);
}

.hero-right {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
}

.hero-right img {
  width: 100%;
  max-width: 480px;
  z-index: 2;
  position: relative;
}


.circle-deco {
  position: absolute;
  border-radius: 50%;
  filter: blur(7px);
  opacity: 0.8;
  z-index: 1;
}


.circle-a {
  width: 180px;
  height: 180px;
  background: radial-gradient(circle, #1C5FAB, #003366);
  top: -40px;
  right: -60px;

}


.circle-b {
  width: 120px;
  height: 120px;
  background: radial-gradient(circle, #2769b4ff, #003366);
  bottom: -40px;
  left: -40px;
  animation-delay: 2s;
}




@media (max-width: 768px) {
  header {
    padding: 15px 5%;
  }

  nav ul {
    gap: 20px;
  }

  .hero {
    flex-direction: column;
    text-align: center;
    padding-top: 140px;
  }

  .agendar-card,
  .especialista-wrap,
  .exames-container {
    flex-direction: column;
    text-align: center;
  }

  .footer-top {
    flex-direction: column;
    text-align: center;
    gap: 15px;
  }
}



</style>

</head>
<body>
  <?php include '../public/assets/alerta/flash.php' ?>

  <header id="site-header">
    <div class="brand">Med <span>Hub</span></div>
    <nav>
      <ul>
        <li><a href="#home">Início</a></li>
        <li><a href="#agendar">Consultas</a></li>
        <li><a href="#exames">Exames</a></li>
        <li><a href="#sobre">Sobre nós</a></li>
      </ul>
    </nav>
    <a class="btn-login" href="#" onclick="abrirModal()">Login</a>
  </header>

  <main>

    <section id="home" class="hero reveal">
      <div class="hero-left">
        <h1 class="hero-title">Agende seus exames e consultas de forma rápida e prática</h1>
        <p class="hero-sub">
          Organize atendimentos, exames e resultados em uma plataforma prática, segura e moderna.
        </p>
        <a class="btn-primary" href="#agendar">Agende já</a>
      </div>

      <div class="hero-right">
        <img src="fundo_05.png" alt="Agendamento Médico">
        <div class="circle-deco circle-a"></div>
        <div class="circle-deco circle-b"></div>
      </div>

      <div class="hero-wave" aria-hidden="true">
        <svg viewBox="0 0 1440 160" preserveAspectRatio="none">
          <path d="M0,85 
                   C240,110 480,70 720,90 
                   C960,110 1200,10 1600,85 
                   L1440 160 L0 160 Z" 
                fill="#ffffff"></path>
        </svg>
      </div>
    </section>

    <section id="agendar" class="agendar-section reveal">
      <div class="agendar-card">
        <div class="agendar-left">
          <img src="fundo_06.png" alt="Calendário Médico">
        </div>

        <div class="agendar-right">
          <h2>
            Agende suas<br>
            <span>Consultas e Exames</span><br>
            de forma <span>Rápida</span>
          </h2>

          <ul class="feature-list">
            <li>
              <i class="fa-solid fa-calendar-check"></i>
              <span>Marque consultas e exames online</span>
            </li>
            <li>
              <i class="fa-solid fa-bell"></i>
              <span>Receba notificações automáticas</span>
            </li>
          </ul>

          <a class="btn-primary" href="#">Agendar agora</a>
        </div>
      </div>
    </section>

    <section id="exames" class="exames-section">
      <div class="exames-container">
        <div class="exames-imagens">
          <img src="fundo_07.jpg" alt="Imagem exame 1">
        </div>

        <div class="exames-texto">
          <h2>Exames</h2>
          <p>
            Nossa clínica oferece uma ampla gama de exames laboratoriais e de imagem,
            todos com agendamento online. Sem filas, sem complicações, você escolhe
            o melhor horário.
          </p>

          <ul class="exames-lista">
            <li><strong>Exames laboratoriais:</strong> sangue, urina, glicemia e mais</li>
            <li><strong>Exames de imagem:</strong> raio-X, ultrassonografia, tomografia</li>
          </ul>
        </div>
      </div>
    </section>

    <section id="especialistas" class="session-especialistas reveal">
      <div class="especialista-wrap">

        <div class="especialista-left">
          <h2>Encontre o especialista certo <span>para o seu atendimento</span></h2>
          <p>
            Disponibilizamos profissionais de diversas áreas médicas, garantindo praticidade
            e qualidade no atendimento.
          </p>

          <div class="especialidades-grid">
            <a href="#" class="especialidade-item">Cardiologista</a>
            <a href="#" class="especialidade-item">Ortopedista</a>
            <a href="#" class="especialidade-item">Pediatra</a>
            <a href="#" class="especialidade-item">Clínico geral</a>
          </div>

          <button class="btn-visualizar">Visualizar</button>
        </div>

        <div class="especialista-right">
          <img src="fundo_07.jpg" alt="Médico" />
        </div>
      </div>
    </section>

  </main>

  <footer class="footer-medhub">
    <div class="footer-top">
      <div class="footer-col footer-left">
        <h4>Criadores</h4>
        <p>Henrique Pereira Luiz<br>Mateus Warmling Berti</p>
      </div>

      <div class="footer-col footer-center">
        <p class="footer-slogan">
          Gestão de Consultas e Exames com Agilidade e Segurança
        </p>
        <div class="footer-logo">
          <span class="logo-med">Med</span>
          <span class="logo-hub">Hub</span>
        </div>
        <p class="footer-rights">© 2025 MedHub | Direitos reservados</p>
      </div>

      <div class="footer-col footer-right">
        <button class="footer-btn">💬 Fale Conosco</button>
      </div>
    </div>
  </footer>

</body>
</html>