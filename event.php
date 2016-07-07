<?php 
	global $post;
	global $wpdb;

	$idpost = $post->ID;
	// var_dump($idpost);
/* ##########  POST D'IMAGE  ###########*/
	if(isset($_POST['event_proposed_email']) && isset($_FILES['event_proposed_drawing']) && isset($_POST['event_proposed_img_name'])){
		// var_dump($_POST['event_proposed_email']);
		// var_dump($_POST['event_proposed_img_name']);
		// var_dump($_FILES['event_proposed_drawing']);
		if(filter_var($_POST['event_proposed_email'], FILTER_VALIDATE_EMAIL)){
			$newImg = validateEventImg($_FILES['event_proposed_drawing']);
			$name = validateEventImgName($_POST['event_proposed_img_name']);
			if(!!$newImg && !!$name){
				global $wpdb;
				// $query = "SELECT * FROM {$wpdb->prefix}comments" ;
				$mail = $_POST['event_proposed_email'];
				// Checker si le mail n'a pas deja up une img
				$query = "SELECT COUNT(email) as nb FROM {$wpdb->prefix}image WHERE email='".$mail."' AND post=".$idpost." LIMIT 0,1";
				$resultats = $wpdb->get_results($query);
				// var_dump($resultats);
				// var_dump((int)$resultats[0]->nb);
				// // var_dump();
				if((int) $resultats[0]->nb == 0){
					echo "tu peux enregistrer ton image maggle";

					$query = "SELECT COUNT(email) as nb FROM {$wpdb->prefix}image WHERE name=".$name." LIMIT 0,1";
					$resultats = $wpdb->get_results($query);
					if((int) $resultats[0]->nb == 0){
						$finalPath = renameContestEventImg($idpost, $newImg['path'], $name, $newImg['format']);
						// var_dump($wpdb->prefix.'image');

						// var_dump($idpost);
						// var_dump($finalPath);
						// var_dump($name);
						// var_dump($mail);
						$r = $wpdb->insert(
					    	$wpdb->prefix.'image',
						    array(
						        'post' => $idpost,
						        'src' => $finalPath,
						        'name' => $name,
						        'email' => $mail
						    ),
						    array(
						        '%d',
						        '%s',
						        '%s',
						        '%s'
						    )
						);
						// var_dump($r);
						if($r){
							echo "GG T'AS UP TON DESSIN FRERO";
						}
						else{
							echo "L'UP A FAIL !";
						}
					}
					else
						echo "Ce nom d'image est déjà utilisé pour cet event !";
				}
				else
					echo "Une image a déjà été postée avec cet email !";
			}
			else{
				echo "image's name must me 49 characters long and be composed only of aplhanumerical characters !";
				echo "<br>";
				echo "email must be formated as: your_email@email.com";
			}
		}

		unset($_POST['event_proposed_email'], $_POST['event_proposed_img_name'], $_FILES['event_proposed_drawing']);flush();
	}
/* ##########  POST DE VOTE ########### */
	else if(isset($_POST['vote_mail'])){
		$mail = trim($_POST['vote_mail']);
		if(isset($_POST['image_choose'])){
			$img = $_POST['image_choose'];
			if(filter_var($mail,FILTER_VALIDATE_EMAIL)){		
				$wpdb->insert(
			    	$wpdb->prefix.'vote',
				    array(
				        'mail' => $mail,
				        'image' => $img,
				        'post' => $idpost,
				    ),
				    array(
				        '%s',
				        '%d',
				        '%d',
				    )
				);
				$e = 0;
			}else{
				//Si adresse email éronnée 
				$e = 1;
			}	
		}else{
			//Si pas d'image choisie
			$ei = 2;
		}
		
	}else{
	//Si pas d'adresse mail renseignée
		$em = 3;
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
		<input type="radio" name="image_choose" value="1">
		<input type="radio" name="image_choose" value="2">
		<input type="radio" name="image_choose" value="3">
		<input type="radio" name="image_choose" value="4">
		<input type="radio" name="image_choose" value="5">
		<input type="email" name="vote_mail" placeholder="Votre e-mail">
		<?php 
			if(isset($e)){
					if($e == 0) echo '<span class="success">Vote effectué !</span>';
					if($e == 1) echo '<span class="error">Adresse email invalide</span>';
					if($e == 2) echo '<span class="error">Veuillez choisir une image</span>';
					if($e == 3) echo '<span class="error">Renseignez l\'adresse email</span>';
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
				<label for="event_proposed_img_name">Donnez un nom à votre image !</label>
				<input type="text" name="event_proposed_img_name">
				<label for="event_proposed_email">Donne ton email pour recevoir </label>
				<input required type="email" id="event_proposed_email" name="event_proposed_email" placeholder="email@domain.dtc">
				<input type="submit" value="Envoyer !">
			</form>
		</div>
	</div>
