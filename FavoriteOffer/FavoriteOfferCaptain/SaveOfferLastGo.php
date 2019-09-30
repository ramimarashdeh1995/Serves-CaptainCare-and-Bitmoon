<?php
require_once 'ClassFavoriteCaptain.php';
$response= array();
 $co =new ClassFavoriteCaptain();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
     if(isset($_POST['cap_id'])and isset($_POST['offer_id'])and isset($_POST['ven_id'])){
         $result=$co->SaveOfferMarketFree($_POST['ven_id'],$_POST['cap_id'], $_POST['offer_id']);
         if($result==1){        
            $response['error']=false;
            $response['message']="Add";
         }elseif ($result==0) {
            $response['error']=true;
            $response['message']="not Add";
        } else if($result==3){
            $response['error']=true;
            $response['message']="your not have CC";
        }
     } else {
          $response['error']=true;
          $response['message']="not input";
     }
 }else{
      $response['error']=true;
      $response['message']="not request";
 }
 echo json_encode($response);
