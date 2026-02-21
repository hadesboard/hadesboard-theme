<?php
/**
 * Page Template
 *
 * @package HadesBoard
 */

defined('ABSPATH') || exit;

get_header();

while (have_posts()) : the_post();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="https://schema.org/WebPage">
    <header class="entry-header">
        <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
    </header>

    <div class="entry-content" itemprop="mainContentOfPage">
        <?php
        the_content();

        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('صفحات:', 'hadesboard'),
            'after'  => '</div>',
        ));
        ?>
    </div>

    <?php
    // Comments on pages (if enabled)
    if (comments_open() || get_comments_number()) :
        comments_template();
    endif;
    ?>
</article>

<?php
endwhile;

get_footer();
?>
