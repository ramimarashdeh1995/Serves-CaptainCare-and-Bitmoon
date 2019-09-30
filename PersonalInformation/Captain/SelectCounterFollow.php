<?php
require_once 'ClassPICaptain.php';
$response= array();
 $co =new ClassPICaptain();
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['cap_id'])){
        $response['error']=false;
        $response['followere']=$co->SelectCounterCaptainFollowers($_POST['cap_id']);
        $response['following']=$co->SelectCounterCaptainFollowing($_POST['cap_id']);
    } else {
        $response['error']=true;
        $response['message']="Error";
    }
} else {
    $response['error']=true;
    $response['message']="Error Request";
}
echo json_encode($response,JSON_UNESCAPED_UNICODE);
