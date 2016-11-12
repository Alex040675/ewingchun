<?php

?>
<?php
if ($page == 0): //if node is being displayed as a teaser
?>

<div class="main-history">
	<div class="history-left">
		<div class="history-top"></div>
		<div class="history-mid">
			<div class="history-left1">
				<p class="font-16"><a href="<?php print $node_url ?>" class="font-16link"><?php print $title; ?><br />
					<span>Sifu/Author: <?php print render($content['field_sifu']); ?></span> </p>
			</div>
			<div class="history-right1">
        <div class="article_main">
          <?php
          print $sifu_img;
          ?>
        </div>
        <div class="article_thumb">
          <?php if ($sifu_imgs): ?>
            <ul>
              <?php print $sifu_imgs; ?>
            </ul>
          <?php endif; ?>
        </div>

			</div>
			<div class="clear-left"></div>
			<div class="article-teaser">
				<!--<span class="history-content">-->
				<p>
					<?php if($teaser): ?>
					<?php $str1 = $node->body['und'][0]['value']; ?>
					<?php print strip_tags(substr($str1, 0, 500)); ?>
					<?php //echo htmlspecialchars($str1); ?>
					<span>... <a href="<?php print $node_url ?>" class="blue-link">Read More</a></span>
					<?php endif; ?>
				</p>
				<!--</span>-->
			</div>
			<!-- .article-teaser -->
		</div>
		<div class="history-btm"></div>
	</div>
	<div class="history-right">
		<div class="posted-top"></div>
		<div class="posted-mid">
			<p class="ar-font12"><?php print t('Posted By : ') . l ($name,  'user/' . $uid); ?><br />
				<?php print format_date($node->changed, 'small'); ?><br />
				<?php print $comment_count; ?> Comments<br />
				<a href="<?php print "comment/reply/$node->nid"; ?>" class="blue-link" > Add Comment </a>
			<p><a href="<?php print $node_url ?>" class="blue-link">Read More</a></p>
			<p>Related Images:</p>
			<div class="post-images">
				<ul>
					<?php print $article_images; ?>
				</ul>
			</div>
			</p>
		</div>
		<div class="posted-btm"></div>
	</div>
</div>
<?php
endif;
?>
<?php
if ($page == 1): //if node is being displayed as a node
?>
<div class="articletitle-leftp">
	<div class="articalmain">
		<?php if (!empty($content['field_sifu'])): ?>
		<div class="left">Sifu/Author: <a href="#" class="youtublink"><?php print render($content['field_sifu']); ?></a></div>
		<?php endif; ?>
		<div class="center"><?php print t('Posted By : ') . l ($name,  'user/' . $uid); ?></div>
		<div class="right">Date: <span><?php print format_date($node->changed, 'small'); ?></span></div>
		<div class="middle">
			<?php if( $node->field_sifu['und'][0]['nid'] || $node->field_embeded_video['und'][0]['view'] || $article_images ) : ?>
			<div class="middleleft">
				<?php if ($sifu_img) : ?>
				<div class="middleleftimg">
					<?php print $sifu_img; ?>
					<p class="img-caption"><?php print $sifu_name; ?></p>
				</div><!-- .middleleftimg -->
				<?php endif; ?>
				<?php if ($node->field_emvideo[0]['view']) : ?>
				<div class="middleleftimg1"> <a href="<?php echo $node->field_emvideo[0]['embed']?>" rel="lightvideo[|width:400px; height:300px;]" class="emvideo-thumbnail-replacement" ><span></span><img src="http://img.youtube.com/vi/<?php echo $node->field_emvideo[0][value] ?>/0.jpg" /></a>
					<?php 
$videoid = $node->field_emvideo[0][value];
$content = file_get_contents("http://youtube.com/get_video_info?video_id=".$videoid);
parse_str($content, $ytarr);
?>
					<p><a href="<?php echo $node->field_emvideo[0]['embed']?>"><?php echo $ytarr['title']; ?></a></p>
				</div>
				<?php endif; ?>
				<?php if ($article_images) : ?>
				<div class="articalfpo">
					<ul>
						<?php print $article_images; ?>
					</ul>
				</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<div class="middle-center"> <?php print strip_tags($node->content['body']['#value']); ?> </div>
			<div class="artical-sn"> <?php print $sharethis; ?> </div>
		</div>
	</div>
</div>
<div class="artical-rightmain">
	<div class="relatedproducts">
		<p class="yca">related products</p>
		<?php
			if($relatedproducts!=NULL) {
				print $relatedproducts;
			} else {
			?>
				<div class="view view-products view-id-products view-display-id-block_2 view-dom-id-2">
					<div class="view-empty"> <p>No Related Products</p></div>
				</div>
			<?php	
			}
		?>
		<?php //print $relatedproducts; ?>
		<!--<div class="videoaddbanner"></div>-->
	</div>
	<div class="recentarticles">
		<p class="yca">other articles by sifu</p>
		<?php
			if($otherarticles!=NULL) {
				print $otherarticles;
			} else {
				echo "<br/><p>No Articles</p>";
			}
		?>	
	</div>
	<div class="recentarticles">
		<p class="yca">recent articles</p>
		<?php print $recent_articles; ?> </div>
	<div class="recentarticles">
		<p class="yca">recent wiki posts</p>
		<?php print $recent_wiki; ?> </div>
</div>
<?php
endif;
?>
