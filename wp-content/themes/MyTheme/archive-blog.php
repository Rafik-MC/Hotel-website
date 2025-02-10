<?php get_header(); ?>

<div class="blog-archive-container">
    <h2>Blog Posts</h2>
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            ?>
            <div class="archive-blog-item">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <div class="excerpt">
                    <?php the_excerpt(); ?>
                </div>
            </div>
        <?php endwhile;
    else :
        echo '<p>No blog posts found.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>
