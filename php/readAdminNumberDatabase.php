<?php

require_once('RecupConf.php');
require_once('Database.php');

// Get all info from conf file
$conf = new RecupConf();

// Database class (connection and requests)
$database = new Database($conf->getDbName(), $conf->getDbLogin(), $conf->getDbPasswd());

$admin = $database->select("user", "number", "rights", "0");
echo $admin[0];

?>
