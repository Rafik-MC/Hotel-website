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

// Register Custom Post Type: Testimonials
function create_testimonials_cpt() {
    $labels = array(
        'name' => 'Testimonials',
        'singular_name' => 'Testimonial',
        'menu_name' => 'Testimonials',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Testimonial',
        'edit_item' => 'Edit Testimonial',
        'all_items' => 'All Testimonials',
        'search_items' => 'Search Testimonials',
        'not_found' => 'No Testimonials Found',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-format-quote',
    );

    register_post_type('testimonials', $args);
}
add_action('init', 'create_testimonials_cpt');

// Handle Testimonial Submission
function handle_testimonial_submission() {
    if (isset($_POST['submit_testimonial'])) {
        // Ensure the media handling functions are available
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        // Sanitize form inputs
        $client_name = sanitize_text_field($_POST['client_name']);
        $testimonial = sanitize_textarea_field($_POST['testimonial']);
        $star_rating = intval($_POST['star_rating']);

        // Handle photo upload
        $photo_id = null;
        if (!empty($_FILES['client_photo']['name'])) {
            $photo_id = media_handle_upload('client_photo', 0);
            if (is_wp_error($photo_id)) {
                // Handle upload error
                echo 'Error uploading photo.';
                return;
            }
        }

        // Insert the testimonial post
        $testimonial_id = wp_insert_post(array(
            'post_title'   => $client_name,
            'post_content' => $testimonial,
            'post_type'    => 'testimonials',
            'post_status'  => 'publish',
        ));

        if ($testimonial_id) {
            // Save custom fields
            update_post_meta($testimonial_id, 'client_name', $client_name);
            update_post_meta($testimonial_id, 'star_rating', $star_rating);
            if (!empty($photo_id)) {
                update_post_meta($testimonial_id, 'client_photo', $photo_id);
            }

            // Redirect after submission
            wp_redirect(add_query_arg('submitted', 'true', get_permalink()));
            exit;
        }
    }
}
add_action('init', 'handle_testimonial_submission');

// Notify admin on new Testimonial submission
function notify_admin_on_testimonial_submission($post_id, $post, $update) {
    if ($post->post_type === 'testimonials' && !$update) {
        $admin_email = get_option('admin_email');
        $client_name = get_post_meta($post_id, 'client_name', true);
        $star_rating = get_post_meta($post_id, 'star_rating', true);
        $testimonial_content = $post->post_content;

        $subject = 'New Testimonial Submitted';
        $message = "A new testimonial has been added:\n\n";
        $message .= "Client Name: " . esc_html($client_name) . "\n";
        $message .= "Testimonial Content: \n" . esc_html($testimonial_content) . "\n";
        $message .= "Rating: " . str_repeat('⭐', intval($star_rating)) . "\n";

        wp_mail($admin_email, $subject, $message);
    }
}
add_action('wp_insert_post', 'notify_admin_on_testimonial_submission', 10, 3);

// Add custom fields for testimonials if necessary
function add_testimonial_custom_fields() {
    // Register custom fields for the testimonial
    if(function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_testimonial_fields',
            'title' => 'Testimonial Fields',
            'fields' => array(
                array(
                    'key' => 'field_client_name',
                    'label' => 'Client Name',
                    'name' => 'client_name',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_testimonial_text',
                    'label' => 'Testimonial Text',
                    'name' => 'testimonial_text',
                    'type' => 'textarea',
                ),
                array(
                    'key' => 'field_client_photo',
                    'label' => 'Client Photo',
                    'name' => 'client_photo',
                    'type' => 'image',
                    'return_format' => 'url',
                ),
                array(
                    'key' => 'field_star_rating',
                    'label' => 'Star Rating',
                    'name' => 'star_rating',
                    'type' => 'number',
                    'min' => 1,
                    'max' => 5,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'testimonials',
                    ),
                ),
            ),
        ));
    }
}
add_action('init', 'add_testimonial_custom_fields');

// Register Custom Post Type: Blog (Fixed)
function create_blog_post_type() {
    // Ensure this code only registers the Blog CPT
    if (!post_type_exists('blog')) {
        register_post_type('blog', array(
            'labels' => array(
                'name' => 'Blog',
                'singular_name' => 'Blog Post',
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'comments'),
            'show_in_rest' => true, // For Gutenberg editor compatibility
            'rewrite' => array('slug' => 'blog'),
            'hierarchical' => false, // Set to false to avoid page-like behavior
        ));
    }
}
add_action('init', 'create_blog_post_type');


function enqueue_jquery() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');
