<?php
include_once 'IDataManager.php';
include_once 'PostgreSQLDB.php';

class PostgreSQLDataManager implements IDataManager {
  private $db;

  function __construct($db_host, $db_name, $db_user, $db_passwd){
    $this->db = new PostgreSQLDB($db_host, $db_name, $db_user, $db_passwd);
  }

  function sanitize($str){
    return $this->db->sanitize($str);
  }

  function query($sql){
    return $this->db->query($sql);
  }


  function get_item($id){
    return $this->db->query_ex('select uid, title, description, body, permalink, date, category from item_table where id = '.$id);
  }
  function get_feed($id){
    return $this->db->query_ex('select name, author, site_url, feed_url from feed_table where id = '.$id);
  }
  
  function get_items($category = NULL, $pagesize = NULL, $page = 0){
    $now = time();
    $sql = 'select i.id, i.uid, i.description, i.title, i.body, i.permalink, i.date, i.category, f.name, f.author, f.site_url, f.feed_url from item_table as i '
      . ' left join feed_table as f on i.feed_id = f.id '
        .' where date <= '.$now;
    if($category)
      $sql .= ' and category = \''.$category.'\'';
    $sql .=' order by date desc';
    if($pagesize)
      $sql .= ' limit '.$pagesize.' offset '.($pagesize * $page).';';
    $result = $this->db->query($sql);
    $list = array();
    while(($arr = $this->db->fetch($result)) != NULL ){
      $list[] = $arr;
    }
    return $list;
  }
  
  function get_feeds($pagesize = NULL, $page = 0){
    $sql = 'select f.id, name, author, site_url, feed_url, MAX(i.date) as lastdate from feed_table as f '
          .' left join item_table as i on f.id = i.feed_id '
          .' where i.date IS NULL or i.date <='.time()
          .' group by f.id, f.name, f.author, f.site_url, f.feed_url'
          .' order by MAX(i.date) desc';
    if($pagesize)
      $sql .= ' limit '.$pagesize.' offset '.($pagesize * $page).';';
    $result = $this->db->query($sql);
    $list = array();
    while(($arr = $this->db->fetch($result)) != NULL ){
      $list[] = $arr;
    }
    return $list;
  }

  function get_categories(){
    
    $sql = 'select category, COUNT(id) AS count, MAX(date) AS lastdate from item_table where category <> \'\' '
          .' and date <= '.time()
          .' group by category';
    $result = $this->db->query($sql);
    $list = array();
    while(($arr = $this->db->fetch($result)) != NULL ){
      $list[] = $arr;
    }
    return $list;
  }

  function is_exist_item($uid){
    $ret = $this->db->query_ex('select id, date from item_table where uid = \''.$uid.'\'');
    return ($ret && array_key_exists('id', $ret)) ? $ret : FALSE;
  }

  function set_item($data){
    if(!array_key_exists('id', $data) || $data['id'] == '' || !is_numeric($data['id'])){
      // create
      $this->db->query('insert into item_table (feed_id, uid, title, body, permalink, date, category, description) values ('
                       .$data['feed_id'].', \''.$data['uid'].'\', \''.$data['title'].'\', \''.$data['body'].'\', \''
                       .$data['permalink'].'\', '.$data['date'].', \''.$data['category'].'\', \''.$data['description'].'\')');
    } else {
      $this->db->query('update item_table set title = \''.$data['title'].'\', body = \''
                       .$data['body'].'\', permalink = \''.$data['permalink'].'\', uid = \''
                       .$data['uid'].'\', category = \''.$data['category'].'\', date = '.$data['date']
                       .', description = \''.$data['description'].'\' '
                       .' where id='.$data['id']);
    }
  }

  function set_feed($data){
    if(!array_key_exists('id', $data) || $data['id'] == '' || !is_numeric($data['id'])){
      // create
      $this->db->query('insert into feed_table (name, author, site_url, feed_url) values (\''
                       .$data['name'].'\', \''.$data['author'].'\', \''.$data['site_url'].'\', \''
                       .$data['feed_url'].'\')');
    } else {
      $this->db->query('update feed_table set name = \''.$data['name'].'\', author = \''
                       .$data['author'].'\', site_url = \''.$data['site_url'].'\', feed_url = \''
                       .$data['feed_url'].'\' where id='.$data['id']);
    }
  }

  function delete_item($id){
    $this->db->query('delete from item_table where id = '.$id);
  }
  
  function delete_feed($id){
    $this->db->query('delete from feed_table where id = '.$id);
  }
  
  
  function try_query($sql){
    if( $this->db->query($sql) ){
      print '<b>success:</b> '.$sql."<br>\n";
    }else{
      print '<span style="color: red;"><b>fail:</b> '.$sql."</span><br>\n";
    }
  }
  
  function initialize_db() {
    $this->try_query('CREATE TABLE feed_table ('
                     .'id SERIAL NOT NULL,'
                     .'name VARCHAR(255),'
                     .'author VARCHAR(255),'
                     .'description TEXT,'
                     .'site_url VARCHAR(255),'
                     .'feed_url VARCHAR(255),'
                     .'PRIMARY KEY (id))');

    $this->try_query('CREATE TABLE item_table ('
                     .'id SERIAL NOT NULL,'
                     .'uid TEXT NOT NULL,'
                     .'feed_id INT NOT NULL,'
                     .'title TEXT NOT NULL,'
                     .'permalink TEXT NOT NULL,'
                     .'description TEXT NOT NULL,'
                     .'body TEXT NOT NULL,'
                     .'date BIGINT NOT NULL,'
                     .'category VARCHAR(255) NOT NULL DEFAULT \'\','
                     .'PRIMARY KEY(id))');

  }
  
  function delete_db(){
    $this->try_query('drop table feed_table;');
    $this->try_query('drop table item_table;');
  }
  
}

?>
