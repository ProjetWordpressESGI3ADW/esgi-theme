<?php
function esgi_body_classes( $classes ) {
	
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_author() && ! get_the_author_meta( 'description' ) ) {
		$classes[] = 'no-taxonomy-description';
	}

	if ( ! is_author() && is_archive() && ! get_the_archive_description() || is_search() ) {
		$classes[] = 'no-taxonomy-description';
	}

	if ( is_singular() ) {
		$classes[] = 'singular';
	}

	return $classes;
}
add_filter( 'body_class', 'esgi_body_classes' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :

	function esgi_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		$title .= get_bloginfo( 'name', 'display' );

		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'esgi' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'esgi_wp_title', 10, 2 );

	function esgi_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'esgi_render_title' );
endif;
