<?php
/* Template Name: Testimonials Page */

get_header();  // Include header
?>

<div class="testimonials-container">
    <h2>Client Testimonials</h2>

    <?php
    // WP_Query to fetch Testimonials CPT
    $args = array(
        'post_type' => 'testimonials', // The CPT name
        'posts_per_page' => -1, // Display all testimonials
        'order' => 'ASC', // You can adjust this to DESC if you want the newest first
    );

    // The Query
    $testimonial_query = new WP_Query($args);

    // The Loop
    if ($testimonial_query->have_posts()) :
        while ($testimonial_query->have_posts()) : $testimonial_query->the_post();
        ?>
            <div class="testimonial-item">
                <h3><?php the_title(); ?></h3> <!-- Testimonial title -->
                <div class="testimonial-content">
                    <p><?php the_content(); ?></p> <!-- Testimonial content -->
                </div>

                <?php
                // Get custom fields using get_post_meta
                $client_name = get_post_meta(get_the_ID(), 'client_name', true);
                $client_photo_id = get_post_meta(get_the_ID(), 'client_photo', true); // Get the attachment ID
                $star_rating = get_post_meta(get_the_ID(), 'star_rating', true);
                
                // Get the photo URL using the attachment ID
                $client_photo_url = $client_photo_id ? wp_get_attachment_url($client_photo_id) : null;
                ?>

                <?php if ($client_name): ?>
                    <p><strong>Client Name:</strong> <?php echo esc_html($client_name); ?></p>
                <?php endif; ?>

                <?php if ($client_photo_url): ?>
                    <!-- Display the client photo -->
                    <img src="<?php echo esc_url($client_photo_url); ?>" alt="Client photo" class="client-photo">
                <?php endif; ?>

                <?php if ($star_rating): ?>
                    <p><strong>Rating:</strong> <?php echo str_repeat('⭐', intval($star_rating)); ?> </p>
                <?php endif; ?>
            </div>
        <?php
        endwhile;
        wp_reset_postdata(); // Reset the post data after the loop
    else :
        echo '<p>No testimonials found.</p>'; // Message if no testimonials are found
    endif;
    ?>
</div>

<div class="testimonial-form">
    <h2>Submit Your Testimonial</h2>
    <!-- Display success message if submission is successful -->
    <?php if (isset($_GET['submitted']) && $_GET['submitted'] === 'true'): ?>
        <div class="testimonial-success">
            <p>Thank you for your testimonial! It has been submitted successfully.</p>
        </div>
    <?php endif; ?>

    <!-- Custom HTML form -->
    <form method="POST" enctype="multipart/form-data">
        <label for="client_name">Client Name</label>
        <input type="text" id="client_name" name="client_name" required>

        <label for="testimonial">Your Testimonial</label>
        <textarea id="testimonial" name="testimonial" required></textarea>

        <label for="client_photo">Upload Your Photo</label>
        <input type="file" id="client_photo" name="client_photo" accept="image/*">

        <label for="star_rating">Rate Us</label>
        <select id="star_rating" name="star_rating" required class="star-rating">
            <option value="1">★☆☆☆☆</option>
            <option value="2">★★☆☆☆</option>
            <option value="3">★★★☆☆</option>
            <option value="4">★★★★☆</option>
            <option value="5">★★★★★</option>
        </select>
        
        <button type="submit" class="submit-button" name="submit_testimonial">Submit</button>
    </form>
</div>
<!-- Back to Top Button -->
<button id="back-to-top" class="back-to-top">↑</button>
<?php get_footer(); // Include footer ?>
