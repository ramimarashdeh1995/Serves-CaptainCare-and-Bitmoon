<?php
require_once 'classService.php';
$response= array();
 $co =new classService();
 if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['category'])){
        if($co->SelectAllCategory() !=null){
            $response['error']=false;
            $response['message']=$co->SelectAllCategory();
        } else {
            $response['error']=true;
            $response['message']="not found result";
        }
    }elseif (isset ($_POST['c_id'])) {
        if($co->SelectAllSup_Category($_POST['c_id']) != null){
            $response['error']=false;
            $response['message']=$co->SelectAllSup_Category($_POST['c_id']);
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

