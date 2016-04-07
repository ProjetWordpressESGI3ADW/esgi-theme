<?php get_header(); ?>

    <?php  
        if (have_posts()) {
            while(have_posts()): ?>
                <?php the_post(); ?>
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
                <h1><?php get_the_id(); ?></h1>
                <?php
                    $args["post_id"] = get_the_id();
                    $comments = get_comments($args);
                    foreach ($comments as $comment) { ?>
                            <p><?php echo $comment->comment_content ?></p>
                   <?php }
                ?>
            <?php endwhile;
        } 
    ?>

    <?php wp_nav_menu(array("theme-location" => "menu-secondaire")) ?>
    

<?php get_footer(); ?>
