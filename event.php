<?php 
	global $post;
	global $wpdb;

	$evEndDate = get_post_meta($post->ID, 'event_datefin')[0];
	$evEndDate = date_create_from_format('Y-m-d', $evEndDate);//->format('Y-m-d');
	$curDate = date('Y-m-d');
	
	//$eventIsOver = (strtotime($curDate) <= strtotime($evEndDate));

	$idpost = $post->ID;
/* ##########  POST D'IMAGE  ###########*/
	if(isset($_POST['event_proposed_email']) && isset($_FILES['event_proposed_drawing']) && isset($_POST['event_proposed_img_name'])){	
		if($eventIsOver){
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
					if(is_null($resultats[0]) || (int) $resultats[0]->nb == 0){						
						$query = "SELECT COUNT(email) as nb FROM {$wpdb->prefix}image WHERE name=".$name." LIMIT 0,1";
						$resultats = $wpdb->get_results($query);
						if((int) $resultats[0]->nb == 0){
							$finalPath = renameContestEventImg($idpost, $newImg['path'], $name, $newImg['format']);
							var_dump($finalPath);
							// var_dump($wpdb->prefix.'image');

							// var_dump($idpost);
							// var_dump($finalPath);
							if(!!$finalPath){
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
									$msg= "Your drawing was succeffully uploaded !";
								}
								else{
									$msg= "Not able to save your drawing, we are really sorry";
								}
							}
							else{
								$msg = "Your image couldn't be moved !";
							}
						}
						else
							$msg= "This image name is already being used for this event !";
					}
					else
						$msg= "An image was already posted with this email account";
				}
				else{
					$msg = "image's name must me 49 characters long and be composed only of aplhanumerical characters !";
					$msg .= "<br>";
					$msg .= "email must be formated as: your_email@email.com";
				}
			}
			else{
				$msg= 'Email was quite not an email !';
			}
		}
		else{
			$msg = "Event is over !";
		}
		unset($_POST['event_proposed_email'], $_POST['event_proposed_img_name'], $_FILES['event_proposed_drawing']);flush();
	}

/* ##########  POST DE VOTE ########### */
	else if(isset($_POST['vote_mail'])){	
		if($eventIsOver){
			$mail = trim($_POST['vote_mail']);
			//On check si on a pas deja voté avec cet e-mail
			$query = "SELECT COUNT(mail) as nb FROM {$wpdb->prefix}vote WHERE mail=".$mail." AND post=".$idpost." LIMIT 0,1";
			$resultats = $wpdb->get_results($query);
			var_dump($resultats);
			if((int) $resultats[0]->nb == 0){
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
				//Si deja voté
				$e = 4;
			}
		}
		else
			$msg = "Event is over !";
	}
	else{
	//Si pas d'adresse mail renseignée
		// $msg = "Please writ your email address";
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

	$description = get_post_meta($post->ID, 'event_description');
	$path = explode('/', $description[0]);
	$path = get_template_directory_uri().'/images/event/'.$path[count($path)-1];
	?>
		<?php if (isset($msg)): ?>
			<div id="event_up_msg" class="animation fadeDown fixed display-flex-column"><p><a href=""><?php echo $msg; ?></a></p></div>
		<?php endif ?>
	<div class="banniere display-flex-column">
		<h1><?php echo $post->post_title; ?></h1>
		<img id="event_banner_img" src="<?php echo $imgPath; ?>">
		<div id="event_datefin">
			<p>Ending date: <?php echo get_post_meta($post->ID, 'event_datefin')[0]; ?></p>
		</div>
	</div>
	
	<div class="description">
		<p><?php echo $description[0]; ?></p>
	</div>

	<div>
		<div class="col-md-6 col-md-offset-3" id="h3"><h3>Vote for your favorite drawing !</h3></div>
		<form action="" method="POST">
			<div class="col-md-12" id="images">
				<?php
					$query = "SELECT * FROM {$wpdb->prefix}image WHERE post=".$idpost;
					$resultats = $wpdb->get_results($query);
					
					foreach ($resultats as $key => $line) {
						$img = explode("/", $line->src);
						$img = $img[count($img) - 1];
						echo '<div class="item">'
								.'<div class="draw-contour">'
									.'<div class="draw-title">'
										.'<label for="'.$line->id.'">'.$line->name.'</label>'
									.'</div>'
									.'<div class="draw">'
										.'<img width="300" height="300" src="'.get_template_directory_uri().'/images/event/'.$idpost.'/'.$img.'">'
									.'</div>'
									.'<div class="radio">'
										.'<input type="radio" name="image_choose" value="'.$line->id.'" id="'.$line->id.'">'
									.'</div>'
								.'</div>'
							.'</div>';
					}

				?>
			</div>
			<div id="vote_submit" class="col-md-6 col-md-offset-3">
				<span>Check a draw, write your email address and submit your vote !</span>
				<div>
					<input type="email" name="vote_mail" placeholder="Votre e-mail">
					<input type="submit" value="Votez !">
				</div>
			</div>
		</form>
	</div>
	<div class="fixed display-flex-column" id="toi-aussi-upload-ton-img">
		<div id="popup" class="reduire">Hide</div>
		<h3 class="titre_popup">Propose your drawing too</h3>
		<div id="img-upload-form-container">
			<form enctype="multipart/form-data" action="" method="post">
				<label for="event_proposed_drawing">There would be a good place to put your image in, it has to be a png, jpg or jpeg though</label>
				<input required class="img-responsive" id="event_proposed_drawing" name="event_proposed_drawing" type="file">
				<label for="event_proposed_img_name">What name should your image have ?</label>
				<input type="text" name="event_proposed_img_name">
				<label for="event_proposed_email">We're gonna need your email though, in case you win</label>
				<input required type="email" id="event_proposed_email" name="event_proposed_email" placeholder="email@domain.com">
				<input class="btn btn-primary" type="submit" value="Envoyer !">
			</form>
		</div>
	</div>