<?php
   include '../../public/includes/paciente/sidebar.php';
   include '../../public/includes/paciente/header.php';
   include '../../public/includes/paciente/footer.php';
?>

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>MedHub — Agende suas consultas e exames</title>

  <!-- Fonte -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
   rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
    display: flex;
    }


    /* CONTEÚDO PRINCIPAL */
    main {
      flex: 1;
      margin-top: 60px;
      padding: 30px;
      overflow-y: auto;
      margin-bottom: 50px;
    }

    main h1 {
      font-size: 28px;
      color: #003366;
      text-align: center;
      font-weight: 700;
    }

    main h1 span {
      color: #007bff;
    }

    /* ====================== LAYOUT DOS CARDS ====================== */
    .content-grid {
      display: grid;
      grid-template-columns: 1fr 320px;
      gap: 18px;
      align-items: start;
      margin-top: 30px;
    }

    .carousel-card {
      background: linear-gradient(180deg, #ffffff, #f7fbff);
      border-radius: 14px;
      padding: 14px;
      box-shadow: 0 8px 18px rgba(14,40,70,0.06);
      margin-bottom: 24px;
      width: 95%;
    }

    /* BIG CAROUSEL */
    .carousel {
      position: relative;
      overflow: hidden;
      border-radius: 12px;
      background: #ddd;
      min-height: 260px;
    }

    .carousel .slides {
      display: flex;
      transition: transform 400ms ease;
      will-change: transform;
    }
    

    .slide {
      min-width: 100%;
      position: relative;
      display: flex;
      align-items: flex-end;
      color: white;
      height: 260px;
      background-size: cover;
      background-position: center;
      border-radius: 12px;
    }

    .slide .overlay {
      width: 100%;
      background: linear-gradient(180deg, rgba(0,0,0,0) 30%, rgba(0,0,0,0.45) 100%);
      padding: 18px;
      border-radius: 12px;
    }

    .slide h3 {
      margin: 0;
      font-size: 24px;
      font-weight: 700;
      text-shadow: 0 3px 14px rgba(0,0,0,0.25);
    }

    .carousel .arrow {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(255,255,255,0.85);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 6px 18px rgba(17,40,70,0.08);
      border: 1px solid rgba(20,78,138,0.06);
      z-index: 5;
    }

    .carousel .arrow.left { left: 10px; }
    .carousel .arrow.right { right: 10px; }

    .carousel-dots {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      bottom: 12px;
      display: flex;
      gap: 8px;
    }

    .dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: rgba(255,255,255,0.5);
      cursor: pointer;
      border: 1px solid rgba(0,0,0,0.08);
    }

    .dot.active {
      background: white;
      width: 12px;
      height: 12px;
    }

    /* RIGHT COLUMN */
    .right-tall {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .tall-card {
      flex: 1;
      border-radius: 14px;
      overflow: hidden;
      position: relative;
      background-size: cover;
      background-position: center;
      min-height: 360px;
      display: flex;
      align-items: flex-end;
    }

    .tall-card .card-footer {
      width: 100%;
      padding: 18px;
      background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.55) 100%);
      color: white;
      font-weight: 700;
      font-size: 18px;
    }

    
  </style>
</head>

