<?php
function print_tittle(){
    global $pagetittele;
    if(isset($pagetittele)){
        echo $pagetittele;
    }
    else{
        echo'default';
    }
    
 
}
//get info
function getAllFrom($field, $table,  $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {

    global $db;

    $getAll = $db->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

    $getAll->execute();

    $all = $getAll->fetchAll();

    return $all;

}
//check activate
function checkuserstatus($user){
    global $db;

        $stmt=$db->prepare("SELECT user_name , red_stauts  FROM users WHERE user_name=? AND red_stauts=0  ");
        $stmt->execute(array($user));
		$row=$stmt->fetch();
		$count=$stmt->rowCount();
        return $count;
}



//redirect
function redirect_home ($msg ,$url=null,$secondes=3){
    if($url===null){
        $url='index.php';
        $link='hompage';
    }
    else{
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!=''){
            $url=$_SERVER['HTTP_REFERER'];
            $link='previos page';
        }
        else{
            $url='index.php';
            $link='hompage';
        }
    }
    echo $msg;
    
    echo "<div class='alert alert-success'>you will by redirect to $link after $secondes secondes </div>";

   header("refresh:$secondes ;url=$url");
   exit();
} 

//check
function checkitem($select,$from, $value){
    global $db;
   $stmt2=$db->prepare("SELECT $select FROM $from WHERE $select=?");
   $stmt2->execute(array($value));
   $count=$stmt2->rowCount();
   return $count;
}
  
//cont items
function count_item($items , $tabel){
    global $db;
    $stmt=$db->prepare("SELECT COUNT($items) from $tabel");
    $stmt->execute();
    return $stmt->fetchColumn(); 

}

//get latest items
function get_latest_items($select,$from, $orde,$limit=5){
   global $db;
   $stmt2=$db->prepare("SELECT $select FROM $from  ORDER BY $orde DESC LIMIT $limit");
   $stmt2->execute();
   $rows=$stmt2->fetchAll();
   return $rows;
}
