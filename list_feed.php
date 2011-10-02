<?php
include './header.php';


$list = $manager->get_feeds();

// construct streamer output
$contents_item = '';


foreach($list as $arr){
  $contents_item .= '<li><a href="edit_feed.php?id='.$arr['id'].'">'.$arr['name'].'</a>'
    .' <a href="delete_feed.php?id='.$arr['id'].'">del</a></li>';
}


print '<html><body>';
print '<a href="edit_feed.php">new</a>';
print '<ol>';
print $contents_item;
print '</ol></body></html>';


?>
