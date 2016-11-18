33333333333<div class="articletitle-leftp">
	<div class="articalmain">
		<div class="left"><?php print t('Posted By : ') . l ($name,  'user/' . $uid, array('html' => true)); ?></div>
		<div class="right">Date: <span><?php print format_date($node->changed, 'short'); ?></span></div>
		<div class="middle">
			<?php if($article_image || $article_images || $node->field_emvideo[0]['view']) : ?>
			<div class="middleleft">
				<?php if ($article_image) : ?>
				<div class="middleleftimg"> <?php print $article_image; ?> </div>
				<?php endif; ?>
				<div class="clear-left"></div>
				<!-- clear the floating elements -->
				<?php if ($article_images) : ?>
				<div class="blogfpo">
					<ul>
						<?php  print $article_images; ?>
					</ul>
				</div>
				<?php endif; ?>
				<?php if($node->field_embeded_video['und'][0]['video_url']) : ?>
				<div class="clear-left"></div>
				<!-- clear the floating elements -->
				<div class="middleleftimg1"><a href="<?php echo $node->field_embeded_video['und'][0]['video_url']?>" rel="lightvideo[|width:640px; height:480px;]" class="lightvideo emvideo-thumbnail-replacement" ><span></span><img src="<?php print file_create_url($node->field_embeded_video['und'][0]['thumbnail_path']) ?>" /></a>
					<?php 
						$videoid = $node->field_embeded_video['und'][0]['video_url'];
						$content = file_get_contents($videoid);
						parse_str($content, $ytarr);
					?>
					<p style="padding:5px 0 0 0;"><a rel="lightvideo[|width:640px; height:480px;]"  href="<?php echo $node->field_embeded_video['und'][0]['video_url']?>"><?php echo $ytarr['title']; ?></a></p>
				</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<div class="middle-center"> <?php print $node->body['und'][0]['value']; ?> </div>
			<div class="artical-sn"> <?php print $sharethis; ?> </div>
		</div>
	</div>
</div>
<div class="artical-rightmain">
	<div class="relatedproducts">
		<p class="yca">related products</p>
		<?php print $relatedproducts; ?>
		<!--<div class="videoaddbanner"></div>-->
	</div>
	<div class="otherarticlessifu">
		<p class="yca">other blogs by user</p>
		<ul>
			<?php print $otherblogsbyuser; ?>
		</ul>
	</div>
	<div class="recentarticles">
		<p class="yca">recent articles</p>
		<?php print $recent_articles; ?> </div>
	<div class="recentarticles">
		<p class="yca">recent wiki posts</p>
		<ul>
			<?php print $recent_wiki; ?>
		</ul>
	</div>
</div>
<?php
$comments = comment_node_page_additions($node);
print render($comments);
?>
