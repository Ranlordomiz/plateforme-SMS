<?php

require_once('RecupConf.php');
require_once('Database.php');

// Get all info from conf file
$conf = new RecupConf();

// Database class (connection and requests)
$database = new Database($conf->getDbName(), $conf->getDbLogin(), $conf->getDbPasswd());

if($database->count("user", "*", "number", "+".trim($_GET['number'])) > 0 ){

	$name = $database->select("user", "name", "number", "+".trim($_GET['number']));
	echo $name[0];

}
else{

        echo "-1";

}

?>
