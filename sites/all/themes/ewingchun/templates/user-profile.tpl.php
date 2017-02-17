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
 * @see hook_form_alter()
 * Custom variable:
 * - $classes: Adds additional node classes for advanced styling
 *
 */
?>
<div class="main-user">
<div class="user-left">
<h1></h1>
<div class="user-detail">
<div class="user-detail-left">
<?php //print theme('user_picture', array('account' => $variables['user_profile']['user_picture']['#markup']));
print render($variables['user_profile']['user_picture']['#markup']);
?>
</div>
<div class="user-detail-midle">
<h3><?php
  if ($variables['user_profile']['field_txt_firstname']['0']['#markup']) {
    print $variables['user_profile']['field_txt_firstname']['0']['#markup'] . " ";
  }
  if ($variables['user_profile']['field_txt_lastname']['0']['#markup']) {
    print $variables['user_profile']['field_txt_lastname']['0']['#markup'];
  }
  ?>
</h3>
<div class="user-detail-list">
<ul>
<li><span>Joined:</span> <?php print format_date($variables['elements']['#account']->created, 'short'); ?></li>
<li><span>My Sifu:</span> 
<?php
if ($variables['user_profile']['field_my_sifu']['#items'][0]['nid']) {
  $sifu_title = $variables['user_profile']['field_my_sifu'][0]['#title'];
  $sifu_path = $variables['user_profile']['field_my_sifu'][0]['#href'];
}
?>
<a href = "../<?php print $sifu_path; ?>"><?php print $sifu_title; ?></a>
</li>
<li><span>My School:</span> 
<?php
  if ($variables['user_profile']['field_my_school']['#items'][0]['nid']) {
    $schol_title = $variables['user_profile']['field_my_school'][0]['#title'];
    $schol_path = $variables['user_profile']['field_my_school'][0]['#href'];
  }
?>
  <a href = "../<?php print $schol_path; ?>"><?php print $schol_title; ?></a>
</li>
</ul>
</div>
</div>
<div class="user-detail-right">
<div class="user-detail-list1">
<ul>
<li><span>Years in Wing Chun :</span> 
<?php
if ($variables['user_profile']['summary']['member_for']['#markup']) {
  print $variables['user_profile']['summary']['member_for']['#markup'];
}
?>
</li>
<li><span>Is a Sifu:</span> <?php
  if ($variables['user_profile']['field_are_you_a_sifu_']['0']['#markup']) {
    print $variables['user_profile']['field_are_you_a_sifu_']['0']['#markup'];
  }
 ?>
</li>
</ul>
</div>
</div>
</div>
<div class="clear" style="padding:40px 0 0 0"></div>
<h3>about me</h3>
<div class="content" style="padding:15px 0 0 0">
<?php
  if ($variables['user_profile']['field_about_me']) {
    print ($variables['user_profile']['field_about_me'][0]['#markup']);
  }
//
//$account_id = arg(1);
//$account = user_load($account_id);
//$user_id = $account->uid;
//
//$var = content_profile_load('profile', $user_id);
//
//print $var->body; ?>

</div>
<div class="blog-part">
<div class="blog-part-left">
<h3>My Articles</h3>
<?php $abc = views_embed_view('Blogs', 'block_3');
print $abc; ?>
</div>
<div class="blog-part-right">
<div class="blog-top">
<div class="blog-topleft">
<h3>my blog posts </h3>
</div>
<div class="blog-topright">
  <a href="/node/add/blog" class="blue-link">add a post</a></div>
</div>
<?php $aaa = views_embed_view('Blogs', 'block_7');
print render($aaa); ?>
</div>
</div>
</div>
<div class="user-right">
<p class="contr-title">contribute.<span> Add A :</span></p>
<div class="contri">
<ul>
<li class="even"><a href="/node/add/sifu">Sifu</a></li>
<li class="odd"><a href="/node/add/resource">School</a></li>
<li class="even"><a href="/node/add/article">Article</a></li>
<li class="odd"><a href="/node/add/wiki">Encyclopedia Entry</a></li>
<li class="even"><a href="/node/add/video">Video</a></li>
<li class="odd"><a href="/node/add/blog">Blog Entry</a></li>
<li class="even"><a href="/add-your-stuff">Add your stuff</a></li>
</ul>
</div>
</div>
</div>
<div class="wc_blocks-friend_images">
  <h3 class="block-title">my friends</h3>
  <?php
    $block = block_load("user_relationship_blocks", "user");
    print render(_block_get_renderable_array( _block_render_blocks(array($block))));
    $current_relationships = user_relationships_load(array('between' => array($user->uid, $account->uid)), array('sort' => 'rtid'));
    if (count($current_relationships) < 1) {
      if ($variables['user_profile']['user_relationships_ui']['actions']['#markup']) {
        print $variables['user_profile']['user_relationships_ui']['actions']['#markup'];
      }
    }
  ?>
</div>

  <div class="recent-wiki">
    <h3>My Wiki Articles</h3>
    <?php $abc = views_embed_view('wiki', 'block_17');
    print $abc; ?>
  </div>
<?php
/* Another Method to add user relationship links
//add link
global $user;
$account = user_load($node->uid);
$actions = _user_relationships_ui_actions_between($user, $account);
if (count($actions)) {
  print theme('item_list', $actions);
}
*/
?>