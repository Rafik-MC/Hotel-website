<?php
/*
Template Name: About Page
*/
get_header(); // Include the header
?>

<div class="content about-page">
    <h1>À Propos de Nous</h1>
    <p>Bienvenue sur notre page À propos. Découvrez l'histoire de notre entreprise, notre mission, et les valeurs qui nous guident au quotidien :</p>

    <!-- History Section -->
    <div class="about-section history">
        <h2>Notre Histoire</h2>
        <div class="about-content">
            <div class="about-image">
                <img src="<?php echo get_template_directory_uri(); ?>/images/history.jpg" alt="Notre Histoire" class="about-img">
            </div>
            <div class="about-text">
               <p>Notre entreprise, fondée en 2003, a pour objectif de fournir des solutions de conseil en infrastructure et construction de la plus haute qualité. Depuis nos débuts, nous avons évolué pour devenir un acteur clé dans le secteur de la construction et des infrastructures, en mettant l'accent sur l'innovation et la durabilité dans tous nos projets.</p>
               <p>Au fil des années, nous avons renforcé notre position grâce à une équipe d'experts passionnés, des projets réalisés avec succès, et une vision claire de l'excellence dans chaque aspect de notre travail.</p>
            </div>
        </div>
    </div>

    <!-- Mission Section -->
    <div class="about-section mission">
        <h2>Notre Mission</h2>
        <div class="about-content">
            <div class="about-image">
                <img src="<?php echo get_template_directory_uri(); ?>/images/mission.jpg" alt="Notre Mission" class="about-img">
            </div>
            <div class="about-text">
                <p>Notre mission est de fournir des solutions de haute qualité qui répondent aux besoins spécifiques de nos clients. Nous croyons en l'innovation continue et dans la recherche de nouveaux moyens pour améliorer l'efficacité et la durabilité des solutions proposées.</p>
                <p>Nous nous engageons à offrir un service exceptionnel et à établir des relations de confiance avec nos clients, partenaires et collaborateurs.</p>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="about-section values">
        <h2>Nos Valeurs</h2>
        <div class="about-content">
            <div class="about-image">
                <img src="<?php echo get_template_directory_uri(); ?>/images/values.jpg" alt="Nos Valeurs" class="about-img">
            </div>
            <div class="about-text">
                <p>Nos valeurs fondamentales guident chaque aspect de notre entreprise. Elles incluent :</p>
                <ul>
                    <li><strong>Excellence :</strong> Nous nous efforçons toujours de fournir le meilleur à nos clients.</li>
                    <li><strong>Innovation :</strong> Nous croyons que la clé du succès réside dans l'innovation continue.</li>
                    <li><strong>Engagement :</strong> Nous nous engageons envers nos clients, partenaires et employés.</li>
                    <li><strong>Durabilité :</strong> Nous avons à cœur de promouvoir des solutions durables et respectueuses de l'environnement.</li>
                </ul>
                <p>Ces valeurs nous permettent de maintenir un haut niveau de qualité et d'intégrité dans toutes nos interactions.</p>
            </div>
        </div>
    </div>
</div>
<!-- Back to Top Button -->
<button id="back-to-top" class="back-to-top">↑</button>
<?php
get_footer(); // Include the footer
?>
