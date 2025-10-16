<?php
    include '../public/assets/css/usuario/modal_login.html';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Med Hub — Agende Consultas e Exames</title>

  <style>
/* ===== RESET ===== */
* { margin: 0; padding: 0; box-sizing: border-box; }
html, body {
  font-family: "Inter", "Segoe UI", Roboto, Arial, sans-serif;
  background: #FAFDFF;
  color: #002E53;
}

:root {
  --azul-escuro: #002E53;
  --azul-medio: #1C5FAB;
  --branco: #FAFDFF;
  --radius: 16px;
  --shadow: 0 10px 30px rgba(0,0,0,0.1);
}
/* ===== HEADER ===== */
header {
  background: var(--azul-escuro);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 22px 60px;
  position: sticky;
  top: 0;
  z-index: 100;
}

header .brand {
  display: flex;
  align-items: center;
  color: var(--branco);
  font-size: 45px;
  font-weight: 700;
}

header nav ul {
  display: flex;
  list-style: none;
  gap: 130px;
}

header nav a {
  color: var(--branco);
  text-decoration: none;
  font-weight: 600;
  font-size: 17px;
  position: relative; /* necessário para o ::after */
}

header nav a::after {
  content: "";
  width: 0%;
  height: 2px;
  background-color: #ffffff; /* cor do sublinhado */
  position: absolute;
  bottom: -4px; /* distância do texto */
  left: 0;
  transition: 0.4s; /* animação */
  border-radius: 5px;
}

header nav a:hover::after {
  width: 100%;
}

header .btn-login {
  background: var(--azul-medio);
  color: #fff;
  padding: 13px 50px;
  border-radius: var(--radius);
  font-size: 20px;
  text-decoration: none;
  font-weight: 600;
  transition: 0.3s;
}

header .btn-login:hover {
  background: #114c8f;
}



/* hero */
.hero {
  position: relative;
  width: 100%;
  min-height: 480px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #1C5FAB;
  color: #fff;
  overflow: hidden;
  padding: 80px 10%;
}
.hero-left {
  flex: 1;
  display: flex;
  justify-content: center;
}
.hero-box {
  background: #123c7d;
  color: white;
  padding: 120px 110px;
  margin-bottom: 70px;
  border-radius: 150px 500px 130px 450px;
  display: flex;
  box-shadow: 5px 5px 20px rgba(0, 14, 41, 1);
  flex-direction: column;
}
.hero-box h1 {
  font-size: 40px;
  font-weight: 600;
  line-height: 1.5;
  margin-bottom: 20px;
  color: #fff;
}
.hero-box .btn {
  background: #0257B8;
  font-size: 25px;
  padding: 15px 15px;
    font-weight: 400;
  border-radius: 15px;
  margin-left: 290px;
  width: 250px;
  color: white;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  transition: .3s;
}

.hero-box .btn:hover {
  background: #002550ff;
}
.hero-right {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}
.hero-right img {
  width: 580px;
  max-width: 100%;
}
.hero-curve {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100px;
  background: #FAFDFF;
  clip-path: ellipse(80% 100% at 50% 100%);
}

