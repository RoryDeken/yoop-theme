<?php
/**
 * Template part for displaying about us section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Business Gravity 1.0.0
 */
if( !business_gravity_get_option( 'disable_about' ) ):
	$id = business_gravity_get_option( 'about_page' );
	if( $id ):
		$query = new WP_Query( apply_filters( 'business_gravity_about_page_args',  array(
			'post_type'  => 'page',
			'p'          => $id,
		)));
		while( $query->have_posts() ):
			$query->the_post();
			$image = business_gravity_get_thumbnail_url( array(
				'size' => 'business-gravity-1170-710'
			));
	?>
	<!-- About Section -->
	<section class="wrapper block-about">
			<?php echo get_the_content(); ?>

	</section> <!-- End About Section -->
	<?php
		endwhile;
		wp_reset_postdata();
	endif;
endif;
