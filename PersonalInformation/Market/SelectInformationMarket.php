<?php
require_once 'ClassPIMarket.php';
$response= array();
 $co =new ClassPIMarket();
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['ven_id'])){
        $response['Information']=$co->SelectInformationMarket($_POST['ven_id']);
        $response['followere']=$co->SelectCounterMarketFollowers($_POST['ven_id']);
        $response['following']=$co->SelectCounterMarketFollowing($_POST['ven_id']);
        $response['block']=$co->SelectCounterMarketBlock($_POST['ven_id']);
    } else {
        $response['error']=true;
        $response['message']="not found input";
    }
} else {
    $response['error']=true;
    $response['message']="not found request";
}
echo json_encode($response,JSON_UNESCAPED_UNICODE);
