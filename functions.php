<?php

if ( ! function_exists( 'esgi_setup' ) ) :

function esgi_setup() {
	load_theme_textdomain( 'esgi', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );
	
	add_editor_style( array( 'editor-style.css', esgi_fonts_url() ) );

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'esgi' ),
	) );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support( 'custom-background', apply_filters( 'esgi_custom_background_args', array(
		'default-color' => 'ffffff',
	) ) );
}
endif; 
add_action( 'after_setup_theme', 'esgi_setup' );

function esgi_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'esgi_content_width', 739 );
}
add_action( 'after_setup_theme', 'esgi_content_width', 0 );

if ( ! function_exists( 'esgi_content_width' ) ) :

function esgi_content_width() {
     global $content_width;

     if ( is_page_template( 'fullwidth-page.php' ) ) {
          $content_width = 1088; 
     }
}
add_action( 'template_redirect', 'esgi_content_width' );

endif; 

function esgi_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'esgi' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets 1', 'esgi' ),
		'id'            => 'footer-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets 2', 'esgi' ),
		'id'            => 'footer-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets 3', 'esgi' ),
		'id'            => 'footer-3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'esgi_widgets_init' );

function esgi_scripts() {
	wp_enqueue_style( 'esgi-style', get_stylesheet_uri() );

	wp_enqueue_style( 'esgi-esgi', esgi_fonts_url(), array(), null );

	wp_enqueue_script( 'esgi-script', get_template_directory_uri() . '/js/esgi.js', array( 'jquery' ), '20150623', true );

	$adminbar = is_admin_bar_showing();
	wp_localize_script( 'esgi-script', 'esgiadminbar', array( $adminbar ) );

	wp_enqueue_script( 'esgi-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20120206', true );

	wp_enqueue_script( 'esgi-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'esgi_scripts' );

function esgi_fonts_url() {
    $fonts_url = '';

	$esgi = esc_html_x( 'on', 'esgi Baskerville font: on or off', 'esgi' );

	if ( 'off' !== $esgi ) {
		$font_families = array();
		$font_families[] = 'esgi Baskerville:400,400italic,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;

}

function esgi_admin_scripts( $hook_suffix ) {

	wp_enqueue_style( 'esgi-esgi', esgi_fonts_url(), array(), null );

}
add_action( 'admin_print_styles-appearance_page_custom-header', 'esgi_admin_scripts' );

function esgi_cat_count_span( $links ) {
	$links = str_replace( '</a> (', '</a><span class="post-count">(', $links );
	$links = str_replace( ')', ')</span>', $links );
	return $links;
}
add_filter( 'wp_list_categories', 'esgi_cat_count_span' );

function esgi_archive_count_span( $links ) {
  $links = str_replace( '</a>&nbsp;(', '</a><span class="post-count">(', $links );
  $links = str_replace( ')', ')</span>', $links );
  return $links;
}
add_filter( 'get_archives_link', 'esgi_archive_count_span' );

if ( ! function_exists( 'esgi_continue_reading_link' ) ) :

function esgi_continue_reading_link() {
	return '&hellip; <a class="more-link" href="'. esc_url( get_permalink() ) . '">' . sprintf( wp_kses_post( __( 'Continue reading <span class="screen-reader-text">%1$s</span> <span class="meta-nav" aria-hidden="true">&rarr;</span>', 'esgi' ) ), esc_attr( strip_tags( get_the_title() ) ) ) . '</a>';
}
endif; 

function esgi_auto_excerpt_more( $more ) {
	return esgi_continue_reading_link();
}
add_filter( 'excerpt_more', 'esgi_auto_excerpt_more' );

function esgi_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= esgi_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'esgi_custom_excerpt_more' );

function esgi_comments( $comment, $args, $depth ) {
?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-metadata">
						<span class="comment-author vcard">
							<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>

							<?php printf( '<b class="fn">%s</b>', get_comment_author_link() ); ?>
						</span>
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( '<span class="comment-date">%1$s</span><span class="comment-time screen-reader-text">%2$s</span>', get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<span class="reply">',
							'after'     => '</span>'
						) ) );
						?>
						<?php edit_comment_link( esc_html__( 'Edit', 'esgi' ), '<span class="edit-link">', '</span>' ); ?>

					</div>

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'esgi' ); ?></p>
					<?php endif; ?>
				</footer>

				<div class="comment-content">
					<?php comment_text(); ?>
				</div>

			</article>
<?php
}

require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/jetpack.php';
