<?php
require_once 'ClassSaveProcessMarket.php';
require_once '../Notification/FirebaseCaptain.php';
$response= array();
 $co =new ClassSaveProcessMarket();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
     if(isset($_POST['cap_id'])and isset($_POST['ven_id'])and isset($_POST['offer_id'])){
        
        $result=$co->AcceptOfferCaptain($_POST['cap_id'], $_POST['ven_id'], $_POST['offer_id']);
        if($result==1){
            $response['error']=true;
            $response['message']="your not have CC";

        }else{
            $devicetoken = $co->getAllTokens_Captain($_POST['cap_id']);
        
            $firebase = new FirebaseCaptain();
        
            $response['error']=false;
            $response['message']="insert";
            $response['notification']=  $firebase->send($devicetoken, $result);
            
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