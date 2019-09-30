<?php
require_once 'ClassFMarket.php';
$response= array();
 $co =new ClassFMarket();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
     if(isset($_POST['cap_id'])and isset($_POST['ven_id'])){
         $result=$co->UnfollowMarket2($_POST['cap_id'], $_POST['ven_id']);
         if($result==1){
            $response['error']=false;
            $response['message']="Un-Follow";
         }elseif ($result==0) {
            $response['error']=true;
            $response['message']="problem to follow";
        } else {
            $response['error']=true;
            $response['message']="error error";
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