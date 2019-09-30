<?php
require_once 'ClassPIMarket.php';
$response= array();
 $co =new ClassPIMarket();
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['ven_id'])){
        $response['error']=false;
        $response['followere']=$co->SelectCounterMarketFollowers($_POST['ven_id']);
        $response['following']=$co->SelectCounterMarketFollowing($_POST['ven_id']);
    } else {
        $response['error']=true;
        $response['message']="Error";
    }
} else {
    $response['error']=true;
    $response['message']="Error Request";
}
echo json_encode($response,JSON_UNESCAPED_UNICODE);
