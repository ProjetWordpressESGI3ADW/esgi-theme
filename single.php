<?php
get_header();

if (have_posts()) {

	if(is_numeric(strpos(get_post()->post_type, "even")))
		require_once('event.php');
	else{
		while (have_posts()) {
			the_post();
			echo get_the_title();
			echo the_content();
			// $custom = get_post_custom($post->ID);
			// $content = $custom['id_poste'][0];
			// if ( $content )
			// 	echo $content;
		}
	}
}

get_footer();
