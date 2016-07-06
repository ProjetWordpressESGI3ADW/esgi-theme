<?php
get_header();
if (have_posts()) {
	while (have_posts()) {
		the_post();
		get_the_title();
		$custom = get_post_custom($post->ID);
		$content = $custom['id_poste'][0];
		if ( $content )
			echo $content;
	}
}

get_footer();