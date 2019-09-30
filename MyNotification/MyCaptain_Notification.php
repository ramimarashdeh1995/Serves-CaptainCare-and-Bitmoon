<?php
require_once 'ClassMyNotification.php';
$response= array();
 $co =new ClassMyNotification();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['cap_id'])){
        $result=$co->SelectAllNotificationCaptain($_POST['cap_id']);
        if($result==null){
            $response['error']=true;
            $response['notification']="not found your notification";
        } else {
            $response['error']=false;
            $response['notification']=$result;
        }
    } else {
        $response['error']=true;
        $response['notification']="not input";
    }
 } else {
     $response['error']=true;
     $response['notification']="not Request";
}
echo json_encode($response);