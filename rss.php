<?php
include dirname(__FILE__) . '/header.php';
include dirname(__FILE__) . '/index_content.php';

$page->theme = '_rss';
$page->set('index', display_list(''));

include 'footer.php';
?>
