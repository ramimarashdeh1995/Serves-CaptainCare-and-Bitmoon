<?php
require_once 'classOfferMarket.php';
//require_once '../Notification/Firebase.php';

$response= array();
 $co =new classOfferMarket();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
     if (isset($_POST['ven_id'])and isset($_POST['sub_id'])and isset($_POST['city'])and isset($_POST['offer_title'])and isset($_POST['offer_disc'])and isset($_POST['offer_pic1'])and isset($_POST['offer_pic2'])and isset($_POST['offer_pic3'])and isset($_POST['offer_pic4'])and isset($_POST['offer_pic5'])and isset($_POST['offer_pic6'])and isset($_POST['offer_end'])and isset($_POST['cost'])){         
        $result=$co->InsertPushOffer($_POST['ven_id'], $_POST['sub_id'],$_POST['city'], $_POST['offer_title'], $_POST['offer_disc'], $_POST['offer_pic1'], $_POST['offer_pic2'], $_POST['offer_pic3'],$_POST['offer_pic4'],$_POST['offer_pic5'],$_POST['offer_pic6'],$_POST['offer_end'],$_POST['cost']);
        if($result == 1){
            $response['error']=false;
            $response['message']="insert Free";
          
        }else if($result == 2){
            $response['error']=false;
            $response['message']="insert CC";
          
        } else if ($result==3){
            $response['error']=true;
            $response['message']="not your have CC";
        } else if ($result==4){
            $response['error']=true;
            $response['message']="not your have CC";
        } else if ($result==0){
            $response['error']=true;
            $response['message']="not insert";
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

 /* $mPushNotification = $result;
            
            $devicetoken = $co->getAllTokens_Captain();
            
            $firebase = new Firebase();
              
            echo $firebase->send($devicetoken, $mPushNotification);*/