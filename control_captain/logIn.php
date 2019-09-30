<?php
require_once 'class_captain.php';
$response= array();
 $co =new class_captain();
 if($_SERVER['REQUEST_METHOD']==='POST'){
     if(isset($_POST['cap_mobile'])and isset($_POST['cap_password'])){
         if(empty($_POST['cap_mobile'])){
              $response['error']=true;
              $response['message']="input email";
         }else if(empty($_POST['cap_password'])){
              $response['error']=true;
              $response['message']="inpute password";
         }else{
            $result=$co->log_in($_POST['cap_mobile'], $_POST['cap_password']);
            if($result === 1){
                $response['error']=false;
               $response['message']=$co->true_log_in($_POST['cap_mobile'], $_POST['cap_password']);
            }else if($result===0){
                $response['error']=true;
                $response['message']="error for log in";
            }else if($result===2){
                $response['error']=true;
                $response['message']="cheak for email";
            }else if($result===3){
                $response['error']=true;
                $response['message']="cheak for password";
            }else if($result===4){
                $response['error']=true;
                $response['message']="Phone number already register .. Please wait to Active Account";
            }
         }
     }else{
         $response['error']=true;
         $response['message']="not isset";
     }
 }else{
     $response['error']=true;
     $response['message']="not Serves ";
 }
echo json_encode($response);