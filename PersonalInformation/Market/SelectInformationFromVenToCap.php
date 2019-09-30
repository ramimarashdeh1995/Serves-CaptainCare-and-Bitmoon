<?php
require_once 'ClassPIMarket.php';
$response= array();
 $co =new ClassPIMarket();
if($_SERVER['REQUEST_METHOD']==='POST'){
    if (isset($_POST['cap_id'])and isset($_POST['ven_id'])){
        if($co->IsCaptainFollowingMarket($_POST['cap_id'], $_POST['ven_id'])==1){
            $response['error']=false;
            $response['following']=1;
            $response['message']=$co->SelectInformaionMarketFromCaptain($_POST['ven_id']);
        }elseif ($co->IsCaptainFollowingMarket($_POST['cap_id'], $_POST['ven_id'])==0) {
            $response['error']=false;
            $response['following']=0;
            $response['message']=$co->SelectInformaionMarketFromCaptain($_POST['ven_id']);
        } else {
            $response['error']=true;
            $response['message']="Error";
        }
    } else {
        $response['error']=true;
        $response['message']="Error Input";
    }
} else {
    $response['error']=true;
    $response['message']="Error Request";
}
echo json_encode($response,JSON_UNESCAPED_UNICODE);
