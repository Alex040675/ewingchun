<?php

/**
 * @file
 * Template overrides as well as (pre-)process and alter hooks for the
 * ewingchun theme.
 */
function ewingchun_preprocess(&$variables) {
//  Added field 'help' to node 'sifu' edit
  if (($variables['node']->type == 'sifu') and (arg(0) == 'node')) {
    if ((arg(1) == 'add') or (arg(2) == 'edit')) {
      $variables['theme_hook_suggestions'][] = 'page__edit__sifu';
      $query = db_select('node_type', 'nt');
      $query
        ->condition('type', 'sifu')
        ->fields('nt', array('help'));
      $result = $query->execute();
      foreach ($result as $row) {
        $variables['sifu_help'] = $row;
      }
    }
  }
}
function ewingchun_preprocess_node(&$variables) {
  // Add variables for sifu content type.
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
          $lineage[$jcnt]['nid'] = $instructor->nid;
        }
        foreach ($field_collection[$idx]->field_primary_lineage as $activity) {
          if($activity[0]['value'] == 0) {
            $primary_affiliated = 'No';
          }
          else {
            $primary_affiliated = 'Yes';
          }
          $data[$variables['node']->nid]['primary_affiliated'][$jcnt] = $primary_affiliated;
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

        if ( count($lineage) > 1 && $lineage[$jcnt]['primary_lineage'] == 'No') {

          if ($jcnt%2 == 0) {
            $variables['output_secondary_teacher'] .= '<div class="primary01">
          <div class="primary02-left">' . $lineage[$jcnt]['noderef_instructor'] . '</div>
          <div class="primary02-midle">' . $term->name . '</div>
          <div class="primary02-rgt">' . $secondary_affiliated . '</div></div>';
          }
          else {
            $variables['output_block'] = '<div class="primary-top">secondary/previous teachers</div>
              <div class="primary-center">
              <div class="primary01">
              <div class="mprimary ">
              <div class="primary01-left">Teacher Name</div>
              <div class="primary01-midle">Rank Sifu ' . $variables['node']->field_txt_lastname['und'][0]['value'] . ' Obtained</div>
              <div class="primary01-rgt">Still Affiliated?</div>
              </div>';
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
    // If there is no primary flag, but there is teacher flag.
    $flag = FALSE;
    $variables['output_primary_teacher'] = '';
    if (!empty($lineage)) {
      foreach($lineage as $key => $val) {
        if ($val['primary_lineage'] == 'Yes') {
          $flag = TRUE;
          $main_instructor = $val['nid'];
          $affilated = $val['primary_lineage'];
          $variables['output_primary_teacher'] .= '<div class="primary01">
            <div class="primary02-left">' . $val['noderef_instructor']. '</div>
            <div class="primary02-midle">' . $val['field_taxo_rank'] . '</div>
            <div class="primary02-rgt">' . $val['primary_lineage'] . '</div>
            </div>';
        }
      }
      if ($flag == FALSE) {
        foreach($lineage as $key => $val) {
          if ($key == 0) {
            $main_instructor = $val['nid'];
            $affilated = 0;
            $variables['output_primary_teacher'] .= '<div class="primary01">
            <div class="primary02-left">' . $val['noderef_instructor']. '</div>
            <div class="primary02-midle">' . $val['field_taxo_rank'] . '</div>
            <div class="primary02-rgt">' . $val['primary_lineage'] . '</div>
            </div>';
          }
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

    $variables['full_lineage'] = _wc_lineage_get_primary($variables['node'], $main_instructor, $affilated);


    // Output Sifu Encyclopedia block
    $arg = arg(1);

    // Output Sifu article block
    $articles =  '<div class="student-midle-title"> <div class="student-midle-titleleft"> <h3>' . t('Articles') . '</h3> </div> <div class="student-midle-titleright">' . l('Add', 'node/add/article', array('attributes' => array('class' => 'add'), 'query'=>array('edit[field_sifu][und]'=>$variables['node']->nid,) )) . '</div> </div>';
    $articles .=  views_embed_view('article', 'block_2', $arg);
    $variables['sifu_articles'] = $articles;

    // Output Sifu Encyclopedia block
    $wiki =  '<div class="student-midle-title"> <div class="student-midle-titleleft"> <h3>' . t('Encyclopedia') . '</h3> </div> <div class="student-midle-titleright"> ' . l('Add', 'node/add/wiki', array('attributes' => array('class' => 'add'), 'query'=>array('edit[field_related_sifus][und]'=>$variables['node']->nid,) )) . '</div> </div>';
    $wiki .=  views_embed_view('wiki', 'block_16', $arg);

    // Output Sifu student block
    $variables['sifu_wiki'] = $wiki;
    $students = '<div class="student-title"> <div class="student-titleleft"> <h3>' . t('Student Sifus') . '</h3> </div> <div class="student-titleright"> ' . l('Add', 'node/add/sifu', array('attributes' => array('class' => 'add'), 'query'=>array('edit[field_lineage_information][und][0][field_noderef_instructor][und]'=>$variables['node']->nid,))) . '</div> </div>';
    $students .= views_embed_view('sifu', 'block_1', $arg);
    $variables['sifu_students'] = $students;

    // Output Sifu video block
    $videos = '<div class="student-right-title"> <div class="student-right-titleleft"> <h3>' . t('Videos') . '</h3> </div> <div class="student-midle-titleright">' . l('Add', 'node/add/video', array('attributes' => array('class' => 'add'), 'query'=>array('edit[field_sifu][und]'=>$variables['node']->nid,))) . '</div> </div>';
    $videos .= views_embed_view('videos', 'block_1', $arg);
    $videos .=  '<br />' ;
    $variables['sifu_videos'] = $videos;

    // Output Sifu products view
    $products = '<div class="student-right-title"> <div class="student-right-titleleft"> <h3>' . t('Products') . '</h3> </div> <div class="student-midle-titleright">' . l('Add', 'node/add/product', array('attributes' => array('class' => 'add'),'query'=>array('edit[field_sifu][und]'=>$variables['node']->nid,))) . '</div> </div>' ;
    $products .= views_embed_view('products', 'block_1', $arg);
    $variables['sifu_products'] = $products;

    // Output Sifu school block
    $schools = '<div class="student-title"> <div class="student-titleleft"> <h3>' . t('Schools') . '</h3> </div> <div class="student-titleright">' . l('Add', 'node/add/resource', array('attributes' => array('class' => 'add'), 'query'=>array('edit[field_instructors][und]'=>$variables['node']->nid,))) . '</div> </div>';
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
      $sifu_node = node_load($variables['node']->field_instructors['und'][0]['nid']);
      // Pull in linked name
      $sifu_name = l($sifu_node->title, 'node/' . $sifu_node->nid);
      $variables['head_instructor'] = $sifu_name;
    }
    if (!empty($variables['node']->field_school_lineage['und'][0]['tid'])) {
      $term_obj = taxonomy_term_load($variables['node']->field_school_lineage['und'][0]['tid']);
      // Pull in linked name
      $term_name = l($term_obj->name, 'taxonomy/term/' . $term_obj->tid);
      $variables['school_lineage'] = $term_name;
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
  // Add variables for article content type.
  if ($variables['node']->type == "article") {
    foreach ($variables['node']->field_related_images['und'] as $key => $img) {
      // Make sure there is actually an image before outputting
      if ($img['uri'] != NULL) {
        if ($key == 0) {
          // Print out main image
          $full_size = image_style_url('full-size', $img['uri']);
          $thumbnail = image_style_url('article-main-img', $img['uri']);
          // Output main sifu profile image with lightbox overlay
          $variables['article_main_image'] = '<a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[sifu]"><img class="sifu-image" src="'. $thumbnail . '" alt="' . $img['alt'] . '" /></a>';
          continue;
        }

        // Render additional images with lightbox
        $full_size = image_style_url('full-size', $img['uri']);
        $thumbnail = image_style_url('sifu-listing', $img['uri']);

        // Output a list of images with lightbox overlays
        $variables['article_images'] .= '<li><a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[sifu]"><img src="'. $thumbnail . '" alt="' . $img['data']['alt'] . '" /></a></li>';
      }
    }
//    $arg = arg(1);
//    $relvideo = $variables['node']->field_embeded_video[0]['video_url'];
//    $relatedvideo = '<a rel="lightframe[video|width:656; height:401;]" class="emvideo-thumbnail-replacement emvideo-modal-lightbox2 lightbox2 lightbox-processed emvideo-thumbnail-replacement-processed" title="Bruce Lee" href="/lakhan/ewingchun/emvideo/modal/9265/640/385/field_emvideo/youtube/QG2M9yVJ_s8"><span></span><img width="120" height="90" title="See video" alt="See video" src="http://img.youtube.com/vi/QG2M9yVJ_s8/0.jpg"></a>';
//    $variables['articlevideos'] = $relatedvideo;

//    foreach ($sifu_node->field_related_images['und'] as $key => $val) {
//      $full_size = image_style_url('full-size', $img['filepath']);
//      $thumbnail = image_style_url('article-images', $img['filepath']);
//      // Output a list of images with lightbox overlays
//      $variables['article_images'] .= '<li><a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[article]"><img src="'. $thumbnail . '" alt="' . $img['alt'] . '" /></a></li>';
//
//    }
//    $variables['related_sifu'] = $variables['node']->field_sifu['und'][0]['nid'];
//    if (isset($variables['node']->field_sifu['und'][0]['nid'])) {
//      // Pull in Sifu profile image
//      $sifu_node = $variables['node']->field_sifu['und'][0]['node'];
//      $sifu_img =  $sifu_node->field_profile_img['und'][0]['uri'];
//
//      // Pull in linked name
//      $full_size = image_style_url('full-size', $sifu_img);
//      $thumbnail = image_style_url('article-images', $sifu_img);
//
//      // Output imagecache with lightbox
//      $variables['sifu_img'] = '<div class="left"><a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[article]"><img src="'. $full_size . '" alt="' . $img['alt'] . '" /></a></div>';
//    }
    $otherbysifu = views_embed_view('article', 'block_1', $variables['node']->field_sifu['und'][0]['nid']);
    $variables['otherarticles'] = $otherbysifu;

    $relatedpro = views_embed_view('products', 'block_2', $variables['node']->field_sifu['und'][0]['nid']);
    $variables['relatedproducts'] = $relatedpro;

    $recentarticles = views_embed_view('article', 'block_5', $variables['node']->field_sifu['und'][0]['nid']);
    $variables['recent_articles'] = $recentarticles;

    $recentwiki = views_embed_view('wiki', 'block_4', $variables['node']->field_sifu['und'][0]['nid']);
    $variables['recent_wiki'] = $recentwiki;

    if ($variables['node']->field_emvideo['0']['embed'] != NULL) {
      foreach ($variables['node']->field_emvideo AS $key => $video) {
        $variables['article_videos'] .= $video['view'];
      }
    }
  }

  // Add variables for blogs.
  if ($variables['node']->type == 'blog') {
    $arg = arg(1);
    foreach ($variables['node']->field_image['und'] AS $key => $img) {
      // Check for an image before outputting
      if (isset($img['uri']) && $img['uri'] != NULL) {
        if ($key == 0) {
          // Print out main image
          $full_size = image_style_url('full-size', $img['uri']);
          $thumbnail = image_style_url('article-main-img', $img['uri']);

          // Output main sifu profile image with lightbox overlay
          $variables['article_image'] = '<a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[sifu]"><img src="'. $thumbnail . '" alt="' . $img['alt'] . '" /></a>';
          continue;
        }

        // Render additional images with lightbox
        $full_size = image_style_url('full-size', $img['uri']);
        $thumbnail = image_style_url('sifu-listing', $img['uri']);

        // Output a list of images with lightbox overlays
        $variables['article_images'] .= '<li><a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[sifu]"><img src="'. $thumbnail . '" alt="' . $img['alt'] . '" /></a></li>';
      }
    }

    // Check to see if the current UID belongs to Sifu role
    $sifu_users = db_query("SELECT uid from {users_roles} WHERE rid='6' AND uid=:uid", array(':uid' => $variables['node']->uid));
    $is_sifu = $sifu_users->fetchField();

    if (!empty($is_sifu)) {
      // Creating variable for sifu label
      $variables['sifu_label'] = '<span class=sifu>(' . t('Sifu') . ')</span>';
    }
   /* $relatedpro = views_embed_view('products', 'block_3', $arg);
    $variables['relatedproducts'] = $relatedpro;*/

    $recentarticles = views_embed_view('Blogs', 'block_3', $arg);
    $variables['recent_articles'] = $recentarticles;

    $otherblogs = views_embed_view('Blogs', 'block_4', $variables['node']->uid);
    $variables['otherblogsbyuser'] = $otherblogs;
  }

  //Add variables for wiki
  if ($variables['node']->type == 'wiki') {
    // Iterate over product image
    foreach ($variables['node']->field_wiki_images['und'] AS $key => $img) {
      // Check for an image before outputting
      if ($img['uri'] != NULL) {
        if ($key == 0) {
          // Print out main image
          $full_size = image_style_url('full-size', $img['uri']);
          $thumbnail = image_style_url('article-main-img', $img['uri']);

          // Output main wiki image with lightbox overlay
          $variables['wiki_image'] = '<a title="' . $img['alt'] . '" href="' . $full_size . '" rel="lightbox[product]"><img class="sifu-image" src="'. $thumbnail . '" alt="' . $img['alt'] . '" /></a>';
          continue;
        }
        // Render additional images with lightbox
        $full_size = image_style_url('full-size', $img['filepath']);
        $thumbnail = image_style_url('sifu-listing', $img['filepath']);

        // Output a list of images with lightbox overlays
        $variables['wiki_images'] .= '<li><a title="' . $img['data']['alt'] . '" href="' . $full_size . '" rel="lightbox[product]"><img src="'. $thumbnail . '" alt="' . $img['alt'] . '" /></a></li>';


      }
    }
  }

    //Add Variables for videos page.
    if ($variables['node']->type == 'video') {

        $variables['video_inner_ad'] = theme('blocks', 'video_ad');
        $recent_videos = '';
        $recent_videos_block = views_embed_view('videos', 'block_3', $arg);
        $recent_videos .= '<div class="recentvideos"> <p class="yca">recent videos</p> <div class="rcntvid">' . $recent_videos_block . '</div> <div class="videoaddbanner"> </div> </div>';
        $variables['recent'] = $recent_videos;

        // Videos block by sifu.
        $sifu_videos_block = views_embed_view('videos', 'block_4', $variables['node']->field_sifu['und'][0]['nid']);
        $sifu_videos = '<div class="recentvideos"> <p class="yca">Other videos by Sifu</p> <div class="rcntvid">' . $sifu_videos_block . '</div> <div class="videoaddbanner"> </div> </div>';
        $variables['videos_sifu'] =  $sifu_videos;


    }

}

/**
 * Returns the PRIMARY lineage for a single sifu.
 *
 */
function _wc_lineage_get_primary($node, $nid, $affilated) {
  if (empty($node)) {
    return;
  }

  $output = cache_get('wc-lineage-get-primary/' . $node->nid)->data;

  if (!$output) {

    $nids = array();
    $q = "SELECT n.nid, n.title AS name, i.field_noderef_instructor_nid AS instructor, i.delta, p.field_primary_lineage_value AS pri, a.field_int_stillaffiliated_value AS affiliated
          FROM node n
          LEFT JOIN field_data_field_lineage_information li ON li.entity_id = n.nid
          LEFT JOIN field_data_field_noderef_instructor i ON li.field_lineage_information_value = i.entity_id
          LEFT JOIN field_data_field_primary_lineage p ON i.entity_id = p.entity_id
          AND p.delta = i.delta
          LEFT JOIN field_data_field_int_stillaffiliated a ON p.entity_id = a.entity_id
          AND a.delta = i.delta
          WHERE li.entity_id = :nid
          AND a.bundle = 'field_lineage_information'
          AND i.bundle = 'field_lineage_information'
          AND p.bundle = 'field_lineage_information'
          ORDER BY pri DESC , affiliated DESC";
    $delta = array_search(array('value' => '1'), $node->field_primary_lineage);


    // Start with this node.
    $self = (object) array();
    $self->nid = $node->nid;
    $self->name = $node->title;
    $self->instructor = $nid;
    $self->pri = 1;
    $self->affiliated = $affilated;
    $lineages = array(0 => array($self));
    // Keep querying as long as we find referenced instructors.
    $nids = array();
    while ($sifu = db_query($q, array(':nid' => $nid))->fetchObject()) {
      if (in_array($sifu->nid, $nids)) {
        // Prevent getting stuck in an unclosed loop.
        // @TODO can this happen with fuill lineages?
        break;
      }
      else {
        $lineages[0][] = $sifu;
      }
      $nids[] = $sifu->nid;

      $nid = $sifu->instructor;
      if (!$sifu->pri && !$sifu->affiliated) {
        break;
      }
    }
    // We want to Display the oldest ancestors first, so we reverse here.
    $lineages[0] = array_reverse($lineages[0]);
    $output = '';
    foreach ($lineages AS $line) {
      $row = array();
      foreach ($line AS $sifu) {
        $row[] = l($sifu->name, 'node/' . $sifu->nid);
      }
      $row = implode(' > ', $row);
      if ($row) $output .= "<span class='lineage'>" . $row . "</span>\n";
    }
    cache_set('wc-lineage-get-primary/' . $node->nid, $output);
  }

  return $output;
}