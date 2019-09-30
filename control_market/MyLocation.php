<?php
require_once 'class_market.php';
$response= array();
 $co =new class_market();
 if($_SERVER['REQUEST_METHOD']==='POST'){
     if (isset($_POST['ven_id'])and isset($_POST['lon'])and isset($_POST['lat'])){
        $result=$co->UpdateLocation($_POST['ven_id'],$_POST['lon'],$_POST['lat']);
        if($result==1){
            $response['error']=false;
            $response['message']="Update";
        } else {
            $response['error']=true;
            $response['message']="Not Update";
        }
     } else if(isset ($_POST['ven_id'])){
         $response['data']=$co->SelectMyLocation($_POST['ven_id']);
     } else {
         $response['error']=true;
         $response['message']="Not Input data";
     }
 } else {
     $response['error']=true;
     $response['message']="Not Request";
}
echo json_encode($response);