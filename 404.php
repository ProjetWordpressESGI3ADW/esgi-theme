<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops page introuvable!.', 'esgi' ); ?></h1>
				</header>

				<div class="page-content">
					<p><?php esc_html_e( 'Il se trouve que la page que vous cherchez n&rsquo;existe pas.', 'esgi' ); ?></p>

					<?php get_search_form(); ?>

				</div>

				<div class="widget-areas">

					<div class="widget-area">
						<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
					</div>

					<?php if ( esgi_categorized_blog() ) : ?>
					<div class="widget-area">
						<div class="widget widget_categories">
							<h2 class="widget-title"><?php esc_html_e( 'Catégories les plus utilisées', 'esgi' ); ?></h2>
							<ul>
							<?php
								wp_list_categories( array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								) );
							?>
							</ul>
						</div>
					</div>
					<?php endif; ?>

					<div class="widget-area">
						<?php
							$archive_content = '<p>' . sprintf( esc_html__( 'Essayez dans les archives. %1$s', 'esgi' ), convert_smilies( ':)' ) ) . '</p>';
							the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
						?>
					</div>
			</section>

		</main>
	</div>

<?php get_footer(); ?>
