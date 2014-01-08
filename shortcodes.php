<?php

require( get_template_directory() . '/Classes/Podlove/Modules/Contributors/Shortcodes.php' );

function t3bits_overwrite_shortcodes() {
	new \T3Bits\Podlove\Modules\Contributors\Shortcodes();
}
add_action( 'after_setup_theme', 't3bits_overwrite_shortcodes' );

?>