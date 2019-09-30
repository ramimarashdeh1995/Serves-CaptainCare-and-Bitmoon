<?php
require_once 'classOfferMarket.php';
$response= array();
 $co =new classOfferMarket();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['sub_id'])and isset($_POST['cap_id'])){
        if($co->SelectMarketOffer($_POST['sub_id'],$_POST['cap_id'])==null){
            $response['error']=true;
            $response['message']="not found offer";
        } else {
            $response['error']=false;
            $response['message']=$co->SelectMarketOffer($_POST['sub_id'],$_POST['cap_id']);
           // $response['message']=array_merge($co->SelectMarketOffer($_POST['sub_id'],$_POST['cap_id']),$co->IsOfferFavorite($_POST['cap_id']));
           // $response['offer_favorite']=$co->IsOfferFavorite($_POST['cap_id']);
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