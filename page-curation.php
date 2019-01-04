<?php
/**
 * Template Name: Page Curation Template
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Business Gravity 1.0.0
 */
get_header();
$post = get_post();
$post_id = $post->ID;
$post_cats = wp_get_post_categories($post_id);

if( have_posts() ):
	/**
	* Prints Title and breadcrumbs for archive pages
	* @since Business Gravity 1.0.0
	*/

	business_gravity_inner_banner();

?>
	<section class="wrapper block-grid" id="main-content">
		<div class="container">
			<div class="row">
				<?php if( business_gravity_get_option( 'archive_layout' ) == 'left' ): ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
				<?php $class = ''; ?>
				<?php business_gravity_get_option( 'archive_layout' ) == 'none' ? $class = 'col-12' : $class = 'col-12 col-md-8'; ?>
					<div class="<?php echo esc_attr( $class ); ?>" id="main-wrap">
					<div class="row masonry-wrapper">
						<?php
            foreach ($post_cats as $cat) {
                $args = array('category__in' => array($cat));
                $query = new WP_Query($args);
				if ( $query->have_posts() ) {

            while ( $query->have_posts() ) {

                $query->the_post();
					get_template_part( 'template-parts/archive/content', '' );

            }

        }
							
								
						}

            wp_reset_query();
						
            foreach ($post_cats as $cat) {
                $args = array('category__not_in' => array($cat),'post_type'=>'post');
                $query = new WP_Query($args);
				if ( $query->have_posts() ) {

            while ( $query->have_posts() ) {

                $query->the_post();
					get_template_part( 'template-parts/archive/content', '' );

            }

        }
							
								
						}
						?>
					</div>
					<?php
						the_posts_pagination( array(
							'next_text' => '<span>'.esc_html__( 'Next', 'business-gravity' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Next page', 'business-gravity' ) . '</span>',
							'prev_text' => '<span>'.esc_html__( 'Prev', 'business-gravity' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Previous page', 'business-gravity' ) . '</span>',
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'business-gravity' ) . ' </span>',
						));
					?>
				</div>
				<?php if( business_gravity_get_option( 'archive_layout' ) != 'left' && business_gravity_get_option( 'archive_layout' ) != 'none' ): ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php
else:
	get_template_part( 'template-parts/page/content', 'none' );
endif;

get_footer();
