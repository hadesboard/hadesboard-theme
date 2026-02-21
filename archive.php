<?php
/**
 * Archive Template
 *
 * @package HadesBoard
 */

defined('ABSPATH') || exit;

get_header();
?>

<section class="section" aria-labelledby="archive-title">
    <h2 id="archive-title" class="section-title">
        <?php
        if (is_post_type_archive('project')) {
            esc_html_e('همه پروژه‌ها', 'hadesboard');
        } elseif (is_category()) {
            single_cat_title();
        } elseif (is_tag()) {
            single_tag_title();
        } elseif (is_author()) {
            the_author();
        } elseif (is_date()) {
            if (is_year()) {
                echo get_the_date('Y');
            } elseif (is_month()) {
                echo get_the_date('F Y');
            } elseif (is_day()) {
                echo get_the_date();
            }
        } else {
            the_archive_title();
        }
        ?>
    </h2>

    <?php if (have_posts()) : ?>

        <?php if (is_post_type_archive('project')) : ?>

            <?php while (have_posts()) : the_post(); ?>
                <article class="project" itemscope itemtype="https://schema.org/CreativeWork">
                    <h3 class="project-title" itemprop="name">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <?php if (has_excerpt()) : ?>
                        <p class="project-excerpt" itemprop="description"><?php echo esc_html(get_the_excerpt()); ?></p>
                    <?php endif; ?>
                    <div class="project-meta">
                        <?php hadesboard_project_technologies(); ?>
                    </div>
                    <?php hadesboard_project_url(); ?>
                </article>
            <?php endwhile; ?>

        <?php else : ?>

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

        <?php endif; ?>

        <?php hadesboard_pagination(); ?>

    <?php else : ?>
        <p class="no-content"><?php esc_html_e('چیزی پیدا نشد.', 'hadesboard'); ?></p>
    <?php endif; ?>

</section>

<?php get_footer(); ?>
