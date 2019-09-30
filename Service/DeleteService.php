<?php
require_once 'classService.php';
$response= array();
 $co =new classService();
 if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['cat_id'])and isset($_POST['sub_id'])and isset($_POST['ven_id'])){
        $result=$co->DeleteService($_POST['cat_id'], $_POST['sub_id'], $_POST['ven_id']);
        if($result==1){
            $response['error']=false;
            $response['message']="delete";
        } else {
            $response['error']=true;
            $response['message']="not delete";
        }
    } else {
        $response['error']=true;
        $response['message']="not input";
    }
 } else {
     $response['error']=true;
     $response['message']="not requset";
}
echo json_encode($response);