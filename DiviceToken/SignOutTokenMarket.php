<?php
require_once 'ClassDiviceToken.php';
$response= array();
 $co =new ClassDiviceToken();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['ven_id'])){
        $result=$co->SignOutTokenMarket($_POST['ven_id']);
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