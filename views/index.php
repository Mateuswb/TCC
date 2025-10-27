<?php
  include '../public/modals/usuario/modal_login.php';
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Med Hub — Agende Consultas e Exames</title>

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <!-- icons -->
  <script src="https://kit.fontawesome.com/4b60c7eafd.js" crossorigin="anonymous"></script>

  <style>
    /* ========== RESET & VARIABLES ========== */
    *{margin:0;padding:0;box-sizing:border-box;}
    html, body{height:100%;font-family:"Inter",sans-serif;line-height:1.5;background:#FAFDFF;color:#002E53;overflow-x:hidden;}
    :root{
      --azul-escuro: #002E53;
      --azul-forte: #015997;
      --azul-medio: #1C5FAB;
      --azul-claro: #065C92;
      --white: #ffffff;
      --radius:16px;
      --shadow:0 14px 36px rgba(0,0,0,0.12);
      --transition:0.35s cubic-bezier(.25,.8,.25,1);
    }
    a{color:inherit;text-decoration:none;}
    img{display:block;max-width:100%;border-radius:12px;}
    
    /* ========== HEADER ========== */
    header{
      position:fixed;top:0;left:0;width:100%;padding:20px 6%;
      display:flex;justify-content:space-between;align-items:center;gap:20px;
      background: #035088ff;
      backdrop-filter:blur(6px);
      transition: transform var(--transition), background var(--transition), box-shadow var(--transition);
      z-index:2000;
    }
    header.scrolled{ background: var(--white); box-shadow: 0 10px 28px rgba(255, 255, 255, 0.08);}
    header.hidden{ transform: translateY(-120%);}
    .brand{ font-weight:800; font-size:2.3rem; color:var(--azul-escuro);}
    .brand span{ color:var(--azul-medio);}
    nav ul{ display:flex;gap:100px; list-style:none; align-items:center;}
    nav a{position:relative;padding:6px 0;font-weight:500; color: white;}
    nav a::after{content:"";position:absolute;left:0;bottom:-4px;height:3px;width:0;background: white;border-radius:4px;transition:width .28s;}
    nav a:hover::after{width:100%;}
    .btn-login{
      background:var(--azul-medio); color:#fff; padding:12px 26px; border-radius:12px; font-weight:700; box-shadow:0 10px 28px rgba(0,95,171,0.12); transition: transform var(--transition);
    }
    .btn-login:hover{ transform: translateY(-3px);}
    
    /* ========== HERO ========== */
    .hero{
      display:flex;align-items:center;justify-content:space-between;gap:32px;
      padding:140px 6% 60px;min-height:560px;position:relative;z-index:1;
      background:linear-gradient(180deg,var(--azul-forte),var(--azul-medio));
      color:#fff;
    }
    .hero-left{max-width:640px; display:flex;flex-direction:column;gap:18px;}
    .hero-title{font-size:2.6rem;font-weight:800;line-height:1.1; text-shadow: 0 10px 28px rgba(0,0,0,0.18);}
    .hero-sub{font-weight:500;font-size:1.1rem;opacity:0.95;}
    .btn-primary{
      background:var(--white); color: white; padding:14px 28px; border-radius:14px; font-weight:700; box-shadow:0 12px 36px rgba(8,40,80,0.15); transition: transform var(--transition);
    }
    .btn-primary:hover{ transform: translateY(-4px); box-shadow:0 24px 48px rgba(8,40,80,0.18);}
    .hero-right{ width:48%; max-width:480px; background:rgba(255,255,255,0.08); padding:14px; border-radius:18px; box-shadow:var(--shadow);}
    
    /* ========== SECTIONS ========== */
    section{padding:80px 6%;position:relative;z-index:1;}
    section h2{font-size:2rem;color:var(--azul-escuro);margin-bottom:20px;}
    
    /* ========== AGENDAR CARD ========= */
   .agendar-section {
  background-color: #1C5FAB; /* fundo azul sólido */
  width: 100%;
  padding: 60px 6%;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.agendar-card {
  display: flex;
  gap: 40px;
  width: 100%;
  max-width: 1200px;
  align-items: center;
}

.agendar-left {
  flex: 1 1 50%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.agendar-left img {
  max-width: 100%;
  height: auto;
  display: block;
}

.agendar-right {
  flex: 1 1 50%;
  color: #fff;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.agendar-right h2 {
  font-size: 2rem;
  font-weight: 700;
}

.agendar-right h2 span {
  font-weight: 800;
}

.feature-list {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 12px;
  padding-left: 0;
  margin: 16px 0;
}

.feature-list li {
  display: flex;
  align-items: center;
  gap: 12px;
  font-weight: 500;
  font-size: 1rem;
}

.feature-list i {
  color: #000000ff;
  font-size: 1.2rem;
}

.btn-primary {
  background-color: #065C92;
  color: #000000ff;
  padding: 12px 28px;
  border-radius: 12px;
  font-weight: 700;
  text-decoration: none;
  width: fit-content;
  transition: transform 0.3s ease;
}

.btn-primary:hover {
  transform: translateY(-3px);
}

@media (max-width: 900px){
  .agendar-card {
    flex-direction: column;
    text-align: center;
  }
  .agendar-left, .agendar-right {
    flex: 1 1 100%;
  }
  .agendar-right h2 {
    font-size: 1.6rem;
  }
}
    
    /* ========== ESPECIALISTAS ========= */
   .especialista-wrap {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #f7f9fb;
  width: 120%;
  padding: 40px;
  border-radius: 10px;
  gap: 20px;
}

.especialista-left {
  flex: 1;
}

.especialista-left h2 {
  font-size: 28px;
  margin-bottom: 20px;
  line-height: 1.3;
}

.especialista-left h2 span {
  font-weight: bold;
}

.especialista-left p {
  margin-bottom: 25px;
  color: #555;
}

.especialidades-grid {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
  margin-bottom: 25px;
}

.especialidades-grid a {
  text-decoration: underline;
  color: #0071f3;
  font-weight: 500;
  transition: color 0.3s;
}

.especialidades-grid a:hover {
  color: #004bb5;
}

.btn-visualizar {
  padding: 12px 25px;
  background-color: #0071f3;
  color: white;
  border: none;
  border-radius: 6px;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.3s;
}

.btn-visualizar:hover {
  background-color: #005bb5;
}

.especialista-right {
  flex: 1;
  display: flex;
  justify-content: center;
}

.especialista-right img {
  max-width: 100%;
  border-radius: 10px;
  box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

    
    /* ========== ACESSO ========= */
    .acesso{ text-align:center; background:linear-gradient(180deg, #f4f9ff, #ffffff); border-radius:20px; padding:60px; box-shadow:var(--shadow);}
    
    /* ========== FOOTER ========= */
    footer{background:var(--azul-escuro); color:#dff3ff; padding:40px 6%; text-align:center; border-radius:16px;}
    
    /* ========== REVEAL ANIMATIONS ========= */
    .reveal{opacity:0; transform:translateY(20px); transition:opacity .7s ease, transform .7s ease;}
    .reveal.show{opacity:1; transform:translateY(0);}
    
    /* ========== RESPONSIVE ========= */
    @media(max-width:1024px){.cards-grid{flex-direction:column;}.card{flex:1 1 100%;}}
    @media(max-width:720px){
      .hero{flex-direction:column; padding-top:140px;}
      .hero-right{width:100%; margin-top:28px;}
      .agendar-card{flex-direction:column;}
      .especialista-wrap{flex-direction:column;}
    }
    /* ===== REMOVE ESPAÇOS ENTRE CARDS ===== */
.cards-grid{
  display:flex;
  flex-wrap:wrap;
  margin-top:24px;
  gap:0; /* sem espaços */
}
.card{
  flex:1 1 33.3333%; /* ocupa um terço */
  min-height:300px;
  border-radius:0; /* remove arredondado se quiser encaixar */
  margin:0; /* remove margin */
  padding:24px;
  box-shadow:var(--shadow);
}

/* ===== FORMAS DE FUNDO ===== */
.hero::before, .agendar-card::before, .especialista-wrap::before, .acesso::before{
  content:"";
  position:absolute;
  width:300px;
  height:300px;
  background:var(--azul-claro);
  border-radius:50%;
  filter:blur(120px);
  z-index:0;
  opacity:0.3;
}

.hero::before{ top:-50px; left:-50px; }
.agendar-card::before{ top:0; right:-80px; }
.especialista-wrap::before{ bottom:-60px; left:-60px; }
.acesso::before{ top:20px; right:-60px; }

/* Para a hero podemos adicionar mais formas */
.hero::after{
  content:"";
  position:absolute;
  width:200px;
  height:200px;
  background:#065C92;
  border-radius:50%;
  filter:blur(100px);
  right:30px; bottom:-40px;
  opacity:0.25;
  z-index:0;
}

/* Ajuste do conteúdo para estar acima das formas */
.hero > *, .agendar-card > *, .especialista-wrap > *, .acesso > *{
  position:relative;
  z-index:1;
}

  </style>
</head>
<body>
  <?php include '../public/assets/alerta/flash.php' ?>

  <!-- HEADER -->
  <header id="site-header">
    <div class="brand">Med <span>Hub</span></div>
    <nav>
      <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#agendar">Consultas</a></li>
        <li><a href="#exames">Exames</a></li>
        <li><a href="#acesso">Sobre-nós</a></li>
      </ul>
    </nav>
    <a class="btn-login" href="#" onclick="abrirModal()">Entrar</a>
  </header>

  <!-- MAIN -->
  <main>
    <!-- HERO -->
    <section id="home" class="hero reveal">
      <div class="hero-left">
        <h1 class="hero-title">Agende seus exames e consultas de forma rápida e prática</h1>
        <p class="hero-sub">Organize atendimentos, exames e resultados em uma plataforma prática, segura e moderna.</p>
        <a class="btn-primary" href="#agendar">Agende já</a>
      </div>
      <div class="hero-right">
        <img src="../teste.png" alt="Agendamento Médico">
      </div>
    </section>

    <!-- AGENDAR -->
    <section id="agendar" class="reveal">
      <div class="agendar-card">
        <div class="agendar-left">
          <img src="../download.png" alt="Calendário Médico">
        </div>
        <div class="agendar-right">
          <h2>Agende suas <span>Consultas e Exames</span> de forma <span>Rápida</span></h2>
          <ul class="feature-list">
            <li><i class="fa-solid fa-calendar-check"></i> Marque consultas e exames online</li>
            <li><i class="fa-solid fa-bell"></i> Receba notificações automáticas</li>
          </ul>
          <a class="btn-primary" href="#">Agendar agora</a>
        </div>
      </div>
    </section>

    <!-- ESPECIALISTAS -->
   <section id="exames" class="reveal">
  <div class="especialista-wrap">
    <div class="especialista-left">
      <h2>Encontre o especialista certo <span>para o seu atendimento</span></h2>
      <p>Disponibilizamos profissionais de diversas áreas médicas, garantindo praticidade e qualidade no atendimento.</p>
      
      <div class="especialidades-grid">
        <a href="#">Cardiologista</a>
        <a href="#">Ortopedista</a>
        <a href="#">Pediatra</a>
        <a href="#">Clínico geral</a>
      </div>

      <button class="btn-visualizar">Visualizar</button>
    </div>

    <div class="especialista-right">
      <img src="../download.png" alt="Médico" />
    </div>
  </div>
</section>

    <!-- ACESSO -->
    <section id="acesso" class="reveal">
      <div class="acesso">
        <h2>Acesse onde quiser</h2>
        <p>Use o Med Hub no celular, tablet ou computador, com acesso rápido e seguro em qualquer lugar.</p>
        <img src="https://cdn-icons-png.flaticon.com/512/2950/2950611.png" alt="Dispositivos" style="max-width:480px;margin:18px auto 0;display:block">
      </div>
    </section>
  </main>

  <!-- FOOTER -->
  <footer>
    <div class="logo">Med <span>Hub</span></div>
    <p>© <span id="year"></span> Med Hub. Todos os direitos reservados.</p>
  </footer>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
    document.querySelectorAll('.reveal').forEach(el => {
      const observer = new IntersectionObserver(entries=>{
        entries.forEach(entry=>{
          if(entry.isIntersecting){entry.target.classList.add('show');observer.unobserve(entry.target);}
        });
      }, {threshold:0.1});
      observer.observe(el);
    });
    if(typeof abrirModal!=='function'){window.abrirModal=()=>alert('Abrir modal');}
  </script>
</body>
</html>
