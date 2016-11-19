<?php

/**
 * @file
 * Default theme implementation for comments.
 *
 * Available variables:
 * - $author: Comment author. Can be link or plain text.
 * - $content: An array of comment items. Use render($content) to print them
 *   all, or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $created: Formatted date and time for when the comment was created.
 *   Preprocess functions can reformat it by calling format_date() with the
 *   desired parameters on the $comment->created variable.
 * - $changed: Formatted date and time for when the comment was last changed.
 *   Preprocess functions can reformat it by calling format_date() with the
 *   desired parameters on the $comment->changed variable.
 * - $new: New comment marker.
 * - $permalink: Comment permalink.
 * - $submitted: Submission information created from $author and $created during
 *   template_preprocess_comment().
 * - $user_picture: The comment author's picture from user-picture.tpl.php.
 * - $signature: Authors signature.
 * - $status: Comment status. Possible values are:
 *   comment-unpublished, comment-published or comment-preview.
 * - $title: Linked title.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - comment: The current template type, i.e., "theming hook".
 *   - comment-by-anonymous: Comment by an unregistered user.
 *   - comment-by-node-author: Comment by the author of the parent node.
 *   - comment-preview: When previewing a new or edited comment.
 *   The following applies only to viewers who are registered users:
 *   - comment-unpublished: An unpublished comment visible only to
 *     administrators.
 *   - comment-by-viewer: Comment by the user currently viewing the page.
 *   - comment-new: New comment since last the visit.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * These two variables are provided for context:
 * - $comment: Full comment object.
 * - $node: Node object the comments are attached to.
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess()
 * @see template_preprocess_comment()
 * @see template_process()
 * @see theme_comment()
 */
print_r(image_load($comment->picture));
print_r($comment);
?>
222
<article<?php print $attributes; ?>>
<div class="review-headingbg">
  <div class="review-hleftbg"><img width="18" height="31" alt="" src="/sites/all/themes/ewingchun/images/coment-leftbg.jpg"></div>
  <div class="review-hcenterbg">
    <div class="centerleft"><?php print $author; ?></div>
    <div class="centerright">
      <div class="centerright01"><span><?php print $created; ?><?php print render($content['links']) ?></span></div>
    </div>
  </div>
  <div class="review-hrightbg"> <img width="10" height="31" src="/sites/all/themes/ewingchun/images/coment-rightbg.jpg"> </div>
</div>
<div class="review-content">
  <div class="review-left"> <?php print $user_picture; ?> </div>
  <div class="review-right">
    <p class="usearname-title">Title: <span><?php print $title; ?></span></p>
    <div class="usearcontent"> <?php  print render($content); ?></div>
  </div>
</div>
</article>
