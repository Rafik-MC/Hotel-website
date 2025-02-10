<?php get_header(); ?>
<?php
$featured_image = get_field('featured_image');
if ($featured_image):
?>
    <img src="<?php echo $featured_image['url']; ?>" alt="<?php echo $featured_image['alt']; ?>" />
<?php endif; ?>

<?php
$read_more_url = get_field('read_more_button_url');
if ($read_more_url): 
?>
    <a href="<?php echo esc_url($read_more_url); ?>" class="read-more-btn">Read More</a>
<?php endif; ?>

<main>
    <section class="single-post">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article>
                    <h1><?php the_title(); ?></h1>
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>Post not found.</p>
        <?php endif; ?>
    </section>
</main>

<?php get_footer(); ?>
