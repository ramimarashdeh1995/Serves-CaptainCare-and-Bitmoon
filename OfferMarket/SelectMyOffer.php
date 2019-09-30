<?php
require_once 'classOfferMarket.php';
$response= array();
 $co =new classOfferMarket();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['ven_id'])){
        $co->ChekIsEndDate($_POST['ven_id']);
        if($co->SelectMyOffer($_POST['ven_id'])==null){
            $response['error']=true;
            $response['message']="not found result";
        } else {
            $response['error']=false;
            $response['message']=$co->SelectMyOffer($_POST['ven_id']);
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