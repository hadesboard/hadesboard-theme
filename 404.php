<?php
/**
 * 404 Template
 *
 * @package HadesBoard
 */

defined('ABSPATH') || exit;

get_header();
?>

<section class="error-404">
    <h1>۴۰۴</h1>
    <p><?php esc_html_e('صفحه‌ای که دنبالش بودی پیدا نشد. شاید رفته قهوه بخوره.', 'hadesboard'); ?></p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="project-link">
        <?php esc_html_e('برگشت به خانه', 'hadesboard'); ?>
    </a>
</section>

<?php get_footer(); ?>
