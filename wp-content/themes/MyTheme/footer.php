<footer>
    <section class="footer">
        <!-- Navigation Links -->
        <div class="footer-links">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                <li><a href="<?php echo home_url('/about'); ?>">About</a></li>
                <li><a href="<?php echo home_url('/services'); ?>">Services</a></li>
                <li><a href="<?php echo home_url('/blog'); ?>">Blog</a></li>
                <li><a href="<?php echo home_url('/contact'); ?>">Contact</a></li>
            </ul>
        </div>

        <!-- Social Media Links -->
        <div class="footer-social">
            <h4>Follow Us</h4>
            <ul>
                <li><a href="https://www.facebook.com" target="_blank">Facebook</a></li>
                <li><a href="https://www.instagram.com" target="_blank">Instagram</a></li>
                <li><a href="https://www.x.com" target="_blank">X</a></li>
                <li><a href="https://www.tiktok.com" target="_blank">TikTok</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div class="footer-contact">
            <h4>Contact Us</h4>
            <p> Mohammadia, Algiers, Algeria</p>
            <p>Phone: +213 555 555 555</p>
            <p>Email: <a href="mailto:info@infralgi.com">info@infralgi.com</a></p>
        </div>
<div></div>
        <!-- Legal Links Section - moved below copyright text -->
        <div class="footer-legal">
            
            <p>
                <a href="<?php echo home_url('/terms-of-service'); ?>">Terms of Service</a> | 
                <a href="<?php echo home_url('/privacy-policy'); ?>">Privacy Policy</a>
            </p>
            <p>&copy; <?php echo date('Y'); ?> Infralgi Solution. All Rights Reserved</p>
        </div>
    </section>
</footer>

<?php wp_footer(); ?>
<script>
// Get the button
var mybutton = document.getElementById("back-to-top");

// Show the button when the user scrolls down 300px
window.onscroll = function() {
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        mybutton.classList.add("show"); // Make the button visible
    } else {
        mybutton.classList.remove("show"); // Hide the button when scrolling up
    }
};

// When the user clicks the button, scroll to the top of the page
mybutton.onclick = function() {
    window.scrollTo({top: 0, behavior: 'smooth'});
}
</script>


</body>
</html>
