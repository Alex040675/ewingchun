<?php
// You can use preprocess hooks to modify the variables before they are passed
// to the theme function or template file.
//
///**
// * Implements hook_preprocess_page().
// */
/**
 * @param $variables
 */
function ewingchun_preprocess_page(&$variables) {
    global $user;
    // Move some variables to the top level for themer convenience and template cleanliness.
    $variables['show_messages'] = $variables['page']['#show_messages'];
    foreach (system_region_list($GLOBALS['theme'], REGIONS_ALL, FALSE) as $region_key) {
      if (!isset($variables['page'][$region_key])) {
        $variables['page'][$region_key] = array();
      }
      if ($region_content = drupal_get_region_content($region_key)) {
        $variables['page'][$region_key][]['#markup'] = $region_content;
      }
    }

    // Set up layout variable.
    $variables['layout'] = 'none';
    if (!empty($variables['page']['sidebar_first'])) {
      $variables['layout'] = 'first';
    }
    if (!empty($variables['page']['sidebar_second'])) {
      $variables['layout'] = ($variables['layout'] == 'first') ? 'both' : 'second';
    }

    $variables['base_path']         = base_path();
    $variables['front_page']        = url();
    $variables['feed_icons']        = drupal_get_feeds();
    $variables['language']          = $GLOBALS['language'];
    $variables['language']->dir     = $GLOBALS['language']->direction ? 'rtl' : 'ltr';
    $variables['logo']              = theme_get_setting('logo');
    $variables['main_menu']         = theme_get_setting('toggle_main_menu') ? menu_main_menu() : array();
    $variables['secondary_menu']    = theme_get_setting('toggle_secondary_menu') ? menu_secondary_menu() : array();
    $variables['action_links']      = menu_local_actions();
    $variables['site_name']         = (theme_get_setting('toggle_name') ? filter_xss_admin(variable_get('site_name', 'Drupal')) : '');
    $variables['site_slogan']       = (theme_get_setting('toggle_slogan') ? filter_xss_admin(variable_get('site_slogan', '')) : '');
    $variables['tabs']              = menu_local_tabs();

    if ($node = menu_get_object()) {
      $variables['node'] = $node;
    }

    // Populate the page template suggestions.
    if ($suggestions = theme_get_suggestions(arg(), 'page')) {
      $variables['theme_hook_suggestions'] = $suggestions;
    }
//  Added login form for anonym if add node
//    global $user;
//    if (($variables['node']->nid) and ($variables['node']->nid == '166') and ($variables['user']->uid) == '0') {
//      $variables['page']['content']['system_main'][] = drupal_get_form('user_login');
//    }
//  Changes ../user/..
  if ((arg(0) == 'user') and ($variables['page']['content']['system_main']['user_relationships_ui'])) {
    $variables['page']['content']['system_main']['user_relationships_ui']['#title'] = '';
    $variables['page']['content']['system_main']['user_relationships_ui']['actions']['#title'] = '';
  }
// Delete  modules/field/modules/text/text.js from summary field. The summary field is constantly disclosed
  if (arg(0) == 'node') {
    if (arg(1) == 'add' or (arg(2) == 'edit')) {
      if ($variables['page']['content']['system_main']['body']['und'][0]['summary']) {
        $variables['page']['content']['system_main']['body']['und'][0]['summary']['#attached'] = '';
      }
    }
  }
//  Added text to node
  if ((arg(0) == 'node') and (arg(2) == 'edit')) {
    if ($variables['node']->revision_timestamp) {
      $variables['time_revision'] = format_date($variables['node']->revision_timestamp, $type = 'short');
    }
    if ($variables['node']->revision_uid) {
      $rev_uid = $variables['node']->revision_uid;
      $query = db_select('users', 'u');
      $query
        ->condition('uid', $rev_uid)
        ->fields('u', array('name'));
      $result = $query->execute();
      foreach ($result as $row) {
        $variables['revision_name'] = $row;
      }
    }
  }
  if ((arg(0) == 'node') and ($variables['node']->type == 'article') and arg(2)== NULL and ($variables['node']->revision_timestamp)) {
    $variables['article_node_messages'] = t('This post has one or more pending revisions: ') . l('view list of revisions', 'node/' . $variables['node']->nid . '/revisions', array('html' => true));
  }
  if ((arg(0) == 'node') and (arg(2) == 'revisions')) {
    $variables['revision_node_messages'] = t('The revisions let you track differences between multiple versions of a post.');
  }
  if ((arg(0) == 'node') and arg(2) == 'outline') {
    $variables['outline_node_messages'] = t('The outline feature allows you to include posts in the ') . l('book hierarchy', '/book') . t(', as well as move them within the hierarchy or to ') . l('reorder an entire book', '/admin/content/book');
  }
  // Added logout block for registered user
  if (($user->uid !== '0') and $variables['logged_in']) {
    $variables['logout_block']['#markup'] = "<div class='logout_block'>" . t('Welcome, ') . "<a href=/user/" . $user->uid . ">" . $user->name . "</a>" . " | " . "<a href='/user/logout'>Logout</a></div>";
  }
//  Tabs only for admin
  if (!$variables['is_admin']) {
    if ($variables['tabs']) {
      $variables['tabs'] = [];
    }
  }
}