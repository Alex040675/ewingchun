<div class="encyclopediacategories-center">
  <div class="content"> <?php print $node->body['und'][0]['value']; ?> </div>
</div><!-- .encyclopediacategories-center -->
<div class="encyclopediacategories-right">
  <div class="ecr1">
    <p class="ecr1-txt"><?php print t('Posted By : ') . $name; ?></p>
    <p class="ecr1-txt1">Last Update: <?php print format_date($node->changed, 'short'); ?></p>
    <p class="ecr1-txt1">Category: <?php print $terms; ?></p>
    <p class="ecr1-txt1">Sifus Referenced: <?php print render($content['field_related_sifus']) ?></p>
    <p class="ecr1-txt1">Sifus Referenced Wiki: <?php print render($content['field_related_wiki']); ?></p>
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
    <div class="middleleftimg1"><?php print $node->field_emvideo[0]['view'] ?></div>
  </div><!-- .productname-left -->
</div><!-- .encyclopediacatego