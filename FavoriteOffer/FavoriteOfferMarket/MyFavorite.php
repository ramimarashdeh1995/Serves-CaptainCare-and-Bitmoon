<?php
require_once 'ClassFavoriteMarket.php';
$response= array();
 $co =new ClassFavoriteMarket();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['ven_id'])){
        if($co->SelelctMyFavorite($_POST['ven_id'])==null){
            $response['error']=true;
            $response['message']="not found favorite";
        } else {
            $response['error']=false;
            $response['message']=$co->SelelctMyFavorite($_POST['ven_id']);
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