<?php
require_once 'ClassFCaptain.php';
$response= array();
 $co =new ClassFCaptain();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
     if(isset($_POST['cap_id'])and isset($_POST['ven_id'])){
         $result=$co->AddFollowCaptain($_POST['cap_id'], $_POST['ven_id']);
         if($result==1){
            $response['error']=false;
            $response['message']="follow";
         }elseif ($result==0) {
            $response['error']=true;
            $response['message']="problem to follow";
        } else {
            $response['error']=true;
            $response['message']="error error";
        }
     } else if(isset ($_POST['f_id'])){
        $result=$co->UnFollowCaptain($_POST['f_id']);
        if($result==1){
            $response['error']=false;
            $response['message']="UnFollow";
        }elseif ($result==0) {
            $response['error']=true;
            $response['message']="problem to UnFollow";
        } else {
            $response['error']=true;
            $response['message']="error error error";
        }
     } else {
        $response['error']=true;
        $response['message']="not input";
     }
 } else {
    $response['error']=true;
    $response['message']="not request";
}
echo json_encode($response);