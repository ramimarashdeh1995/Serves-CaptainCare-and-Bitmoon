<?php
require_once 'classplancaptain.php';
$response= array();
 $co =new classplancaptain();
 if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['plan'])){
        $response['error']=false;
        $response['message']=$co->getPlanPackeg();
    } else {
        $response['error']=true;
        $response['message']="not input";
    }
 } else {
     $response['error']=true;
     $response['message']="not request";
}
echo json_encode($response,JSON_UNESCAPED_UNICODE);