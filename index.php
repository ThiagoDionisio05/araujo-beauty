<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Araujo Beauty</title>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/style.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>

<body>

<!-- ================= NAVBAR ================= -->
<header class="navbar">
  <div class="nav-container">
    <div class="logo">Araujo Beauty</div>

    <nav class="nav-links" id="navLinks">

  <a href="#home">Home</a>
  <a href="#servicos">Serviços</a>
  <a href="#feedbacks">Feedback</a>
  <a href="#quem-somos">Quem Somos</a>
  <a href="#localizacao">Localização</a>

  <?php if(isset($_SESSION['user_id'])): ?>

      <span class="nav-user">
 Olá, <?php echo explode(' ', $_SESSION['user_name'])[0]; ?> 👋
</span>


      <a href="auth/logout.php" class="nav-logout">Sair</a>

  <?php else: ?>

      <a href="auth/login.php" class="nav-login">Entrar</a>

  <?php endif; ?>

</nav>


    <button class="menu-toggle" id="menuToggle" aria-label="Abrir menu">
      <span></span>
      <span></span>
      <span></span>
    </button>
  </div>
</header>

<!-- ================= HERO TEXT ================= -->
<div class="banner-text">
  Realçando sua beleza com naturalidade
  <span class="banner-line"></span>

  <p class="banner-subtext">
    Design de sobrancelhas, micropigmentação e estética facial.
  </p>

  <p class="banner-subtext-secondary">
    Atendimento Personalizado
  </p>

  <?php if(isset($_SESSION['user_id'])): ?>

    <?php if($_SESSION['user_role'] === 'admin'): ?>

        <a href="dashboard/index.php" class="btn-whatsapp btn-admin">
            Ir para Dashboard
            <i class="fa-solid fa-chart-line"></i>
        </a>

    <?php else: ?>

        <a href="agendamento/index.php" class="btn-whatsapp btn-client">
            Ir para Agendamento
            <i class="fa-regular fa-calendar"></i>
        </a>

    <?php endif; ?>

<?php else: ?>

    <a href="auth/login.php" class="btn-whatsapp btn-guests">
    Reserve o seu momento conosco
    <i class="fab fa-whatsapp"></i>
</a>


<?php endif; ?> 

</div>

<!-- ================= BANNER ================= -->
<section class="banner-wrapper" id="home">
  <picture class="banner">
    <source media="(min-width: 768px)" srcset="assets/images/imagem-desktop.png">
    <img src="assets/images/imagem-mobile.png" alt="Design de Sobrancelhas" loading="eager">
  </picture>
</section>

<!-- ================= SERVIÇOS ================= -->
<section class="services" id="servicos">
  <h1 class="services-title">Serviços</h1>
  <div class="services-divider"></div>
</section>

<section class="procedures">
  <div class="procedures-grid">

    <details class="procedure-card card-a">
      <summary>
        <span>Design de Sobrancelhas</span>
        <span class="icon">+</span>
      </summary>
      <p>
        Protocolo estratégico voltado à saúde dos fios, com mapeamento facial para alcançar o design ideal.
      </p>
    </details>

    <details class="procedure-card card-b">
      <summary>
        <span>Design com Henna</span>
        <span class="icon">+</span>
      </summary>
      <p>
        Design personalizado finalizado com henna, com duração média de até 7 dias.
      </p>
    </details>

    <details class="procedure-card card-a">
      <summary>
        <span>Nanopigmentação</span>
        <span class="icon">+</span>
      </summary>
      <p>
        Técnica semi-permanente avançada, com duração média de 4 meses a 1 ano.
      </p>
    </details>

    <details class="procedure-card card-b">
      <summary>
        <span>Nanolips</span>
        <span class="icon">+</span>
      </summary>
      <p>
        Micropigmentação labial para lábios mais saudáveis, corados e naturais.
      </p>
    </details>

    <details class="procedure-card card-a">
      <summary>
        <span>Spa de Lábios</span>
        <span class="icon">+</span>
      </summary>
      <p>
        Esfoliação, hidratação e finalização com produtos ricos em vitaminas e colágeno.
      </p>
    </details>

    <details class="procedure-card card-b">
      <summary>
        <span>Dermaplaning</span>
        <span class="icon">+</span>
      </summary>
      <p>
        Remoção de células mortas e penugem facial para uma pele mais macia e rejuvenescida.
      </p>
    </details>

    <details class="procedure-card card-a">
      <summary>
        <span>Cílios</span>
        <span class="icon">+</span>
      </summary>
      <p>
        Procedimento refinado respeitando a identidade visual do estúdio.
      </p>
    </details>

     <details class="procedure-card card-a">
      <summary>
        <span>Maquiagem</span>
        <span class="icon">+</span>
      </summary>
      <p>
        Procedimento refinado respeitando a identidade visual do estúdio.
      </p>
    </details>

  </div>

  <button class="load-more">Veja Mais</button>
