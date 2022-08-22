<?php
// Error Reporting


include 'admin/connect.php';
/*
ini_set('display_errors', 'On');
error_reporting(E_ALL);

 */
$sessionUser = '';

if (isset($_SESSION['user'])) {
	$sessionUser = $_SESSION['user'];
}
	include 'connect.php';
//routs
$tbl  ='include/templates/';
$css  ='layout/css/';
$js   ='layout/js/';
$lang ='include/languages/';
$fun  ='include/functions/';

//important files
include $fun.'functions.php';
include $lang.'english.php';
include $tbl.'header.php';



	
	