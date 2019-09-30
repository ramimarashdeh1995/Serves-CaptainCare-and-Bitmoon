<?php

require_once 'class_market.php';
$response= array();
 $co =new class_market();
/* @var $_SERVER type */
 if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['ven_id'])and isset($_POST['ven_name'])and isset($_POST['image'])and isset($_POST['city'])and isset($_POST['address'])){
        $result=$co->UpdatePersnalInformation($_POST['ven_id'], $_POST['ven_name'], $_POST['city'], $_POST['image'],$_POST['address']);
        if($result==0){
            $response['error']=true;
            $response['message']="error";
        } else {
            $response['error']=false;
            $response['message']=$result;
        }
    } else {
        $response['error']=false;
        $response['message']="not input";
    }
 } else {
     $response['error']=true;
     $response['message']="not request";
}
echo json_encode($response,JSON_UNESCAPED_UNICODE);