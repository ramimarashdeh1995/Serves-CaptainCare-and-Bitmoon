<?php
require_once 'ClassSaveProcessMarket.php';
require_once '../Notification/Firebase.php';
$response= array();
 $co =new ClassSaveProcessMarket();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
     if(isset($_POST['ven_id'])and isset($_POST['cap_id'])and isset($_POST['offer_id_market'])){
        $result=$co->SaveOfferMarketFree($_POST['ven_id'],$_POST['cap_id'],$_POST['offer_id_market']);
        if($result==0){
            $response['error']=true;
            $response['message']="Not insert";
        } else if($result==3){
            $response['error']=true;
            $response['message']="your not have CC";
        } else {
            $response['error']=false;
            $response['message']="insert";
            
            $mPushNotification = $result;
            $devicetoken = $co->getAllTokens_Market($_POST['ven_id']);
            $firebase = new Firebase();
            $response['notification']=  $firebase->send($devicetoken, $mPushNotification);
        }
     } else {
        $response['error']=true;
        $response['message']="Not input";
     }
 } else {
    $response['error']=true;
    $response['message']="Not request";
}
echo json_encode($response);