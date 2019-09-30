<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 require '../connection_database/connection_DB.php';
        $db=new connection_DB();
        $con=$db->DB();
        
$response =array();        
        
        
$ven_id=$_GET['ven_id'];
$page_number=$_GET['page'];//1
$item_count=$_GET['item'];//10

$from=$page_number*$item_count - ($item_count);//1*10 -10=0 || 2*10 - 10=10 || 3*10 - 10= 30 

if($ven_id != null){
    
$query=$con->prepare("SELECT vendor_offer.offer_id,vendor_offer.ven_id,vendor_offer.sub_id,sub_category.c_id,sub_category.sub_name,sub_category.sub_name_ar,vendor_offer.city, vendor_offer.offer_title,vendor_offer.offer_disc,vendor_offer.offer_pic1,vendor_offer.offer_pic2,vendor_offer.offer_pic3,vendor_offer.offer_pic4, vendor_offer.offer_pic5,vendor_offer.offer_pic6,vendor_offer.offer_start,vendor_offer.offer_end,vendor_offer.isEnd FROM vendor_offer,sub_category WHERE vendor_offer.ven_id='".$ven_id."' AND sub_category.s_id=vendor_offer.sub_id  ORDER BY `vendor_offer`.`offer_id` DESC LIMIT $item_count OFFSET $from");
$query->execute();
$result=$query->get_result();
$array=array();


while($row=mysqli_fetch_assoc($result)){
    $array[]=$row;
}
if($array==null){
    $response['error']=true;
    $response['data']="null";
} else {
    $response['error']=false;
    $response['data']=$array;
}
    
}else{
     $response['error']=true;
    $response['data']="not Request";
}

echo json_encode($response);
