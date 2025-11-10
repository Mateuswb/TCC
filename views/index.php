<?php
  include '../public/modals/usuario/modal_login.php';
?>  
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>MedHub — Agende Consultas e Exames</title>

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <!-- Icons -->
  <script src="https://kit.fontawesome.com/4b60c7eafd.js" crossorigin="anonymous"></script>

 <style>
:root {
  --white: #ffffff;
  --primary: #015997;
  --dark: #002E53;
  --muted: #f3fbff;
  --glass: rgba(255,255,255,0.06);
  --max-width: 1200px;
  --easing: cubic-bezier(.2,.9,.25,1);
  --shadow-strong: 0 30px 60px rgba(0,34,80,0.16);
  --shadow-soft: 0 10px 30px rgba(2,46,83,0.08);
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html, body {
  height: 100%;
  font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, Arial;
  -webkit-font-smoothing: antialiased;
  background: var(--muted);
  color: var(--dark);
  scroll-behavior: smooth;
}

a {
  color: inherit;
  text-decoration: none;
}

img {
  display: block;
  max-width: 100%;
}

.container {
  max-width: 1600px;
  margin: 0 auto;
  padding: 0 20px;
}

header {
  position: fixed;
  left: 0;
  right: 0;
  top: 0;
  z-index: 1000;
  background: linear-gradient(180deg, rgba(255,255,255,0.95), rgba(255,255,255,0.90));
  backdrop-filter: blur(6px);
  box-shadow: 0 6px 20px rgba(2,46,83,0.06);
  transition: all .28s var(--easing);
  padding: 20px 0;
}

.header-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 26px;
}

.brand {
  font-weight: 800;
  font-size: 2.3rem;
  color: #015997;
}

nav ul {
  display: flex;
  gap: 50px;
  list-style: none;
  align-items: center;
}

nav a {
  font-weight: 600;
  color: var(--dark);
  padding: 8px 10px;
  border-radius: 8px;
  transition: all .18s;
}

nav a:hover {
  background: var(--glass);
}

.btn-login {
  background: #0F3C77;
  border: 1px solid #0F3C77;
  color: #fff;
  padding: 9px 25px;
  border-radius: 10px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-login:hover {
  transform: translateY(-2px) scale(1.02);
  background: #104b99;
}

.mobile-toggle {
  display: none;
  border: 0;
  background: transparent;
  font-size: 1.2rem;
  color: var(--dark);
  cursor: pointer;
}

main {
  padding-top: 84px;
}

.section {
  width: 100%;
  min-height: 100vh;
  position: relative;
  overflow: visible;
  display: flex;
  align-items: center;
}

.section-inner {
  max-width: var(--max-width);
  margin: 0 auto;
  padding: 74px 20px;
  display: flex;
  gap: 36px;
  align-items: center;
}

.col {
  flex: 1;
  min-width: 0;
}

.reveal {
  opacity: 0;
  transform: translateY(22px);
  transition: all .8s var(--easing);
}

.revealed {
  opacity: 1;
  transform: none;
}

.section.especialistas:not(:first-of-type)::before,
.section.exames:not(:first-of-type)::before {
  background: linear-gradient(180deg, rgba(243,251,255,1), rgba(243,251,255,0.98));
  box-shadow: 0 -22px 48px rgba(0,34,80,0.10);
}

.hero {
  background: linear-gradient(135deg, var(--primary), var(--dark));
  color: var(--white);
  overflow: visible;
}

.hero .section-inner {
  align-items: center;
}

.hero-left {
  flex: 1;
  z-index: 6;
  position: relative;
}

.hero-title {
  font-size: 2.6rem;
  line-height: 1.02;
  font-weight: 800;
  margin-bottom: 12px;
}

.hero-sub {
  font-size: 1.05rem;
  opacity: .95;
  margin-bottom: 18px;
}

.cta-row {
  display: flex;
  gap: 14px;
  flex-wrap: wrap;
}

.btn-primary {
  background-color: #00284e;
  padding: 12px 22px;
  border-radius: 12px;
  font-weight: 800;
  border: 0;
  box-shadow: var(--shadow-soft);
  cursor: pointer;
}

.btn-ghost {
  background: rgba(255,255,255,0.08);
  color: var(--white);
  padding: 10px 18px;
  border-radius: 10px;
  border: 0;
  cursor: pointer;
}

.hero-right {
  flex: 0 0 520px;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  z-index: 6;
}

.hero-illustration {
  width: 92%;
  max-width: 520px;
  border-radius: 16px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.14);
  transform: translateY(0);
  animation: float 6s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0) }
  50% { transform: translateY(-14px) }
}

