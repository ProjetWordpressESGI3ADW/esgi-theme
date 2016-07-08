<?php get_header();?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php the_post_navigation( array( 'next_text' => __( '<span class="meta-nav">Article Suivant</span> %title', 'esgi' ), 'prev_text' => __( '<span class="meta-nav">Article Précédent</span> %title', 'esgi' ) ) ); ?>

			<?php
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; ?>

		</main>
	</div>
<?php
if (have_posts()) {

	if(is_numeric(strpos(get_post()->post_type, "even")))
		require_once('event.php');
	else{
		while (have_posts()) {
			the_post();
			echo get_the_title();
			echo the_content();
			// $custom = get_post_custom($post->ID);
			// $content = $custom['id_poste'][0];
			// if ( $content )
			// 	echo $content;
		}
	}
}
?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