<body>
  <main>
    <h1>Agende suas <span>consultas</span> e <span>exames</span></h1>

    <div class="content-grid">
      <!-- LEFT SIDE -->
      <div>
        <!-- Primeiro Carrossel -->
        <div class="carousel-card">
          <div class="carousel" id="mainCarousel">
            <div class="slides">
              <div class="slide" style="background-image:url('https://s2.glbimg.com/Gh6C6zC8UwOfGpwxydR5NRlgLoM=/e.glbimg.com/og/ed/f/original/2021/11/19/clinicadacidadepiracicaba_fotos-42.jpg');">
                <div class="overlay"><h3>Ambiente agradável</h3></div>
              </div>
              <div class="slide" style="background-image:url('https://s2.glbimg.com/Gh6C6zC8UwOfGpwxydR5NRlgLoM=/e.glbimg.com/og/ed/f/original/2021/11/19/clinicadacidadepiracicaba_fotos-42.jpg');">
                <div class="overlay"><h3>Exames</h3></div>
              </div>
              <div class="slide" style="background-image:url('https://s2.glbimg.com/Gh6C6zC8UwOfGpwxydR5NRlgLoM=/e.glbimg.com/og/ed/f/original/2021/11/19/clinicadacidadepiracicaba_fotos-42.jpg');">
                <div class="overlay"><h3>Profissionais de qualidade</h3></div>
              </div>
            </div>
            <div class="arrow left">&#10094;</div>
            <div class="arrow right">&#10095;</div>
            <div class="carousel-dots"></div>
          </div>
        </div>

        <!-- Segundo Carrossel -->
        <div class="carousel-card">
          <div class="carousel" id="secondCarousel">
            <div class="slides">
              <div class="slide" style="background-image:url('https://s2.glbimg.com/Gh6C6zC8UwOfGpwxydR5NRlgLoM=/e.glbimg.com/og/ed/f/original/2021/11/19/clinicadacidadepiracicaba_fotos-42.jpg');">
                <div class="overlay"><h3>Novos recursos</h3></div>
              </div>
              <div class="slide" style="background-image:url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQt-hr_dQhi-1PquvLYJO2ggK3ZnXfLY43OiQ&s');">
                <div class="overlay"><h3>Salas modernas</h3></div>
              </div>
              <div class="slide" style="background-image:url('https://s2.glbimg.com/Gh6C6zC8UwOfGpwxydR5NRlgLoM=/e.glbimg.com/og/ed/f/original/2021/11/19/clinicadacidadepiracicaba_fotos-42.jpg');">
                <div class="overlay"><h3>Equipamentos avançados</h3></div>
              </div>
            </div>
            <div class="arrow left">&#10094;</div>
            <div class="arrow right">&#10095;</div>
            <div class="carousel-dots"></div>
          </div>
        </div>
      </div>

      <!-- RIGHT COLUMN -->
      <div class="right-tall">
        <div class="carousel-card">
          <div class="carousel" id="rightCarousel">
            <div class="slides">
              <div class="slide" style="background-image:url('https://s2.glbimg.com/Gh6C6zC8UwOfGpwxydR5NRlgLoM=/e.glbimg.com/og/ed/f/original/2021/11/19/clinicadacidadepiracicaba_fotos-42.jpg');">
                <div class="overlay"><h3>Atendimento de qualidade</h3></div>
              </div>
              <div class="slide" style="background-image:url('https://s2.glbimg.com/Gh6C6zC8UwOfGpwxydR5NRlgLoM=/e.glbimg.com/og/ed/f/original/2021/11/19/clinicadacidadepiracicaba_fotos-42.jpg');">
                <div class="overlay"><h3>Cuidado humanizado</h3></div>
              </div>
              <div class="slide" style="background-image:url('https://s2.glbimg.com/Gh6C6zC8UwOfGpwxydR5NRlgLoM=/e.glbimg.com/og/ed/f/original/2021/11/19/clinicadacidadepiracicaba_fotos-42.jpg');">
                <div class="overlay"><h3>Equipe especializada</h3></div>
              </div>
            </div>
            <div class="arrow left">&#10094;</div>
            <div class="arrow right">&#10095;</div>
            <div class="carousel-dots"></div>
          </div>
        </div>
      </div>
    </div>
  </main>


  <button class="btn-fale">💬 Fale Conosco</button>

  <script>
    // Função genérica para criar carrosséis
    function setupCarousel(carouselId) {

       

      const carousel = document.getElementById(carouselId);
      const slidesContainer = carousel.querySelector('.slides');
      const slides = carousel.querySelectorAll('.slide');
      const prevBtn = carousel.querySelector('.arrow.left');
      const nextBtn = carousel.querySelector('.arrow.right');
      const dotsContainer = carousel.querySelector('.carousel-dots');

      let currentIndex = 0;

      slides.forEach((_, index) => {
        const dot = document.createElement('div');
        dot.classList.add('dot');
        if (index === 0) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(index));
        dotsContainer.appendChild(dot);
      });

      const dots = dotsContainer.querySelectorAll('.dot');

      function goToSlide(index) {
        slidesContainer.style.transform = `translateX(-${index * 100}%)`;
        dots.forEach(dot => dot.classList.remove('active'));
        dots[index].classList.add('active');
        currentIndex = index;
      }

      nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % slides.length;
        goToSlide(currentIndex);
      });

      prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        goToSlide(currentIndex);
      });

      setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length;
        goToSlide(currentIndex);
      }, 4000);
    }

    setupCarousel('mainCarousel');
    setupCarousel('secondCarousel');
    setupCarousel('rightCarousel');
  </script>
</body>
</html>
