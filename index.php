<?php
	get_header();



		// vérifie si l'on est dans la page homepage ou events
		if(is_home() || strpos(get_the_title(), "events") !== false){
			if(have_posts()){
				the_content();
				$loop = new WP_Query( array( 'post_type' => 'event', 'posts_per_page' => '10' ) );
				// var_dump($loop);
				// get_post_custom_values('event_datefin');
				while ( $loop->have_posts() ){
					$loop->the_post();
					// var_dump(the_title());
		       		echo('<h1>');
						the_title();
					echo('</h1>');
		       		echo('<p>');
						the_content();
					echo('</p>');
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