.floating-elements {
  position: absolute;
  inset: 0;
  pointer-events: none;
  z-index: 4;
  overflow: visible;
}

.floating-wrapper {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
}

.float-item {
  position: absolute;
  display: flex;
  align-items: center;
  justify-content: center;
  will-change: transform, opacity;
  pointer-events: none;
  opacity: .95;
}

.float-shape {
  border-radius: 999px;
  background: rgba(255,255,255,0.12);
  box-shadow: 0 8px 30px rgba(0,0,0,0.06);
  backdrop-filter: blur(3px);
  border: 1px solid rgba(255,255,255,0.06);
}

.float-shape.small { width: 44px; height: 44px }
.float-shape.med { width: 78px; height: 78px }
.float-shape.big { width: 120px; height: 120px; opacity: .9 }

.float-icon {
  background: rgba(255,255,255,0.95);
  color: var(--primary);
  width: 46px;
  height: 46px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  box-shadow: 0 10px 30px rgba(1,89,151,0.08);
  font-weight: 700;
}

.float-icon.blue {
  background: var(--white);
  color: var(--primary);
}

@keyframes floaty1 {
  0% { transform: translateY(0) rotate(0deg) }
  50% { transform: translateY(-24px) rotate(-6deg) }
  100% { transform: translateY(0) rotate(0deg) }
}

@keyframes floaty2 {
  0% { transform: translateY(0) rotate(0deg) }
  50% { transform: translateY(-38px) rotate(7deg) }
  100% { transform: translateY(0) rotate(0deg) }
}

@keyframes floaty3 {
  0% { transform: translateY(0) rotate(0deg) }
  50% { transform: translateY(-18px) rotate(-4deg) }
  100% { transform: translateY(0) rotate(0deg) }
}

@keyframes driftX {
  0% { transform: translateX(0) }
  50% { transform: translateX(18px) }
  100% { transform: translateX(0) }
}

.a1 { animation: floaty1 6.6s ease-in-out infinite; }
.a2 { animation: floaty2 8.2s ease-in-out infinite; }
.a3 { animation: floaty3 5.6s ease-in-out infinite; }
.a4 { animation: floaty1 7.4s ease-in-out infinite; }
.a5 { animation: floaty2 9.1s ease-in-out infinite; }
.a6 { animation: floaty3 6.8s ease-in-out infinite; }
.xdrift { animation: driftX 10s ease-in-out infinite; }

.float-item[data-opacity] { opacity: var(--o,0.9) }
.float-item[data-scale] {
  transform-origin: center;
  transform: scale(var(--s,1));
}

.agendar {
  background: linear-gradient(180deg, var(--primary), #0f5f8c);
  color: var(--white);
  margin-top: 90px;
  overflow: visible;
  position: relative;
}

.agendar::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -35px;
  width: 100%;
  height: 80px;
  background: linear-gradient(to bottom, rgba(0, 59, 94, 0.9), rgba(15, 95, 140, 0));
  filter: blur(20px);
  z-index: 2;
  pointer-events: none;
}

.agendar-left { flex: 0 0 420px }
.agendar-card {
  background: rgba(255,255,255,0.04);
  padding: 22px;
  border-radius: 14px;
  box-shadow: var(--shadow-soft);
}

.agendar h2 {
  font-size: 1.9rem;
  margin-bottom: 12px;
  font-weight: 800;
}

