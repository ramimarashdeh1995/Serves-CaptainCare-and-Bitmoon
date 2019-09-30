<?php
require_once 'class_captain.php';
$response= array();
 $co =new class_captain();
 if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['ven_id'])and isset($_POST['ven_name'])){
        $result=$co->UpdateName($_POST['ven_id'], $_POST['ven_name']);
        if ($result===1){
            $response['error']=false;
            $response['message']="update name";
        }elseif ($result===0) {
            $response['error']=true;
            $response['message']="not update name";
        }else {
            $response['error']=true;
            $response['message']="else";
        }
    }elseif (isset ($_POST['ven_id'])and isset ($_POST['ven_photo_url'])) {
        $result=$co->UpdateImageProfile($_POST['ven_id'], $_POST['ven_photo_url']);
        if($result===1){
            $response['error']=false;
            $response['message']="update Image";
        }elseif ($result===0) {
            $response['error']=true;
            $response['message']="not update Image";
        } else {
            $response['error']=true;
            $response['message']="else";
        }
    } else {
        $response['error']=true;
        $response['message']="not input";
    }
 } else {
     $response['error']=true;
     $response['message']="not requst";
}
echo json_encode($response);