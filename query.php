<?php

define('DRUPAL_ROOT', getcwd());

require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


$link = mysql_connect("localhost", "root", "mayank12");
mysql_select_db("drupal_jermy");

/* 
 * Add Destination
 * 
$query = "SELECT dest . * , th.parent, td.name as parent_name
FROM site_iyc_destination dest
LEFT JOIN term_hierarchy th ON dest.tid = th.tid
LEFT JOIN term_data td ON td.tid = th.parent
LIMIT 200, 50";
$result = mysql_query($query);
while ($row = mysql_fetch_object($result))
{
  $url = get_url($row->tid);

  if ($row->parent_name !='') {
    $parent_term = array_keys(taxonomy_get_term_by_name($row->parent_name));
  }
  
  $node = new stdClass();
  $node->type = "destination";
  $node->title = utf8_encode($row->name);
  $node->language = LANGUAGE_NONE;
  $node->path = array('alias' => $url);
  node_object_prepare($node);
  $node->uid = 1;
  $node->body[$node->language][0]['value'] = utf8_encode($row->body_upper);
  $node->body[$node->language][0]['format'] = 'filtered_html';
  $node->field_lower_title[$node->language][0]['value'] = utf8_encode($row->title_lower);
  $node->field_body_lower[$node->language][0]['value'] = utf8_encode($row->body_lower);
  $node->field_airport_for_weather[$node->language][0]['value'] = utf8_encode($row->airport);
  if (isset($parent_term)) {
    foreach ($parent_term as $key => $value) {
      $node->field_parent[$node->language][$key]['tid'] = $value;
    }
  }
  $node = node_submit($node); // Prepare node for a submit
  node_save($node);
}
*/




function get_page_title($nid) {
  $query = "SELECT page_title FROM page_title WHERE id = ".$nid;
  $result = mysql_query($query);
  while ($row = mysql_fetch_object($result))
  {
    return $row->page_title;
  }
}

/**
 * Add Boat Model
 */
/*
$query = "SELECT model . * , model.class as boat_class, td.description
FROM site_iyc_boat_model model
LEFT JOIN term_data td ON td.tid = model.tid
LIMIT 383 , 2";
$result = mysql_query($query);

while ($row = mysql_fetch_object($result))
{
  $url = get_url($row->tid);

  if ($row->boat_class !='') {
    $parent_term = array_keys(taxonomy_get_term_by_name($row->boat_class));
  }
  $node = new stdClass();
  $node->type = "boat_model";
  $node->title = utf8_encode($row->make).' '.utf8_encode($row->model);
  $node->language = LANGUAGE_NONE;
  $node->path = array('alias' => $url);
  node_object_prepare($node);
  $node->uid = 1;
  $node->body[$node->language][0]['value'] = utf8_encode($row->description);
  $node->body[$node->language][0]['format'] = 'filtered_html';
  $node->field_model[$node->language][0]['value'] = utf8_encode($row->model);
  $node->field_length[$node->language][0]['value'] = utf8_encode($row->length);
  if (isset($parent_term)) {
    foreach ($parent_term as $key => $value) {
      $node->field_class[$node->language][$key]['tid'] = $value;
    }
  }
  $node = node_submit($node); // Prepare node for a submit
  node_save($node);
  
  $last_id = array_keys(node_get_recent($number = 1));
    
  // Save taxonomy for this 
  $term = new stdClass();
  $term->name = utf8_encode($row->make).' '.utf8_encode($row->model);
  $term->vid = 4; 
  $term->field_node_id[LANGUAGE_NONE][0]['value'] = $last_id[0]; 
  taxonomy_term_save($term);
}*/

/**
 *  Import content of Boat offer
 */
