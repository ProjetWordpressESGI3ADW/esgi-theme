<?php
/**
 * Proper way to enqueue scripts and styles
 */
// Fonction pour éviter les conflits entre js et css et les inclure
function wpdocs_theme_name_scripts() {
    /**
	*	Module
	*/
	wp_enqueue_style('style-menu', get_stylesheet_directory_uri() . '/css/menu.css' );
	wp_enqueue_style('style-font', get_stylesheet_directory_uri() . '/css/font.css' );
	wp_enqueue_style('style-icon', get_stylesheet_directory_uri() . '/css/icon.css' );
	/**
	*	Général
	*/
    wp_enqueue_style( 'style-name', get_stylesheet_uri() );
    /**
    *	Javascript
    */
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'script-menu', get_template_directory_uri() . '/js/menu.js');
    wp_enqueue_script( 'script-example', get_template_directory_uri() . '/js/example.js');
    /**
	*	Bootstrap
	*/
	wp_enqueue_style('bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.css' );	
    wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.js' );
    /**
     * Custom css
     */
    wp_enqueue_style('global-css', get_stylesheet_directory_uri() . '/css/global.css' );

}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );

//Fonction pour ajouter des menus
function menus(){
	register_nav_menu('x_menu','Menu horizontal');
	register_nav_menu('y_menu','Menu vertical');
}
function custom_nav_class($classes, $item){
        $classes[] = "toto";
        return $classes;
}
add_filter('nav_menu_css_class' , 'custom_nav_class' , 10 , 2);
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
		'default-image'				=>	get_template_directory_uri().'/images/logo.png',
		'width'						=> 0,
		'height'					=> 0,
		'flex-height'				=> false,
		'flex-width'				=> false,
		'uploads'					=> true,
		'random-default'			=> false,
		'header-text'				=> true,
		'default-text-color'		=> '',
		'wp-head-callback'			=> '',
		'admin-head-callback'		=> '',
		'admin-preview-callback'	=> ''
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



/*Création de mon propre type */
add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'acme_product',
		array(
			'labels' => array(
			'name' => __( 'Products' ),
			'singular_name' => __( 'Product' )
		),
		'public' => true,
		'has_archive' => true,
		)
	);
}



/* Creation du nouveau type de contenu 'event' affiché as "Evenement" */
function newCustomPostType(){
	register_post_type('event', array(
			'labels' => array(
				'name' => __('Evenements'),
				'singular_label' => __('Evenement')
			),
			'all_items' => 'Tous les évenements',
			'view_item' => 'Voir l\'évenement',
			'public' => true,
			'has_archive' => true,
			'menu_position' => 4,
			'menu_icon' => get_bloginfo('template_directory') . '/images/calend.png',
			'supports' => array(
				'title',
				'thumbnail',
				'revisions',
				)
			));
	register_taxonomy( 'Ajouter Categorie', 'event', array( 'hierarchical' => true, 'label' => 'Ajouter Categorie', 'query_var' => true, 'rewrite' => true ));
}
add_action('init', 'newCustomPostType');
function my_rewrite_flush() {
    newCustomPostType();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'my_rewrite_flush' );

// Add post thumbnails
/*function custom_theme_setup(){
	add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'custom_theme_setup');
*/

/**
 * Register meta box(es).
 */


function wpdocs_register_meta_boxes() {
    add_meta_box ( 'event_description', 'Description', 'event_description_callback', ['event'], 'normal', 'high');
    add_meta_box ( 'event_datefin', 'Date de fin', 'event_datefin_callback', ['event'], 'normal', 'low');
    add_meta_box ( 'event_addImage', 'Image de l\'event', 'event_addImage_callback', ['event'], 'normal', 'low');

}
// add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wpdocs_my_display_callback( $post ) {
    echo '<script>alert('.$post.')</script>';
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
/*function wpdocs_save_meta_box( $post_id ) {
	echo '<input type="text" name="event_titre" placeholder="Votre titre">';
    // Save logic goes here. Don't forget to include nonce checks!
}
add_action( 'save_post', 'wpdocs_save_meta_box' );
*/
/*add_meta_box ( 'id_poste', 'Titre', 'event_titre_callback', ['event'], 'normal', 'high');
add_action( 'add_meta_boxes', 'Titre' );*/

function event_description_callback(){
	global $post;
	$val = get_post_meta($post->ID, 'event_description');
	// var_dump($val);
	if(strlen(trim($val[0])) > 0){
		echo '<div id="descriptiondiv">
			<div id="description-wrap">
				<label class="" id="desription-prompt-text" for="title">Saisissez votre desription</label>
				<input type="text" name="event_description" size="30" value="'.$val[0].'" id="description" spellcheck="true" autocomplete="off">
				
			</div>
		  </div>';
	}
	else{
		echo '<div id="descriptiondiv">
			<div id="description-wrap">
				<label class="" id="desription-prompt-text" for="title">Saisissez votre desription</label>
				<input type="text" name="event_description" size="30" value="" id="description" spellcheck="true" autocomplete="off">
				
			</div>
		  </div>';
		 }
}

function event_datefin_callback(){
	$dateMinimum = time() + (3600*24);
	$dateMinimum = date ( 'Y-m-d', $dateMinimum );

	global $post;
	$val = get_post_meta($post->ID, 'event_datefin');
	// var_dump($val);
	if(strlen(trim($val[0])) > 0)
		echo '<input type="date" min="'.$dateMinimum.'" max="" id="id_event_datefin" required placeholder="Choisissez la date de fin de votre event" name="event_datefin" value="'.$val[0].'">';
	else
		echo '<input type="date" value="'.$dateMinimum.'" min="'.$dateMinimum.'" max="" id="id_event_datefin" required placeholder="Choisissez la date de fin de votre event" name="event_datefin">';
}

