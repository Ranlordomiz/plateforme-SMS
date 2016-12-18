<?php

class RecupConf{

	// login for database
	private $dbName;
	private $dbLogin;
	private $dbPasswd;


	/*
	 *
	 *	RecupConf constructor (recup on file with regex)
	 *
	 */
	function RecupConf(){

		// Regex for conf.txt file
		$reConf = "/(.*)=\"(.*)\"/";
		$this->readFile($reConf);

	}


	/*
	 *
	 *	Read the conf file and recup data
	 *
	 */
	function readFile($reConf){

		$file = fopen("conf.txt", "r");
		if ($file) {

			$test = 0;

		    while (($line = fgets($file)) !== false) {

		        // process the line read.
		    	preg_match($reConf, $line, $matches);
		    	if($test == 0)
		    		$this->dbName = $matches[2];
		    	else if($test == 1)
		    		$this->dbLogin = $matches[2];
		    	else if($test == 2)
		    		$this->dbPasswd = $matches[2];
		    	$test++;

		    }

		    fclose($file);

		} else {

		    // error opening the file.
			exit("ERROR can't open file");

		}
	}


	/*
	 *
	 *	Get dbName
	 *
	 */
	function getDbName(){

		return $this->dbName;

	}


	/*
	 *
	 *	Get dbLogin
	 *
	 */
	function getDbLogin(){

		return $this->dbLogin;

	}


	/*
	 *
	 *	Get dbPasswd
	 *
	 */
	function getDbPasswd(){

		return $this->dbPasswd;

	}

}

?>
