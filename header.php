<?php
/**
 * Header template
 *
 * @package HadesBoard
 */

defined('ABSPATH') || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if (is_front_page()) : ?>
    <header class="site-header" role="banner" itemscope itemtype="https://schema.org/WPHeader">
        <div class="container">
            <h1 class="site-title" itemprop="headline">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <?php bloginfo('name'); ?>
                </a>
            </h1>
            <p class="site-description" itemprop="description">
                <?php bloginfo('description'); ?>
            </p>
        </div>
    </header>
<?php else : ?>
    <header class="site-header inner-header" role="banner">
        <div class="container">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="back-link">
                <?php esc_html_e('برگشت به خانه', 'hadesboard'); ?>
            </a>
            <?php if (is_singular()) : ?>
                <div class="article-meta">
                    <span><?php echo esc_html(get_the_date()); ?></span>
                    <span><?php echo esc_html(hadesboard_reading_time()); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </header>
<?php endif; ?>

<main id="main" class="site-main container" role="main">
