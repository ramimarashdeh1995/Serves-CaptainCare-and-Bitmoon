<?php
require_once 'ClassSaveProcessMarket.php';
require_once '../Notification/FirebaseCaptain.php';
$response= array();
 $co =new ClassSaveProcessMarket();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['save_id'])and isset($_POST['ven_id'])and isset($_POST['cap_id'])and isset($_POST['rank'])){
        $result=$co->EndOfferMarket($_POST['save_id'], $_POST['ven_id'], $_POST['cap_id'], $_POST['rank']);
        $devicetoken = $co->getAllTokens_Captain($_POST['cap_id']);
        $firebase = new FirebaseCaptain();
        $response['error']=false;
        $response['message']="ok";
        
        $response['notification']= $firebase->send($devicetoken, $result);
    } else if(isset ($_POST['save_id'])and isset ($_POST['rank'])and isset ($_POST['cap_id'])){
        $result=$co->CaptainEvalMarket($_POST['save_id'], $_POST['rank'], $_POST['cap_id']);
        if($result !=0){
            $response['error']=false;
            $response['message']=$result;
        } else {
             $response['error']=true;
            $response['message']="ERROR";
        }
    } else {
        
        $response['error']=true;
        $response['message']="not input";
    }
 } else {
     $response['error']=true;
     $response['message']="not request";
}
echo json_encode($response);