<?php
require_once 'classService.php';
$response= array();
 $co =new classService();
 if($_SERVER['REQUEST_METHOD']==='POST'){
     if (isset($_POST['ven_id'])and isset($_POST['cat_id'])and isset($_POST['sub_id'])){
        $result=$co->InsertService($_POST['ven_id'], $_POST['cat_id'], $_POST['sub_id']);
        if($result==1){
            $response['error']=false;
            $response['message']="insert";
        } else if ($result==0){
            $response['error']=true;
            $response['message']="not insert";
        }else if ($result==2){
            $response['error']=true;
            $response['message']="this is insert";
        }
     } else {
         $response['error']=true;
         $response['message']="not inpput";
     }
 } else {
     $response['error']=true;
     $response['message']="not requst";
}
echo json_encode($response);