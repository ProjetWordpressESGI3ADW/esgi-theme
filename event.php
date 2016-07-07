<?php 
	global $post;
	global $wpdb;

	$val = get_post_meta($post->ID, 'upload_image');
	$imgPath = explode('/', $val[0]);
	$imgPath = get_template_directory_uri().'/images/event/'.$imgPath[count($imgPath)-1];

	$event_handle = 'event_css';
	$event_stylesheet = get_template_directory_uri() . '/css/event.css';

	wp_enqueue_style( $event_handle, $event_stylesheet );

	if(isset($_POST['email'])){
		if(filter_var(trim($_POST['email']),FILTER_VALIDATE_EMAIL)){
			$mail = $_POST['email'];
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

?>

	<h3>Coche une des images, inscris ton adresse email et vote pour ton dessin préféré!</h3>
	<form action="" method="POST">
		<input type="email" name="vote_mail">
		<?php 
			if(isset($em)){
					echo $em;
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
			<form enctype="multipart/form-data" action="<?php echo get_template_directory_uri()?>/event_post.php" method="post">
				<label for="event_proposed_drawing">Slit here</label>
				<input required class="img-responsive" id="event_proposed_drawing" name="event_proposed_drawing" type="file">
				<label for="event_proposed_email">Donne ton email pour recevoir </label>
				<input required type="email" id="event_proposed_email" name="event_proposed_email" placeholder="email@domain.dtc">
				<input type="submit" value="Envoyer !">
			</form>
		</div>
	</div>
