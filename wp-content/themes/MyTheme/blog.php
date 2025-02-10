<?php
/*
Template Name: Blog Page
*/
get_header(); // Include the header
?>

<div class="blog-page-container">
    <h1>Latest Blog Posts</h1>

    <?php
    // Query to display the latest blog posts from the 'blog' custom post type
    $args = array(
        'post_type' => 'blog', // Make sure this is your CPT slug
        'posts_per_page' => 5, // Limit the number of posts displayed
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="post-item">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p><?php the_excerpt(); ?></p>
            </div>
            <?php
        }
    } else {
        echo "<p class='no-posts'>No blog posts available at the moment.</p>";
    }
    wp_reset_postdata();
    ?>
</div>
<!-- Back to Top Button -->
<button id="back-to-top" class="back-to-top">↑</button>
<?php
get_footer(); // Include the footer
?>
