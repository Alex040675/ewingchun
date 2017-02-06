<div class="encyclopediacategories-center">
  <div class="content"> <?php print $node->body['und'][0]['value']; ?> </div>
</div><!-- .encyclopediacategories-center -->
<div class="encyclopediacategories-right">
  <div class="ecr1">
    <p class="ecr1-txt"><?php print t('Posted By : ') . $name; ?></p>
    <p class="ecr1-txt1">Last Update: <?php print format_date($node->changed, 'short'); ?></p>
    <p class="ecr1-txt1">Category: <?php print render($content['field_category']); ?></p>
    <?php if (isset($content['field_related_sifus'])): ?>
    <p class="ecr1-txt1">Sifus Referenced: <?php print render($content['field_related_sifus']) ?></p>
    <?php endif; ?>
    <?php if (isset($content['field_related_wiki'])): ?>
    <p class="ecr1-txt1">Sifus Referenced Wiki: <?php print render($content['field_related_wiki']); ?></p>
    <?php endif; ?>
    <div class="ecrl-sources">
      <p class="ecr1s-txt">Sources</p>
      <p class="ecr1s-txt1"><?php print $node->field_sources['und'][0]['value'] ?></p>
    </div>
  </div><!-- .ecr1 -->
  <div class="productname-left">
    <div class="middleleftimg"><?php print $wiki_image; ?></div>
    <div class="blogfpo">
      <ul>
        <?php print render($content['field_category']); ?>
      </ul>
    </div><!-- .blogfpo -->
    <?php if ($node->field_embeded_video['und'][0]['video_url']) : ?>
    <div class="middleleftimg1"><a href="<?php echo $node->field_embeded_video['und'][0]['video_url']?>" rel="lightvideo[|width:400px; height:300px;]" class="lightvideo emvideo-thumbnail-replacement" ><span></span><img src="<?php print file_create_url($node->field_embeded_video['und'][0]['thumbnail_path']) ?>" /></a>
<!--      --><?php //print $node->field_emvideo[0]['view'] ?>
      <?php
      $videoid = $node->field_embeded_video['und'][0]['video_url'];
      $content = file_get_contents($node->field_embeded_video['und'][0]['video_url']);
      parse_str($content, $ytarr);
      ?>
      <p><a href="<?php echo $node->field_embeded_video['und'][0]['video_url']?>"><?php echo $ytarr['title']; ?></a></p>
    </div>
    <?php endif; ?>
  </div><!-- .productname-left -->
</div>