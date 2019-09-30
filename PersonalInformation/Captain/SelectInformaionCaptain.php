<?php
require_once 'ClassPICaptain.php';
$response= array();
 $co =new ClassPICaptain();
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['cap_id'])){
        $response["Information"]=$co->SelectInformationCaptain($_POST['cap_id']);
        $response['followere']=$co->SelectCounterCaptainFollowers($_POST['cap_id']);
        $response['following']=$co->SelectCounterCaptainFollowing($_POST['cap_id']);
        $response['block']=$co->SelectCounterCaptainBlock($_POST['cap_id']);
    } else {
        $response['error']=true;
        $response['message']="not found input";
    }
} else {
    $response['error']=true;
    $response['message']="not found request";
}
echo json_encode($response,JSON_UNESCAPED_UNICODE);
