<?php
/**
 * Custom template tags for HadesBoard theme
 *
 * @package HadesBoard
 */

defined('ABSPATH') || exit;

/**
 * Display posted on date
 */
function hadesboard_posted_on() {
    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

    $time_string = sprintf(
        $time_string,
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date())
    );

    echo '<span class="posted-on">' . $time_string . '</span>';
}

/**
 * Display posted by author
 */
function hadesboard_posted_by() {
    echo '<span class="byline">' . esc_html(get_the_author()) . '</span>';
}

/**
 * Display post categories
 */
function hadesboard_entry_categories() {
    if ('post' === get_post_type()) {
        $categories_list = get_the_category_list(', ');
        if ($categories_list) {
            printf('<span class="cat-links">%s</span>', $categories_list);
        }
    }
}

/**
 * Display post tags
 */
function hadesboard_entry_tags() {
    if ('post' === get_post_type()) {
        $tags_list = get_the_tag_list('', ', ');
        if ($tags_list) {
            printf('<span class="tags-links">%s</span>', $tags_list);
        }
    }
}

/**
 * Display project technologies
 */
function hadesboard_project_technologies($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $terms = get_the_terms($post_id, 'project_tech');

    if ($terms && !is_wp_error($terms)) {
        $techs = array();
        foreach ($terms as $term) {
            $techs[] = esc_html($term->name);
        }
        echo implode(' · ', $techs);
    }
}

/**
 * Display project URL button
 */
function hadesboard_project_url($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $url = get_post_meta($post_id, '_project_url', true);

    if ($url) {
        printf(
            '<a href="%s" class="project-link" target="_blank" rel="noopener noreferrer">%s</a>',
            esc_url($url),
            esc_html__('مشاهده پروژه', 'hadesboard')
        );
    }
}

/**
 * Display related posts
 */
function hadesboard_related_posts($count = 3) {
    $post_id = get_the_ID();
    $categories = get_the_category($post_id);

    if (empty($categories)) {
        return;
    }

    $category_ids = array();
    foreach ($categories as $category) {
        $category_ids[] = $category->term_id;
    }

    $args = array(
        'category__in'        => $category_ids,
        'post__not_in'        => array($post_id),
        'posts_per_page'      => $count,
        'ignore_sticky_posts' => 1,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        ?>
        <section class="related-posts">
            <h3><?php esc_html_e('بقیه چرت و پرت‌ها', 'hadesboard'); ?></h3>
            <ul class="related-list">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <div class="related-meta"><?php echo esc_html(get_the_date()); ?></div>
                    </li>
                <?php endwhile; ?>
            </ul>
        </section>
        <?php
        wp_reset_postdata();
    endif;
}

/**
 * Display author box
 */
function hadesboard_author_box() {
    ?>
    <div class="author-box">
        <div class="author-avatar">
            <?php echo get_avatar(get_the_author_meta('ID'), 50); ?>
        </div>
        <div class="author-info">
            <h4><?php the_author(); ?></h4>
            <p><?php echo esc_html(get_the_author_meta('description') ?: get_bloginfo('description')); ?></p>
        </div>
    </div>
    <?php
}

/**
 * Display pagination
 */
function hadesboard_pagination() {
    the_posts_pagination(array(
        'mid_size'  => 1,
        'prev_text' => __('قبلی', 'hadesboard'),
        'next_text' => __('بعدی', 'hadesboard'),
        'class'     => 'pagination',
    ));
}
