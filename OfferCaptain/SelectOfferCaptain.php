<?php
require_once 'classOffer.php';
$response= array();
 $co =new classOffer();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
     if(isset($_POST['offer_id']) and isset($_POST['ven_id'])and isset($_POST['cap_id'])){
         $result=$co->SelectOfferMarket($_POST['cap_id'],$_POST['ven_id'],$_POST['offer_id']);
         if($result==1){
            $response['error']=true;
            $response['message']="EndOffer";

         }else if($result==2){
            $response['error']=true;
            $response['message']="SaveOffer";
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