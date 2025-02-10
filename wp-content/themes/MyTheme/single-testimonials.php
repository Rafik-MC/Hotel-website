<?php get_header(); ?>

<div class="testimonial-single">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="testimonial-content">
            <h1><?php the_title(); ?></h1>
            <div class="testimonial-text">
                <?php the_content(); ?>
            </div>
            <div class="testimonial-meta">
                <p><strong>Client Name:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'client_name', true)); ?></p> <!-- Client Name -->
                <p><strong>Testimonial:</strong> <?php the_content(); ?></p> <!-- Testimonial Text -->
                
                <?php
                $client_photo = get_post_meta(get_the_ID(), 'client_photo', true); // Get client photo (if saved as custom field)
                if( $client_photo ): ?>
                    <img src="<?php echo esc_url($client_photo); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
                <?php endif; ?> <!-- Client Photo -->

                <p><strong>Rating:</strong> 
                    <?php
                    $star_rating = get_post_meta(get_the_ID(), 'star_rating', true); // Get the star rating value
                    echo str_repeat('⭐', intval($star_rating)); // Display stars based on the rating (1 to 5 stars)
                    ?>
                </p> <!-- Star Rating -->
            </div>
        </div>
    <?php endwhile; else : ?>
        <p><?php esc_html_e( 'Sorry, no testimonials found.' ); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>


