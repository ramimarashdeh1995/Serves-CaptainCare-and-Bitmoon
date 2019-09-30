<?php
require_once 'classService.php';
$response= array();
 $co =new classService();
 if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['sub_category'])){
        if($co->SelectAllSubService() !=null){
            $response['error']=false;
            $response['message']=$co->SelectAllSubService();
        } else {
            $response['error']=true;
            $response['message']="not found result";
        }
    } else {
        $response['error']=true;
        $response['message']="not found input";
    }
 } else {
     $response['error']=true;
     $response['message']="not found requst";
}
echo json_encode($response,JSON_UNESCAPED_UNICODE);

