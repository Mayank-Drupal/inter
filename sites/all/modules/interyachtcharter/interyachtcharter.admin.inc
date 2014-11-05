<?php

/**
 * @file
 * Contains menu callbacks for interyachtcharter_gallery admin pages.
 */

/**
 * Menu callback for settings page.
 */
function interyachtcharter_admin_image_gallery() {
  $tree = taxonomy_get_tree(5);
  $rows = array();
  if ($tree) {
    $header = array(t('Name'), t('Operations'));
    foreach ($tree as $term) {
      $rows[] = array(str_repeat(' -- ', $term->depth) . ' ' . l($term->name, "taxonomy/term/$term->tid"), l(t('edit gallery'), "admin/structure/image/edit/$term->tid"));
    }
    return theme('table', array('header' => $header, 'rows' => $rows ));
  }
  else {
    return t('No galleries available');
  }
}

/**
 * Menu callback for editing or adding a gallery.
 */
function interyachtcharter_admin_edit($tid = NULL) {
  if (is_numeric($tid)) {
    $edit = (array) taxonomy_term_load($tid);
  } else {
    $edit = array();
  }

  if ($vocabulary = taxonomy_vocabulary_machine_name_load('image_galleries')) {
    module_load_include('inc', 'taxonomy', 'taxonomy.admin');
    $taxonomy_form = drupal_get_form('taxonomy_form_term', $edit ,$vocabulary);
  }
  return drupal_render($taxonomy_form);
}
