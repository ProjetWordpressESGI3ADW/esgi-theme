<?php
	get_header();



		// vérifie si l'on est dans la page homepage ou events
		if(is_home() || strpos(get_the_title(), "events") !== false){
			if(have_posts()){
				the_content();
				$loop = new WP_Query( array( 'post_type' => 'event', 'posts_per_page' => '10' ) );
				foreach ($loop->posts as $key => $post){
					$eventEndDate = date("d F, Y", strtotime(get_post_meta($post->ID, 'event_datefin')[0]));

					$val = get_post_meta($post->ID, 'upload_image');
					$imgPath = explode('/', $val[0]);
					$imgPath = get_template_directory_uri().'/images/event/'.$imgPath[count($imgPath)-1];


					echo 
					"<div>
						<h1>". $post->post_title . "</h1>
						<p>" . get_post_meta($post->ID, 'event_description')[0] . "</p>
						<p>End event : " . $eventEndDate . "</p>

						<div>
							<img src='".$imgPath."' alt=''>
						</div>

					</div>";			
				}
				wp_reset_query();	
			}else{
				echo("contenu introuvable");
			}
		}
		else{
			echo("post introuvable");
		}

		// if(is_active_sidebar('sidebar-1')){
		// 	dynamic_sidebar('sidebar-1');
		// }

		get_footer();
	?>
	</div>
