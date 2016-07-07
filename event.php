<?php 
	global $post;

	var_dump($post);

	$val = get_post_meta($post->ID, 'upload_image');
	$imgPath = explode('/', $val[0]);
	$imgPath = get_template_directory_uri().'/images/event/'.$imgPath[count($imgPath)-1];


	echo '<h3>Coche une des images, inscris ton adresse email et vote pour ton dessin préféré!</h3>';
	echo '<form action="" method="POST">'
			.'<input type="email" name="email">'
			.'<input type="submit">'
		 .'</form>' ;

	if(isset($_POST['email'])){
		if(filter_var(trim($_POST['email']),FILTER_VALIDATE_EMAIL)){
			$mail = $_POST['email'];
			echo $mail;
		}else{
			echo 'Email invalide';
		}
		
	}