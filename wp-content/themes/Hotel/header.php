<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?></title>
    <?php wp_head(); ?> <!-- This is where WordPress hooks in styles, scripts, etc. -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body <?php body_class(); ?>>
   
<header>
    <div class="hero1-section" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/hero-bg.jpg');">
        <!-- Logo -->
        <div class="logo">
            <a href="<?php echo esc_url( home_url() ); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Calque_1.svg" alt="Hôtel Le Belvedere Logo">
            </a>
        </div>
        <!-- Hamburger Menu Toggle -->
        <div class="menu-toggle" onclick="toggleMenu()">☰</div>

        <!-- Navigation -->
        <nav>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'nav-menu',
            ));
            ?>
        </nav>

        <!-- Overlay Background -->
        <div class="menu-overlay" onclick="toggleMenu()"></div>

        <!-- Hero Content -->
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-stars">
                <span>★</span><span>★</span><span>★</span><span>★</span>
            </div>
            <h1>Hôtel Le Belvedere<br>Votre refuge au coeur de Ghardaïa</h1>
            <p class="hero-subtext">Vivez une expérience unique alliant luxe et confort au <span class="belvedere" >Belvedere</span>,<br> et au plus près des trésors de Ghardaïa.</p>
            <a href="#details" class="btn-hero">Voir plus</a>
        </div>
    </div>
    <div class="scroll-navigation">
          <a href="#section1" class="scroll-dot1"></a>
          <a href="#section2" class="scroll-dot2"></a>
    </div>
    <div class="hero-line">
        <hr>
    </div>
</header>
