<?php
$dsn='mysql:host=localhost;dbname=shop';

$user='root';
$pass='';
$option=array(
	PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8',
);

try {

	$db=new PDO($dsn,$user,$pass,$option);
	$db->setattribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	//echo "you are conected";
	
} 
catch (PDOException $e) {
	echo"faild".$e->getMessage();
	
}
?>