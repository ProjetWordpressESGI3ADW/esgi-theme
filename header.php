<!DOCTYPE html>
<html>
	<head>
		<meta charset=<?php bloginfo("charset");?>>
		<title><?php wp_title();?></title>
		<?php wp_head(); ?>
	</head>
	<body>
		<header>
			<nav class="navbar navbar-default navbar-fixed-top">
				<div class="container-fluid">
					<div class="navbar-header">
				        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
				      	</button>
				      	<a class="navbar-brand" href="#"><?= bloginfo("name"); ?></a>
				    </div>
				</div>
			</nav>
		</header>
		<div class="container-fluid main-container">
			<div class="row">
				<div class="col-sm-2">
					<!-- Navbar Y -->
					<?php
						if(has_nav_menu('y_menu')){
							wp_nav_menu(array('theme_location'=>'y_menu', "menu_class" => "nav nav-pills nav-stacked"));

							echo '<div class="navbar-side-menu navbar-side-menu-collapse">';
								echo '<ul class="navbar-menu-ul nav nav-pills nav-stacked">';
									echo '<li class="navbar-menu-li">';
										echo '<a href="#" class="active">';
										echo '</a>';
									echo '</li>';
								echo '</ul>';
							echo '</div>';

							echo '<div class="index-content">';
								echo '<span class="icon-open"><img src="' . get_template_directory_uri() . '/img/icon/icon-menu.png" id="open-navbar-side-menu"></span></div>';
						}
					?>
				</div>
				<div class="col-sm-10">
