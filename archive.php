<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );

					if ( is_author() && '' !== get_the_author_meta( 'description' ) ) {
						echo '<div class="taxonomy-description">' . get_the_author_meta( 'description' ) . '</div><!-- .taxonomy-description -->';
					} else {
						the_archive_description( '<div class="taxonomy-description">', '</div><!-- .taxonomy-description -->' );
					}
				?>
			</header>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					get_template_part( 'template-parts/content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main>
	</div>

<?php get_footer(); ?>