</section>

<!-- ================= FEEDBACKS ================= -->
<section class="services" id="feedbacks">
  <h1 class="services-title">Feedbacks</h1>
  <div class="services-divider"></div>

  <h2 class="feedback-subtitle">
    Relatos reais de autoestima renovada!
  </h2>

  <img src="assets/images/Feedbacks.png" alt="Feedbacks de clientes" class="testimonial-image">
</section>

<!-- ================= QUEM SOMOS ================= -->
<section class="services">
  <h1 class="services-title" id="quem-somos">Quem Somos</h1>
  <div class="services-divider"></div>
</section>

<section class="about-us">
  <div class="about-card">

    <button class="arrow left-arrow" aria-label="Anterior">&#10094;</button>

    <article class="about-person">
      <img src="assets/images/isabelle.jpg" alt="Isabelle Araujo" class="about-photo">

      <div class="about-text">
        <h3>Isabelle Araujo</h3>
        <p>
          Lorem ipsum dolor sit amet consectetur.Lorem ipsum ddolor sit amet consecteturLorem ipsum dolor sit amet consectetur Vel sed viverra vitae pulvinar. Aliquet pellentesque metus a iaculis tortor. Ut ut quam ipsum aliquam ac nullam gravida. Mattis vitae pharetra a sed. Dolor sit morbi at varius est eget. Neque nec sed molestie nisl. Ullamcorper pharetra in massa montes risus. Hendrerit ultrices metus tempus est tempor consequat. Faucibus pellentesque fermentum accumsan quisque rhoncus elementum nullam nisi enim. Amet enim aliquam sapien iaculis diam tristique urna ut ornare. Rutrum adipiscing in et nisl a diam interdum justo curabitur
        </p>
      </div>
    </article>

    <button class="arrow right-arrow" aria-label="Próximo">&#10095;</button>

  </div>
</section>

<!-- ================= LOCALIZAÇÃO ================= -->
<section class="location-section" id="localizacao">
  <div class="location-container">

    <div class="location-left">
      <h2 class="location-title">Localização</h2>

      <p class="location-address">
        QMS 54,<br>
        Sobradinho - DF<br>
        73080-490
      </p>

      <div class="location-socials">
        <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
        <a href="#" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
      </div>
    </div>

    <div class="location-right">
      <div class="map-wrapper">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1921.1672266582186!2d-47.82868286148314!3d-15.627168613184192!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x935a41bce0a93f5d%3A0x307b9fab9c0b98f2!2sIsabelle%20Araujo%20Beauty%20(Studio)!5e0!3m2!1sen!2sbr!4v1770561074036!5m2!1sen!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>

      <p class="location-name">Araujo Beauty</p>
    </div>

  </div>

  <footer class="location-footer">
  <p>
    © 2026 Isabelle Araujo Beauty.<br>
    Todos os direitos reservados.
  </p>

  <p class="footer-dev">
    Desenvolvido por <strong>Thiago Dionisio</strong>
  </p>
</footer>

</section>

<script src="assets/js/script.js"></script>

</body>
</html>
