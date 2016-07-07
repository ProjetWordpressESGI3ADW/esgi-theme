<?php 
	global $post;

	var_dump($post);

	$val = get_post_meta($post->ID, 'upload_image');
	$imgPath = explode('/', $val[0]);
	$imgPath = get_template_directory_uri().'/images/event/'.$imgPath[count($imgPath)-1];

	$event_handle = 'event_css';
	$event_stylesheet = get_template_directory_uri() . '/css/event.css';

	wp_enqueue_style( $event_handle, $event_stylesheet );
?>

	<div class="abolute" id="toi-aussi-upload-ton-img">
		<h3>Toi aussi up ton dessin miskin</h3>
		<div id="img-upload-form-container">
			<form enctype="multipart/form-data" action="<?php echo get_template_directory_uri()?>" method="post">
				<label for="event_proposed_drawing">Slit here</label>
				<input required class="img-responsive" id="event_proposed_drawing" name="event_proposed_drawing" type="file">
				<label for="event_proposed_email">Donne ton email pour recevoir </label>
				<input required type="email" id="event_proposed_email" name="event_proposed_email" placeholder="email@domain.dtc">
			</form>
		</div>
	</div>
