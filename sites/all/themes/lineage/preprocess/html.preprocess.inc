<?php

/**
 * @file
 * Contains a pre-process hook for 'html'.
 */

/**
 * Implements hook_preprocess_html().
 */
function lineage_preprocess_html() {
  // Load the matchMedia polyfill.
  $path = drupal_get_path('theme', YOURTHEME);
  $options = array('group' => JS_THEME);
  drupal_add_js("$path/js/matchMedia.js", $options);
  drupal_add_js("$path/js/matchMedia.addListener.js", $options);

  // Load the mediaquery behavior from Omega. This allows registering media
  // queries via Drupal.settings to automatically print body classes based on
  // whether or not they currently apply.
  $omega = drupal_get_path('theme', 'omega');
  drupal_add_js("$omega/js/omega.mediaqueries.min.js", $options);

  // Register the media queries. The array keys will be used to compose the body
  // class names and the values are the actual media queries.
  drupal_add_js(array('omega' => array('mediaQueries' => array(
    'tablet' => 'all and (min-width: 700px)',
    'desktop' => 'all and (min-width: 900px)',
  ))), 'setting');
}