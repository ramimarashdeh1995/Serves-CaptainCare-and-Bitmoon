<?php
require_once 'classOfferMarket.php';
$response= array();
 $co =new classOfferMarket();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
     if(isset($_POST['offer_id']) and isset($_POST['ven_id'])and isset($_POST['cap_id'])){
         $result=$co->SelectOfferCaptainFromNotification($_POST['cap_id'],$_POST['ven_id'],$_POST['offer_id']);
         if($result==1){
            $response['error']=true;
            $response['message']="EndOffer";

         }else if($result==null){
            $response['error']=true;
            $response['message']="ERROR";
         }else{
            $response['error']=false;
            $response['message']=$result;
         }
     }else{
         $response['error']=true;
            $response['message']="ERROR_INPUT";
     }
 }else{
     $response['error']=true;
            $response['message']="ERROR_REQUEST";
 }
 echo json_encode($response,JSON_UNESCAPED_UNICODE);