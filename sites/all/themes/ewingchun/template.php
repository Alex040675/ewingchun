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

    $max = max(count($variables['node']->field_noderef_instructor['und']), count($variables['node']->field_img_certification['und']), count($variables['node']->field_taxo_rank['und']), count($variables['node']->field_txt_certnotes['und']), count($variables['node']->field_int_stillaffiliated['und']));

    $output = array();
    // Group Rank, cert image, and cert notes
    for ($i = 0; $i < $max; $i++) {
      unset($instructor, $instructor_name, $tid, $term, $rank);
      if ($i == 0){
        // Build Instructor link
        if (isset($variables['node']->field_noderef_instructor[$i]['nid'])){
          $instructor = node_load($variables['node']->field_noderef_instructor[$i]['nid']);

          // Output the name as link
          $instructor_name = l($instructor->title, $instructor->path);
          $variables['sifu_primary_instructor_name'] = $instructor_name;
        }
        // Build Rank vocabulary link
        if (isset($variables['node']->field_taxo_rank[$i]['value'])){
          // Find taxomomy ID and get term name
          $tid = $variables['node']->field_taxo_rank[$i]['value'];
          $term = taxonomy_term_load($tid);
          $variables['teach_primary_rank'] = $term->name;

          // Output the term name as link
          $rank = ' - ' . l($term->name, 'taxonomy/term/' . $tid);

        }
        //Output still affiliated or onot...
        if($variables['node']->field_int_stillaffiliated['und'][$i]['value'] == 0)
        {
          $primary_affiliated = 'No';
        }
        else
        {
          $primary_affiliated = 'Yes';
        }

        $variables['output_primary_teacher'] .= '<div class="primary01"> <div class="primary02-left">' . $instructor_name . '</div>
        <div class="primary02-midle">' . $term->name . '</div>
        <div class="primary02-rgt">' . $primary_affiliated . '</div>
        </div>';
        continue;
      }
      //Output still affiliated or onot...
      if($variables['node']->field_int_stillaffiliated['und'][$i]['value'] == 0) {
        $secondary_affiliated = 'No';
      }
      else {
        $secondary_affiliated = 'Yes';
      }
      if ($i%2 == 0) {
        $variables['output_secondary_teacher'] .= '<div class="primary01"> <div class="primary02-left">' . $instructor_name . '</div>
          <div class="primary02-midle">' . $term->name . '</div>
          <div class="primary02-rgt">' . $secondary_affiliated . '</div></div>';
      }
      else {
        $variables['output_secondary_teacher'] .= '<div class="primary02"> <div class="primary02-left">' . $instructor_name . '</div>
          <div class="primary02-midle">' . $term->name . '</div>
          <div class="primary02-rgt">' . $secondary_affiliated . '</div></div>';
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
  }

  // Output Sifu Encyclopedia block
  /*$arg = arg(1);
  $wiki =  '<div class="student-midle-title"> <div class="student-midle-titleleft"> <h3>' . t('Encyclopedia') . '</h3> </div> <div class="student-midle-titleright"> ' . l('Add', 'node/add/wiki', array('attributes' => array('class' => 'add'), 'query' => 'edit[field_related_sifus][nid][nid]=' . $sifu_profile_node->nid)) . '</div> </div>';
  $wiki .=  views_embed_view('wiki', 'block_1', $arg);

  $variables['sifu_wiki'] = $wiki;

  // Output Sifu student block
  $students = '<div class="student-title"> <div class="student-titleleft"> <h3>' . t('Student Sifus') . '</h3> </div> <div class="student-titleright"> ' . l('Add', 'node/add/sifu', array('attributes' => array('class' => 'add'), 'query' => 'edit[field_noderef_instructor][nid][nid]=' . $sifu_profile_node->nid)) . '</div> </div>';
  $students .= views_embed_view('sifu', 'block_1', $arg);
  $variables['sifu_students'] = $students;

  // Output Sifu video block
  $videos = '<div class="student-right-title"> <div class="student-right-titleleft"> <h3>' . t('Videos') . '</h3> </div> <div class="student-midle-titleright">' . l('Add', 'node/add/video', array('attributes' => array('class' => 'add'), 'query' => 'edit[field_sifu][nid][nid]=' . $sifu_profile_node->nid)) . '</div> </div>';
  $videos .= views_embed_view('videos', 'block_1', $arg);
//    $videos .= l('Add Video', 'node/add/video', array('attributes' => array('class' => 'add')));
  $videos .=  '<br />' ;
  $variables['sifu_videos'] = $videos;

  // Output Sifu products view
  $products = '<div class="student-right-title"> <div class="student-right-titleleft"> <h3>' . t('Products') . '</h3> </div> <div class="student-midle-titleright">' . l('Add', 'node/add/product', array('attributes' => array('class' => 'add'), 'query' => 'edit[field_sifu][nid][nid]=' . $sifu_profile_node->nid)) . '</div> </div>' ;
  $products .= views_embed_view('products', 'block_1', $arg);
  $variables['sifu_products'] = $products;

  // Output Sifu school block
  $schools = '<div class="student-title"> <div class="student-titleleft"> <h3>' . t('Schools') . '</h3> </div> <div class="student-titleright">' . l('Add', 'node/add/resource', array('attributes' => array('class' => 'add'), 'query' => 'edit[field_instructors][nid][nid]=' . $sifu_profile_node->nid)) . '</div> </div>';
  $schools .= views_embed_view('related_schools', 'block_1', $arg);*/
  $variables['sifu_schools'] = $schools;
  foreach ($variables['node']->field_img_certification AS $key => $img) {
    // Check for an image before outputting
    if ($img['filepath'] != NULL) {
      $full_size = imagecache_create_url('full-size', $img['filepath']);
      $thumbnail = imagecache_create_url('sifu-listing', $img['filepath']);


      $variables['cert_imgs'] .= '<li><a title="' . $img['data']['alt'] . '" href="' . $full_size . '" rel="lightbox[cert]"><img class="cert" src="'. $thumbnail . '" alt="' . $img['alt'] . '" /></a></li>';


    }
  }
}