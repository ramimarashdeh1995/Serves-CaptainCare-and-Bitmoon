<?php
require_once 'ClassFMarket.php';
$response= array();
 $co =new ClassFMarket();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['ven_id'])and isset($_POST['cap_id'])){
        $result=$co->BlockMarket($_POST['ven_id'], $_POST['cap_id']);
        if($result==1){
            $response['error']=false;
            $response['message']="Blouck";
        }elseif ($result==0) {
            $response['error']=true;
            $response['message']="not Blouck";
        } else {
            $response['error']=true;
            $response['message']="error Blouck";
        }
    } else if(isset ($_POST['b_id'])){
        $result=$co->UnBlockMarket($_POST['b_id']);
        if($result==1){
            $response['error']=false;
            $response['message']="UnBlock";
        }elseif ($result==0) {
            $response['error']=true;
            $response['message']="problem to UnBlock";
        } else {
            $response['error']=true;
            $response['message']="error error error Block";
        }
     }  else {
        $response['error']=true;
        $response['message']="not input";
    }
 } else {
     $response['error']=true;
     $response['message']="not request";
}
echo json_encode($response);