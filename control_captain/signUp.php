<?php
require_once 'class_captain.php';
$response= array();
 $co =new class_captain();
/* @var $_SERVER type */
if($_SERVER['REQUEST_METHOD']==='POST'){
    /* @var $_POST type */
    if (isset($_POST['cap_name'])and isset($_POST['cap_password'])and isset($_POST['cap_mobile'])and isset($_POST['cap_city'])and isset($_POST['cap_lic_url'])and isset($_POST['cap_token'])){
        $result=$co->signUp($_POST['cap_name'], $_POST['cap_password'], $_POST['cap_mobile'], $_POST['cap_city'], $_POST['cap_lic_url'],$_POST['cap_token']);
        if($result==1){
            $response['error']=false;
            $response['message']="wait for the admin to approve your application";
        }elseif ($result==0) {
            $response['error']=true;
            $response['message']="A problem happened";
        }elseif ($result==2) {
            $response['error']=true;
            $response['message']="Phone Number Already exist";
        }elseif ($result==3) {
            $response['error']=true;
            $response['message']="Phone number already register .. Please wait to Active Account";
        }
    }else if(isset($_POST['cap_mobile'])){
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
}else{
    $response['error']=true;
    $response['message']="not found requst POST";
}
echo json_encode($response);