<?php
require_once 'ClassContract.php';
$response= array();
 $co =new ClassContract();
 if($_SERVER['REQUEST_METHOD']==='POST'){
     if(isset($_POST['contract'])){
        $response['error']=false;
        $response['message']=$co->getContract();
     }else{
         $response['error']=true;
         $response['message']="not isset";
     }
 }else{
     $response['error']=true;
     $response['message']="not Serves ";
 }
echo json_encode($response);