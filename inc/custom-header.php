<?php

function esgi_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'esgi_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '404040',
		'width'                  => 1088,
		'height'                 => 300,
		'flex-height'            => true,
		'wp-head-callback'       => 'esgi_header_style',
		'admin-head-callback'    => 'esgi_admin_header_style',
		'admin-preview-callback' => 'esgi_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'esgi_custom_header_setup' );

if ( ! function_exists( 'esgi_header_style' ) ) :

function esgi_header_style() {
	$header_text_color = get_header_textcolor();

	if ( HEADER_TEXTCOLOR == $header_text_color ) {
		return;
	}
	?>
	<style type="text/css">
	<?php
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; 

if ( ! function_exists( 'esgi_admin_header_style' ) ) :

function esgi_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#desc {
		}
		#headimg img {
		}
	</style>
<?php
}
endif;

if ( ! function_exists( 'esgi_admin_header_image' ) ) :

function esgi_admin_header_image() {
?>
	<div id="headimg">
		<h1 class="displaying-header-text">
			<a id="name" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</h1>
		<div class="displaying-header-text" id="desc" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>"><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; 
