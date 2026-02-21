<?php
/**
 * Single Project Template
 *
 * @package HadesBoard
 */

defined('ABSPATH') || exit;

get_header();

while (have_posts()) : the_post();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="https://schema.org/CreativeWork">
    <header class="entry-header">
        <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
        <div class="project-meta">
            <?php hadesboard_project_technologies(); ?>
        </div>
    </header>

    <?php if (has_post_thumbnail()) : ?>
        <figure class="project-thumbnail">
            <?php the_post_thumbnail('hadesboard-featured', array('itemprop' => 'image')); ?>
        </figure>
    <?php endif; ?>

    <div class="entry-content" itemprop="description">
        <?php the_content(); ?>
    </div>

    <?php
    $project_url = get_post_meta(get_the_ID(), '_project_url', true);
    if ($project_url) :
    ?>
        <div class="project-actions">
            <a href="<?php echo esc_url($project_url); ?>" class="project-link" target="_blank" rel="noopener noreferrer">
                <?php esc_html_e('مشاهده پروژه', 'hadesboard'); ?>
            </a>
        </div>
    <?php endif; ?>

    <hr class="divider">

    <?php hadesboard_author_box(); ?>

</article>

<hr class="divider">

<!-- Other Projects -->
<?php
$other_projects = new WP_Query(array(
    'post_type'      => 'project',
    'posts_per_page' => 3,
    'post__not_in'   => array(get_the_ID()),
    'orderby'        => 'rand',
));

if ($other_projects->have_posts()) :
?>
<section class="related-posts">
    <h3><?php esc_html_e('پروژه‌های دیگه', 'hadesboard'); ?></h3>
    <ul class="related-list">
        <?php while ($other_projects->have_posts()) : $other_projects->the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <div class="related-meta"><?php hadesboard_project_technologies(); ?></div>
            </li>
        <?php endwhile; ?>
    </ul>
</section>
<?php
wp_reset_postdata();
endif;

endwhile;

get_footer();
?>
