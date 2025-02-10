<?php

namespace MonaWP\Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Patterns {
    
    public function patterns() {
        if ( function_exists( 'register_block_pattern' ) ) {
            // Registering the first table pattern
            register_block_pattern(
                'custom/table-pattern',
                array(
                    'title'       => __( 'Mona Pricing Table', 'monawp' ),
                    'description' => __( 'A custom block pattern for a table.', 'monawp' ),
                    'content'     => '<figure class="wp-block-table"><table><thead><tr><th>Plan</th><th>Features</th><th>Price</th><th>Action</th></tr></thead><tbody><tr><td>Basic</td><td>Starter pack</td><td>$9.99/month</td><td><button style="margin: 0.4rem 0;"><a href="#">Sign Up</a></button></td></tr><tr><td>Standard</td><td>Intermediate pack</td><td>$19.99/month</td><td><button style="margin: 0.4rem 0;"><a href="#">Sign Up</a></button></td></tr><tr><td>Premium</td><td>Advanced pack</td><td>$29.99/month</td><td><button style="margin: 0.4rem 0;"><a href="#">Sign Up</a></button></td></tr></tbody></table><figcaption class="wp-element-caption">Choose the plan that suits you best.</figcaption></figure>',
                )
            );

            // Registering the second table pattern
            register_block_pattern(
                'custom/second-table-pattern',
                array(
                    'title'       => __( 'Mona Pricing Table 2', 'monawp' ),
                    'description' => __( 'A custom block pattern for a table.', 'monawp' ),
                    'content'     => '<figure class="pricing-table"><table style="border-collapse: collapse; width: 100%;"><thead><tr><th>Plan</th><th>Features</th><th>Price</th></tr></thead><tbody><tr><td>Basic</td><td>Starter pack</td><td>$9.99/month</td></tr><tr><td>Standard</td><td>Intermediate pack</td><td>$19.99/month</td></tr><tr><td>Premium</td><td>Advanced pack</td><td>$29.99/month</td></tr></tbody><tfoot><tr><td><button style="margin: 0.4rem 0;"><a href="#">Basic</a></button></td><td><button style="margin: 0.4rem 0;"><a href="#">Features</a></button></td><td><button style="margin: 0.4rem 0;"><a href="#">Price</a></button></td></tr></tfoot></table><figcaption class="pricing-table-caption">Choose the plan that suits you best.</figcaption></figure>',
                )
            );
			
            register_block_pattern(
                'custom/testimonial-pattern',
                array(
                    'title'       => __( 'Mona Testimonials', 'monawp' ),
                    'description' => __( 'Three testimonials wrapped in responsive columns.', 'monawp' ),
                    'content'     => '<div class="wp-block-columns testimonials-wrapper">
                                        <div class="wp-block-column">
                                            <blockquote class="wp-block-quote">
                                                <p>First testimonial text.</p>
                                                <cite>John Doe</cite>
                                            </blockquote>
                                        </div>
                                        <div class="wp-block-column">
                                            <blockquote class="wp-block-quote">
                                                <p>Second testimonial text.</p>
                                                <cite>Jane Smith</cite>
                                            </blockquote>
                                        </div>
                                        <div class="wp-block-column">
                                            <blockquote class="wp-block-quote">
                                                <p>Third testimonial text.</p>
                                                <cite>Michael Johnson</cite>
                                            </blockquote>
                                        </div>
                                    </div>',
                )
            );
			
        }
    }

}

$patterns = new Patterns();
add_action( 'init', array( $patterns, 'patterns' ) );

?>