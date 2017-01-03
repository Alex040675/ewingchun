<?php
/**
 * @file Main relationships listing block
 * List the relationships between the viewed user and the current user
 */
if ($relationships) {
  $the_other_uid = $settings->block_type == UR_BLOCK_MY ? $user->uid : $account->uid;
  $showing_all_types = $settings->rtid == UR_BLOCK_ALL_TYPES;
  $rows = array();
  foreach ($relationships as $rtid => $relationship) {
    if ($the_other_uid == $relationship->requester_id) {
      $rtype_heading = $relationship->is_oneway ?
        t("@rel_name of", user_relationships_type_translations($relationship)) :
        t("@rel_plural_name", user_relationships_type_translations($relationship, TRUE));
      $relatee = $relationship->requestee;
    }
    else {
      $rtype_heading = t("@rel_plural_name", user_relationships_type_translations($relationship));
      $relatee = $relationship->requester;
    }

    $title = $rtype_heading;
    $rows[$title][] = $relatee;
  }

  $output = "<ul class='friends'>";
  foreach ($rows as $title => $users) {
    if ($users[0]->picture > 0) {
      $file = file_load($users[0]->picture);
      $output .=  "<li><img src='" . image_style_url('user_comment', $file->uri) . "' /> " . l($users[0]->name, 'user/' . $users[0]->uid) . "</li>";
    } else {
      $output .=  "<li><img src='" . image_style_url('user_comment', file_build_uri(variable_get('user_picture_default'))) . "'/>" . l($users[0]->name, 'user/' . $users[0]->uid) . "</li>";
    }
  }

  print $output;
}
/* removing printing out empty placeholder so the block is hidden when no data
// No relationships so figure out how we present that
else {
  if ($settings->rtid == UR_BLOCK_ALL_TYPES) {
    $rtype_name = 'relationships';
  }
  else {
    $rtype      = user_relationships_type_load($settings->rtid);
    $rtype_name = $rtype->plural_name;
  }

  if ($account->uid == $user->uid) {
    print t('You have no @rels', array('@rels' => $rtype_name));
  }
  else {
    print t('!name has no @rels', array('!name' => theme('username', $account), '@rels' => $rtype_name));
  }
}
*/
?>
