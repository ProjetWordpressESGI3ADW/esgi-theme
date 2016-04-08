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
        'name'          => __( 'Main Sidebar', 'esgi' ),
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
*		############  WIDGET ############
*/
	function my_widgets(){
		register_widget('link_custom');
	}
	add_action('widgets_init', 'my_widgets');
	
	/**
	* 
	*/
	class link_custom extends WP_Widget
	{
		public function link_custom(){
			parent::__construct(false, 'link_custom');
			$options = array(
				'classname'		=>	'link-custom', 
				'description'	=>	'ceci est notre premier widget' 
			);
			$this->WP_Widget('link-custom', 'Lien personnalisé', $options);
		}		
		public function widget($args, $instance){
			// Widget output
			echo '<a href="'.$instance["url"].'" class="custom-url">'.$instance["name"].'</a>';
		}
		public function update($new, $old){
			// Save widget options
			return $new;
		}
		public function form($instance){
			// Output admin widget options form
			$params = array(
				'url'	=> 'http://www.google.com',
				'name'	=> 'GOOGLE'
			);
			$instance = wp_parse_args($instance, $params);

			echo '
				<p>
					<label for="'.$this->get_field_id("name").'">Titre du lien : </label>
					<input value="'.$instance["name"].'" name="'.$this->get_field_name("name").' id="'.$this->get_field_id("name").'" type="text">
				</p>
				<p>
					<label for="'.$this->get_field_id("url").'">Url : </label>
					<input value="'.$instance["url"].'" name="'.$this->get_field_name("url").' id="'.$this->get_field_id("url").'" type="text">
				</p>
			';
		}
	}


/*
	Ajout d'un Logo d'en-tete
*/

	$defaults = array(
			'default-image'				=>	get_template_directory_uri().'/img/logo1.png',
			'width'						=>	0,
			'height'					=>	0,
			'flex-height'				=>	'',
			'flex-width'				=>	'',
			'uploads'					=>	'',
			'random-default'			=>	'',
			'header-text'				=>	'',
			'default-text-color'		=>	'',
			'wp-head-callback'			=>	'',
			'admin-head-callback'		=>	'',
			'admin-preview-callback'	=>	'',
	);
	add_theme_support('custom-header', $defaults);

function menu_page(){
	add_menu_page('Options_suplementaires', 'Option Sup', 'administrator', 'manage_options', 'options_page');
}
	add_action("admin_menu", "menu_page");

/* modifications du theme importés dans la table wp_options */
function theme_options(){
	register_setting('esgi-theme', 'background');
	register_setting('esgi-theme', 'text_color');
}
	add_action('admin_init', 'theme_options');

/* Construction de la page d'options */
function options_page(){
	echo '<h1>Ma page d\'options</h1>
			<form action="options.php" method="POST">';
				settings_fields('esgi-theme');
				echo'<label for="background">Background : </label>'
				.'<input id="background" name="background" value="'.get_option('background').'" type="text">'
				.'<label for="background">Couleur du texte : </label>'
				.'<input id="text_color" name="text_color" value="'.get_option('text_color').'" type="text">'
				.'<input value="Mettre à jour" type="submit">
			</form>';
}
/* Styliser le head */
function head_style(){
	echo('<style>')
			.'body{
				background-color:'.get_option('background').';'
				.'color:'.get_option('text_color').';
			 }
		 </style>';
}
add_action('wp_head', 'head_style');

