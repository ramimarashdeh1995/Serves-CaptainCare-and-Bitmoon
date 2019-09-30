<?php
require_once 'ClassDiviceToken.php';
$response= array();
 $co =new ClassDiviceToken();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['cap_id'])){
        $result=$co->SignOutTokenCaptain($_POST['cap_id']);
        if($result==1){
            $response['error']=false;
            $response['message']="Update";
        } else {
            $response['error']=true;
            $response['message']="Not Update";
        }
    } else {
        $response['error']=true;
        $response['message']="Not Input";
    }
 } else {
    $response['error']=true;
    $response['message']="Not Request";
}
echo json_encode($response);