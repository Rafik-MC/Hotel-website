<?php get_header(); ?>

<main>
   <!-- Hero Section -->
   <section class="hero" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/hero-image.jpg'); background-size: cover; background-position: center;">
   <div class="overlay"></div>
    <h2>Welcome to Infralgi Solution</h2>
    <p>Your trusted partner in infrastructure consulting.</p>
</section>

<!-- Introduction Section -->
<section class="intro">
    <h3>Introduction to Our Company</h3>
    <p>At Infralgi Solution, we provide expert consulting services for the infrastructure industry. With a focus on sustainable development and innovation, we help our clients build for the future.</p>
</section>

<!-- Services Section -->
<section class="services">
    <h2><a href="<?php echo get_permalink( get_page_by_path( 'services' ) ); ?>"> Our Services</a></h2>
    <ul>
        <li>
            <h4>Consulting</h4>
            <p>Providing professional consulting services tailored to your project needs.</p>
        </li>
        <li>
            <h4>Project Management</h4>
            <p>Efficiently managing every stage of your infrastructure project.</p>
        </li>
        <li>
            <h4>Design & Planning</h4>
            <p>Creating innovative and sustainable infrastructure designs.</p>
        </li>
    </ul>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <h2><a href="<?php echo site_url('client-testimonials/'); ?>" class="cta-button">View Our Testimonials</a></h2>

    <?php
    $args = array(
        'post_type' => 'testimonials', // Custom Post Type
        'posts_per_page' => 5, // Number of testimonials to show
    );

    $testimonials_query = new WP_Query($args);

    if ($testimonials_query->have_posts()) {
        while ($testimonials_query->have_posts()) {
            $testimonials_query->the_post();
            // Fetch the custom fields
            $client_name = get_post_meta(get_the_ID(), 'client_name', true);
            $testimonial_text = get_the_content(); // Using post content for the testimonial text
            $client_photo_id = get_post_meta(get_the_ID(), 'client_photo', true);
            $star_rating = get_post_meta(get_the_ID(), 'star_rating', true);

            // Fetch the photo URL if available
            $client_photo = $client_photo_id ? wp_get_attachment_url($client_photo_id) : null;

            echo '<div class="testimonial-item">'; // Changed class name to align with new styles

            // Display client photo if available
            if ($client_photo) {
                echo '<img src="' . esc_url($client_photo) . '" alt="' . esc_attr($client_name) . '" class="client-photo">';
            }

            echo '<div class="testimonial-content">';
            echo '<h3>' . esc_html($client_name) . '</h3>'; // Display client name
            echo '<p>' . esc_html($testimonial_text) . '</p>'; // Display testimonial text

            // Display star rating if available
            if ($star_rating) {
                echo '<p><strong>Rating:</strong> ' . str_repeat('⭐', $star_rating) . '</p>';
            }

            echo '</div>'; // End of testimonial-content div
            echo '</div>'; // End of testimonial-item div
        }
    } else {
        echo '<p>No testimonials found.</p>';
    }

    wp_reset_postdata();
    ?>
</section>

<!-- Call-to-Action Section -->
<section class="cta">
    <h3>Get in Touch with Us Today</h3>
    <a href="<?php echo site_url('contact/'); ?>" class="btn">Contact Us</a>
</section>
</main>
<!-- Back to Top Button -->
<button id="back-to-top" class="back-to-top">↑</button>


<?php get_footer(); ?>


<?php




?>