.feature-list {
  list-style: none;
  padding: 0;
  margin: 12px 0 16px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.feature-item {
  display: flex;
  align-items: center;
  gap: 12px;
  font-weight: 700;
  color: rgba(255,255,255,0.95);
}

.feature-item i {
  background: rgba(255,255,255,0.07);
  padding: 10px;
  border-radius: 8px;
}

.especialistas {
  background: var(--white);
  color: var(--dark);
  overflow: visible;
}

.especialistas .section-inner {
  align-items: center;
}

.especialista-left {
  flex: 1;
  padding-right: 8px;
}

.especialista-right { flex: 0 0 420px }

.especialista-left h2 {
  font-size: 1.9rem;
  color: var(--dark);
  margin-bottom: 10px;
  font-weight: 800;
}

.especialidades-grid {
  display: grid;
  grid-template-columns: repeat(2,1fr);
  gap: 12px;
  margin: 18px 0;
}

.especialidade-item {
  display: inline-block;
  padding: 12px;
  border-radius: 10px;
  border: 1px solid rgba(1,89,151,0.08);
  font-weight: 700;
  color: var(--primary);
  text-align: center;
  background: linear-gradient(180deg,rgba(1,89,151,0.03),transparent);
}

.exames {
  background-color: #01599713;
  color: var(--dark);
  overflow: visible;
  box-shadow: 1px 10px 5px black;
}

.exames .section-inner {
  align-items: center;
}

.exames-left { flex: 0 0 420px }
.exames-right {
  flex: 1;
  padding-left: 8px;
}

.exames h2 {
  font-size: 1.8rem;
  color: var(--dark);
  margin-bottom: 10px;
  font-weight: 800;
}

.exames-cards {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  margin-top: 12px;
}

.exam-card {
  background: linear-gradient(180deg,#fbfeff,#f5fbff);
  padding: 14px;
  border-radius: 12px;
  border: 1px solid rgba(1,89,151,0.04);
  box-shadow: 0 8px 24px rgba(2,46,83,0.04);
  min-width: 170px;
  flex: 1;
}

.parallax-tris {
  position: absolute;
  inset: 0;
  pointer-events: none;
  z-index: 0;
  overflow: hidden;
}

.parallax-tris .tri {
  position: absolute;
  opacity: .50;
  filter: blur(6px);
  transform-origin: center;
}

.tri.t1 {
  left: -60px;
  top: 40px;
  width: 220px;
  height: 220px;
  background-color: rgb(0, 43, 124);
  clip-path: polygon(50% 0%,0% 100%,100% 100%);
}

.tri.t2 {
  right: -40px;
  bottom: 20px;
  width: 180px;
  height: 180px;
  background-color: rgb(0, 43, 124);
  opacity: .01;
}

.tri.t3 {
  left: 20%;
  top: 60%;
  width: 140px;
  height: 140px;
  background: linear-gradient(135deg,#cfe9ff,#6bc3ff);
  opacity: .02;
}

footer {
  background: linear-gradient(180deg,var(--dark),#001e3a);
  color: var(--white);
  padding: 48px 0;
}

.footer-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
}

.footer-logo {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
}

.footer-logo .brand {
  color: var(--white);
}

.footer-btn {
  background: var(--white);
  color: var(--primary);
  padding: 10px 16px;
  border-radius: 10px;
  border: 0;
  font-weight: 700;
  cursor: pointer;
}

@media(max-width:980px) {
  .hero-right { flex: 0 0 360px }
  .agendar-left, .especialista-right, .exames-left { flex: 0 0 320px }
  nav ul { gap: 18px }
}

@media(max-width:760px) {
  .container { padding: 0 16px }
  .section-inner { flex-direction: column; padding: 48px 16px; gap: 24px }
  nav ul { display: none }
  .mobile-toggle { display: block }
  .hero-title { font-size: 1.8rem; text-align: center }
  .hero-sub { text-align: center }
  .hero-right { order: 2 }
  .hero-left { order: 1; text-align: center }
  .agendar-left, .agendar-right, .especialista-right, .especialista-left, .exames-left, .exames-right {
    flex-basis: 100%;
    flex: unset;
  }
  .especialidades-grid { grid-template-columns: repeat(2,1fr) }
  .float-item { display: none }
  .section:not(:first-of-type)::before {
    content: '';
    position: absolute;
    left: 6%;
    right: 6%;
    top: -28px;
    height: 60px;
    border-radius: 16px;
    background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(255,255,255,0.94));
    box-shadow: 0 -28px 60px rgba(0,34,80,0.12), 0 8px 24px rgba(0,0,0,0.02);
    z-index: 5;
    pointer-events: none;
  }
}

.sr-only {
  position: absolute;
  left: -9999px;
  top: auto;
  width: 1px;
  height: 1px;
  overflow: hidden;
}
</style>

</head>
<body>
<header id="site-header" aria-label="Cabeçalho do site">
  <div class="container header-inner">
    <div style="display:flex;align-items:center;gap:12px">
      <div class="brand" aria-hidden="true">
        <div class="logo-pill">Med <span>Hub</span></div>
      </div>
      <button class="mobile-toggle" aria-expanded="false" aria-controls="mobile-nav" id="mobileToggle" title="Abrir menu">
        <i class="fa-solid fa-bars"></i>
      </button>
    </div>

    <nav aria-label="Navegação principal">
      <ul id="mainNav">
        <li><a href="#home">Início</a></li>
        <li><a href="#agendar">Consultas</a></li>
        <li><a href="#exames">Exames</a></li>
        <li><a href="#sobre">Sobre nós</a></li>
      </ul>
    </nav>

    <div style="display:flex;gap:12px;align-items:center">
      <button class="btn-login" onclick="abrirModal()">Login</button>
    </div>
  </div>

  <div id="mobile-nav"
       style="display:none;background:var(--white);box-shadow:0 8px 28px rgba(0,0,0,0.06);
              position:fixed;top:70px;left:12px;right:12px;border-radius:12px;padding:12px;z-index:1100">
    <nav aria-label="Navegação mobile">
      <ul style="list-style:none;display:flex;flex-direction:column;gap:8px">
        <li><a href="#home" onclick="toggleMobileNav()">Início</a></li>
        <li><a href="#agendar" onclick="toggleMobileNav()">Consultas</a></li>
        <li><a href="#exames" onclick="toggleMobileNav()">Exames</a></li>
        <li><a href="#sobre" onclick="toggleMobileNav()">Sobre nós</a></li>
      </ul>
    </nav>
  </div>
</header>

<main>

  <!-- HERO -->
  <section id="home" class="section hero" aria-label="Hero — Agende consultas e exames">
    <div class="floating-elements" aria-hidden="true">
      <div class="floating-wrapper">
        <div class="float-item a2" style="left:6%;top:20%;z-index:3;--s:1.05" data-opacity="0.95" data-scale="1">
          <div class="float-shape big"></div>
        </div>
        <div class="float-item a1 xdrift" style="left:78%;top:12%;z-index:3;--o:0.95;--s:0.98">
          <div class="float-shape med"></div>
        </div>
        <div class="float-item a3" style="left:22%;top:38%;z-index:5;--o:0.95;--s:0.9">
          <div class="float-shape small"></div>
        </div>
        <div class="float-item a4" style="left:12%;top:8%;z-index:6;--o:1;--s:1">
          <div class="float-icon blue"><i class="fa-solid fa-stethoscope"></i></div>
        </div>
        <div class="float-item a2" style="left:72%;top:44%;z-index:6;--o:1;--s:1">
          <div class="float-icon"><i class="fa-solid fa-heartbeat"></i></div>
        </div>
        <div class="float-item a5" style="left:86%;top:6%;z-index:6;--o:0.98;--s:0.95">
          <div class="float-icon blue"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="float-item a6" style="left:10%;top:68%;z-index:4;--o:0.95;--s:0.9">
          <div class="float-icon"><i class="fa-solid fa-pills"></i></div>
        </div>
        <div class="float-item a3" style="left:44%;top:8%;z-index:2;--s:0.6">
          <div class="float-shape small" style="background:rgba(255,255,255,0.06)"></div>
        </div>
        <div class="float-item a4" style="left:30%;top:72%;z-index:2;--s:0.7">
          <div class="float-shape med" style="background:rgba(255,255,255,0.05)"></div>
        </div>
        <div class="float-item a1" style="left:56%;top:22%;z-index:3;--s:0.85">
          <div class="float-shape small" style="background:rgba(255,255,255,0.08)"></div>
        </div>
        <div class="float-item a5" style="left:62%;top:64%;z-index:3;--s:0.9">
          <div class="float-shape small" style="background:rgba(255,255,255,0.06)"></div>
        </div>
      </div>
    </div>

    <div class="section-inner container">
      <div class="col hero-left reveal">
        <h1 class="hero-title">Agende seus exames e consultas de forma rápida e prática</h1>
        <p class="hero-sub">Organize atendimentos, exames e resultados em uma plataforma prática, segura e moderna.</p>
        <div class="cta-row">
          <a class="btn-primary" href="#agendar">Agende já</a>
          <a class="btn-ghost" href="#exames">Ver exames</a>
        </div>
      </div>

      <div class="col hero-right reveal" aria-hidden="true">
        <img class="hero-illustration" src="../public/assets/imgs/fundo_05.png" alt="Ilustração agendamento médico">
      </div>
    </div>

    <div class="wave-bottom" aria-hidden="true" style="z-index:2"></div>
  </section>

  <!-- AGENDAR -->
  <section id="agendar" class="section agendar">
    <div class="section-inner container agendar-card-inner">
      <div class="col agendar-left reveal">
        <div class="agendar-card">
          <img src="../public/assets/imgs/fundo_06.png" alt="Calendário Médico"
               style="border-radius:12px;box-shadow:0 12px 40px rgba(0,0,0,0.08);width:100%">
        </div>
      </div>

      <div class="col agendar-right reveal">
        <h2>Agende suas Consultas e Exames de forma Rápida</h2>
        <ul class="feature-list">
          <li class="feature-item"><i class="fa-solid fa-calendar-check"></i><span>Marque consultas e exames online</span></li>
          <li class="feature-item"><i class="fa-solid fa-bell"></i><span>Receba notificações automáticas</span></li>
          <li class="feature-item"><i class="fa-solid fa-file-medical"></i><span>Laudos e resultados digitais</span></li>
        </ul>

        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:10px">
          <div style="background:rgba(255,255,255,0.06);padding:12px;border-radius:12px;min-width:160px">
            <strong>Agenda integrada</strong>
            <small>Sincronize horários e lembretes</small>
          </div>
          <div style="background:rgba(255,255,255,0.04);padding:12px;border-radius:12px;min-width:160px">
            <strong>Segurança</strong>
            <small>Dados criptografados</small>
          </div>
        </div>

        <div style="margin-top:18px">
          <a class="btn-primary" href="#especialistas">Agendar agora</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ESPECIALISTAS -->
  <section id="especialistas" class="section especialistas">
    <div class="parallax-tris" aria-hidden="true">
      <div class="tri t1"></div>
      <div class="tri t2"></div>
      <div class="tri t3"></div>
    </div>

    <div class="section-inner container">
      <div class="col especialista-left reveal">
        <h2>Encontre o especialista certo para o seu atendimento</h2>
        <p>Disponibilizamos profissionais de diversas áreas médicas, garantindo praticidade e qualidade no atendimento.</p>
        <div class="especialidades-grid">
          <a class="especialidade-item" href="#">Cardiologista</a>
          <a class="especialidade-item" href="#">Ortopedista</a>
          <a class="especialidade-item" href="#">Pediatra</a>
          <a class="especialidade-item" href="#">Clínico geral</a>
        </div>
        <div style="margin-top:8px">
          <button class="btn-primary" onclick="location.href='#exames'">Visualizar</button>
        </div>
      </div>

      <div class="col especialista-right reveal" aria-hidden="true">
        <img src="../public/assets/imgs/fundo_07.jpg" alt="Médico"
             style="border-radius:12px;box-shadow:0 12px 40px rgba(2,46,83,0.10);width:100%">
      </div>
    </div>

    <div style="position:absolute;left:0;right:0;bottom:-1px;pointer-events:none">
      <svg viewBox="0 0 1440 80" preserveAspectRatio="none" style="display:block;width:100%;height:70px">
        <path d="M0,0 C360,80 720,0 1440,60 L1440 80 L0 80 Z" fill="rgba(243,251,255,1)"></path>
      </svg>
    </div>
  </section>

  <!-- EXAMES -->
  <section id="exames" class="section exames" aria-label="Seção de exames">
    <div class="parallax-tris" aria-hidden="true">
      <div class="tri t1"></div>
      <div class="tri t2"></div>
      <div class="tri t3"></div>
    </div>

    <div class="section-inner container">
      <div class="col exames-left reveal" aria-hidden="true">
        <img src="../public/assets/imgs/fundo_08.png" alt="Exames"
             style="border-radius:12px;box-shadow:0 12px 40px rgba(2,46,83,0.08);width:100%">
      </div>

      <div class="col exames-right reveal">
        <h2>Exames</h2>
        <p>Nossa clínica oferece uma ampla gama de exames laboratoriais e de imagem, todos com agendamento online. Sem filas — escolha o melhor horário para você.</p>
        <div class="exames-cards">
          <div class="exam-card">
            <strong>Laboratório</strong>
            <p style="margin-top:6px;font-size:.95rem">Sangue, urina e perfis completos — resultados digitais.</p>
          </div>
          <div class="exam-card">
            <strong>Imagem</strong>
            <p style="margin-top:6px;font-size:.95rem">Ultrassom, raio-X e tomografia com laudo digital.</p>
          </div>
          <div class="exam-card">
            <strong>Check-ups</strong>
            <p style="margin-top:6px;font-size:.95rem">Programas personalizados para sua saúde.</p>
          </div>
        </div>
      </div>
    </div>

    <div style="position:absolute;left:0;right:0;bottom:-1px;pointer-events:none">
      <svg viewBox="0 0 1440 80" preserveAspectRatio="none" style="display:block;width:100%;height:70px">
        <path d="M0,60 C420,20 720,80 1440,30 L1440 80 L0 80 Z" fill="#015997"></path>
      </svg>
    </div>
  </section>

</main>

<footer aria-label="Rodapé">
  <div class="container footer-inner" style="display:flex;align-items:center;justify-content:space-between;gap:12px">
    <div>
      <h4 style="color:rgba(255,255,255,0.95);margin-bottom:6px">Criadores</h4>
      <p style="color:rgba(255,255,255,0.75);line-height:1.4">
        Henrique Pereira Luiz<br>Mateus Warmling Berti
      </p>
    </div>

    <div class="footer-logo" style="text-align:center">
      <div style="display:flex;align-items:center;justify-content:center;gap:10px">
        <div class="logo-pill" 
            style="color:white;font-size:40px;padding:8px 12px;font-weight:700;border-radius:10px">
          MedHub
        </div>
      </div>
      <small style="color:rgba(255,255,255,0.8);margin-top:8px;display:block;font-size:0.9rem;">
        © 2025 <strong>MedHub</strong> | Todos os direitos reservados
      </small>
    </div>

    <div>
      <a class="footer-btn"
        href="https://mail.google.com/mail/?view=cm&fs=1&to=clinicamedhub2025@gmail.com&su=Contato%20MedHub&body=Olá%2C%20gostaria%20de%20falar%20sobre..."
        target="_blank"
        style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;color: black;">
        <img src="https://upload.wikimedia.org/wikipedia/commons/4/4e/Gmail_Icon.png"
            alt="Gmail"
            style="width:22px;height:22px;">
        Enviar e-mail
      </a>
    </div>
  </div>
</footer>

<script>
  const reveals = document.querySelectorAll('.reveal');
  const io = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) entry.target.classList.add('revealed');
    });
  }, { threshold: 0.16 });
  reveals.forEach(r => io.observe(r));

  const header = document.getElementById('site-header');
  window.addEventListener('scroll', () => {
    header.style.padding = window.scrollY > 18 ? '10px 0' : '14px 0';
  });

  const mobileToggle = document.getElementById('mobileToggle');
  function toggleMobileNav() {
    const mn = document.getElementById('mobile-nav');
    const expanded = mn.style.display === 'block';
    mn.style.display = expanded ? 'none' : 'block';
    mobileToggle.setAttribute('aria-expanded', String(!expanded));
  }
  mobileToggle?.addEventListener('click', toggleMobileNav);

  (function () {
    const triangleGroups = document.querySelectorAll('.parallax-tris');
    if (!triangleGroups.length) return;

    const cfg = { mouseMul: 0.04, scrollMul: 0.15, floatSpeed: 0.0006 };
    let lastTime = 0;
    const groups = [];

    triangleGroups.forEach(group => {
      const tris = group.querySelectorAll('.tri');
      const local = [];
      tris.forEach((t, i) => {
        const base = {
          el: t,
          rx: Math.random() * 40 - 20,
          ry: Math.random() * 40 - 20,
          r: Math.random() * 20 - 10,
          s: 0.9 + Math.random() * 0.3
        };
        t.style.transform = `translate(${base.rx}px, ${base.ry}px) scale(${base.s})`;
        local.push(base);
      });
      groups.push({ group, items: local });
    });

    let mouseX = 0, mouseY = 0;
    window.addEventListener('mousemove', e => {
      mouseX = e.clientX - window.innerWidth / 2;
      mouseY = e.clientY - window.innerHeight / 2;
    });

    function animate(t) {
      const dt = t - lastTime;
      lastTime = t;
      groups.forEach(g => {
        g.items.forEach((it, idx) => {
          const scrollY = window.scrollY;
          const scrollOffset = scrollY * cfg.scrollMul * (0.03 * (idx + 1));
          const mx = mouseX * cfg.mouseMul * (0.02 * (idx + 1));
          const my = mouseY * cfg.mouseMul * (0.02 * (idx + 1));
          const float = Math.sin(t * cfg.floatSpeed + idx) * 8;
          const tx = it.rx + mx + scrollOffset;
          const ty = it.ry + my + float;
          const rot = it.r * Math.sin(t * 0.0009 + idx);
          it.el.style.transform = `translate(${tx}px, ${ty}px) rotate(${rot}deg) scale(${it.s})`;
          it.el.style.opacity = 0.04 + 0.08 * (0.5 + 0.5 * Math.sin(t * 0.0007 + idx));
        });
      });
      requestAnimationFrame(animate);
    }
    requestAnimationFrame(animate);
  })();

  (function () {
    const floats = document.querySelectorAll('.floating-elements .float-item');
    if (!floats.length) return;

    floats.forEach((el, idx) => {
      const dx = Math.random() * 18 - 9;
      const dy = Math.random() * 10 - 5;
      el.style.transform = `translate(${dx}px, ${dy}px)`;
    });

    let t0 = performance.now();
    function anim(now) {
      const dt = now - t0;
      t0 = now;
      floats.forEach((el, i) => {
        const speed = 0.0006 + i * 0.00015;
        const amp = 8 + (i % 3) * 6;
        const offsetY = Math.sin(now * speed + i) * amp;
        const offsetX = Math.cos(now * (speed * 0.8) + i * 1.3) * (4 + (i % 2) * 6);
        const rotate = Math.sin(now * (speed * 0.4) + i) * (3 + (i % 4));
        el.style.transform = `translate(${offsetX}px, ${offsetY}px) rotate(${rotate}deg) scale(${getComputedStyle(el).getPropertyValue('--s') || 1})`;
        const baseO = parseFloat(el.getAttribute('data-opacity') || 0.95);
        el.style.opacity = Math.max(0.55, baseO * (0.85 + 0.15 * Math.sin(now * (speed * 0.9) + i)));
      });
      requestAnimationFrame(anim);
    }
    requestAnimationFrame(anim);
  })();

  window.addEventListener('scroll', () => {
    const whiteSections = document.querySelectorAll('.especialistas, .exames');
    whiteSections.forEach(sec => {
      const rect = sec.getBoundingClientRect();
      const offset = Math.max(-200, Math.min(200, rect.top - window.innerHeight / 2));
      const tris = sec.querySelectorAll('.tri');
      tris.forEach((t, i) => {
        const factor = (i + 1) * 0.02;
        t.style.transform = `translateY(${offset * factor}px)`;
      });
    });
  }, { passive: true });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 760) {
      const mn = document.getElementById('mobile-nav');
      if (mn) mn.style.display = 'none';
    }
  });

   window.addEventListener('load', () => {
    window.scrollTo(0, 0);
  });
</script>
</body>
</html>