function event_addImage_callback(){	
	global $post;
	var_dump($post);
	$val = get_post_meta($post->ID, 'upload_image');
	if(strlen(trim($val[0])) > 0){
		$clientPath = explode('/', $val[0]);
		$clientPath = get_template_directory_uri().'/images/event/'.$clientPath[count($clientPath)-1];
		echo('
			<img id="event_already_uploaded_img"  src="'.$clientPath.'" alt="post'.$post->ID.'">
			<figcaption id="event_already_uploaded_img_figcaption">Image courante</figcaption>
			<div id="id_event_addImage">
			<input class="img-responsive" id="event_addImage" name="event_addImage" type="file">
	  	</div>');
	}
	else
		echo('<div id="id_event_addImage">
			<input id="event_addImage" name="event_addImage" type="file">
	  	</div>');

	//echo("<input type='file' id='eventImage' value='Ajouter une image'>");
}

function init_fields(){
	// echo "<script>alert('on est dans init_fields()');</script>";
	add_meta_box('id_poste', 'Poste au sein de l\'entreprise', 'id_poste', 'team');
	add_meta_box ( 'event_description', 'Description', 'event_description_callback', ['event'], 'normal', 'high');
    add_meta_box ( 'event_datefin', 'Date de fin', 'event_datefin_callback', ['event'], 'normal', 'low');
    add_meta_box ( 'event_addImage', 'Image de l\'event', 'event_addImage_callback', ['event'], 'normal', 'low');
}

function id_poste(){
	echo "<script>alert('on est dans id_poste()');</script>";
	global $post;
	$custom = get_post_custom($post->ID);
	$id_poste = $custom["id_poste"][0];
	echo '<input size="70" type="text" value="'.$id_poste.'" name="id_poste"/>';
}

function validateEventDate($string){
	$date = DateTime::createFromFormat('Y-m-d', $string);
	if(!!$date)
		return $string;
	return false;
}

function validateEventDescription($string){
	$string = trim($string);
	$authorizedChars= "a-z0-9 ,\.=\!éàôûîêçùèâ@\(\)\?";
	if(preg_match("/[^".$authorizedChars."]/i", $string))
		return false;
	return $string;
}
function renameEventFile($postId, $path, $format){
	$finalPath = str_replace("\\", '/', plugin_dir_path( __FILE__ )) . 'images/event/'.$postId.'.'.$format;
	// var_dump($finalPath);
	echo "<script>alert('".$finalPath."');</script>";
	touch($finalPath);
	$r = move_uploaded_file($path, $finalPath);
	if($r) return $finalPath;
	return false;
}
function validateEventImg(array $upFile){
	if($upFile['size'] > 2000000) return false;
	if($upFile['error'] > 0) return false; 
	$type = $upFile['type'];
	if(is_bool(strpos($type, 'image'))) return false;
	$authorizedFormats = ['png', 'jpg', 'jpeg', 'gif'];
	$name = $upFile['name'];
	$format = explode('.', $name);
	$format = $format[count($format)-1];
	if(!(in_array($format, $authorizedFormats))) return false;

	return ['path' => $upFile['tmp_name'], 'format' => $format];
}

function save_custom(){
	global $post;
	// var_dump($post);
	// var_dump($_POST);
	// var_dump($_FILES);
	// exit;
	if($post->post_type == 'event'){
		// On enregistre donc les informations d'une contenu de type event 
		$id = $post->ID;
		$newDateFin = validateEventDate($_POST['event_datefin']);
		if(!$newDateFin){
			var_dump("FAIL DATE");
			return;
		}


		$description = validateEventDescription($_POST['event_description']);
		if(!$description){
			var_dump("FAIL DESCRIPTION");
			return;
		}

		$newImg = validateEventImg($_FILES['event_addImage']);
		if(!$newImg){
			var_dump("FAIL IMG");
			return;
		}
		$newImg = renameEventFile($id, $newImg['path'], $newImg['format']);
		if(!$newImg){
			var_dump("FAIL TO MOVE FILE");
			return false;
		}

		update_post_meta($id, 'event_datefin', $newDateFin);
		update_post_meta($id, 'event_description', $description);
		update_post_meta($id, 'upload_image', $newImg);
		return;
	}
	
	// fonction pour eviter le vidage des champs personalisés lors de la
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post->ID;
	update_post_meta($post->ID, "id_poste", $_POST["id_poste"]);
}
// function pr ajouter des chps personnalisés
add_action("save_post", "save_custom");
add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );
add_action("admin_init", "init_fields");

function register_my_setting() {
	register_setting( 'my_options_group', 'my_option_name', 'intval' ); 
} 
add_action( 'admin_init', 'register_my_setting' );


/* ############  IMPORT DU CSS BACK-ADMIN  ############# */
function admin_css() {
	$admin_handle = 'admin_css';
	$admin_stylesheet = get_template_directory_uri() . '/css/admin.css';

	wp_enqueue_style( $admin_handle, $admin_stylesheet );
}
add_action('admin_print_styles', 'admin_css', 11 );

/* ############  IMPORT DU JS BACK-ADMIN  ############# */
function admin_js() {
	$admin_handle = 'admin_js';
	$admin_js = get_template_directory_uri() . '/js/admin.js';
	var_dump("fdp");

	wp_enqueue_script( $admin_handle, $admin_js );
}
// add_action('admin_print_scripts', 'admin_js', 11 );

/* ACTIVATION DU BOUTON DE RECHERCHE DE MEDIA  */
function my_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', get_bloginfo('template_url') . '/js/admin.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
}
function my_admin_styles() {
	wp_enqueue_style('thickbox');
}
add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');


