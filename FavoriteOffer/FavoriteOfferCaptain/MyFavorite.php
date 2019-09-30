<?php
require_once 'ClassFavoriteCaptain.php';
$response= array();
$co=new ClassFavoriteCaptain();
// $co =new ClassFavoriteCaptain();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['cap_id'])){
        $result=$co->SelelctMyFavorite($_POST['cap_id']);
        if($result==null){
            $response['error']=true;
            $response['message']="not found favorite";
        } else {
            $response['error']=false;
            $response['message']=$result;
        }
    } else {
        $response['error']=true;
        $response['message']="not input";
    }
 } else {
    $response['error']=true;
    $response['message']="not Requet";
}
echo json_encode($response,JSON_UNESCAPED_UNICODE);