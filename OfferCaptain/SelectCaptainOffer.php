<?php
require_once 'classOffer.php';
$response= array();
 $co =new classOffer();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['ven_id'])and isset($_POST['sub_id'])){
        if($co->SelectCaptainOffer($_POST['sub_id'],$_POST['ven_id'])==null){
            $response['error']=true;
            $response['message']="not found offer";
        } else {
            $response['error']=false;
            $response['message']=$co->SelectCaptainOffer($_POST['sub_id'],$_POST['ven_id']);
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