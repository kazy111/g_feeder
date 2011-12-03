<?php

include_once('./header.php');


function pull_rss($feed_obj){
  global $manager;

  $url= $feed_obj['feed_url'];
  print $url;
  // Create a new instance of the SimplePie object
  $feed = new SimplePie();
  $xmldump = FALSE;
  
  // Use the URL that was passed to the page in SimplePie
  $feed->set_feed_url($url);

  $feed->set_cache_duration(1800);

  // XML dump
  $feed->enable_xml_dump(FALSE);

  // Don't strip any tags 
  $feed->strip_htmltags(false);

  // Allow us to change the input encoding from the URL string if we want to. (optional)
  if (!empty($_GET['input'])) {
      $feed->set_input_encoding($_GET['input']);
  }

  // Allow us to cache images in feeds.  This will also bypass any hotlink blocking put in place by the website.
  if (!empty($_GET['image']) && $_GET['image'] == 'true') {
    $feed->set_image_handler('./handler_image.php');
  }

  // We'll enable the discovering and caching of favicons.
  $feed->set_favicon_handler('./handler_image.php');

  // Initialize the whole SimplePie object.  Read the feed, process it, parse it, cache it, and 
  // all that other good stuff.  The feed's information will not be available to SimplePie before 
  // this is called.
  $success = $feed->init();

  // We'll make sure that the right content type and character encoding gets set automatically.
  // This function will grab the proper character encoding, as well as set the content type to text/html.
  $feed->handle_content_type();

  if($success) {
    // TODO Update Feed info
//    if (!$favicon = $feed->get_favicon()){
//      $favicon = './for_the_demo/favicons/alternate.png';
//    }

    foreach($feed->get_items() as $item) {

      $data = Array();
      $data['feed_id'] = $feed_obj['id'];
      $data['title'] = addslashes(trim($item->get_title()));
      $data['body'] = addslashes(trim($item->get_content()));
      $data['description'] = addslashes(strip_tags(trim(mb_convert_kana($item->get_description(),'s'))));

      $cat = $item->get_category();
      $data['category'] = $cat ? $cat->get_label() : '';
      $data['uid'] = $item->get_id();
      $data['permalink'] = $item->get_permalink();
      $data['date'] = $item->get_date('U');

      $flag = TRUE;

      // already exists
      $info_tmp = $manager->is_exist_item($data['uid']);
      if($info_tmp){
        if((int)$info_tmp['date'] < (int)$data['date']) {
          $data['id'] = $info_tmp['id'];
        }else{
          $flag = FALSE;
        }
      }
      
      // NG title
      $flag &= !preg_match('/^PR\: /', $data['title']);

      if($flag){
        print(''.$data['title'].'<br/>');
        $manager->set_item($data);
      }


    }
  }
}

$list = $manager->get_feeds();
print_r($list);
foreach($list as $f){
  pull_rss($f);
}

?>

