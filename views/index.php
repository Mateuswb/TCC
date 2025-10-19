<?php
    include '../public/assets/css/usuario/modal_login.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Med Hub — Agende Consultas e Exames</title>

  <style>

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
/* header */
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
  position: relative;
}

header nav a::after {
  content: "";
  width: 0%;
  height: 2px;
  background-color: #ffffff;
  position: absolute;
  bottom: -4px; 
  left: 0;
  transition: 0.4s;
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
  width: 500px;
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



/*  EXAMES*/
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

/*  ACESSO */
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

/* FOOTER */
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

/* RESPONSIVO  */
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
.especialista-section {
  display: flex;
  justify-content: center;
  background-color: #fff;
  padding: 40px 20px;
}

.container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  background: #fff;
  box-shadow: 0 3px 8px rgba(0,0,0,0.1);
  border-radius: 10px;
  overflow: hidden;
  padding: 40px;
}

.text-content {
  flex: 1;
}

.text-content h2 {
  font-size: 1.8rem;
  font-weight: 700;
  color: #000;
  margin-bottom: 20px;
}

.text-content p {
  color: #333;
  font-size: 1rem;
  margin-bottom: 30px;
  line-height: 1.5;
}

.text-content p a {
  color: #0056b3;
  text-decoration: underline;
}

.especialidades {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px 40px;
  margin-bottom: 25px;
}

.especialidades .link {
  text-decoration: none;
  color: #000;
  font-weight: 600;
  border-bottom: 2px solid #003366;
  width: fit-content;
}

.btn-visualizar {
  background-color: #0056b3;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 10px 25px;
  cursor: pointer;
  font-weight: 600;
  transition: background 0.3s;
}

.btn-visualizar:hover {
  background-color: #004091;
}

.image-content {
  position: relative;
  width: 300px;
}

.image-bg {
  position: absolute;
  right: 20px;
  top: 20px;
  bottom: 20px;
  left: 20px;
  background-color: #003f5c;
  border-radius: 8px;
  z-index: 1;
}

.image-content img {
  position: relative;
  z-index: 2;
  width: 100%;
  border-radius: 8px;
  object-fit: cover;
  box-shadow: 0 3px 6px rgba(0,0,0,0.2);
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
    <img src="../teste.png" alt="Agendamento Médico">
  </div>

  <div class="hero-curve"></div>
</section>


<p></p>
  <!-- AGENDAR -->
<section id="agendar" class="agendar">
  <div class="agendar-container">
    <div class="agendar-img">
      <img src="../download.png" alt="Calendário Médico">
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
<section class="especialista-section">
  <div class="container">
    <div class="text-content">
      <h2>Encontre o especialista certo<br>para o seu atendimento</h2>
      <p>
        Disponibilizamos profissionais de diversas áreas médicas, garantindo praticidade e
        qualidade no atendimento.
      </p>

      <div class="especialidades">
        <a href="#" class="link">Cardiologista</a>
        <a href="#" class="link">Ortopedista</a>
        <a href="#" class="link">Pediatra</a>
        <a href="#" class="link">Clínico geral</a>
      </div>

      <button class="btn-visualizar">Visualizar</button>
    </div>

    <div class="image-content">
      <div class="image-bg"></div>
      <img src="medico.png" alt="Médico com jaleco e estetoscópio" />
    </div>
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

  

</body>
</html>

