<?php
require_once 'ClassPIMarket.php';
$response= array();
 $co =new ClassPIMarket();
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['ven_id'])and isset($_POST['about_me'])){
        $result=$co->UpdateAboutMarket($_POST['ven_id'],$_POST['about_me']);
        if($result==1){
            $response['error']=false;
            $response['message']="update";
        } else {
            $response['error']=true;
            $response['message']="not update";
        }
    } else {
        $response['error']=true;
        $response['message']="not input";
    }
} else {
    $response['error']=true;
    $response['message']="not Request";
}
echo json_encode($response);