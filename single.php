<?php
/**
 * Single Post Template
 *
 * @package HadesBoard
 */

defined('ABSPATH') || exit;

get_header();

while (have_posts()) : the_post();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="https://schema.org/BlogPosting">
    <header class="entry-header">
        <h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
    </header>

    <div class="entry-content" itemprop="articleBody">
        <?php
        the_content();

        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('صفحات:', 'hadesboard'),
            'after'  => '</div>',
        ));
        ?>
    </div>

    <hr class="divider">

    <?php hadesboard_author_box(); ?>

</article>

<hr class="divider">

<?php
hadesboard_related_posts(3);

// Comments
if (comments_open() || get_comments_number()) :
    comments_template();
endif;

endwhile;

get_footer();
?>
