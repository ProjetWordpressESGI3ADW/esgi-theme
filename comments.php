<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( 
					esc_html( _nx( 'Commentaires sur &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'esgi' ) ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h2>
		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 54,
					'callback'    => 'esgi_comments'
				) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'esgi' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Les plus vieux commentaires', 'esgi' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Nouveaux commentaires', 'esgi' ) ); ?></div>

			</div>
		</nav>
		<?php endif; ?>

	<?php endif; ?>

	<?php
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Les commentaires sont fermés.', 'esgi' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div>