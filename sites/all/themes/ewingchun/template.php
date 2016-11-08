<?php

/**
 * @file
 * Template overrides as well as (pre-)process and alter hooks for the
 * ewingchun theme.
 */
function ewingchun_preprocess_node(&$variables) {
  if ($variables['node']->type == 'sifu') {
    foreach ($variables['node']->field_profile_img['und'] AS $key => $img) {
      print_r($img);die();
      // Check for an image before outputting
      if ($img['filepath'] != NULL) {
        if ($key == 0) {
          // Print out main image
          $full_size = image_style_url('full-size', $img['uri']);
          $thumbnail = image_style_url('article-main-img', $img['uri']);

          // Output main sifu profile image with lightbox overlay
          $vars['sifu_image'] = '<a title="' . $img['data']['alt'] . '" href="' . $full_size . '" rel="lightbox[sifu]"><img src="'. $thumbnail . '" alt="' . $img['data']['alt'] . '" /></a>';
          continue;
        }

        // Render additional images with lightbox
        $full_size = image_style_url('full-size', $img['uri']);
        $thumbnail = image_style_url('sifu-listing', $img['uri']);

        // Output a list of images with lightbox overlays
        $vars['sifu_images'] .= '<li><a title="' . $img['data']['alt'] . '" href="' . $full_size . '" rel="lightbox[sifu]"><img src="'. $thumbnail . '" alt="' . $img['data']['alt'] . '" /></a></li>';
      }
    }
  }
}