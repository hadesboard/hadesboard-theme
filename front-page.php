<?php
/**
 * Front Page Template
 *
 * @package HadesBoard
 */

defined('ABSPATH') || exit;

get_header();
?>

<!-- About Section -->
<section class="section about" aria-labelledby="about-title">
    <h2 id="about-title" class="section-title"><?php esc_html_e('درباره من', 'hadesboard'); ?></h2>
    <?php
    $about_text = get_theme_mod('hadesboard_about');
    if ($about_text) :
    ?>
        <p><?php echo wp_kses_post($about_text); ?></p>
    <?php else : ?>
        <p><?php esc_html_e('محتوای درباره من را از طریق سفارشی‌ساز وارد کنید.', 'hadesboard'); ?></p>
    <?php endif; ?>
</section>

<hr class="divider">

<!-- Skills Section -->
<section class="section" aria-labelledby="skills-title">
    <h2 id="skills-title" class="section-title">
        <?php echo esc_html(get_theme_mod('hadesboard_skills_title', __('چیزایی که بابتشون پول می‌گیرم', 'hadesboard'))); ?>
    </h2>
    <?php
    $skills = get_theme_mod('hadesboard_skills', 'WordPress, PHP, WooCommerce, JavaScript, MySQL, HTML/CSS, Git');
    $skills_array = array_map('trim', explode(',', $skills));
    ?>
    <ul class="skills-list" role="list">
        <?php foreach ($skills_array as $skill) : ?>
            <li><?php echo esc_html($skill); ?></li>
        <?php endforeach; ?>
    </ul>
</section>

<hr class="divider">

<!-- Projects Section -->
<?php if (get_theme_mod('hadesboard_show_projects', true)) : ?>
    <section class="section" aria-labelledby="projects-title">
        <h2 id="projects-title" class="section-title">
            <?php echo esc_html(get_theme_mod('hadesboard_projects_title', __('چیزایی که ساختم و هنوز زنده‌ان', 'hadesboard'))); ?>
        </h2>

        <?php
        $projects_count = get_theme_mod('hadesboard_projects_count', 3);
        $projects = new WP_Query(array(
            'post_type'      => 'project',
            'posts_per_page' => $projects_count,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));

        if ($projects->have_posts()) :
            while ($projects->have_posts()) : $projects->the_post();
        ?>
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
        <?php
            endwhile;
            wp_reset_postdata();
        else :
        ?>
            <p class="no-content"><?php esc_html_e('هنوز پروژه‌ای اضافه نشده.', 'hadesboard'); ?></p>
        <?php endif; ?>
    </section>

    <hr class="divider">
<?php endif; ?>

<!-- Blog Section -->
<?php if (get_theme_mod('hadesboard_show_blog', true)) : ?>
    <section class="section" aria-labelledby="blog-title">
        <h2 id="blog-title" class="section-title">
            <?php echo esc_html(get_theme_mod('hadesboard_blog_title', __('چرت و پرت‌هایی که می‌نویسم', 'hadesboard'))); ?>
        </h2>

        <?php
        $blog_count = get_theme_mod('hadesboard_blog_count', 3);
        $posts = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => $blog_count,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));

        if ($posts->have_posts()) :
            while ($posts->have_posts()) : $posts->the_post();
        ?>
            <article class="blog-post" itemscope itemtype="https://schema.org/BlogPosting">
                <div class="blog-meta">
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" itemprop="datePublished">
                        <?php echo esc_html(get_the_date()); ?>
                    </time>
                </div>
                <h3 class="blog-post-title" itemprop="headline">
                    <a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a>
                </h3>
                <?php if (has_excerpt()) : ?>
                    <p class="blog-post-excerpt" itemprop="description"><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>
                <a href="<?php the_permalink(); ?>" class="blog-link"><?php esc_html_e('ادامه مطلب', 'hadesboard'); ?> &larr;</a>
            </article>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
        ?>
            <p class="no-content"><?php esc_html_e('هنوز پستی منتشر نشده.', 'hadesboard'); ?></p>
        <?php endif; ?>
    </section>

    <hr class="divider">
<?php endif; ?>

<!-- Contact Section -->
<section class="section" aria-labelledby="contact-title">
    <h2 id="contact-title" class="section-title">
        <?php echo esc_html(get_theme_mod('hadesboard_contact_title', __('اگه کار داشتین', 'hadesboard'))); ?>
    </h2>
    <ul class="contact-list">
        <?php
        $phone = get_theme_mod('hadesboard_phone');
        $email = get_theme_mod('hadesboard_email');
        $telegram = get_theme_mod('hadesboard_telegram');
        $github = get_theme_mod('hadesboard_github');

        if ($phone) :
            $phone_english = hadesboard_persian_to_english($phone);
        ?>
            <li>
                <span><?php esc_html_e('تلفن', 'hadesboard'); ?></span>
                <a href="tel:<?php echo esc_attr($phone_english); ?>"><?php echo esc_html($phone); ?></a>
            </li>
        <?php endif;

        if ($email) :
        ?>
            <li>
                <span><?php esc_html_e('ایمیل', 'hadesboard'); ?></span>
                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
            </li>
        <?php endif;

        if ($telegram) :
        ?>
            <li>
                <span><?php esc_html_e('تلگرام', 'hadesboard'); ?></span>
                <a href="<?php echo esc_url($telegram); ?>" target="_blank" rel="noopener noreferrer">
                    <?php echo esc_html(str_replace('https://t.me/', '@', $telegram)); ?>
                </a>
            </li>
        <?php endif;

        if ($github) :
        ?>
            <li>
                <span><?php esc_html_e('گیت‌هاب', 'hadesboard'); ?></span>
                <a href="<?php echo esc_url($github); ?>" target="_blank" rel="noopener noreferrer">
                    <?php echo esc_html(str_replace('https://github.com/', '', $github)); ?>
                </a>
            </li>
        <?php endif; ?>
            <li>
                <span><?php esc_html_e('واتساپ', 'hadesboard'); ?></span>
                <?php esc_html_e('لطفا نه', 'hadesboard'); ?>
            </li>
    </ul>
</section>

<?php get_footer(); ?>
