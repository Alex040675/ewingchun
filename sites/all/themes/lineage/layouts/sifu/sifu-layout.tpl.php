<?php
dsm($node);
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
<?php if ($status == 0) : ?>
    <p class="node-moderatation"><?php print t('Post is awaiting moderation.'); ?></p>
<?php endif; ?>
<div id="node-<?php print $nid; ?>" class="<?php print $classes; ?>">
  <?php print $node->sifu_lineage ?>
  <div class="align-right"><?php print $sharethis . l('Print', 'print/' . $node->nid) . l('RSS', 'sifus/rss', array('attributes' => array('class' => 'rss'))); ?></div>

  <div id="sifu-bio">
    <?php if ($sifu_image): ?>
      <?php print $sifu_image; ?>
    <?php endif; ?>

    <?php if ($precontent): ?>
      <p class="bold"><?php print t('Bio Info:') ?></p>
      <?php print $precontent ?>
	<?php if ($body): ?>
	   <a href="/<?php print $node->path?>#more">Read more</a>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($sifu_images): ?>
      <ul class="sifu-images">
        <?php print $sifu_images; ?>
      </ul>
    <?php endif; ?>

    <div id="first-box" class="sifu-box">
      <h3><?php print t('Teachers') ?></h3>
      <?php print $teachers_list; ?>
      <h3><?php print t('Articles') ?></h3>
      <?php print $sifu_articles; ?>
    </div>

    <div id="second-box" class="sifu-box">
      <?php
        print $sifu_students;
        print $sifu_videos;
      ?>
    </div>

    <div id="third-box" class="sifu-box">
      <?php print $sifu_schools; ?>
      <?php print $sifu_urls; ?>
    </div>

    <div id="node-footer" class="clear">
      <?php print $sifu_products;?>
    </div>

    <?php if ($body): ?>
      <a name="more"></a>
      <p class="bold"><?php print t("Bio (con't)") ?></p>
      <?php print $body; ?>
    <?php endif; ?>

    <p><?php if ($bday): print t('Born: ') . $bday; endif; ?><?php if ($dday): print t(' Died: ') . $dday; endif; ?></p>
    <p class="bold italic"><?php print t('Last updated: ') . format_date($node->changed, 'small'); ?></p>
  </div>


  <?php if ($links): ?>
    <div class="drupal-links"><?php print $links; ?></div>
  <?php endif; ?>

</div>
