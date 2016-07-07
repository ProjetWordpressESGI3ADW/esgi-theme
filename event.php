<?php 
	global $post;

	var_dump($post);

	$val = get_post_meta($post->ID, 'upload_image');
	$imgPath = explode('/', $val[0]);
	$imgPath = get_template_directory_uri().'/images/event/'.$imgPath[count($imgPath)-1];

	$event_handle = 'event_css';
	$event_stylesheet = get_template_directory_uri() . '/css/event.css';

	wp_enqueue_style( $event_handle, $event_stylesheet );

	echo '<h3>Coche une des images, inscris ton adresse email et vote pour ton dessin préféré!</h3>';
	echo '<form action="<?php echo get_template_directory_uri()?>/eventvote_post.php" method="POST"><input type="email" name="email"><input type="submit"></form>' ;
?>
	<?php
		$val = get_post_meta($post->ID, 'upload_image');
		?><br><br><?php
		print_r($val);
	?>
		
	<div class="banniere">
		<h1>Titre</h1>
		<img src="https://sp.yimg.com/ib/th?id=OIP.M2de0ec74f51e3c8d313ffda88464b32eH0&pid=15.1&rs=1&c=1&qlt=95&w=105&h=108#inline">
	</div>
	
	<div class="description">
		description description description description description description description description description description description description 
		description description description description description description description description description description description description 
		description description description description description description description description description description description description 
		description description description description description description description description description description description description 
	</div>

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
