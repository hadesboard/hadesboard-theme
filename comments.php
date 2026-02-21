<?php
/**
 * Comments Template
 *
 * @package HadesBoard
 */

defined('ABSPATH') || exit;

if (post_password_required()) {
    return;
}
?>

<section id="comments" class="comments-area section">

    <?php if (have_comments()) : ?>
        <h2 class="section-title">
            <?php
            $comments_count = get_comments_number();
            printf(
                esc_html(_n('%s نظر', '%s نظر', $comments_count, 'hadesboard')),
                number_format_i18n($comments_count)
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 40,
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation(array(
            'prev_text' => __('نظرات قدیمی‌تر', 'hadesboard'),
            'next_text' => __('نظرات جدیدتر', 'hadesboard'),
        ));
        ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php esc_html_e('امکان ثبت نظر وجود نداره.', 'hadesboard'); ?></p>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply'          => __('نظر بده', 'hadesboard'),
        'title_reply_to'       => __('پاسخ به %s', 'hadesboard'),
        'cancel_reply_link'    => __('انصراف', 'hadesboard'),
        'label_submit'         => __('ارسال نظر', 'hadesboard'),
        'comment_notes_before' => '',
        'comment_notes_after'  => '',
    ));
    ?>

</section>
