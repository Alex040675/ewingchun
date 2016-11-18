<?php 
/**
 * @file comment.tpl.php
 * Default theme implementation for comments.
 *
 * Available variables:
 * - $author: Comment author. Can be link or plain text.
 * - $content: Body of the post.
 * - $date: Date and time of posting.
 * - $links: Various operational links.
 * - $new: New comment marker.
 * - $picture: Authors picture.
 * - $signature: Authors signature.
 * - $status: Comment status. Possible values are:
 *   comment-unpublished, comment-published or comment-preview.
 * - $submitted: By line with date and time.
 * - $title: Linked title.
 *
 * These two variables are provided for context.
 * - $comment: Full comment object.
 * - $node: Node object the comments are attached to.
 *
 * @see template_preprocess_comment()
 * @see theme_comment()
 */
?>
111111111122222277777777777777
<div class="review-headingbg">
	<div class="review-hcenterbg">
		<div class="centerleft"><?php print $author; ?></div>
		<div class="centerright">
			<div class="centerright01"><span><?php print $created; ?><?php  print render($content['links']); ?></span></div>
		</div>
	</div>
	<div class="review-hrightbg"></div>
</div>
<div class="review-content">
	<div class="review-left"> <?php print $user_picture; ?> </div>
	<div class="review-right">
		<p class="usearname-title">Title: <span><?php print $title; ?></span></p>
		<div class="usearcontent"> <?php print render($content); ?></div>
	</div>
</div>