<?php

require_once 'class_captain.php';
$response= array();
 $co =new class_captain();
/* @var $_SERVER type */
 if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['cap_id'])and isset($_POST['cap_name'])and isset($_POST['image'])and isset($_POST['city'])){
        $result=$co->UpdatePersnalInformation($_POST['cap_id'], $_POST['cap_name'], $_POST['city'], $_POST['image']);
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