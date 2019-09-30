<?php
require_once 'class_market.php';
$response= array();
 $co =new class_market();
/* @var $_SERVER type */
if($_SERVER['REQUEST_METHOD']==='POST'){
    /* @var $_POST type */
    if (isset($_POST['ven_name'])and isset($_POST['ven_city'])and isset($_POST['ven_address'])and isset($_POST['ven_mobile'])and
            isset($_POST['ven_password'])and isset($_POST['ven_trad'])and isset($_POST['token'])){
        $result=$co->signUp($_POST['ven_name'], $_POST['ven_city'], $_POST['ven_address'], $_POST['ven_mobile'], $_POST['ven_password'],$_POST['ven_trad'],$_POST['token']);
        if($result === 1){
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
        }elseif ($result==5) {
            $response['error']=true;
            $response['message']="code error";
        }
        elseif ($result==9) {
            $response['error']=true;
            $response['message']="problem category";
        }
    }/*else if(isset ($_POST['ven_email'])){
        $result=$co->CreatvarificationEmail($_POST['ven_email']);
        if($result === 1){
            $response['error']=false;
            $response['message']="send email";
        }elseif ($result==0) {
            $response['error']=true;
            $response['message']="A problem happened code";
        }elseif ($result==2) {
            $response['error']=true;
            $response['message']="Email Already exist";
        }elseif ($result==3) {
            $response['error']=true;
            $response['message']="Email number already register .. Please wait to Active Account";
        }elseif ($result===4) {
            $response['error']=true;
            $response['message']="not send email .. ";
        }
    }*/
    else if(isset($_POST['ven_mobile'])){
         $result=$co->validationMobileNumber($_POST['ven_mobile']);
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
    $response['message']="not found requst";
}
echo json_encode($response);