<?php
/**
 * Footer template
 *
 * @package HadesBoard
 */

defined('ABSPATH') || exit;
?>

</main><!-- .site-main -->

<footer class="site-footer" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
    <div class="container">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
