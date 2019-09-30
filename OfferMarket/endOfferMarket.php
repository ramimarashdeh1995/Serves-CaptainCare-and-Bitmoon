<?php
require_once 'classOfferMarket.php';
$response= array();
 $co =new classOfferMarket();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
     if (isset($_POST['offer_id'])){         
         $result=$co->endOfferMarket($_POST['offer_id']);
        if($result==1){
            $response['error']=false;
            $response['message']="Delete";
        } else if ($result==0){
            $response['error']=true;
            $response['message']="not Delete";
        } else {
             $response['error']=true;
            $response['message']="not rami";
        }
     } else {
         $response['error']=true;
         $response['message']="not inpput";
     }
 } else {
     $response['error']=true;
     $response['message']="not requst";
}
echo json_encode($response);