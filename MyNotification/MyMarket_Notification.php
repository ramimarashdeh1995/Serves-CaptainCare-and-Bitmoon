<?php
require_once 'ClassMyNotification.php';
$response= array();
 $co =new ClassMyNotification();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['ven_id'])){
        if($co->SelectAllNotificationMarket($_POST['ven_id'])==null){
            $response['error']=true;
            $response['notification']="not found your notification";
        } else {
            $response['error']=false;
            $response['notification']=$co->SelectAllNotificationMarket($_POST['ven_id']);
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