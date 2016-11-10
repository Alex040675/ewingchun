<?php

?>

<?php if ($status == 0) : ?>
  <p class="node-moderatation"><?php print t('Post is awaiting moderation.'); ?></p>
<?php endif; ?>
<div class="common-top">
  <div class="common-topright"> <?php print $sharethis; ?> </div>
</div>
<div class="commonname">
  <div class="common-left">
    <?php if ($sifu_image): ?>
      <?php print $sifu_image; ?>
    <?php endif; ?>
  </div>
  <div class="common-midle">
    <ul>
      <?php if ($node->field_txt_firstname['und'][0]['value']): ?>
        <li><span>First (Given):</span> <?php print ($node->field_txt_firstname['und'][0]['value']); ?></li>
      <?php endif; ?>
      <?php if ($node->field_txt_lastname['und'][0]['value']): ?>
        <li><span>Last (Family): </span> <?php print ($node->field_txt_lastname['und'][0]['value']); ?></li>
      <?php endif; ?>
      <li><span>Commenly Know As:</span> <?php print $node->title; ?></li>
      <?php if ($node->field_txt_altname['und'][0]['value']): ?>
        <li><span>Nicknames/Alt Spellings:</span> <?php print ($node->field_txt_altname['und'][0]['value']); ?></li>
      <?php endif; ?>
    </ul>
  </div>
  <?php

  if($node->field_primary_lineage['und'][0]['value'] = 1) : ?>
    <div class="common-right">
      <div class="common-right-lft">Primary Lineage: </div>
      <div class="common-right-2"> <?php print $node->taxonomy_vocabulary_9['und'][0]['taxonomy_term']->name; ?></div>
    </div>
  <?php endif; ?>
  <div class="comon-btom">
    <?php if ($node->field_homepage_link['und'][0]['view']): ?>
      <p class="comom-btm-text"><strong>Websites/Social Pages:</strong> <?php print_r($node->field_bdate); ?> </p>
    <?php endif; ?>
    <div class="dob">
      <?php if ($node->field_bdate['und'][0]['value']): ?>
        <div class="dob-left"><span>Date of Birth:</span> <?php print date("M d, Y", strtotime($node->field_bdate['und'][0]['value'])) ; ?> </div>
      <?php endif; ?>
      <?php if ($node->field_death_date['und'][0]['value']): ?>
        <div class="dob-right"><span>Date of Death:</span> <?php print date("M d, Y", strtotime($node->field_death_date['und'][0]['value'])); ?></div>
      <?php endif; ?>
    </div>
  </div>
</div>
</div>
<div class="common-namelist">
  <?php if ($sifu_images): ?>
    <ul>
      <?php print $sifu_images; ?>
    </ul>
  <?php endif; ?>
</div>
<div class="clear" style="padding:20px 0 0 0;"></div>
<?php

?>
<?php if (isset($node->body['und'][0]['summary']) && $node->body['und'][0]['summary'] != ''): ?>
<h3>bio (teaser)</h3>
<div class="content" style="padding:15px 0 0 0;"> <?php print strip_tags($node->body['und'][0]['summary'],"<p>,<br>"); ?>
  <?php if (isset($node->body['und'][0]['value'])): ?>
    <a href="/<?php print $node->path?>#more" class="more-link">Read more</a>
  <?php endif; ?>
  <?php else: ?>
  <h3>bio (teaser)</h3>
  <div class="content" style="padding:15px 0 0 0;"> <?php print strip_tags($node->body['und'][0]['summary'],"<p>,<br>"); ?>
    <?php if (isset($node->body['und'][0]['value'])): ?>
      <a href="/<?php print $node->path?>#more" class="more-link">Read more</a>
    <?php endif; ?>
  <?php endif; ?>

</div>
<div class="primary-part">
  <div class="primary-partleft">
    <?php
    if ($output_primary_teacher) : ?>
    <div class="primary-top"> primary teacher/lineage </div>
    <div class="primary-center">
      <div class="primary01">
        <div class="mprimary ">
          <div class="primary01-left">Teacher Name</div>
          <div class="primary01-midle">Rank Sifu <?php print $node->field_txt_lastname['und'][0]['value']; ?> Obtained</div>
          <div class="primary01-rgt">Still Affiliated?</div>
        </div>
        <div class="primary02"> <?php print $output_primary_teacher; ?> </div>
        <?php endif; ?>
        <?php if (isset($node->taxonomy_vocabulary_9['und'][0]['taxonomy_term']->name)) : ?>
          <div class="primary01">
            <p class="lineage-text"><strong>Full Lineage:</strong><br/>
              <?php print $node->taxonomy_vocabulary_9['und'][0]['taxonomy_term']->name ?> </p>
          </div>
        <?php endif; ?>
      </div>
      <div class="primary-bottom"></div>
    </div>
    <?php if (isset($node->field_img_certification[0]['uri'])) : ?>
      <div class="certification">
        <div class="certification-left">
          <h3>certification pictures:</h3>
        </div>
        <div class="certification-right">
          <ul>
            <?php print $cert_imgs; ?>
          </ul>
        </div>
      </div>
    <?php endif; ?>
    <?php print $output_block; ?> <?php print $output_secondary_teacher; ?>
    <?php if ($output_block) : ?>
      <?php print $output_secondary_bottom; ?>
    <?php endif; ?>
  </div>
  <?php if ($node->field_txt_certnotes['und'][0]['value']) : ?>
    <div class="primary-partright">
      <p class="contr-title">lineage notes</p>
      <div class="lineage1">
        <div class="flexcroll"> <?php print $node->field_txt_certnotes['und'][0]['value']; ?></div>
      </div>
    </div>
  <?php endif; ?>
  <div class="student-sifus">
    <div class="student-left"> <?php print $sifu_students; ?> </div>
    <div class="student-midle"> <?php print $sifu_articles; ?> </div>
    <div class="student-right"> <?php print $sifu_products; ?> </div>
  </div>
  <div class="student-sifus">
    <div class="student-left"> <?php print $sifu_schools; ?> </div>
    <div class="student-midle"> <?php print $sifu_wiki; ?> </div>
    <div class="student-right"> <?php print $sifu_videos; ?> </div>
  </div>
  <div class="bottom-border"></div>
  <?php if (isset($node->body['und'][0]['value'])): ?>
    <div id="more">
      <div class="bottom-biography">
        <h3>biography (con't)</h3>
        <div class="content" style="padding:15px 0 0 0;"><?php print strip_tags($node->body['und'][0]['value'],"<p>,<br>"); ?></div>
      </div>
    </div>
  <?php endif; ?>
  <?php if (isset($content['links'])): ?>
    <div class="drupal-links"><?php print render($content['links']);  ?></div>
  <?php endif; ?>

  <?php
    $comment_form = drupal_get_form('comment_node_sifu_form', (object) array('nid' => $node->nid));
    print drupal_render($comment_form);?>