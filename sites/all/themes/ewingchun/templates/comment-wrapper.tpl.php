<?php
// $Id: comment-wrapper.tpl.php,v 1.2 2007/08/07 08:39:35 goba Exp $

/**
 * @file comment-wrapper.tpl.php
 * Default theme implementation to wrap comments.
 *
 * Available variables:
 * - $content: All comments for a given page. Also contains sorting controls
 *   and comment forms if the site is configured for it.
 *
 * The following variables are provided for contextual information.
 * - $node: Node object the comments are attached to.
 * The constants below the variables show the possible values and should be
 * used for comparison.
 * - $display_mode
 *   - COMMENT_MODE_FLAT_COLLAPSED
 *   - COMMENT_MODE_FLAT_EXPANDED
 *   - COMMENT_MODE_THREADED_COLLAPSED
 *   - COMMENT_MODE_THREADED_EXPANDED
 * - $display_order
 *   - COMMENT_ORDER_NEWEST_FIRST
 *   - COMMENT_ORDER_OLDEST_FIRST
 * - $comment_controls_state
 *   - COMMENT_CONTROLS_ABOVE
 *   - COMMENT_CONTROLS_BELOW
 *   - COMMENT_CONTROLS_ABOVE_BELOW
 *   - COMMENT_CONTROLS_HIDDEN
 *
 * @see template_preprocess_comment_wrapper()
 * @see theme_comment_wrapper()
 */
global $user;
?>


<section<?php print $attributes; ?>>
  <div id="comments">
    <?php if ($content) : ?>
      <?php if ($node->comment_count == 0) : ?>
        <h2 class="title">No Comments yet...</h2>
      <?php endif; ?>
      <?php if($node->comment_count != 0) : ?>
        <h2 class="title"><?php print $node->comment_count; ?> Comments</h2>
      <?php endif; ?>
    <?php endif; ?>
    <?php print render($content['comments']); ?>
    <div class="comment_form">
      <?php if ($user->uid > 0): ?>
      <h2<?php print $form_title_attributes ?>><?php print t('Add new comment'); ?></h2>
      <?php  print render($content['comment_form']); ?>
      <?php endif; ?>
    </div>

  </div>
</section>