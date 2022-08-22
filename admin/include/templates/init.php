<?php

	include '../../connect.php';
//routs
$tbl='../templates/';
$css='../../layout/css/';
$js='../../layout/js/';
$lang='../languages/';
$fun='../functions/';

//important files
include $fun.'functions.php';
include $lang.'english.php';
include $tbl.'header.php';
include $tbl.'footer.php';

if(!isset($nonavbar)){
	include $tbl.'navbar.php';
}
	
	