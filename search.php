<?php
/**
 * Search Results Template
 *
 * @package HadesBoard
 */

defined('ABSPATH') || exit;

get_header();
?>

<section class="section" aria-labelledby="search-title">
    <h2 id="search-title" class="section-title">
        <?php printf(esc_html__('نتایج جستجو برای: %s', 'hadesboard'), '<span>' . get_search_query() . '</span>'); ?>
    </h2>

    <?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>
            <article class="blog-post">
                <div class="blog-meta">
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo esc_html(get_the_date()); ?>
                    </time>
                    <span class="post-type">
                        <?php
                        $post_type = get_post_type();
                        if ($post_type === 'project') {
                            esc_html_e('پروژه', 'hadesboard');
                        } elseif ($post_type === 'page') {
                            esc_html_e('صفحه', 'hadesboard');
                        } else {
                            esc_html_e('نوشته', 'hadesboard');
                        }
                        ?>
                    </span>
                </div>
                <h3 class="blog-post-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <p class="blog-post-excerpt">
                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 30)); ?>
                </p>
                <a href="<?php the_permalink(); ?>" class="blog-link"><?php esc_html_e('ادامه مطلب', 'hadesboard'); ?> &larr;</a>
            </article>
        <?php endwhile; ?>

        <?php hadesboard_pagination(); ?>

    <?php else : ?>
        <p class="no-content">
            <?php esc_html_e('چیزی با این عبارت پیدا نشد. شاید یه کلمه دیگه امتحان کنی؟', 'hadesboard'); ?>
        </p>
    <?php endif; ?>

</section>

<?php get_footer(); ?>
