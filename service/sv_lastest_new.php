<?php
require_once 'database.php';

$query = 'SELECT id,title,brief FROM tbl_news ORDER BY date DESC LIMIT 5';

$db = new db_query($query);
$data = array();
while ($row = mysql_fetch_assoc($db->result)) {
	$data[] = $row;
}
unset($db);

if (!empty($data)) {
	print json_encode($data);
}











