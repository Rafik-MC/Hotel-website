<?php
// Enqueue styles
function my_theme_enqueue_styles() {
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

// Register navigation menus
function my_theme_setup() {
    register_nav_menus(array(
        'primary' => 'Primary Menu',
        'main-menu' => 'Main Navigation Menu',
    ));
}
add_action('after_setup_theme', 'my_theme_setup');

function hotel_belvedere_customizer($wp_customize) {
    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Hero Section', 'hotel-belvedere'),
        'priority' => 30,
    ));

    // Hero Background Image
    $wp_customize->add_setting('hero_bg_image', array(
        'default' => get_template_directory_uri() . '/assets/images/hero-bg.jpg',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_bg_image', array(
        'label'    => __('Hero Background Image', 'hotel-belvedere'),
        'section'  => 'hero_section',
        'settings' => 'hero_bg_image',
    )));

    // Logo
    $wp_customize->add_setting('logo_image', array(
        'default' => get_template_directory_uri() . '/assets/images/Calque_1.png',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo_image', array(
        'label'    => __('Logo Image', 'hotel-belvedere'),
        'section'  => 'hero_section',
        'settings' => 'logo_image',
    )));

    // Hero Heading
    $wp_customize->add_setting('hero_heading', array(
        'default' => 'Hôtel Le Belvedere<br>Votre refuge au coeur de Ghardaïa',
    ));
    $wp_customize->add_control('hero_heading', array(
        'label'   => __('Hero Heading', 'hotel-belvedere'),
        'section' => 'hero_section',
        'type'    => 'text',
    ));

    // Hero Subtext
    $wp_customize->add_setting('hero_subtext', array(
        'default' => 'Vivez une expérience unique alliant luxe et confort au <span class="belvedere">Belvedere</span>,<br> et au plus près des trésors de Ghardaïa.',
    ));
    $wp_customize->add_control('hero_subtext', array(
        'label'   => __('Hero Subtext', 'hotel-belvedere'),
        'section' => 'hero_section',
        'type'    => 'textarea',
    ));

    // Hero Button Text
    $wp_customize->add_setting('hero_button_text', array(
        'default' => 'Voir plus',
    ));
    $wp_customize->add_control('hero_button_text', array(
        'label'   => __('Hero Button Text', 'hotel-belvedere'),
        'section' => 'hero_section',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'hotel_belvedere_customizer');

function enqueue_custom_styles() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
    wp_enqueue_style('theme-styles', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');

// Enqueue custom JS file in functions.php
function my_theme_enqueue_scripts() {
    // Enqueue the main stylesheet
    wp_enqueue_style( 'theme-style', get_stylesheet_uri() );
    
    // Enqueue custom JS file for mobile menu toggle
    wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/js/custom.js', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_scripts' );

// In functions.php or a template file
include( get_template_directory() . '/LeBelvedere.php' );








if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_form"])) {  
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : '';  
    $first_name = isset($_POST["first_name"]) ? trim($_POST["first_name"]) : '';  
    $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : '';  
    $subject = isset($_POST["subject"]) ? trim($_POST["subject"]) : '';  
    $message = isset($_POST["message"]) ? trim($_POST["message"]) : '';  

    // Validate required fields
    if (!empty($name) && !empty($first_name) && !empty($phone) && !empty($subject) && !empty($message)) {
        $to = "bourasmohammedrafik@gmail.com";
        $email_subject = "New Contact Form Submission: $subject";
        
        // Structure the message
        $email_content = "You have received a new message from the contact form.\n\n";
        $email_content .= "---------------------------------------\n";
        $email_content .= "Name: $name\n";
        $email_content .= "First Name: $first_name\n";
        $email_content .= "Phone: $phone\n";
        $email_content .= "Subject: $subject\n";
        $email_content .= "Message:\n$message\n";
        $email_content .= "---------------------------------------\n";
        $email_content .= "Sent on: " . date("Y-m-d H:i:s") . "\n";

        // Email headers
        $headers = "From: contact-form@" . $_SERVER['HTTP_HOST'] . "\r\n" . 
                   "Reply-To: no-reply@" . $_SERVER['HTTP_HOST'] . "\r\n" . 
                   "X-Mailer: PHP/" . phpversion();

        if (mail($to, $email_subject, $email_content, $headers)) {
            // Redirect to contact page with success message
            header("Location: " . site_url('/contact?status=success'));
            exit();
        } else {
            // Redirect to contact page with error message
            header("Location: " . site_url('/contact?status=error'));
            exit();
        }
    } else {
        // Redirect to contact page with missing fields message
        header("Location: " . site_url('/contact?status=missing'));
        exit();
    }
}

