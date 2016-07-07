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

if ( ! function_exists( 'esgi_content_width' ) ) :

function esgi_content_width() {
     global $content_width;

     if ( is_page_template( 'fullwidth-page.php' ) ) {
          $content_width = 1088;
     }
}
add_action( 'template_redirect', 'esgi_content_width' );

endif;

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
	register_setting('esgi-theme', 'font_size');
	register_setting('esgi-theme', 'font_family');
	register_setting('esgi-theme', 'h1_color');
	register_setting('esgi-theme', 'h2_color');
	register_setting('esgi-theme', 'a_color');
	register_setting('esgi-theme', 'ahover_color');

}
	add_action('admin_init', 'theme_options');

/* Construction de la page d'options */
function options_page(){
	echo '<h1>Ma page d\'options</h1>
			<form action="options.php" method="POST">';
				settings_fields('esgi-theme');
				echo'<div class="container">'
						.'<div class="row">'
							.'<div class="col-md-4">'
								.'<label>Background : </label>'
							.'</div>'
							.'<div class="col-md-8">'
								.'<span style="background-color:blue"><input type="radio" name="background" class="Bradio" id="Bblue" value="blue"></span>'
								.'<span style="background-color:red"><input type="radio" name="background" class="Bradio" id="Bred" value="red"></span>'
								.'<span style="background-color:green"><input type="radio" name="background" class="Bradio" id="Bgreen" value="green"></span>'
								.'<span style="background-color:yellow"><input type="radio" name="background" class="Bradio" id="Byellow" value="yellow"></span>'
								.'<span style="background-color:grey"><input type="radio" name="background" class="Bradio" id="Bgrey" value="grey"></span>'
								.'<span style="background-color:pink"><input type="radio" name="background" class="Bradio" id="Bpink" value="pink"></span>'
								.'<span style="background-color:purple"><input type="radio" name="background" class="Bradio" id="Bpurple" value="purple"></span>'
								.'<span style="background-color:orange"><input type="radio" name="background" class="Bradio" id="Borange" value="orange"></span>'
								.'<span style="background-color:black"><input type="radio" name="background" class="Bradio" id="Bblack" value="black"></span>'
								.'<label for="Brgb"> RGB : </label>'
								.'<input type="radio" name="background" id="Brgb">'
								.'<input type="text" id="backgroundRGB" name="background" value="'.get_option('background').'" style="display:none">'
							.'</div>'
						.'</div>'
						.'<div class="row">'
							.'<div class="col-md-4">'
								.'<label>Couleur du texte : </label>'
							.'</div>'
							.'<div class="col-md-8">'
								.'<span style="background-color:blue"><input type="radio" name="text_color" class="Tradio" id="Tblue" value="blue"></span>'
								.'<span style="background-color:red"><input type="radio" name="text_color" class="Tradio" id="Tred" value="red"></span>'
								.'<span style="background-color:green"><input type="radio" name="text_color" class="Tradio" id="Tgreen" value="green"></span>'
								.'<span style="background-color:yellow"><input type="radio" name="text_color" class="Tradio" id="Tyellow" value="yellow"></span>'
								.'<span style="background-color:grey"><input type="radio" name="text_color" class="Tradio" id="Tgrey" value="grey"></span>'
								.'<span style="background-color:pink"><input type="radio" name="text_color" class="Tradio" id="Tpink" value="pink"></span>'
								.'<span style="background-color:purple"><input type="radio" name="text_color" class="Tradio" id="Tpurple" value="purple"></span>'
								.'<span style="background-color:orange"><input type="radio" name="text_color" class="Tradio" id="Torange" value="orange"></span>'
								.'<span style="background-color:black"><input type="radio" name="text_color" class="Tradio" id="Tblack" value="black"></span>'
								.'<label for="Trgb"> RGB : </label>'
								.'<input type="radio" name="text_color" id="Trgb">'
								.'<input type="text" id="textRGB" name="text_color" value="'.get_option('text_color').'" style="display:none">'
							.'</div>'
						.'</div>'
						.'<div class="row">'
							.'<label for="font_size">Taille de la Police : </label>'
							.'<input id="font_size" name="font_size" value="'.get_option('font_size').'" type="text">'
							.'<label for="font_family">Famille de Police : </label>'
							.'<input id="font_family" name="font_family" value="'.get_option('font_family').'" type="text">'
						.'</div>'
						.'<div class="row">'
							.'<div class="col-md-4">'
								.'<label>Couleur des hyperliens: </label>'
							.'</div>'
							.'<div class="col-md-8">'
								.'<span style="background-color:blue"><input type="radio" name="a_color" class="Aradio" id="Ablue" value="blue"></span>'
								.'<span style="background-color:red"><input type="radio" name="a_color" class="Aradio" id="Ared" value="red"></span>'
								.'<span style="background-color:green"><input type="radio" name="a_color" class="Aradio" id="Agreen" value="green"></span>'
								.'<span style="background-color:yellow"><input type="radio" name="a_color" class="Aradio" id="Ayellow" value="yellow"></span>'
								.'<span style="background-color:grey"><input type="radio" name="a_color" class="Aradio" id="Agrey" value="grey"></span>'
								.'<span style="background-color:pink"><input type="radio" name="a_color" class="Aradio" id="Apink" value="pink"></span>'
								.'<span style="background-color:purple"><input type="radio" name="a_color" class="Aradio" id="Apurple" value="purple"></span>'
								.'<span style="background-color:orange"><input type="radio" name="a_color" class="Aradio" id="Aorange" value="orange"></span>'
								.'<span style="background-color:black"><input type="radio" name="a_color" class="Aradio" id="Ablack" value="black"></span>'
								.'<label> RGB : </label>'
								.'<input type="radio" name="a_color" id="Argb">'
								.'<input type="text" id="ARGB" name="a_color" value="'.get_option('a_color').'" style="display:none">'
							.'</div>'
						.'</div>'
						.'<div class="row">'
							.'<div class="col-md-4">'
								.'<label>Survolage des hyperliens: </label>'
							.'</div>'
							.'<div class="col-md-8">'
								.'<span style="background-color:blue"><input type="radio" name="ahover_color" class="Ahoveradio" id="Ahblue" value="blue"></span>'
								.'<span style="background-color:red"><input type="radio" name="ahover_color" class="Ahoveradio" id="Ahred" value="red"></span>'
								.'<span style="background-color:green"><input type="radio" name="ahover_color" class="Ahoveradio" id="Ahgreen" value="green"></span>'
								.'<span style="background-color:yellow"><input type="radio" name="ahover_color" class="Ahoveradio" id="Ahyellow" value="yellow"></span>'
								.'<span style="background-color:grey"><input type="radio" name="ahover_color" class="Ahoveradio" id="Ahgrey" value="grey"></span>'
								.'<span style="background-color:pink"><input type="radio" name="ahover_color" class="Ahoveradio" id="Ahpink" value="pink"></span>'
								.'<span style="background-color:purple"><input type="radio" name="ahover_color" class="Ahoveradio" id="Ahpurple" value="purple"></span>'
								.'<span style="background-color:orange"><input type="radio" name="ahover_color" class="Ahoveradio" id="Ahorange" value="orange"></span>'
								.'<span style="background-color:black"><input type="radio" name="ahover_color" class="Ahoveradio" id="Ahblack" value="black"></span>'
								.'<label for="Ahrgb"> RGB : </label>'
								.'<input type="radio" name="ahover_color" id="Ahrgb">'
								.'<input type="text" id="AHRGB" name="ahover_color" value="'.get_option('ahover_color').'" style="display:none">'
							.'</div>'
						.'</div>'
						.'<div>'
						.'<label for="h1_color">Couleur des "h1" (Gros titre) : </label>'
						.'<input id="h1_color" name="h1_color" value="'.get_option('h1_color').'" type="text">'
						.'</div>'
						.'<div class="row">'
							.'<div class="col-md-4">'
								.'<label>Couleur des titres d\'articles </label>'
							.'</div>'
							.'<div class="col-md-8">'
								.'<span style="background-color:blue"><input type="radio" name="h2_color" class="h2radio" id="h2blue" value="blue"></span>'
								.'<span style="background-color:red"><input type="radio" name="h2_color" class="h2radio" id="h2red" value="red"></span>'
								.'<span style="background-color:green"><input type="radio" name="h2_color" class="h2radio" id="h2green" value="green"></span>'
								.'<span style="background-color:yellow"><input type="radio" name="h2_color" class="h2radio" id="h2yellow" value="yellow"></span>'
								.'<span style="background-color:grey"><input type="radio" name="h2_color" class="h2radio" id="h2grey" value="grey"></span>'
								.'<span style="background-color:pink"><input type="radio" name="h2_color" class="h2radio" id="h2pink" value="pink"></span>'
								.'<span style="background-color:purple"><input type="radio" name="h2_color" class="h2radio" id="h2purple" value="purple"></span>'
								.'<span style="background-color:orange"><input type="radio" name="h2_color" class="h2radio" id="h2orange" value="orange"></span>'
								.'<span style="background-color:black"><input type="radio" name="h2_color" class="h2radio" id="h2black" value="black"></span>'
								.'<label for="H2rgb"> RGB : </label>'
								.'<input type="radio" name="h2_color" id="H2rgb">'
								.'<input type="text" id="H2RGB" name="h2_color" value="'.get_option('h2_color').'" style="display:none">'
							.'</div>'
						.'</div>'
						.'<div>'
						.'<input value="Mettre à jour" type="submit">'
						.'</div>'
				.'</div>
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

/**
 * Shortcode évennements ouverts
 */

class OpenEvents {
    public function __construct() {
        add_shortcode("list_open_events", array($this, "open_events"));
    }

    public function open_events($atts, $content) {
        $events = new WP_Query( array( 'post_type' => 'event', 'posts_per_page' => '10') );
        echo "<div class='open-events-container'>";
        foreach ($events->posts as $key => $event) {
            $today = new DateTime("NOW");
            $date = explode("-", get_post_meta($event->ID)["event_datefin"][0]);
            $end_date = new DateTime();
            $end_date->setDate(
                intval($date[0]),
                intval($date[1]),
                intval($date[2])
            );
            if ($end_date >= $today) {
                $event_meta = get_post_meta($event->ID);
                $val = get_post_meta($event->ID, 'upload_image');
                $imgPath = explode('/', $val[0]);
                $imgPath = get_template_directory_uri().'/images/event/'.$imgPath[count($imgPath)-1];
                echo "<div class='event'>
                        <div class='event-img' style='background-image: url(" . $imgPath . ")'>
                        </div>
                        <div class='event-details'>
                            <h3>" . $event->post_title . "</h3>
                            <p>" . $event_meta["event_description"][0] . "</p>
                                <div class='btn-container'>
                                    <a class='btn btn-xs btn-success' href='" .
                                    $event->guid .
                                    "'>Rejoindre</a>
                                </div>
                        </div>
                    </div>";
            }
        }
        echo "</div>";
    }
}

new OpenEvents();



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
	if(isset($_SESSION['event_up_msg_description']))
		echo '<p class="event_upload_error_msg">'.$_SESSION['event_up_msg_description'].'</p>';
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

	if(isset($_SESSION['event_up_msg_description'])) unset($_SESSION['event_up_msg_description']);
}

