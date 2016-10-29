<?php

/**
 * @file
 * Contains a pre-process hook for 'page'.
 */

/**
 * Implements hook_preprocess_page().
 */
function lineage_preprocess_page(&$variables, $hook) {
  if ($variables['node']->type == 'sifu') {
    $node = $variables['node'];
    $node->path = url("node/$node->nid");
    $lineage = array(get_lineage_link($node));

    $item = field_get_items('node', $node, 'field_noderef_instructor');

    while (isset($item[0]['nid'])) {
        $item_node = node_load($item[0]['nid']);
        $lineage[] = get_lineage_link($item_node);
        $item = field_get_items('node', $item_node, 'field_noderef_instructor');
    }
    $node->lineage = implode(' > ', array_reverse($lineage));
  }
  // Remove the 'page' class from the attributes array.
  $variables['attributes_array']['class'] = array_diff($variables['attributes_array']['class'], array(drupal_html_class($hook)));

  if ($layout = omega_layout()) {
    foreach ($layout['info']['regions'] as $region => $name) {
      if (!isset($variables['page'][$region])) {
        $variables['page'][$region] = array();
      }
    }

    $original = system_region_list($GLOBALS['theme_key'], REGIONS_VISIBLE);
    foreach (array_diff_key($original, $layout['info']['regions']) as $region => $name) {
      unset($variables['page'][$region]);
    }
  }
}
