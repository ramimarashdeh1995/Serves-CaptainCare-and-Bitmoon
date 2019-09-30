<?php
require_once 'ClassFavoriteCaptain.php';
$response= array();
 $co =new ClassFavoriteCaptain();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['cap_id'])and isset($_POST['offer_id'])and isset($_POST['save_id'])){
         $result=$co->FinishSaveProcessFromCaptain($_POST['cap_id'], $_POST['save_id'], $_POST['offer_id']);
         if($result==1){
             $response['error']=false;
             $response['message']="end";
         }elseif ($result==0) {
            $response['error']=true;
            $response['message']="not Delete";
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