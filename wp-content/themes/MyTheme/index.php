<?php get_header(); ?>

<main>
    <!-- Hero Section -->
    <?php if (is_front_page() && is_home()) : ?>
    <!-- This content will display only on the homepage -->
    <section class="hero">
        <h2>Welcome to Infralgi Solution</h2>
        <p>Building the future of infrastructure with trusted consulting and expertise.</p>
    </section>

    <!-- Services Section -->
    <section class="services">
        <h3>Our Services</h3>
        <ul>
            <li>
                <h4>Consulting</h4>
                <p>Expert advice on construction and infrastructure projects.</p>
            </li>
            <li>
                <h4>Project Management</h4>
                <p>Efficient management of your infrastructure projects from start to finish.</p>
            </li>
            <li>
                <h4>Design & Planning</h4>
                <p>Innovative and sustainable designs for your infrastructure needs.</p>
            </li>
        </ul>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <h3>What Our Clients Say</h3>
        <blockquote>"Infralgi Solution's team exceeded our expectations, delivering on time and with great attention to detail."</blockquote>
        <cite>- John Doe, Client</cite>
        <blockquote>"A highly professional and reliable consulting partner for all our projects."</blockquote>
        <cite>- Jane Smith, Client</cite>
    </section>

    <!-- Call-to-Action Section -->
    <section class="cta">
        <h3>Ready to Work with Us?</h3>
        <a href="/contact" class="btn">Contact Us</a>
    </section>
</main>
<?php endif; ?>
<?php get_footer(); ?>
