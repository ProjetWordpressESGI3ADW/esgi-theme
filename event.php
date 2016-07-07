<?php 
	global $post;
	$idpost = $post->ID;
/* ##########  POST D'IMAGE  ###########*/
	if(isset($_POST['event_proposed_email']) && isset($_FILES['event_proposed_drawing'])){
		if(filter_var($_POST['event_proposed_email'], FILTER_VALIDATE_EMAIL)){
			$newImg = validateEventImg($_FILES['event_proposed_drawing']);
			if(!!$newImg){
				global $wpdb;
				// $query = "SELECT * FROM {$wpdb->prefix}comments" ;
				$mail = $filteredinputs['event_proposed_email'];
				// Checker si le mail n'a pas deja up une img
				$query = "SELECT COUNT(*) as cb FROM {$wpdb->prefix}images WHERE post =".$idpost;
				$resultats = $wpdb->get_results($query) ;

				var_dump($resultats);
		}
		}
	}
/* ##########  POST DE VOTE ########### */
	else if(false){

	}
		
/* ########### PAGE NORMAL ############# */
else{
	$val = get_post_meta($idpost, 'upload_image');
	$imgPath = explode('/', $val[0]);
	$imgPath = get_template_directory_uri().'/images/event/'.$imgPath[count($imgPath)-1];
	$event_handle = 'event_css';
	$event_stylesheet = get_template_directory_uri() . '/css/event.css';
	$event_js = get_template_directory_uri() . '/js/event.js';

	wp_enqueue_style( $event_handle, $event_stylesheet );
	wp_enqueue_script( "event_js", $event_js );
?>
	
	<?php
		$description = get_post_meta($post->ID, 'event_description');
		$path = explode('/', $description[0]);
		$path = get_template_directory_uri().'/images/event/'.$path[count($path)-1];
		echo $path;
	?>
		
	<div class="banniere">
		<h1>Titre</h1>
		<img src="https://sp.yimg.com/ib/th?id=OIP.M2de0ec74f51e3c8d313ffda88464b32eH0&pid=15.1&rs=1&c=1&qlt=95&w=105&h=108#inline">
		<div>01/01/2001</div>
	</div>
	
	<div class="description">
		description description description description description description description description description description description description 
		description description description description description description description description description description description description 
		description description description description description description description description description description description description 
		description description description description description description description description description description description description 
	</div>
	
	<div class="fixed" id="toi-aussi-upload-ton-img">
		<div id="popup" class="reduire">Masquer</div>
		<h3 class="titre_popup">Toi aussi up ton dessin miskin</h3>
		<div id="img-upload-form-container">
			<form enctype="multipart/form-data" action="" method="post">
				<label for="event_proposed_drawing">Slit here</label>
				<input required class="img-responsive" id="event_proposed_drawing" name="event_proposed_drawing" type="file">
				<label for="event_proposed_email">Donne ton email pour recevoir </label>
				<input required type="email" id="event_proposed_email" name="event_proposed_email" placeholder="email@domain.com">
				<input class="btn btn-primary" type="submit" value="Envoyer !">
			</form>
		</div>
	</div>
	
	<h3>Coche une des images, inscris ton adresse email et vote pour ton dessin préféré!</h3>
	<form class="formVoteDessin" action="<?php echo get_template_directory_uri()?>/eventvote_post.php" method="POST">
		Email : <input placeholder="email@domaine.com" type="email" name="email">
		<input class="enterEmail btn btn-primary" type="submit">
	</form>	
<?php
}
