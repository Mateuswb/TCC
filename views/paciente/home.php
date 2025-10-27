  
<?php
  require '../../autentica/verifica_login.php';

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
  
  <!-- CSS -->
  <link rel="stylesheet" href="../../public/assets/css/paciente/home.css">

</head>

<body>
  <main>
    <h1>Agende suas <span>consultas</span> e <span>exames</span></h1>
  
    <div class="content-grid">
      <div>
        <!-- Primeiro Carrossel -->
        <div class="carousel-card">
          <div class="carousel" id="mainCarousel">
            <div class="slides">
              <div class="slide" style="background-image:url('../../public/assets/imgs/fundo_1.png');">
                <div class="overlay"><h3>Ambiente agradável</h3></div>
              </div>
              <div class="slide" style="background-image:url('../../public/assets/imgs/fundo_1.png');">
                <div class="overlay"><h3>Exames</h3></div>
              </div>
              <div class="slide" style="background-image:url('../../public/assets/imgs/fundo_1.png');">
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
              <div class="slide" style="background-image:url('../../public/assets/imgs/fundo_1.png');">
                <div class="overlay"><h3>Novos recursos</h3></div>
              </div>
              <div class="slide" style="background-image:url('../../public/assets/imgs/fundo_1.png');">
                <div class="overlay"><h3>Salas modernas</h3></div>
              </div>
              <div class="slide" style="background-image:url('../../public/assets/imgs/fundo_1.png');">
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
              <div class="slide" style="background-image:url('../../public/assets/imgs/fundo_1.png');">
                <div class="overlay"><h3>Atendimento de qualidade</h3></div>
              </div>
              <div class="slide" style="background-image:url('../../public/assets/imgs/fundo_1.png');">
                <div class="overlay"><h3>Cuidado humanizado</h3></div>
              </div>
              <div class="slide" style="background-image:url('../../public/assets/imgs/fundo_1.png');">
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

  <script>
    // criar carrosséis
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
