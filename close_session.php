<?php

session_start();

if(isset($_SESSION['pseudo'])){
	unset($_SESSION['pseudo']);
}

if(isset($_SESSION['passwd'])){
	unset($_SESSION['passwd']);
}

?>

