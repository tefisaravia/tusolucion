<?php
/**
 * AgentPress Pro.
 *
 * This file adds the taxonomy template to the AgentPress Pro Theme.
 *
 * @package AgentPress
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/agencypress/
 */

// Force full width layout.
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Add listings archive widget area.
add_action( 'genesis_before_content_sidebar_wrap', 'agentpress_archive_widget' );
function agentpress_archive_widget() {

	if ( is_active_sidebar( 'listings-archive' ) ) {

		genesis_widget_area( 'listings-archive', array(
			'before' => '<div class="listing-archive full-width widget-area">',
			'after'  => '</div>',
		) );
	}
}

// Relocate archive intro text.
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_taxonomy_title_description' );

// Remove the standard loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'agentpress_listing_archive_loop' );
/**
 * Custom loop for listing archive page.
 */
function agentpress_listing_archive_loop() {

	if ( have_posts() ) : while ( have_posts() ) : the_post();

		$listing_precio = genesis_get_custom_field( '_listing_precio' );
		$listing_text  = genesis_get_custom_field( '_listing_text' );
		$dormitorio       = genesis_get_custom_field( '_listing_dormitorio' );
		$categoria          = genesis_get_custom_field( '_listing_categoria' );
		$tipo         = genesis_get_custom_field( '_listing_tipo' );
		$zona           = genesis_get_custom_field( '_listing_zona' );

		$loop = ''; // Init.

		$loop .= sprintf( '<a href="%s">%s</a>', get_permalink(), genesis_get_image( array( 'size' => 'properties' ) ) );

		if ( $listing_precio ) {
			$loop .= sprintf( '<span class="listing-precio">%s</span>', $listing_precio );
		}

		if ( $listing_text ) {
			$loop .= sprintf( '<span class="listing-text">%s</span>', $listing_text );
		}

		if ( $categoria || $tipo || $zona ) {

			// Count number of completed fields.
			$pass = count( array_filter( array( $categoria, $tipo, $zona ) ) );

			// If only 1 field filled out, no comma.
			if ( 1 == $pass ) {
				$categoria_tipo_zona = $categoria . $tipo . $zona;
			}
			// If categoria filled out, en after categoria.
			elseif ( $categoria ) {
				$categoria_tipo_zona = $categoria . " en " . $tipo . " Zona " . $zona;
			}
			// Otherwise, comma after tipo.
			else {
				$categoria_tipo_zona = $categoria . " " . $tipo . " - " . $zona;
			}

			$loop .= sprintf( '<span class="listing-categoria-tipo-zona">%s</span>', trim( $categoria_tipo_zona ) );

		}

		if ( $dormitorio ) {
			$loop .= sprintf( '<span class="listing-dormitorio">%s Dormitorios</span>', $dormitorio );
		}

		$loop .= sprintf( '<a href="%s" class="more-link">%s</a>', get_permalink(), __( 'View Listing', 'agentpress' ) );

		// Wrap in post class div, and output.
		printf( '<div class="%s"><div class="widget-wrap"><div class="listing-wrap">%s</div></div></div>', join( ' ', get_post_class() ), $loop );

	endwhile; 

	genesis_posts_nav();

	else: printf( '<div class="entry"><p>%s</p></div>', __( 'Sorry, no properties matched your criteria.', 'agentpress' ) );

	endif;

}

// Run the Genesis loop.
genesis();
