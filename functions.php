<?php
/**
 * Theme functions and definitions
 *
 * @package constrution_gravity
 */

if ( ! function_exists( 'constrution_gravity_enqueue_styles' ) ) :
	/**
	 * @since Constrution Gravity 1.0.0
	 */
	function constrution_gravity_enqueue_styles() {
		wp_enqueue_style( 'constrution-gravity-style-parent', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'constrution-gravity-style', get_stylesheet_directory_uri() . '/style.css', array( 'constrution-gravity-style-parent' ), '1.0.0' );
		wp_enqueue_style( 'constrution-gravity-google-fonts', '//fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,600,700', false );
	}
endif;
add_action( 'wp_enqueue_scripts', 'constrution_gravity_enqueue_styles', 99 );


function constrution_gravity_customizer_fields( $fileds ) {
	unset( $fileds['footer_layout'] );
	return $fileds;
}

add_filter( 'Businessgravity_Customizer_fields', 'constrution_gravity_customizer_fields', 11 );

function tags_categories_support_all() {
	register_taxonomy_for_object_type('post_tag', 'page');
	register_taxonomy_for_object_type('category', 'page');
}

// ensure all tags and categories are included in queries
function tags_categories_support_query($wp_query) {
	if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
	if ($wp_query->get('category_name')) $wp_query->set('post_type', 'any');
}

// tag and category hooks
add_action('init', 'tags_categories_support_all');
add_action('pre_get_posts', 'tags_categories_support_query');
