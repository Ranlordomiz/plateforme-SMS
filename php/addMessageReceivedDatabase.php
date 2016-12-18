<?php

require_once('RecupConf.php');
require_once('Database.php');

// Get all info from conf file
$conf = new RecupConf();

// Database class (connection and requests)
$database = new Database($conf->getDbName(), $conf->getDbLogin(), $conf->getDbPasswd());

$database->insertInto("receivedMessage", "", $_GET['userId'], utf8_decode($_GET['message']), date("Y-m-d H:i:s"));

?>
