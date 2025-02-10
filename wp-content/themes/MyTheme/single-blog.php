<?php get_header(); ?>

<div class="blog-post-container">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>
            <div class="single-blog-post">
                <h2><?php the_title(); ?></h2>
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
                <div class="post-meta">
                    <p>Published on: <?php the_date(); ?></p>
                </div>
            </div>
        <?php endwhile;
    endif;
    ?>
</div>
<!-- Back to Top Button -->
<button id="back-to-top" class="back-to-top">↑</button>
<?php get_footer(); ?>
