<?php

/* Database config */

$db_host		= 'todolistdb.cye2rtsyfggv.us-east-1.rds.amazonaws.com';
$db_user		= 'root';
$db_pass		= 'poop16';
$db_database	= 'todolist'; 

/* End config */


$link = @mysql_connect($db_host,$db_user,$db_pass) or die('Unable to establish a DB connection');

mysql_set_charset('utf8'); //what's this do? - Rich
mysql_select_db($db_database,$link);

?>