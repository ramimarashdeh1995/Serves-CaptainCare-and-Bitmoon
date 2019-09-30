<?php

require_once 'class_market.php';
$response= array();
 $co =new class_market();
/* @var $_SERVER type */
 if($_SERVER['REQUEST_METHOD']==='POST'){
     if(isset($_POST['ven_id'])and isset($_POST['passwordNow'])and isset($_POST['NewPassword'])){
         $result=$co->UpdatePasswordInApp($_POST['ven_id'],$_POST['passwordNow'],$_POST['NewPassword']);
         if($result===1){
            $response['error']=false;
            $response['message']="Update Password";
        }elseif ($result===0) {
            $response['error']=true;
            $response['message']="not update";
        }else if($result===2){
             $response['error']=true;
            $response['message']="error pass";
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