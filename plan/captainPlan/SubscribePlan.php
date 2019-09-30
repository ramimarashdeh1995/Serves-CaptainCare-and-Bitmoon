<?php
require_once 'classplancaptain.php';
$response= array();
 $co =new classplancaptain();
 if($_SERVER['REQUEST_METHOD']==='POST'){
     if(isset($_POST['cap_id'])and isset($_POST['plan_id'])){
         $result=$co->UpdatePlane($_POST['cap_id'],$_POST['plan_id']);
         if($result==1){
             $response['error']=false;
             $response['message']="ok";
         }else if($result==2){
              $response['error']=true;
             $response['message']="not your have cc";
         }else{
              $response['error']=true;
             $response['message']="server error";
         }
         
     }else{
        $response['error']=true;
        $response['message']="not input";
     }
 }else{
     $response['error']=true;
    $response['message']="not request";
 }
 echo json_encode($response);