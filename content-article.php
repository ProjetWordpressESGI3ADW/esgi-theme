<article class="post-article">
  	<h1 id=""><?php the_title() ?></h1>
  	<div><?php the_content(); ?></div>
	<?php comments_template() ?>
  	<?php comment_form(); ?>
</article>