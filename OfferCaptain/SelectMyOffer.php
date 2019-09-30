<?php
require_once 'classOffer.php';
$response= array();
 $co =new classOffer();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['cap_id'])){
        $co->ChekIsEndDate($_POST['cap_id']);
        if($co->SelectMyOffer($_POST['cap_id'])==null){
            $response['error']=true;
            $response['message']="not found result";
        } else {
            $response['error']=false;
            $response['message']=$co->SelectMyOffer($_POST['cap_id']);
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