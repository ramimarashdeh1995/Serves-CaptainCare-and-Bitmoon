<?php

require_once 'class_market.php';
$response= array();
 $co =new class_market();
/* @var $_SERVER type */
 if($_SERVER['REQUEST_METHOD']==='POST'){
     if(isset($_POST['ven_mobile'])and isset($_POST['ven_password'])){
         $result=$co->UpdatePassword($_POST['ven_mobile'],$_POST['ven_password'],$_POST['code']);
         if($result===1){
            $response['error']=false;
            $response['message']="Update Password";
        }elseif ($result===0) {
            $response['error']=true;
            $response['message']="not update";
     }elseif ($result==5) {
            $response['error']=true;
            $response['message']="code error";
        }

     
        }/*else if(isset ($_POST['ven_mobile'])){
        $result=$co->CreatvarificationEmailForUpdatePassword($_POST['ven_email']);
        if($result === 1){
            $response['error']=false;
            $response['message']="send email";
        }elseif ($result==0) {
            $response['error']=true;
            $response['message']="A problem happened code";
        }elseif ($result==3) {
            $response['error']=true;
            $response['message']="Email number already register .. Please wait to Active Account";
        }elseif ($result===4) {
            $response['error']=true;
            $response['message']="not send email .. ";
        }
     }*/else{
        $response['error']=true;
        $response['message']="not found input";
    }
 } else {
    $response['error']=true;
    $response['message']="not found requst";
}
echo json_encode($response);