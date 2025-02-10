<?php
/* Template Name: Contact */
 ?>
 
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">



   

<div class="hero-section" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/contact/contact-background.jpg');">
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
        <!-- Hero Content -->
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-stars">
                <span>★</span><span>★</span><span>★</span><span>★</span>
            </div>
            <h1>Contact</h1>
        </div>
    </div>

<main>


 <!-- Display status message here -->
 <?php
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'success') {
                echo "<p style='color: green;'>Email sent successfully!</p>";
            } elseif ($_GET['status'] == 'error') {
                echo "<p style='color: red;'>Email sending failed. Please try again.</p>";
            } elseif ($_GET['status'] == 'missing') {
                echo "<p style='color: orange;'>Please fill in all the fields.</p>";
            }
        }
        ?>

        <div class="contact-tetxt">
            <h3>We are here to answer all your questions, assist you with reservations, or provide additional information about our services.</h3>
        </div>
    <div class="contact-container">
        <!-- Left Side with Image -->
        <div class="contact-image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contact/contact.jpg" alt="Contact Us">
        </div>

        <!-- Right Side with Form -->
        <div class="form-wrapper">
            <form action="functions.php" method="POST" class="styled-form">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <div class="input-wrapper">
                        <input type="text" id="name" name="name" placeholder="First Name" required>
                        <span class="icon user-icon"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="first-name">First Name:</label>
                    <div class="input-wrapper">
                        <input type="text" id="first-name" name="first_name" placeholder="Second Name" required>
                        <span class="icon user-icon"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <div class="input-wrapper">
                        <input type="tel" id="phone" name="phone" placeholder="Phone" required>
                        <span class="icon phone-icon"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject:</label>
                    <div class="input-wrapper">
                        <input type="text" id="subject" name="subject" placeholder="Subject" required>
                        <span class="icon mail-icon"></span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="message">Message:</label>
                    <div class="input-wrapper">
                        <textarea id="message" name="message" placeholder="Message" required></textarea>
                        <span class="icon mail-icon"></span>
                    </div>
                </div>

                <div class="form-group recaptcha">
                    <div class="g-recaptcha" data-sitekey="your-site-key"></div>
                </div>

                <button type="submit" class="submit-btn" name="submit_form">Send</button>
            </form>
        </div>
    </div>
</main>

<?php get_footer(); ?>
