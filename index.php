<?php
	get_header();
	?>	

	<!-- Navbar Y -->
	<?php 
		if(has_nav_menu('y_menu')){
			wp_nav_menu(array('theme_location'=>'y_menu'));			
		
			echo '<div class="navbar-side-menu navbar-side-menu-collapse">';
				echo '<ul class="navbar-menu-ul">';
					echo '<li class="navbar-menu-li">';
						echo '<a href="#" class="active">';									
						echo '</a>';
					echo '</li>';							
				echo '</ul>';
			echo '</div>';

			echo '<div class="index-content">';		
				echo '<span class="icon-open"><img src="' . get_template_directory_uri() . '/img/icon/icon-menu.png" id="open-navbar-side-menu"></span>';							
		}
	?>

	<!-- Navbar X -->
	<?php 
		if(has_nav_menu('x_menu')){
			wp_nav_menu(array('theme_location'=>'x_menu'));
								
			echo '<div class="navbar-side-menu navbar-side-menu-collapse">';
				echo '<ul class="navbar-menu-ul">';
					echo '<li class="navbar-menu-li">';
						echo '<a href="#" class="active">';									
						echo '</a>';
					echo '</li>';							
				echo '</ul>';
			echo '</div>';									

			echo '<div class="index-content">';		
				echo '<span class=""><img src="icon/icon-menu.png" id="open-navbar-side-menu"></span>';				
		}
	?>
		<?php
		
		if(is_home()){ // vérifie si l'on est dans la page homepage ou articles
			if(have_posts()){
				while(have_posts()):
					the_post();
					?><h2><?php the_title();?></h2>
					  <h3><?php 
					  		$content= get_the_content() ;
					  		$ex = get_the_excerpt();
					  		if( $content != $ex ){
					  			the_excerpt();
					  			$link = get_permalink();
					  			echo "<a href='".$link."'>Lien vers l'article</a>";
					  		}else{
					  			the_content('lire la suite');}?></h3>
					 <?php 
				endwhile;
			}else{
				echo("contenu introuvable");
			}
		//Si on se trouve sur la page d'events
		}else if(strpos(get_the_title(), "events") !== false){ // si l'on n'est pas dans homepage
			the_content();
			$loop = new WP_Query( array( 'post_type' => 'event', 'posts_per_page' => '10' ) );
			while ( $loop->have_posts() ){
				$loop->the_post();
	       		echo('<h1>');
					the_title();
				echo('</h1>');
			} 

			wp_reset_query();			
		}else{
			echo("post introuvable");
		}

		if(is_active_sidebar('sidebar-1')){
			dynamic_sidebar('sidebar-1');
		}

		get_footer();
	?>
	</div>