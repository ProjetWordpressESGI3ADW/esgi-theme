<!DOCTYPE html>
<html>
	<head>
		<meta charset=<?php bloginfo("charset");?>>
		<title><?php wp_title();?></title>
		<?php wp_head(); ?>
	</head>
	<body>
		<header>
			<?php if (has_nav_menu('x_menu')): ?>
				<nav class="navbar navbar-default navbar-fixed-bottom">
					<div class="container-fluid">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class=" navbar-brand x-menu-logo-a " href=""><img class="x-menu-logo-img" src="<?php header_image(); ?>" alt="logo"></a>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li class="active"><a href="#">Events <span class="sr-only">(current)</span></a></li>
								<li><a href="#">News</a></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Top 3 drawings <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="#">Drawing 1</a></li>
										<li><a href="#">Drawing 2</a></li>
										<li><a href="#">Drawing 3</a></li>
									</ul>
								</li>
							</ul>
							<form class="navbar-form navbar-right" role="search">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Search">
								</div>
								<button type="submit" class="btn btn-default">Submit</button>
							</form>
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container-fluid -->
				</nav>
			<?php else: ?>
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
			<?php endif; ?>
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
