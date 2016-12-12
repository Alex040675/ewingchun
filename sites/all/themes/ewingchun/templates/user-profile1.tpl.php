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
<div class="main-user">
<div class="user-left">
<h1></h1>
<div class="user-detail">
<div class="user-detail-left">
<?php print theme('user_picture', $user); ?>
</div>
<div class="user-detail-midle">
<h3><?php print $account->profile_fullname; ?></h3>
<div class="user-detail-list">
<ul>
<li><span>Joined:</span> <?php print format_date($account->created, 'small'); ?></li>
<li><span>My Sifu:</span> 
<?php 
$account_id = arg(1);
$account = user_load($account_id);
$user_id = $account->uid;

$var = content_profile_load('profile', $user_id);

$sifu_node = node_load($var->field_my_sifu[0]['nid']);

print $sifu_node->title;   ?></li>
<li><span>My School:</span> 
<?php 
$account_id = arg(1);
$account = user_load($account_id);
$user_id = $account->uid;

$var = content_profile_load('profile', $user_id);

$sifu_node = node_load($var->field_attending_school[0]['nid']);

print $sifu_node->title;   ?></li>
</ul>
</div>
</div>
<div class="user-detail-right">
<div class="user-detail-list1">
<ul>
<li><span>Years in Wing Chun :</span> 
<?php 
$yearswc = $account->profile_startyear;
		if ($yearswc != 0) {
		$currenttime = time ();
		$currentyear = date("Y",$currenttime);
		$yearsinwc = $currentyear - $yearswc;
		}
		else
		{
		yearsinwc == "Unknown";
		}
print $yearsinwc;
?>
<?php    ?>
</li>
<li><span>Is a Sifu:</span> <?php print $account->profile_issifu; ?></li>
</ul>
</div>
</div>
</div>
<div class="clear" style="padding:40px 0 0 0"></div>
<h3>about me</h3>
<div class="content" style="padding:15px 0 0 0">
<?php 
$account_id = arg(1);
$account = user_load($account_id);
$user_id = $account->uid;

$var = content_profile_load('profile', $user_id);

print $var->body; ?>

</div>
<div class="blog-part">
<div class="blog-part-left">
<h3>topics i'm participating in</h3>
<?php $abc = views_embed_view('Blogs', 'block_3', $arg);
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
<?php $abc = views_embed_view('Blogs', 'block_2', $arg);
print $abc; ?>
</div>
</div>
</div>
<div class="user-right">
<p class="contr-title">contribute.<span> Add A :</span></p>
<div class="contri">
<ul>
<li><a href="/node/add/sifu">Sifu</a></li>
<li><a href="/node/add/resource">School</a></li>
<li><a href="/node/add/article">Article</a></li>
<li><a href="/node/add/wiki">Encyclopedia Entry</a></li>
<li><a href="/node/add/video">Video</a></li>
<li><a href="/node/add/blog">Blog Entry</a></li>
<li><a href="/node/add/product">Product</a></li>
<li><a href="/node/add/forum">Forum Topic</a></li>
<li><a href="/node/add/product">Book or DVD</a><br />
  <br />
</li>
</ul>
</div>
</div>
</div>
