<?php 
	global $post;
	global $wpdb;

	$idpost = $post->ID;
	var_dump($idpost);
/* ##########  POST D'IMAGE  ###########*/
	if(isset($_POST['event_proposed_email']) && isset($_FILES['event_proposed_drawing']) && isset($_POST['event_proposed_img_name'])){
		if(filter_var($_POST['event_proposed_email'], FILTER_VALIDATE_EMAIL)){
			$newImg = validateEventImg($_FILES['event_proposed_drawing']);
			$name = validateEventImgName($_POST['event_proposed_img_name']);
			if(!!$newImg && !!$name){
				global $wpdb;
				// $query = "SELECT * FROM {$wpdb->prefix}comments" ;
				$mail = $filteredinputs['event_proposed_email'];
				// Checker si le mail n'a pas deja up une img
				$query = "SELECT COUNT(email) as nb FROM {$wpdb->prefix}image WHERE email='".$mail."' AND post=".$idpost." LIMIT 0,1";
				$resultats = $wpdb->get_results($query);
				// var_dump($resultats[0]->nb);
				// var_dump((int)$resultats[0]->nb);
				// // var_dump();
				if((int) $resultats[0]->nb == 0){
					echo "tu peux enregistrer ton image maggle";

					$query = "SELECT COUNT(email) as nb FROM {$wpdb->prefix}image WHERE name=".$name." LIMIT 0,1";
					$resultats = $wpdb->get_results($query);
					if((int) $resultats[0]->nb == 0){
						$finalPath = renameContestEventImg($idpost, $newImg['path'], $name, $newImg['format']);
						
						$resultats = $wpdb->insert(
					    	$wpdb->prefix.'vote',
						    array(
						        'post' => $idpost,
						        'src' => $finalPath,
						        'name' => $name,
						        'email' => $mail,
						    ),
						    array(
						        '%d',
						        '%s',
						        '%s',
						        '%s'
						    )
						);
						var_dump($resultats);
					}
					else
						echo "CE NOM D'IMAGE EST DEJA UTILISE";
				/*

				$wpdb->insert(
			    	$wpdb->prefix.'vote',
				    array(
				        'post' => $idpost,
				        'src' => $finalPath,
				        'name' => $name,
				        'email' => $mail,
				    ),
				    array(
				        '%d',
				        '%s',
				        '%s',
				        '%s'
				    )
				);
				*/	
				}
			}
		}
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
		<div id="popup" class="reduire">Masquer</div>
		<h3 class="titre_popup">Toi aussi up ton dessin miskin</h3>
		<div id="img-upload-form-container">
			<form enctype="multipart/form-data" action="" method="post">
				<label for="event_proposed_drawing">Slit here</label>
				<input required class="img-responsive" id="event_proposed_drawing" name="event_proposed_drawing" type="file">
				<label for="event_proposed_img_name">Donnez un nom à votre image !</label>
				<input type="text" name="event_proposed_img_name">
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

