<?php
require_once 'class_captain.php';
$response= array();
 $co =new class_captain();
/* @var $_SERVER type */
 if($_SERVER['REQUEST_METHOD']==='POST'){
     if(isset($_POST['cap_mobile'])){
         $result=$co->validationMobileNumber($_POST['cap_mobile']);
         if($result==1){
            $response['error']=false;
            $response['message']="yes";
        }elseif ($result==2) {
            $response['error']=true;
            $response['message']="Phone Number Already exist";
        }elseif ($result==3) {
            $response['error']=true;
            $response['message']="Phone number already register .. Please wait to Active Account ";
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