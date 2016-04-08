<?php
/**
 * Proper way to enqueue scripts and styles
 */
// Fonction pour éviter les conflits entre js et css et les inclures
function wpdocs_theme_name_scripts() {
    wp_enqueue_style( 'style-name', get_stylesheet_uri() );
    wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );

//Fonction pour ajouter des menus
function menus(){
	register_nav_menu('main_menu','Menu_principal');
	register_nav_menu('secondary_menu','Menu_secondaire');
}
add_action('init', 'menus');

/**
 * Ajoute une sidebar (zone de widget).
 */
function wpdocs_theme_slug_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Main Sidebar <3', 'esgi' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'textdomain' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
     	) );
	}
	add_action( 'widgets_init', 'wpdocs_theme_slug_widgets_init' );

/*
	Ajout d'un Logo d'en-tete
*/

	$defaults = array(
			'default-image'				=>	get_template_directory_uri().'/img/logo1.png',
			'width'						=>	0,
			'height'					=>	0,
			'flex-height'				=>	0,
			'flex-width'				=>	0,
			'uploads'					=>	0,
			'random-default'			=>	0,
			'header-text'				=>	0,
			'default-text-color'		=>	0,
			'wp-head-callback'			=>	0,
			'admin-head-callback'		=>	0,
			'admin-preview-callback'	=>	0,
	);
	add_theme_support('custom-header', $defaults);

	function menu_page(){
		add_menu_page('Option_suplementaire', 'Option Sup', 'administrator', 'manage_options');

	}
	add_action("admin_menu", "menu_page");
