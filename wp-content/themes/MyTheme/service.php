<?php
/*
Template Name: Service Page
*/
get_header(); // Include the header
?>

<div class="content service-page">
    <h1>Our Services</h1>
    <p>Welcome to our Services page. Below, you can find the details of the services we offer, along with images to better illustrate what we provide:</p>

    <div class="service-item">
        <div class="service-image">
            <img src="<?php echo get_template_directory_uri(); ?>/images/service1.jpg" alt="Service 1" class="service-img">
        </div>
        <div class="service-info">
            <h2>Consulting</h2>
            <p><strong>Description:</strong> We provide professional consulting services tailored to your project needs. Our team of experts ensures you receive the guidance and insights necessary to make informed decisions and achieve project success.</p>
        </div>
    </div>

    <div class="service-item">
        <div class="service-image">
            <img src="<?php echo get_template_directory_uri(); ?>/images/service2.jpg" alt="Service 2" class="service-img">
        </div>
        <div class="service-info">
            <h2>Project Management</h2>
            <p><strong>Description:</strong> Efficiently managing every stage of your infrastructure project, we ensure seamless execution from planning to completion. Our proven methodologies guarantee optimal results within scope, time, and budget.</p>
        </div>
    </div>

    <div class="service-item">
        <div class="service-image">
            <img src="<?php echo get_template_directory_uri(); ?>/images/service3.jpg" alt="Service 3" class="service-img">
        </div>
        <div class="service-info">
            <h2>Design & Planning</h2>
            <p><strong>Description:</strong> Creating innovative and sustainable infrastructure designs is our forte. We focus on blending creativity with practicality to deliver solutions that meet both your functional and aesthetic requirements.</p>
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<button id="back-to-top" class="back-to-top">↑</button>
<?php
get_footer(); // Include the footer
?>
