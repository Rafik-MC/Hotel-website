<?php
/*
Template Name: Contact Page
*/
get_header(); // Include the header
?>

<div class="content contact-page-wrapper">
    <div class="contact-page-content">
        <h1 class="contact-title">Contact Us</h1>
        <p class="contact-description">We'd love to hear from you. Please use the form below to get in touch:</p>

        <!-- Contact Form -->
        <form class="contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">
            <input type="hidden" name="action" value="contact_form_submission">

            <div class="form-group">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="message">Your Message:</label>
                <textarea id="message" name="message" class="form-input" required></textarea>
            </div>

            <button type="submit" class="submit-button">Send Message</button>
        </form>

        <!-- Company Address -->
        <div class="company-address">
            <h2>Our Office</h2>
            <p>Mohammadia, Algiers, Algeria</p>
        </div>

        <!-- Google Map -->
        <div class="google-map">
            <h2>Find Us On The Map</h2>
            <div class="map-embed">
                <!-- Google Map Embed Code -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d51160.007658930415!2d3.112781821084987!3d36.73455634978363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x128e5273548bbdbf%3A0x85ac8d4fa617c468!2sMohammadia!5e0!3m2!1sen!2sdz!4v1732721334635!5m2!1sen!2sdz" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Back to Top Button -->
<button id="back-to-top" class="back-to-top">↑</button>
<?php
get_footer(); // Include the footer
?>
