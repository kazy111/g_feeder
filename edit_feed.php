<?php
// TODO sanitize, validation

// TODO dropdown box of steamer

include './header.php';

// edit form & register
// if no id, create new entry

function get_form($id){
  global $manager;

  $name = '';
  $author = '';
  $site_url = '';
  $feed_url = '';

  if($id){
    // get info from DB
    $result = $manager->get_feed($id);
    if($result){
      $name = sanitize_html($result['name']);
      $author = sanitize_html($result['author']);
      $site_url = sanitize_html($result['site_url']);
      $feed_url = sanitize_html($result['feed_url']);
    }
  }

  // display form

  return <<< EOD
    <form method="POST">
      <input type="hidden" name="mode" value="1" />
      <input type="hidden" name="id" value="$id" />
      <span class="form_title">name:</span>
      <input type="edit" name="name" value="$name" /><br />
      <span class="form_title">author:</span>
      <input type="edit" name="author" value="$author" /><br />
      <span class="form_title">site_url:</span>
      <input type="edit" name="site_url" value="$site_url" size="100" /><br />
      <span class="form_title">feed_url:</span>
      <input type="edit" name="feed_url" value="$feed_url" size="100" /><br />
      <input type="submit" value="submit" />
    </form>
EOD;

}

function register_program(){
  global $_POST, $manager;

  $manager->set_feed($_POST);
}

$contents = '';
if ( array_key_exists('mode', $_POST) ) {
  // TODO validation
  // priority null check
  
  register_program();
  $contents .= '<span class="message">updated information</span>';
}

$contents .= get_form(get_key($_GET, 'id'));

print '<html><body>';
print $contents;
print '</body></html>';

?>
