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



/**
* Adds the meta box to the page screen
*/


function intro_text_add_custom_box()
{
    $screens = ['post'];
    foreach ($screens as $screen) {
        add_meta_box(
            'intro_text_box_id',           // Unique ID
            'Post Intro Text',  // Box title
            'intro_text_box_html',  // Content callback, must be of type callable
            $screen                   // Post type
        );
    }
}
add_action('add_meta_boxes', 'intro_text_add_custom_box');


function intro_text_box_html($post)
{
    $value = get_post_meta($post->ID, '_intro_text_meta_key', true);
    ?>
    <label for="intro_text">Intro text that appears before main blog content</label>
    <textarea name="intro_text" id="intro_text" class="postbox" style="display:block;width:100%;min-height:50px;border:2px solid #e2e4e7;margin-top:10px;padding:10px;border-radius:4px;"><?php echo $value ?></textarea>

    <?php
	}


		function intro_text_save_postdata($post_id)
	{
	    if (array_key_exists('intro_text', $_POST)) {
	        update_post_meta(
	            $post_id,
	            '_intro_text_meta_key',
	            $_POST['intro_text']
	        );
	    }
	}
	add_action('save_post', 'intro_text_save_postdata');

