<?php

function esgi_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'main',
		'render'         => 'esgi_infinite_scroll_render',
		'footer'         => 'masthead',
		'footer_widgets' => array( 'footer-1', 'footer-2', 'footer-3' ),
	) );

	add_theme_support( 'jetpack-responsive-videos' );

	add_theme_support( 'post-thumbnails' );
	add_image_size( 'esgi-site-logo', '300', '300' );

	add_theme_support( 'site-logo', array( 'size' => 'esgi-site-logo' ) );

} 
add_action( 'after_setup_theme', 'esgi_jetpack_setup' );

function esgi_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} 
