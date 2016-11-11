<?php

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
<div class="schoolname-left">
<div class="productname-left" style="padding-top:0px;">
<div class="middleleftimg">
  <?php print $school_main_image; ?>
</div>
<div class="blogfpo">
<?php if ($school_images): ?>
    <ul>
      <?php print $school_images; ?>
    </ul>
  <?php endif; ?>
</div>
</div>

<div class="schoolname-r">
<?php if ($head_instructor) : ?>
<p style="line-height:normal;">Head Instructor: <span><?php print $head_instructor ?></span></p>
<?php endif; ?>
<?php if ($node->field_link_resource_url[0]['display_title']) : ?>
<p>Website: <?php print l($node->field_link_resource_url[0]['display_title'], $node->field_link_resource_url[0]['url']); ?></p>
<?php endif; ?>
<?php if ($node->field_text_resource_email[0]['value']) : ?>
<p>Contact email: <a href="#" class="review-link"><?php print l($node->field_text_resource_email[0]['value'], 'mailto:' . $node->field_text_resource_email[0]['value']); ?></a></p>
<?php endif; ?>
<?php if ($node->location['phone']) : ?>
<p>Phone: <span><?php print $node->location['phone']; ?></span></p>
<?php endif; ?>
<?php if ($node->location['street']) : ?>
<p>Address 1: <span><?php print $node->location['street']; ?></span></p>
<?php endif; ?>
<?php if ($node->location['additional']) : ?>
<p>Address 2: <span><?php print $node->location['additional']; ?></span></p>
<?php endif; ?>
<?php if ($node->location['city']) : ?>
<p>City: <span><?php print $node->location['city']; ?></span></p>
<?php endif; ?>
<?php if ($node->location['province']) : ?>
<p>State/Provience: <span><?php print $node->location['province']; ?></span></p>
<?php endif; ?>
<?php if ($node->location['country']) : ?>
<p>Country: <span><?php print strtoupper ($node->location['country']); ?></span></p>
<?php endif; ?>
<p>Directions: <span>Try to</span> <?php print l('Map it', 'http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=' . $node->location['latitude'] . '+' . $node->location['longitude']); ?></p>
<span><p>Average Rating:
    <?php
    $fivestar = field_view_field('node', $node, 'field_fivestar_awesomeness');
    print render($fivestar);
    ?></p></span>
</div>
<div class="school-moreinfo">
<h5>more info:</h5><br />
<div class="content">
<?php print strip_tags($node->content['body']['und'][0]['value'],"<p>,<br>"); ?>
</div>
</div>
</div>
<div class="reviews-rightp">

<div class="reviews-rightpimg">
<?php
  // "Geo" microformat, see http://microformats.org/wiki/geo
  if ($node->location['latitude'] && $node->location['longitude']) {
    // Assume that 0, 0 is invalid.
    if ($node->location['latitude'] != 0 || $node->location['longitude'] != 0) {
      $marker = $node->title;
   //   print gmap_simple_map($node->location['latitude'], $node->location['longitude'], '', $marker, 'default');
    }
  }
?>


</div>
<?php if ($school_attended) : ?>
<div class="review-rightuser">
  <div class="reviewusear">
    <?php print $school_attended ?>
    
  </div>
  
  </div>
  <?php endif; ?>
</div>
<?php if ($links): ?>
    <div class="drupal-links"><?php print $links; ?></div>
  <?php endif; ?>
