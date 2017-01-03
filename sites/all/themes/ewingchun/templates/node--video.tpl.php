<?php
// $Id$

/**
 * @file node.tpl.php
 *
 * Theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: Node body or teaser depending on $teaser flag.
 * - $picture: The authors picture of the node output from
 *   theme_user_picture().
 * - $date: Formatted creation date (use $created to reformat with
 *   format_date()).
 * - $links: Themed links like "Read more", "Add new comment", etc. output
 *   from theme_links().
 * - $name: Themed username of node author output from theme_user().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $submitted: themed submission information output from
 *   theme_node_submitted().
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $teaser: Flag for the teaser state.
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 *
 * Custom variable:
 * - $classes: Adds additional node classes for advanced styling
 *
 */
?>

<div class="videotitleinner">
	<div class="videosubtitle">
		<div class="videosubtitle-left"> <?php print t('By : ') . l ($node->name,  'user/' . $node->uid); ?></div>
		<div class="ondate">On: <span><?php print format_date($node->changed, 'small'); ?></span></div>
		<?php if($content['field_sifu']) : ?>
		<div class="rs"><?php print render($content['field_sifu']);  ?></div>
		<div class="rs">	<?php print render($content['taxonomy_vocabulary_7']); ?></div>
		<?php endif; ?>
		<div class="video01">
			<?php if($content['field_emvideo']) : ?>
			<?php print render($content['field_emvideo']);?>
			<?php endif; ?>
		</div>

		<div class="description">
			<h3>description</h3>
			<div class="content"><?php print $node->field_video_description['und'][0]['value']; ?></div>
		</div><!-- .description -->
		<!--<div class="tags">

			<div class="tagright">
				<p></p>
			</div>
		</div>--><!-- .tags -->
	</div><!-- .videosubtitle -->
</div>
<!-- .videotitleinner -->
<div class="recentvideos-right">
	<?php print $recent; ?>
    <?php print $videos_sifu; ?>
</div><!-- .recentvideos-right -->
<div id="comments">
    <?php

		$comments = comment_node_page_additions($node);
		print render($comments);
		if ($logged_in) {
			if ($node->comment_count < 1) {
				print '<h2 class="title">No Comments yet...</h2>';
			}
			?>
			<h2<?php print $form_title_attributes ?>><?php print t('Add new comment'); ?></h2>
			<?php
			$comment_form = drupal_get_form('comment_node_video_form', (object) array('nid' => $node->nid));
			print drupal_render($comment_form);
		}

      ?>
</div>