/*

$query = "SELECT n.title, n.nid, nr.body, GROUP_CONCAT( td.name
SEPARATOR '&--&' ) AS term, n.created, offer . *
FROM site_iyc_boat_offer AS offer
LEFT JOIN node AS n ON n.nid = offer.nid
LEFT JOIN term_node tn ON tn.nid = n.nid
LEFT JOIN term_data td ON td.tid = tn.tid
LEFT JOIN node_revisions AS nr ON nr.nid = n.nid
WHERE n.type = 'site_iyc_boat_offer'
GROUP BY n.nid
LIMIT 3650, 50";

$result = mysql_query($query);

while ($row = mysql_fetch_object($result))
{
  $url = get_url($row->nid);
  $page_title = get_page_title($row->nid);
  $parent_term = array();
  if ($row->term !='') {
    $row_term = explode('&--&', $row->term);
    foreach ($row_term as $key => $value) {
      $term_data = taxonomy_get_term_by_name($value);
      $key = array_keys($term_data);
      if (!empty($term_data)) {
        if($term_data[$key[0]]->vid == 4) {
          $parent_term[4] = array_keys($term_data);
        } else {
          $parent_term[2] = array_keys($term_data);
        }
      }
    }
  }
  $node = new stdClass();
  $node->type = "boat_offer";
  $node->title = utf8_encode($row->title);
  $node->language = LANGUAGE_NONE;
  $node->path = array('alias' => $url);
  node_object_prepare($node);
  $node->uid = 1;
  if (isset($page_title) && !empty($page_title)) {
    $node->page_title = utf8_encode($page_title);
  }
  $node->body[$node->language][0]['value'] = utf8_encode($row->body);
  $node->body[$node->language][0]['format'] = 'filtered_html';
  $node->field_boat_name[$node->language][0]['value'] = utf8_encode($row->boat_name);
  $node->field_engine[$node->language][0]['value'] = utf8_encode($row->engine);
  $node->field_berths[$node->language][0]['value'] = utf8_encode($row->berths);
  $node->field_flag[$node->language][0]['value'] = utf8_encode($row->flag);
  $node->field_max_cruise[$node->language][0]['value'] = utf8_encode($row->max_cruise);
  $node->field_located[$node->language][0]['value'] = utf8_encode($row->located);
  $node->field_category[$node->language][0]['value'] = utf8_encode($row->category);
  $node->field_per_week_a[$node->language][0]['value'] = utf8_encode($row->price_a);
  $node->field_season_a[$node->language][0]['value'] = utf8_encode($row->season_a);
  $node->field_per_week_b[$node->language][0]['value'] = utf8_encode($row->price_b);
  $node->field_season_b[$node->language][0]['value'] = utf8_encode($row->season_b);
  $node->field_per_week_c[$node->language][0]['value'] = utf8_encode($row->price_c);
  $node->field_season_c[$node->language][0]['value'] = utf8_encode($row->season_c);
  $node->field_per_week_d[$node->language][0]['value'] = utf8_encode($row->price_d);
  $node->field_season_d[$node->language][0]['value'] = utf8_encode($row->season_d);
  $node->field_per_week_e[$node->language][0]['value'] = utf8_encode($row->price_e);
  $node->field_season_e[$node->language][0]['value'] = utf8_encode($row->season_e);
  $node->field_per_week_f[$node->language][0]['value'] = utf8_encode($row->price_f);
  $node->field_season_f[$node->language][0]['value'] = utf8_encode($row->season_f);
  $node->field_per_week_g[$node->language][0]['value'] = utf8_encode($row->price_g);
  $node->field_season_g[$node->language][0]['value'] = utf8_encode($row->season_g);
  $node->field_skipper[$node->language][0]['value'] = utf8_encode($row->skipper);
  $node->field_crew[$node->language][0]['value'] = utf8_encode($row->crew);
  $node->field_deposit[$node->language][0]['value'] = utf8_encode($row->deposit);
  $node->field_airport[$node->language][0]['value'] = utf8_encode($row->airport);
  $node->field_currency[$node->language][0]['value'] = utf8_encode($row->currency);
  $node->field_last_updated_season[$node->language][0]['value'] = utf8_encode($row->currency_update);
  $node->field_accomodation[$node->language][0]['value'] = utf8_encode($row->accomodation);

  if (isset($parent_term[2])) {
    foreach ($parent_term[2] as $key => $value) {
        $node->field_yacht_charter_destinations[$node->language][$key]['tid'] = $value;
    }
  }

  if (isset($parent_term[4])) {
    foreach ($parent_term[4] as $key => $value) {
      $node->field_yacht_models[$node->language][0]['tid'] = $value;
    }
  }
  $node = node_submit($node); // Prepare node for a submit
  node_save($node);
}
*/
/**
 * Import Image gallery taxonomy.
 */
/*
$query = "SELECT * FROM term_data WHERE vid = 4 LIMIT 200, 50";
$result = mysql_query($query);

while ($row = mysql_fetch_object($result))
{
  $path = array();
  $term = new stdClass();
  $term->name = utf8_encode($row->name);
  $term->vid = 5;
  $term->description = utf8_encode($row->description);
  taxonomy_term_save($term);
  $tid = db_query('SELECT MAX(tid) FROM {taxonomy_term_data}')->fetchField();
  $url = get_url($row->tid);
  $path['alias'] = trim($url);
  $path['source'] = 'taxonomy/term/' . $tid;
  $path['language'] = LANGUAGE_NONE;
  path_save($path);
}*/

