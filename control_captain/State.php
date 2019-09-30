<?php
$response= array();

require '../connection_database/connection_DB.php';
        $db=new connection_DB();
        $con=$db->DB();


 if($_SERVER['REQUEST_METHOD']==='POST'){
     if(isset($_POST['cap_id'])and isset($_POST['state'])){
         $query="UPDATE `captain` SET `cap_isActive` = '".$_POST['state']."' WHERE `captain`.`cap_id` = '".$_POST['cap_id']."'";
         if(mysqli_query($con,$query)){
             $response['error']=false;
             $response['message']="Update";
         }else{
             $response['error']=true;
             $response['message']="not Update";
         }
     }else{
          $response['error']=true;
             $response['message']="not input";
     }
 }else{
      $response['error']=true;
             $response['message']="not request";
 }
echo json_encode($response);