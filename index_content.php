<?php

include dirname(__FILE__) . '/classes/TagCloud.php';

// function 

function display_list($extra, $c = NULL, $p = '0')
{
  global $page, $manager;

  $cat_data = $manager->get_categories();

  $tags = new HTML_TagCloud();
  foreach($cat_data as $cat){
    $tags->addElement($cat['category'], '?c='.urlencode($cat['category']), $cat['count'], $cat['lastdate']);
  }


  // construct main item output
  $contents_item = '';

  $item_data = $manager->get_items($c, $GLOBALS['page_size'], $p);

  foreach($item_data as $arr){

    $arr['description'] = mb_strimwidth($arr['description'], 0, 400, '...', 'UTF8');
    $arr['category_url'] = '?c='.urlencode($arr['category']);
    $arr['org_url'] = $arr['site_url'];
    $arr['date_rfc'] = date(DATE_RFC2822, $arr['date']);
    $arr['date'] = strftime('%Y/%m/%d(%a) %H:%M:%S', $arr['date']);
    $contents_item .= $page->get_once($extra.'article', $arr);
  }


  // construct feed output
  $feed_data = $manager->get_feeds();

  $contents_feed = '<ol>';
  foreach($feed_data as $arr){
    $arr['org_url'] = $arr['site_url'];
    $arr['lastdate'] = strftime('%Y/%m/%d(%a) %H:%M:%S', $arr['lastdate']);
    $contents_feed .= $page->get_once($extra.'feed', $arr);

  }
  $contents_feed .= '</ol>';



  // construct theme select box
  $contents_theme = '<select id="theme">';
  $themes = $page->get_themes();
  foreach($themes as $t){
    $contents_theme .= '<option value="'.urlencode($t).'"'.(($t == $page->theme)?' selected="selected"':'').'>'.$t.'</option>';
  }
  $contents_theme .= '</select>'
    .'<input type="button" value="変更" onclick="WriteCookie(\'theme\', document.getElementById(\'theme\').options[document.getElementById(\'theme\').selectedIndex].value, 90);location.reload();" />';


  // construct navigation
  $navigate = '';
  if($p > 0) {
    $navigate .= '<a href="?p='.($p-1);
    if($c && $c != '')
      $navigate .= '&amp;c='.$c;
    $navigate .= '">&lt;=Prev</a>';
  }
  if(count($item_data) >= $GLOBALS['page_size']) {
    $navigate .= '<a href="?p='.($p+1);
    if($c && $c != '')
      $navigate .= '&amp;c='.$c;
    $navigate .= '">Next=&gt;</a>';
  }



  $data = new Dwoo_Data();

  $data->assign('item_data', $contents_item);
  $data->assign('feed_data', $contents_feed);
  $data->assign('navigate_data', $navigate);
  $data->assign('tagcloud_data', $tags->buildHTML());
  $data->assign('theme_data', $contents_theme);

  return $data;
}



?>
