<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'esgi' ); ?></h1>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Prêt à publier votre premier article? <a href="%1$s">Get started here</a>.', 'esgi' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Désolé, aucun résultat de recherche. Réessayez.', 'esgi' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'Essayez la recherche, car aucun résultat', 'esgi' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</section>
