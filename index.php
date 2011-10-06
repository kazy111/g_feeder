<?php
include dirname(__FILE__) . '/header.php';
include dirname(__FILE__) . '/index_content.php';


$GLOBALS['extra'] = '';//is_mobile() ? 'mobile_' : '';


$c = (array_key_exists('c', $_GET) && $_GET['c'] != '' ? addslashes($_GET['c']) : '');
$p = (array_key_exists('p', $_GET) && $_GET['p'] != '' && is_numeric($_GET['p']) ? addslashes($_GET['p']) : '0');


$page->set('index', display_list($extra, $c, $p));
$page->set_title(($c&&$c!='' ? $c.' - ' : '').$GLOBALS['site_title']);

include 'footer.php';

?>
