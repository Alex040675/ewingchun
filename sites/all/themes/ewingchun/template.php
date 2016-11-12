<?php

/**
 * @file
 * Template overrides as well as (pre-)process and alter hooks for the
 * ewingchun theme.
 */
function ewingchun_preprocess_node(&$variables) {
  if ($variables['node']->type == 'sifu') {
    foreach ($variables['node']->field_profile_img['und'] AS $key => $img) {
      // Check for an image before outputting
      if ($img['uri'] != NULL) {
        if ($key == 0) {
          // Print out main image
          $full_size = image_style_url('full-size', $img['uri']);
          $thumbnail = image_style_url('article-main-img', $img['uri']);

          // Output main sifu profile image with lightbox overlay
          $variables['sifu_image'] = '<a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[sifu]"><img src="'. $thumbnail . '" alt="' . $img['alt'] . '" /></a>';
          continue;
        }

        // Render additional images with lightbox
        $full_size = image_style_url('full-size', $img['uri']);
        $thumbnail = image_style_url('sifu-listing', $img['uri']);

        // Output a list of images with lightbox overlays
        $variables['sifu_images'] .= '<li><a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[sifu]"><img src="'. $thumbnail . '" alt="' . $img['alt'] . '" /></a></li>';
      }
    }

    $jcnt = 0;
    // Building a lineage table information from the field collection
    if (!empty($variables['node']->field_lineage_information)) {
      foreach ($variables['node']->field_lineage_information['und'] as $key => $value) {
        $field_collection = entity_load('field_collection_item', array($value['value']));
        $idx = $value['value'];

        foreach ($field_collection[$idx]->field_noderef_instructor as $activity) {
          if (isset($activity[0]['nid'])){
            $instructor = node_load($activity[0]['nid']);
            // Output the name as link
            $instructor_name = l($instructor->title, 'node/' . $instructor->nid);

          }
          $lineage[$jcnt]['noderef_instructor'] = $instructor_name;
        }
        foreach ($field_collection[$idx]->field_primary_lineage as $activity) {
          if($activity[0]['value'] == 0) {
            $primary_affiliated = 'No';
          }
          else {
            $primary_affiliated = 'Yes';
          }
          $lineage[$jcnt]['primary_lineage'] = $primary_affiliated;
        }
        foreach ($field_collection[$idx]->field_int_stillaffiliated as $activity) {
          if($activity[0]['value'] == 0) {
            $secondary_affiliated = 'No';
          }
          else {
            $secondary_affiliated = 'Yes';
          }
          $lineage[$jcnt]['stillaffiliated'] = $secondary_affiliated;
        }
        foreach ($field_collection[$idx]->field_taxo_rank as $activity) {
          $tid = $activity[0]['tid'];
          $term = taxonomy_term_load($tid);
          $variables['teach_primary_rank'] = $term->name;

          // Output the term name as link
          $rank = ' - ' . l($term->name, 'taxonomy/term/' . $tid);
          $lineage[$jcnt]['field_taxo_rank'] = $term->name;
        }
        if ($lineage[$jcnt]['primary_lineage'] == 'No') {

          if ($jcnt%2 == 0) {
            $variables['output_secondary_teacher'] .= '<div class="primary01">
          <div class="primary02-left">' . $lineage[$jcnt]['noderef_instructor'] . '</div>
          <div class="primary02-midle">' . $term->name . '</div>
          <div class="primary02-rgt">' . $secondary_affiliated . '</div></div>';
          }
          else {
            $variables['output_secondary_teacher'] .= '<div class="primary02">
          <div class="primary02-left">' . $lineage[$jcnt]['noderef_instructor'] . '</div>
          <div class="primary02-midle">' .  $lineage[$jcnt]['field_taxo_rank'] . '</div>
          <div class="primary02-rgt">' . $lineage[$jcnt]['stillaffiliated'] . '</div></div>';
          }
          $variables['output_secondary_bottom'] = '</div><div class="primary-bottom"></div></div>';
        }

        $jcnt++;
      }
    }
    $variables['output_primary_teacher'] = '';
    if (!empty($lineage)) {
      foreach($lineage as $key => $val) {
        if ($val['primary_lineage'] == 'Yes') {
          $variables['output_primary_teacher'] .= '<div class="primary01">
            <div class="primary02-left">' . $val['noderef_instructor']. '</div>
            <div class="primary02-midle">' . $val['field_taxo_rank'] . '</div>
            <div class="primary02-rgt">' . $val['primary_lineage'] . '</div>
            </div>';
        }
      }
    }
    foreach ($variables['node']->field_img_certification['und'] AS $key => $img) {
      // Check for an image before outputting
      if ($img['uri'] != NULL) {
        $full_size = image_style_url('full-size', $img['uri']);
        $thumbnail = image_style_url('sifu-listing', $img['uri']);
        $variables['cert_imgs'] .= '<li><a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[cert]"><img class="cert" src="'. $thumbnail . '" alt="' . $img['alt'] . '" /></a></li>';
      }
    }
    $variables['output_block'] = '<div class="primary-top">secondary/previous teachers</div>
      <div class="primary-center">
      <div class="primary01">
      <div class="mprimary ">
      <div class="primary01-left">Teacher Name</div>
      <div class="primary01-midle">Rank Sifu ' . $variables['node']->field_txt_lastname['und'][0]['value'] . ' Obtained</div>
      <div class="primary01-rgt">Still Affiliated?</div>
      </div>';


    // Output Sifu Encyclopedia block
    $arg = arg(1);

    // Output Sifu article block
    $articles =  '<div class="student-midle-title"> <div class="student-midle-titleleft"> <h3>' . t('Articles') . '</h3> </div> <div class="student-midle-titleright"> ' . l('Add', 'node/add/article', array('attributes' => array('class' => 'add'),)) . '</div> </div>';
    $articles .=  views_embed_view('article', 'block_2', $arg);
    $variables['sifu_articles'] = $articles;

    // Output Sifu Encyclopedia block
    $wiki =  '<div class="student-midle-title"> <div class="student-midle-titleleft"> <h3>' . t('Encyclopedia') . '</h3> </div> <div class="student-midle-titleright"> ' . l('Add', 'node/add/wiki', array('attributes' => array('class' => 'add'), )) . '</div> </div>';
    $wiki .=  views_embed_view('wiki', 'block_1', $arg);

    // Output Sifu student block
    $variables['sifu_wiki'] = $wiki;
    $students = '<div class="student-title"> <div class="student-titleleft"> <h3>' . t('Student Sifus') . '</h3> </div> <div class="student-titleright"> ' . l('Add', 'node/add/sifu', array('attributes' => array('class' => 'add'), )) . '</div> </div>';
    $students .= views_embed_view('sifu', 'block_1', $arg);
    $variables['sifu_students'] = $students;

    // Output Sifu video block
    $videos = '<div class="student-right-title"> <div class="student-right-titleleft"> <h3>' . t('Videos') . '</h3> </div> <div class="student-midle-titleright">' . l('Add', 'node/add/video', array('attributes' => array('class' => 'add'), )) . '</div> </div>';
    $videos .= views_embed_view('videos', 'block_1', $arg);
    $videos .=  '<br />' ;
    $variables['sifu_videos'] = $videos;

    // Output Sifu products view
    $products = '<div class="student-right-title"> <div class="student-right-titleleft"> <h3>' . t('Products') . '</h3> </div> <div class="student-midle-titleright">' . l('Add', 'node/add/product', array('attributes' => array('class' => 'add'),)) . '</div> </div>' ;
    $products .= views_embed_view('products', 'block_1', $arg);
    $variables['sifu_products'] = $products;

    // Output Sifu school block
    $schools = '<div class="student-title"> <div class="student-titleleft"> <h3>' . t('Schools') . '</h3> </div> <div class="student-titleright">' . l('Add', 'node/add/resource', array('attributes' => array('class' => 'add'), )) . '</div> </div>';
    $schools .= views_embed_view('related_schools', 'block_1', $arg);
    $variables['sifu_schools'] = $schools;
    foreach ($variables['node']->field_img_certification['und'] AS $key => $img) {
      // Check for an image before outputting.
      if ($img['filepath'] != NULL) {
        $full_size = image_style_url('full-size', $img['uri']);
        $thumbnail = image_style_url('sifu-listing', $img['uri']);
        $variables['cert_imgs'] .= '<li><a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[cert]"><img class="cert" src="'. $thumbnail . '" alt="' . $img['alt'] . '" /></a></li>';
      }
    }
  }
  // Add variables for schools content type.
  if ($variables['node']->type == 'resource') {
    if (!empty($variables['node']->field_instructors['und'][0]['nid'])) {
      $sifu_node = node_load($variables['node']->field_instructors[0]['nid']);
      // Pull in linked name
      $sifu_name = l($sifu_node->title, $sifu_node->path);
      $variables['head_instructor'] = $sifu_name;
    }

    foreach ($variables['node']->field_profile_img['und'] AS $key => $img) {
      // Make sure there is actually an image before outputting
      if ($img['uri'] != NULL) {
        if ($key == 0) {
          // Print out main image
          $full_size = image_style_url('full-size', $img['uri']);
          $thumbnail = image_style_url('article-main-img', $img['uri']);

          // Output main sifu profile image with lightbox overlay
          $variables['school_main_image'] = '<a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[sifu]"><img class="sifu-image" src="'. $thumbnail . '" alt="' . $img['alt'] . '" /></a>';
          continue;
        }

        // Render additional images with lightbox
        $full_size = image_style_url('full-size', $img['uri']);
        $thumbnail = image_style_url('sifu-listing', $img['uri']);

        // Output a list of images with lightbox overlays
        $variables['school_images'] .= '<li><a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[sifu]"><img src="'. $thumbnail . '" alt="' . $img['data']['alt'] . '" /></a></li>';

        //output users who attended block
        $attended = '<p class="yca">' . t('users who attend') . '</p>';
        $attended .= views_embed_view('wcusers', 'block_1', $variables['node']->nid);
        $variables['school_attended'] = $attended;
      }
    }

  }

  if ($variables['node']->type == "article") {

    print_r($variables['node']->field_emvideo);
    $relvideo = $variables['node']->field_emvideo[0]['embed'];
    $relatedvideo = '<a rel="lightframe[video|width:656; height:401;]" class="emvideo-thumbnail-replacement emvideo-modal-lightbox2 lightbox2 lightbox-processed emvideo-thumbnail-replacement-processed" title="Bruce Lee" href="/lakhan/ewingchun/emvideo/modal/9265/640/385/field_emvideo/youtube/QG2M9yVJ_s8"><span></span><img width="120" height="90" title="See video" alt="See video" src="http://img.youtube.com/vi/QG2M9yVJ_s8/0.jpg"></a>';
    $vars['articlevideos'] = $relatedvideo;

    foreach ($sifu_node->field_related_images['und'] as $key => $val) {
      if ($key == 0) {
        $sifu_img =  $sifu_node->field_related_images['und'][0]['uri'];
        $full_size = image_style_url('full-size', $sifu_img);
      }
      else {
        $thumbnail = image_style_url('sifu-listing', $img['uri']);
        $variables['sifu_imgs'] .= '<li><a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[article]"><img class="cert" src="'. $thumbnail . '" alt="' . $img['alt'] . '" /></a></li>';
      }

    }
    // Output main img with lightbox
    $variables['sifu_img'] = '<div class="left"><a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[article]"><img src="'. $full_size . '" alt="' . $img['alt'] . '" /></a></div>';

    $variables['related_sifu'] = $variables['node']->field_sifu['und'][0]['nid'];
  }
}