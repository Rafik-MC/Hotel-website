<?php
/* Template Name: Front Page */
define('LOAD_CUSTOM_HEAD', false);

get_header();
?>


    <!--Main-->
    <main>
    <section class="hotel-details">
    <div class="container-fluid">
        <div class="row no-gutters"> <!-- Added no-gutters to remove padding between columns -->
            <!-- Left Section -->
            <div class="hotel-description">
                <h2>Confort et élégance dans chaque détail</h2>
                <p>
                    Nos <strong>153 chambres</strong> et <strong>suites</strong>, soigneusement décorées avec goût et équipées de toutes les commodités modernes, 
                    vous garantissent un séjour des plus relaxants et confortables. Chaque espace est conçu pour créer une 
                    atmosphère chaleureuse, où le bien-être est à l'honneur.
                </p>
                <a href="#rooms" class="btn-chambre">Voir les chambres</a>
            </div>
            <div class="hotel-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Group 4246.png" alt="Hotel Room">
            </div>
        </div>
        <div class="row no-gutters"> <!-- Added no-gutters to remove padding between columns -->
            
        <!-- Right Section -->
            <div class="services-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Rectangle 1614940.jpg" alt="Hotel Services">
            </div>
            <div class="services">
                <h2>Tout ce que vous recherchez, au meilleur hôtel de Ghardaïa</h2>
                <p>
                    Nous mettons à votre disposition une gamme complète de services pour sublimer votre séjour.
                </p>
                <ul class="service-list">
                    <li>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/services/Group.svg" alt="bed image" >
                        153 Chambres
                    </li>
                    <li>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/services/Group-1.svg" alt="bed image" >
                        Restaurant et cafétéria
                    </li>
                    <li>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/services/Group 9.svg" alt="bed image" >
                        Salle de conférence
                    </li>
                    <li>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/services/Group 4236.svg" alt="bed image" >
                        Salle VIP
                    </li>
                    <li>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/services/Group 10.svg" alt="bed image" >
                        Salle de jeux
                    </li>
                    <li>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/services/Group 8.svg" alt="bed image" >
                        Musalla
                    </li> 
                </ul>
                <a href="#details" class="btn-service">Voir plus</a>

            </div>
            <div class="detail-line">
        </div>
        </div>
        
    </div>
</section>


 <!-- Ghardaia Explore Section -->
<section class="explore-section">
    <div class="container">
        <!-- Content Wrapper -->
        <div class="explore-container">
            <!-- Left Content -->
<div class="explore-text">
    <h2>Découvrez Ghardaïa et ses trésors à proximité du Belvedere</h2>
    <p>
        Idéalement situé pour vous permettre d'explorer les richesses culturelles et naturelles de Ghardaïa. Visitez
        Ksar Tafilalet, promenez-vous dans la palmeraie, ou découvrez les sites historiques emblématiques de la région.
    </p>
    <!-- Golden Line -->
    <div class="golden-line"></div>
</div>


            <div class="explore-images">
                  <div class="images-wrapper">
                     <img src="<?php echo get_template_directory_uri(); ?>/assets/images/explore/Rectangle 1614927.jpg" alt="Ghardaia Image 1">
                     <img src="<?php echo get_template_directory_uri(); ?>/assets/images/explore/Rectangle 1614926.jpg" alt="Ghardaia Image 2">
                     <img src="<?php echo get_template_directory_uri(); ?>/assets/images/explore/Rectangle 1614924.jpg" alt="Ghardaia Image 3">
                     <img src="<?php echo get_template_directory_uri(); ?>/assets/images/explore/aghlan1.jpg" alt="Ghardaia Image 4">
                     <img src="<?php echo get_template_directory_uri(); ?>/assets/images/explore/aghlan2.jpeg" alt="Ghardaia Image 5">
                     <img src="<?php echo get_template_directory_uri(); ?>/assets/images/explore/aghlan3.jpeg" alt="Ghardaia Image 6">
                 </div>
           <div class="scroll-buttons">
                 <button class="scroll-btn scroll-left"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/explore/left.png" alt="arrow-left"></button>
                 <button class="scroll-btn scroll-right"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/explore/right.png" alt="arrow-right"></button>
           </div>
           <div class="golden-line2"></div>

          </div>
          
</section>




<!--Offers Gallery-->

<div class="special-offers-section">
    <div class="offer-item">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/offers/Frame 4621.jpg" alt="Breakfast area" class="offer-image">
    </div>
    <div class="offer-item">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/offers/Frame 4622.jpg" alt="Ghardaia" class="offer-image">
    </div>
    <div class="offers-text">
        <h3 class="offers-title">Offres Spéciales</h3>
        <p class="offers-description">
            Profitez d'offres exceptionnelles à l'Hôtel Belvedere à Ghardaia, avec des tarifs réduits sur nos chambres et suites.
            Réservez dès maintenant pour vivre un séjour inoubliable dans le meilleur hôtel de la région.
        </p>
        <a href="#" class="btn-offer">Voir plus</a>
    </div>
</div>

</main>

<?php get_footer(); ?>
