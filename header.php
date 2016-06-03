<!DOCTYPE html>
<html>
	<head>
		<meta charset=<?php bloginfo("charset");?>>
		<title><?php wp_title();?></title>
		<?php wp_head(); ?>
	</head>
	<body>
		<header>
			<?php if(has_nav_menu('y-menu')){
					wp_nav_menu(array('theme_location'=>'y_menu', 'container_class' => 'y-menu' ));
				}
			?>
			<nav class="y-menu">
				<!-- NAVBAR SIDE -->
					<button type="button" id="open-navbar-side-menu">
						<span class="">Open</span>
					</button>

					<div class="navbar-side-menu navbar-side-menu-collapse">
						<ul class="navbar-menu-ul">
							<li class="navbar-menu-li">
								<a href="#" class="active">Accueil
									
								</a>
							</li>							
						</ul>
					</div>
					<!-- FIN NAVBAR SIDE -->
			</div>
		</header>
		<!--<h1><?php bloginfo('name'); ?></h1>
		<h2><?php bloginfo('description'); ?></h2>-->		


