<?php

namespace MonaWP\Customizer;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RGBA_Color_Picker extends \WP_Customize_Control {

	/**
	 * Official control name.
	 */
	public $type = 'alpha-color';

	/**
	 * Add support for palettes to be passed in.
	 *
	 * Supported palette values are true, false, or an array of RGBa and Hex colors.
	 */
	public $palette;

	/**
	 * Add support for showing the opacity value on the slider handle.
	 */
	public $show_opacity;

	/**
	 * Render the control.
	 */
	public function render_content() {
			 // Output the label and description if they were passed in.
			if ( isset( $this->label ) && '' !== $this->label ) {
				echo '<span class="customize-control-title">' . sanitize_text_field( $this->label ) . '</span>';
			}
			if ( isset( $this->description ) && '' !== $this->description ) {
				echo '<span class="description customize-control-description">' . sanitize_text_field( $this->description ) . '</span>';
			} 
		// Process the palette
		if ( is_array( $this->palette ) ) {
			$palette = implode( '|', $this->palette );
		} else {
			// Default to true.
			$palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
		}

		// Support passing show_opacity as string or boolean. Default to true.
		$show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';

		// Begin the output. ?>
		<label>
			<input class="alpha-color-control" type="text" data-show-opacity="<?php echo absint($show_opacity); ?>" data-palette="<?php echo esc_attr( $palette ); ?>" data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php $this->link(); ?>  />
		</label>
		<?php
	}
}

?>