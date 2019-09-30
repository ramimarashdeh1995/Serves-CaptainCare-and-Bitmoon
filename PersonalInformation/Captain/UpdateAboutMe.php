<?php
require_once 'ClassPICaptain.php';
$response= array();
 $co =new ClassPICaptain();
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['cap_id'])and isset($_POST['about_me'])){
        $result=$co->UpdateAboutCaptain($_POST['cap_id'],$_POST['about_me']);
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