<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Comics
 */

get_header(); ?>

<div id="primary" class="content-area full-width-page">
	<div id="content" class="site-content" role="main">

		<article id="post-0" class="post hentry error404 not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Page introuvable.', 'Comics' ); ?></h1>
			</header>

			<div class="entry-content">
				<p><?php _e( 'Contenu recherché introuvable.', 'Comics' ); ?></p>

				<?php get_search_form(); ?>
			</div>
		</article>

	</div>
</div>

<div id="not-found-secondary" class="widget-area" role="complementary">
	<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
	<div class="widget">
		<h2 class="widgettitle"><?php _e( 'Catégorie introuvable', 'Comics' ); ?></h2>
		<ul>
		<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
		</ul>
	</div>

	<?php
	$archive_content = '<p>' . sprintf( __( 'Erreur', 'Comics' ), convert_smilies( ':)' ) ) . '</p>';
	the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
	?>
</div>

<?php get_footer(); ?>