/* ===== AGENDAR ===== */
.agendar {
  background: linear-gradient(135deg, #1C5FAB 80%, #EAF3FF 60%);
  position: relative;
  padding: 100px 10%;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #fff;
}
.agendar-container {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
  gap: 60px;
  max-width: 1200px;
  width: 100%;
}
.agendar-img img {
  width: 500px;
  margin-right: 100px;
}
.agendar-text {
  max-width: 520px;
}
.agendar-text h2 {
  font-size: 36px;
  font-weight: 800;
  line-height: 1.3;
  color: #fff;
  margin-bottom: 20px;
}
.agendar-text h2 span {
  color: #F7F9FF;
}
.agendar-lista {
  list-style: none;
  margin-bottom: 30px;
}
.agendar-lista li {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 12px;
  font-size: 16px;
}
.agendar-lista i {
  font-size: 18px;
  color: #fff;
}
.agendar .btn {
  background: #fff;
  color: #1C5FAB;
  padding: 14px 28px;
  border-radius: 10px;
  text-decoration: none;
  font-weight: 700;
  transition: 0.3s;
}
.agendar .btn:hover {
  background: #002E53;
  color: #fff;
}

/* ===== ESPECIALISTAS ===== */
.especialistas {
  background: #fff;
  padding: 100px 10%;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
  gap: 60px;
}
.especialistas img {
  max-width: 420px;
  border-radius: var(--radius);
  box-shadow: var(--shadow);
}
.especialistas-text {
  max-width: 520px;
}
.especialistas-text h2 {
  font-size: 30px;
  margin-bottom: 14px;
}
.especialistas-text p {
  color: #4d6073;
  margin-bottom: 26px;
  line-height: 1.6;
}
.especialistas-text .btn {
  background: var(--azul-medio);
  color: #fff;
  padding: 12px 22px;
  border-radius: var(--radius);
  text-decoration: none;
  font-weight: 700;
}

/* ===== EXAMES ===== */
.exames {
  background: var(--azul-escuro);
  color: #fff;
  padding: 100px 10%;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
  gap: 60px;
}
.exames img {
  max-width: 420px;
  border-radius: var(--radius);
}
.exames-text {
  max-width: 520px;
}
.exames-text h2 {
  font-size: 30px;
  margin-bottom: 16px;
}
.exames-text p {
  line-height: 1.6;
  color: #e2ecf8;
}

/* ===== ACESSO ===== */
.acesso {
  background: #EAF3FF;
  padding: 100px 10%;
  text-align: center;
}
.acesso h2 {
  font-size: 30px;
  color: var(--azul-escuro);
  margin-bottom: 18px;
}
.acesso p {
  color: #4d6073;
  margin-bottom: 30px;
}
.acesso img {
  max-width: 600px;
  width: 100%;
}

/* ===== FOOTER ===== */
footer {
  background: var(--azul-escuro);
  color: #CFE9FF;
  padding: 60px 10%;
  text-align: center;
}
footer .logo {
  font-size: 20px;
  font-weight: 700;
  margin-bottom: 10px;
}
footer span {
  color: var(--azul-medio);
}
footer p {
  font-size: 14px;
  color: #a8cce6;
}

/* ===== RESPONSIVO ===== */
@media (max-width: 900px) {
  .hero {
    flex-direction: column;
    text-align: center;
    padding: 60px 6%;
  }
  .hero-box {
    max-width: 100%;
  }
  .hero-right img {
    margin-top: 40px;
    width: 300px;
  }
}

  </style>
</head>

<body>

  <!-- HEADER -->
  <header>
    <div class="brand">Med <span>Hub</span></div>
    <nav>
      <ul>
        <li><a href="">Home</a></li>
        <li><a href="">Consultas</a></li>
        <li><a href="">Exames</a></li>
        <li><a href="">Sobre-nós</a></li>
      </ul>
    </nav>
    <a href="#" class="btn-login" onclick="abrirModal()">Entrar</a>

  </header>

  <!-- HERO -->
<section class="hero">
  <div class="hero-left">
    <div class="hero-box">
      <h1>Agende seus exames e consultas de forma rápida e prática</h1>
      <a href="#" class="btn">Agende já</a>
    </div>
  </div>

  <div class="hero-right">
    <img src="teste.png" alt="Agendamento Médico">
  </div>

  <div class="hero-curve"></div>
</section>


<p></p>
  <!-- AGENDAR -->
<section id="agendar" class="agendar">
  <div class="agendar-container">
    <div class="agendar-img">
      <img src="download.png" alt="Calendário Médico">
    </div>

    <div class="agendar-text">
      <h2>Agende suas <br><span>Consultas e Exames</span> de forma <span>Rápida</span></h2>

      <ul class="agendar-lista">
        <li><i class="fa-solid fa-calendar-check"></i> Marque consultas e exames online</li>
        <li><i class="fa-solid fa-bell"></i> Receba notificações automáticas</li>
      </ul>

      <a href="#" class="btn">Agendar agora</a>
    </div>
  </div>
</section>


  <!-- ESPECIALISTAS -->
  <section id="especialistas" class="especialistas">
    <div class="especialistas-text">
      <h2>Encontre o especialista certo para o seu atendimento</h2>
      <p>Busque profissionais por área de atuação, localização e avaliações de pacientes para o melhor atendimento possível.</p>
      <a href="" class="btn">Ver Especialistas</a>
    </div>
    <img src="https://cdn-icons-png.flaticon.com/512/3870/3870822.png" alt="Especialista Médico">
  </section>

  <!-- EXAMES -->
  <section id="exames" class="exames">
    <img src="https://cdn-icons-png.flaticon.com/512/2947/2947062.png" alt="Exame Médico">
    <div class="exames-text">
      <h2>Exames</h2>
      <p>Nossas clínicas oferecem uma ampla gama de exames com resultados digitais, acessíveis de qualquer dispositivo em até 48h.</p>
    </div>
  </section>

  <!-- ACESSO -->
  <section id="acesso" class="acesso">
    <h2>Acesse onde quiser</h2>
    <p>Use o Med Hub no celular, tablet ou computador, com acesso rápido e seguro em qualquer lugar.</p>
    <img src="https://cdn-icons-png.flaticon.com/512/2950/2950611.png" alt="Dispositivos">
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="logo">Med <span>Hub</span></div>
    <p>© <span id="year"></span> Med Hub. Todos os direitos reservados.</p>
  </footer>

  <script src="../public/assets/js/validar_login.js"></script>

</body>
</html>