/*
Image nid not inserted
Image nid
-----------
17744
15941
15918
15917
5008
4995
4990
4985
4980
4979
4978
4977
4976
4975
4968
4967
4966
4965
4965
3526
3219
3218
3217
3211
*/

/**
 * Import Image node.
 */

$query = "SELECT n.nid, nr.title, nr.body, f.filepath, GROUP_CONCAT( td.name
SEPARATOR '&--&' ) AS term
FROM node_revisions nr
LEFT JOIN node n ON n.nid = nr.nid
LEFT JOIN image img ON n.nid = img.nid
LEFT JOIN files f ON f.fid = img.fid
LEFT JOIN term_node tn ON tn.nid = img.nid
LEFT JOIN term_data td ON td.tid = tn.tid
WHERE n.type = 'image'
AND img.image_size = '_original'
GROUP BY img.nid
ORDER BY n.nid DESC
LIMIT 0 ,5";

$result = mysql_query($query);

while ($row = mysql_fetch_object($result))
{
  $url = get_url($row->nid);
  $page_title = get_page_title($row->nid);

  if ($row->term !='') {
    $row_term = explode('&--&', $row->term);
    foreach ($row_term as $key => $value) {
      $term_data = taxonomy_get_term_by_name($value);
      $key = array_keys($term_data);
      if (!empty($term_data)) {
        if($term_data[$key[0]]->vid == 4) {
          $parent_term[4] = array_keys($term_data);
        } else if ($term_data[$key[0]]->vid == 2) {
          $parent_term[2] = array_keys($term_data);
        } else {
          $parent_term[5] = array_keys($term_data);
        }
      }
    }
  }
  $node = new stdClass();
  $node->type = "image";
  $node->title = utf8_encode($row->title);
  $node->language = LANGUAGE_NONE;
  $node->path = array('alias' => $url);
  node_object_prepare($node);
  $node->uid = 1;
  if (isset($page_title)) {
    $node->page_title = utf8_encode($page_title);
  }
  $node->body[$node->language][0]['value'] = utf8_encode($row->body);
  $node->body[$node->language][0]['format'] = 'filtered_html';
  if (isset($parent_term)) {
    foreach ($parent_term as $key => $value) {
      foreach ($value as $val) {
        $node->field_yacht_models[$node->language][$key]['tid'] = $val;
      }
    }
  }

  if (isset($parent_term)) {
    foreach ($parent_term as $key => $value) {
      foreach ($value as $val) {
        $node->field_yacht_charter_destinations[$node->language][$key]['tid'] = $val;
      }
    }
  }

  if (isset($parent_term)) {
    foreach ($parent_term as $key => $value) {
      foreach ($value as $val) {
        $node->field_image_galleries[$node->language][$key]['tid'] = $val;
      }
    }
  }
  
  $filepath = drupal_realpath('/var/www/'.$row->filepath);
  if (isset($filepath)) {
    $file = (object) array(
      'uid' => 1,
      'uri' => $filepath,
      'filemime' => file_get_mimetype($filepath),
      'status' => 1,
    );
    //$file = file_copy($file, 'public://');
    $node->field_image[LANGUAGE_NONE][0] = (array)$file;
  }

  $node = node_submit($node); // Prepare node for a submit
  node_save($node);
}


function get_url($nid) {
  $query = "SELECT dst FROM url_alias WHERE src = 'node/".$nid."'";
  $result = mysql_query($query);
  while ($row = mysql_fetch_object($result))
  {
    return $row->dst;
  }
}


/*
$select = db_select('taxonomy_index', 'ti');
$select->join('node', 'n', 'n.nid = ti.nid');
$select->condition('ti.tid', 1653, '=');
$select->fields('ti',array('nid'));
$select->fields('n',array('type'));
$select->range(0, 1);
$query = $select->execute();
$result = $query->fetchAll();
print_r($result);exit;
*/
/*foreach ($result as $key => $value) {
  $node = node_load($value->nid);
  $node->field_yacht_charter_destinations[$node->language][$key]['tid'] = 2453;
  node_save($node);
}*/

/**
 * Node Delete
 */
 /*
$result= db_query("SELECT nid FROM {node} AS n WHERE n.type = 'image'");
foreach ($result as $record) {
  node_delete($record->nid);
}
*/