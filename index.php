<?php
/**
 * Main Index Template
 *
 * @package HadesBoard
 */

defined('ABSPATH') || exit;

get_header();
?>

<section class="section" aria-labelledby="archive-title">
    <?php if (is_home() && !is_front_page()) : ?>
        <h2 id="archive-title" class="section-title"><?php single_post_title(); ?></h2>
    <?php elseif (is_archive()) : ?>
        <h2 id="archive-title" class="section-title"><?php the_archive_title(); ?></h2>
    <?php elseif (is_search()) : ?>
        <h2 id="archive-title" class="section-title">
            <?php printf(esc_html__('نتایج جستجو برای: %s', 'hadesboard'), '<span>' . get_search_query() . '</span>'); ?>
        </h2>
    <?php else : ?>
        <h2 id="archive-title" class="section-title"><?php esc_html_e('آخرین نوشته‌ها', 'hadesboard'); ?></h2>
    <?php endif; ?>

    <?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>
            <article class="blog-post" itemscope itemtype="https://schema.org/BlogPosting">
                <div class="blog-meta">
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished">
                        <?php echo esc_html(get_the_date()); ?>
                    </time>
                </div>
                <h3 class="blog-post-title" itemprop="headline">
                    <a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a>
                </h3>
                <p class="blog-post-excerpt" itemprop="description">
                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 30)); ?>
                </p>
                <a href="<?php the_permalink(); ?>" class="blog-link"><?php esc_html_e('ادامه مطلب', 'hadesboard'); ?> &larr;</a>
            </article>
        <?php endwhile; ?>

        <?php hadesboard_pagination(); ?>

    <?php else : ?>
        <p class="no-content"><?php esc_html_e('چیزی پیدا نشد.', 'hadesboard'); ?></p>
    <?php endif; ?>

</section>

<?php get_footer(); ?>
