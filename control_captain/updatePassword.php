<?php

require_once 'class_captain.php';
$response= array();
 $co =new class_captain();
/* @var $_SERVER type */
 if($_SERVER['REQUEST_METHOD']==='POST'){
     if(isset($_POST['cap_mobile'])and isset($_POST['cap_password'])){
         $result=$co->UpdatePassword($_POST['cap_mobile'],$_POST['cap_password']);
         if($result===1){
            $response['error']=false;
            $response['message']="Update Password";
        }elseif ($result===0) {
            $response['error']=true;
            $response['message']="not update";
        }
     }else{
        $response['error']=true;
        $response['message']="not found input";
    }
 } else {
    $response['error']=true;
    $response['message']="not found requst";
}
echo json_encode($response);