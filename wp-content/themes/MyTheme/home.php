<?php get_header(); ?>

<main class="site-main">
    <!-- Welcome Section -->
    <section class="welcome-section">
        <h1 class="page-title">Welcome to Our Blog</h1>
        <p class="page-subtitle">Discover our latest updates, news, and insights.</p>
    </section>

    <!-- Blog Posts Section -->
    <section class="blog-posts">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article class="post">
                    <!-- Post Title -->
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <!-- Post Metadata -->
                    <p class="post-meta">Posted on <?php echo get_the_date(); ?></p>

                    <!-- Post Thumbnail -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Post Excerpt -->
                    <div class="post-excerpt">
                        <?php the_excerpt(); ?>
                    </div>

                    <!-- Read More Link -->
                    <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
                </article>
            <?php endwhile; ?>

            <!-- Pagination -->
            <div class="pagination">
                <?php echo paginate_links(); ?>
            </div>
        <?php else : ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </section>
</main>
<!-- Back to Top Button -->
<button id="back-to-top" class="back-to-top">↑</button>
<?php get_footer(); ?>

