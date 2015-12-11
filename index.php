<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620" />
</head>
<body>

<?php
mysql_connect('localhost', 'spw', 'P@ssw0rd');
mysql_select_db('spw');
$key = $_GET['key'];
$array_member = array();

$query_me = mysql_query('SELECT * FROM `buddy` WHERE `token`="'.$key.'"');
$me = mysql_fetch_array($query_me);

if (empty($me['buddy'])) {
	$query_member = mysql_query('SELECT `id`, `name`, `img`, `buddy` FROM `buddy` WHERE `group` NOT LIKE '.$me['group'] .' ORDER BY `id` ASC');
	$query_member_selected = mysql_query('SELECT `id`, `buddy` FROM buddy WHERE `buddy` NOT LIKE 0');

	while ($member = mysql_fetch_array($query_member)) {
		$array_member[] = $member['id'];
	}	

	while ($member_selected = mysql_fetch_array($query_member_selected)){
		$key_value = array_search($member_selected['buddy'], $array_member);
		if ($key_value !== false) {
			unset($array_member[$key_value]);
		}
	}


	$random = array_rand($array_member, 1);
	$random = $array_member[$random];

	mysql_query('UPDATE `buddy` SET `buddy`='.$random.' WHERE `token`="'.$key.'"');
	
	$query_buddy = mysql_query('SELECT `img`, `name` FROM `buddy` WHERE buddy='.$me['buddy']);
        $buddy = mysql_fetch_array($query_buddy);
	echo 'You are '.$me['name'];
        echo 'Your Buddy is '.$buddy['name'].'<br/><br/><img src="img/'.$buddy['img'].'" />';	

} else {
	$query_buddy = mysql_query('SELECT `img`, `name` FROM `buddy` WHERE id='.$me['buddy']);
	$buddy = mysql_fetch_array($query_buddy);
	echo 'You are '.$me['name'];
	echo '<br/>Your Buddy is '.$buddy['name'].'<br/><br/><img src="img/'.$buddy['img'].'" />';
}




mysql_close();

?>

</body>
</html>
