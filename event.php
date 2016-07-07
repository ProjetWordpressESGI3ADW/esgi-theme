<?php 
	global $post;

	var_dump($post);

	$val = get_post_meta($post->ID, 'upload_image');
	$imgPath = explode('/', $val[0]);
	$imgPath = get_template_directory_uri().'/images/event/'.$imgPath[count($imgPath)-1];