function event_datefin_callback(){
	$dateMinimum = time() + (3600*24);
	$dateMinimum = date ( 'Y-m-d', $dateMinimum );
	global $post;
	$val = get_post_meta($post->ID, 'event_datefin');
	if(isset($_SESSION['event_up_msg_date']))
		echo '<p class="event_upload_error_msg">'.$_SESSION['event_up_msg_date'].'</p>';
	if(strlen(trim($val[0])) > 0)
		echo '<input type="date" min="'.$dateMinimum.'" max="" id="id_event_datefin" required placeholder="Choisissez la date de fin de votre event" name="event_datefin" value="'.$val[0].'">';
	else
		echo '<input type="date" value="'.$dateMinimum.'" min="'.$dateMinimum.'" max="" id="id_event_datefin" required placeholder="Choisissez la date de fin de votre event" name="event_datefin">';

	if(isset($_SESSION['event_up_msg_date'])) unset($_SESSION['event_up_msg_date']);
}

function event_addImage_callback(){
	global $post;
	// var_dump($post);
	if(isset($_SESSION['event_up_msg_img']))
		echo '<p class="event_upload_error_msg">'.$_SESSION['event_up_msg_img'].'</p>';
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

	if(isset($_SESSION['event_up_msg_img'])) unset($_SESSION['event_up_msg_img']);
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
function validateEventImgName($string){
	$string = trim($string);
	if(strlen($string) > 49) return false;
	$authorizedChars= "a-z0-9";
	if(preg_match("/[^".$authorizedChars."]/i", $string))
		return false;
	return $string;
}
function validateEventDescription($string){
	$string = trim($string);
	$authorizedChars= "a-z0-9 ,\.=\!éàôûîêçùèâ@\(\)\?";
	if(preg_match("/[^".$authorizedChars."]/i", $string)){
		$_SESSION["event_up_msg_description"] = "here are the only authorized characters for your description : ".str_replace('\\', '', $authorizedChars);
		return false;
	}
	return $string;
}
function renameEventFile($postId, $path, $format){
	$finalPath = str_replace("\\", '/', plugin_dir_path( __FILE__ )) . 'images/event/'.$postId.'.'.$format;
	// var_dump($finalPath);
	touch($finalPath);
	$r = move_uploaded_file($path, $finalPath);
	if($r) return $finalPath;
	return false;
}
function renameContestEventImg($postId, $path, $name, $format){
	// var_dump($postId);
	// var_dump($path);
	// var_dump($name);
	// var_dump($format);
	$imgsEventDir = str_replace("\\", '/', plugin_dir_path( __FILE__ )) . 'images/event';
	$finalPath = $imgsEventDir.'/'.$postId.'/'.$name.'.'.$format;
	// var_dump($imgsEventDir);
	if(!is_dir($imgsEventDir.'/'.$postId))
		if(!mkdir($imgsEventDir.'/'.$postId))
			return false;
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
	if(!(in_array(strtolower($format), $authorizedFormats))) return false;

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
		echo "on a checké la date";
		if(!$newDateFin){
			$_SESSION["event_up_msg_date"] = "date needs to be on american format using: YYYY-mm-dd";
			return;
		}


		$description = validateEventDescription($_POST['event_description']);
		echo "on a checké la description";
		if(!$description)
			return;

		$newImg = validateEventImg($_FILES['event_addImage']);
		echo "on a checké l'image";

		$imgAlrdyExists = file_exists(trim(get_post_meta($post->ID, 'upload_image')[0]));

		if(!$newImg && !$imgAlrdyExists){
			$_SESSION["event_up_msg_img"] = "your image needs to be a png, jpeg, jpg or gif file";
			return;
		}
		$newImg = renameEventFile($id, $newImg['path'], $newImg['format']);
		echo "on a rename l'image reçue";
		if(!$newImg && !$imgAlrdyExists){
			$_SESSION["event_up_msg_img"] = "your image couldn't be moved and parsed on server side !";
			return false;
		}
		echo "on va update !";
		update_post_meta($id, 'event_datefin', $newDateFin);
		update_post_meta($id, 'event_description', $description);
		if(!!$newImg)
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


//Creation de la table vote lors d'un changement de thème (si elle n'existe pas)

function create_vote_table(){

	global $wpdb;

    $table_name = $wpdb->prefix . 'vote';
    $table_name2 = $wpdb->prefix . 'image';


    $sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      mail varchar(80) NOT NULL,
      image int(11) NOT NULL,
      post int(11) NOT NULL,
      UNIQUE KEY id (id)
    );CREATE TABLE $table_name2 (
      id int(11) NOT NULL AUTO_INCREMENT,
      post int(11) NOT NULL,
      src varchar(255) NOT NULL,
      name varchar(50) NOT NULL,
      email varchar(100) NOT NULL,
      UNIQUE KEY id (id)
    );";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
add_action('after_switch_theme', 'create_vote_table');

require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/jetpack.php';
