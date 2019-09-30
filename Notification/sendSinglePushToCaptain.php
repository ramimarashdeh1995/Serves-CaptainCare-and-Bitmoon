<?php 
//importing required files 
require_once 'ClassGET_Token.php';
require_once 'Firebase.php';
require_once 'Push.php'; 

$db = new ClassGET_Token();

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){	
	//hecking the required params 
	if(isset($_POST['title']) and isset($_POST['message']) and isset($_POST['cap_id'])){

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
			//if the push don't have an image give null in place of image
			$push = new Push(
					$_POST['title'],
					$_POST['message'],
					null,null,null
				);
		}

		//getting the push from push object
		$mPushNotification = $push->getPush(); 

		//getting the token from database object 
		$devicetoken = $db->getTokenByID_Captain($_POST['cap_id']);
		//creating firebase class object 
		$firebase = new Firebase(); 
		echo json_encode($devicetoken);

		//sending push notification and displaying result 
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