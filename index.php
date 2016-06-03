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
				echo '<span class=""><img src="icon/icon-menu.png" id="open-navbar-side-menu"></span>';							
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
		/*
		if(is_home()){
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
				echo("Yolo t'as pas de post");
			}
		}else{
			while(have_posts()):
				the_post();
				?><h3><?php the_title();?></h3>
				  <h4><?php the_content();?></h4>
				 <?php 
			endwhile;
			echo("Pas sur la homePage");
		}

		if(is_active_sidebar('sidebar-1')){
			dynamic_sidebar('sidebar-1');
		}*/

		get_footer();
	?>
	</div>