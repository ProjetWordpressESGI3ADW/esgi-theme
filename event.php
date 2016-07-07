<?php 
	global $post;
	global $wpdb;

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
	else if(isset($_POST['vote_mail'])){
		$mail = trim($_POST['vote_mail']);
		if(filter_var($mail,FILTER_VALIDATE_EMAIL)){		
			$wpdb->insert(
			    $wpdb->prefix.'vote',
			    array(
			        'mail' => $mail,
			        'image' => 1,
			        'post' => 1,
			    ),
			    array(
			        '%s',
			        '%d',
			        '%d',
			    )
			);
			$em = 0;
		}else{
			//Si adresse email éronnée 
			$em = 1;
		}	
	}else{
	//Si pas d'adresse mail renseignée
		$em = 2;
	}
		
/* ########### PAGE NORMAL ############# */
	$val = get_post_meta($idpost, 'upload_image');
	$imgPath = explode('/', $val[0]);
	$imgPath = get_template_directory_uri().'/images/event/'.$imgPath[count($imgPath)-1];
	$event_handle = 'event_css';
	$event_stylesheet = get_template_directory_uri() . '/css/event.css';

	wp_enqueue_style( $event_handle, $event_stylesheet );
?>

	<h3>Coche une des images, inscris ton adresse email et vote pour ton dessin préféré!</h3>
	<form action="" method="POST">
		<input type="email" name="vote_mail">
		<?php 
			if(isset($em)){
					if($em == 0) echo '<span class="success">Vote effectué !</span>';
					if($em == 1) echo '<span class="error">Adresse email invalide</span>';
					if($em == 2) echo '<span class="error">Renseignez l\'adresse email</span>';
			}
		?>
		<input type="submit">
	</form>
	<div class="fixed" id="toi-aussi-upload-ton-img">
		<h3>Toi aussi up ton dessin miskin</h3>
		<div id="img-upload-form-container">
			<form enctype="multipart/form-data" action="" method="post">
				<label for="event_proposed_drawing">Slit here</label>
				<input required class="img-responsive" id="event_proposed_drawing" name="event_proposed_drawing" type="file">
				<label for="event_proposed_email">Donne ton email pour recevoir </label>
				<input required type="email" id="event_proposed_email" name="event_proposed_email" placeholder="email@domain.dtc">
				<input type="submit" value="Envoyer !">
			</form>
		</div>
	</div>
