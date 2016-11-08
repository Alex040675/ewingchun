<?php print render($content['field_homepage_link']);

?>

<?php if ($status == 0) : ?>
  <p class="node-moderatation"><?php print t('Post is awaiting moderation.'); ?></p>
<?php endif; ?>
<div class="common-top">
  <div class="common-topright"> <?php print $sharethis; ?> </div>
</div>
<div class="commonname">
  <div class="common-left">
    <?php if ($field_profile_img): ?>
      <?php print $field_profile_img; ?>
    <?php endif; ?>
  </div>
  <div class="common-midle">
    <ul>
      <?php if ($node->field_txt_firstname[0]['value']): ?>
        <li><span>First (Given):</span> <?php print ($node->field_txt_firstname[0]['value']); ?></li>
      <?php endif; ?>
      <?php if ($node->field_txt_lastname[0]['value']): ?>
        <li><span>Last (Family): </span> <?php print ($node->field_txt_lastname[0]['value']); ?></li>
      <?php endif; ?>
      <li><span>Commenly Know As:</span> <?php print $node->title; ?></li>
      <?php if ($node->field_txt_altname[0]['value']): ?>
        <li><span>Nicknames/Alt Spellings:</span> <?php print ($node->field_txt_altname[0]['value']); ?></li>
      <?php endif; ?>
    </ul>
  </div>
  <?php if($node->field_primary_lineage[0]['value'] = 1) : ?>
    <div class="common-right">
      <div class="common-right-lft">Primary Lineage: </div>
      <div class="common-right-2"> <?php print $node->field_lineage[0]['view'] ?></div>
    </div>
  <?php endif; ?>
  <div class="comon-btom">
    <?php if ($node->field_homepage_link[0]['view']): ?>
      <p class="comom-btm-text"><strong>Websites/Social Pages:</strong> <?php print $sifu_urls; ?> </p>
    <?php endif; ?>
    <div class="dob">
      <?php if ($bday): ?>
        <div class="dob-left"><span>Date of Birth:</span> <?php print $bday; ?> </div>
      <?php endif; ?>
      <?php if ($dday): ?>
        <div class="dob-right"><span>Date of Death:</span> <?php print $dday; ?></div>
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
<?php if ($precontent): ?>
<h3>bio (teaser)</h3>
<div class="content" style="padding:15px 0 0 0;"> <?php print strip_tags($precontent,"<p>,<br>"); ?>
  <?php if ($body): ?>
    <a href="/<?php print $node->path?>#more" class="more-link">Read more</a>
  <?php endif; ?>
  <?php endif; ?>
</div>
<div class="primary-part">
  <div class="primary-partleft">
    <?php if ($output_primary_teacher) : ?>
    <div class="primary-top"> primary teacher/lineage </div>
    <div class="primary-center">
      <div class="primary01">
        <div class="mprimary ">
          <div class="primary01-left">Teacher Name</div>
          <div class="primary01-midle">Rank Sifu <?php print $node->field_txt_lastname[0]['value']; ?> Obtained</div>
          <div class="primary01-rgt">Still Affiliated?</div>
        </div>
        <div class="primary02"> <?php print $output_primary_teacher; ?> </div>
        <?php endif; ?>
        <?php if ($node->sifu_lineage) : ?>
          <div class="primary01">
            <p class="lineage-text"><strong>Full Lineage:</strong><br/>
              <?php print $node->sifu_lineage ?> </p>
          </div>
        <?php endif; ?>
      </div>
      <div class="primary-bottom"></div>
    </div>
    <?php if($node->field_img_certification[0]['view']) : ?>
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
  <?php if ($node->field_txt_certnotes[0]['value']) : ?>
    <div class="primary-partright">
      <p class="contr-title">lineage notes</p>
      <div class="lineage1">
        <div class="flexcroll"> <?php print $node->field_txt_certnotes[0]['value']; ?></div>
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
  <?php if ($body): ?>
    <div id="more">
      <div class="bottom-biography">
        <h3>biography (con't)</h3>
        <div class="content" style="padding:15px 0 0 0;"><?php print strip_tags($body,"<p>,<br>"); ?></div>
      </div>
    </div>
  <?php endif; ?>
  <?php if ($links): ?>
    <div class="drupal-links"><?php print $links; ?></div>
  <?php endif; ?>
