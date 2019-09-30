<?php
require_once 'ClassSaveProcessMarket.php';
$response= array();
 $co =new ClassSaveProcessMarket();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['ven_id'])){
        $result=$co->SelectNowOfferMarket($_POST['ven_id']);
        if($result==NULL){
            $response['error']=true;
            $response['message']="not you have now save";
        } else {
            $response['error']=false;
            $response['message']=$result;
        }
    }elseif (isset ($_POST['cap_id'])) {
         $result=$co->SelectOfferCaptain($_POST['cap_id']);
        if($result==NULL){
            $response['error']=true;
            $response['message']="not you have now save";
        } else {
            $response['error']=false;
            $response['message']=$result;
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