<?php 
//importing required files 
require_once 'ClassGET_Token.php';
require_once 'Firebase.php';
require_once 'Push.php'; 

$db = new ClassGET_Token();

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){	
	//hecking the required params 
	if(isset($_POST['title']) and isset($_POST['message'])){

		//creating a new push
		$push = null; 
		//first check if the push has an image with it
		if(isset($_POST['image'])){
			$push = new Push(
					$_POST['title'],
					$_POST['message'],
					$_POST['image'],null,null
				);
		}else{
			$push = new Push(
					$_POST['title'],
					$_POST['message'],
					null,null,null
				);
		}

		$mPushNotification = $push->getPush(); 

		$devicetoken = $db->getAllTokens_Market();

		$firebase = new Firebase(); 

		echo $firebase->send($devicetoken, $mPushNotification);
	}else{
		$response['error']=true;
		$response['message']='Parameters missing';
	}
}else{
	$response['error']=true;
	$response['message']='Invalid request';
}

echo json_encode($response);