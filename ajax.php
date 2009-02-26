<?php


$file = str_replace('\\','/',__FILE__);
$file = explode('wp-content',$file);
$file = $file[0];
require_once($file.'wp-config.php');
require_once($file.'wp-includes/wp-db.php');

$wpdb = new wpdb(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

require_once('./starbox.php');


$data['vote'] = $_POST['rate'] ;
$data['object_id'] = $_POST['id'];

$data['ip'] = $_SERVER['REMOTE_ADDR'] ;
$data = add_magic_quotes($data);

$fields = array_keys($data);

$q = "INSERT INTO " . $starbox->table . " (`" . implode('`,`',$fields) . "`) VALUES ('".implode("','",$data)."')" ;

$wpdb->query($q);

echo get_post_star($_POST['id']) ;

?>
