<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classOffer
 *
 * @author Rami
 */
class classOffer {
    private $con;
    private $id_proc;
    
    function __construct() {
        require '../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
    private function getDate(){
         $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
         return $datetime->format('Y-m-d H:i:s');
    }


    private function ReadQuery($query){
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
    public function getPush($titel,$message,$image,$type,$offer_id) {
        $res = array();
        $res['data']['title'] = $titel;
        $res['data']['message'] = $message;
        $res['data']['image'] = $image;
        $res['data']['type'] = $type;
        $res['data']['offer_id'] = $offer_id;
        return $res;
    }
   

    //this fun to add offer Push : ->
     public function InsertPushOffer($ven_id,$sub_id,$city,$offer_title,$offer_disc,$offer_pic1,$offer_pic2,$offer_pic3,$offer_pic4,$offer_pic5,$offer_pic6,$end_date,$cost,$address){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3')); $date_creat_acc=$datetime->format('Y-m-d H:i:s');    
        $timeA = new DateTime("now",new DateTimeZone('GMT+3'));  $date_creat_pic=$datetime->format('YmdHis');
        $timeB = new DateInterval("PT".$end_date."H0M0S"); 
        $timeA->add($timeB);
        
        $period=  "PO"."$end_date"."H";

        $result= $this->CheckMyHaveFreeCC($ven_id,$period);
        if($result==1||$result==2){
            $query="INSERT INTO `captain_offer`"
                . "(`offer_id` ,`cap_id`,`sub_id`, `city`, `offer_title`, `offer_disc`, `offer_pic1`, `offer_pic2`, `offer_pic3`, `offer_pic4`, `offer_pic5`, `offer_pic6`, `offer_start`, `offer_end`,`isEnd`,`isPaid`,`cost`,`chkd`,`address`)"
                . " VALUES ( NULL ,'".$ven_id."', '".$sub_id."','".$city."', '".$offer_title."', '".$offer_disc."', '".$this->Insertpic($offer_pic1, $ven_id,$date_creat_pic,"insert1")."', '".$this->Insertpic($offer_pic2, $ven_id, $date_creat_pic,"insert2")."', '".$this->Insertpic($offer_pic3, $ven_id, $date_creat_pic,"insert3")."', '".$this->Insertpic($offer_pic4, $ven_id, $date_creat_pic,"insert4")."', '".$this->Insertpic($offer_pic5, $ven_id, $date_creat_pic,"insert5")."', '".$this->Insertpic($offer_pic6, $ven_id, $date_creat_pic,"insert6")."', '".$date_creat_acc."', '".$timeA->format('Y-m-d H:i:s')."','0','1','".$cost."','0','".$address."')";
            if(mysqli_query($this->con, $query)){
                $id = $this->con->insert_id;
                $this->UpdateDocProcessAcceptOfferMarketFromCaptain($id,$result);
                return $result;
            } else {
                return 0;
            }
        } else {
            return 3;
        }
    }
    /* $offer_id=$this->con->insert_id;
            if($offer_pic1==""){
                $this->saveNotification($offer_id,$date_creat_acc);
                return $this->getPush($offer_title, $offer_disc, null, "offerCaptain", $offer_id);
            } else {
                $this->saveNotification($offer_id,$date_creat_acc);
                 return $this->getPush($offer_title, $offer_disc, $pic_offer_1, "offerCaptain", $offer_id);
            }*/
    private function CheckMyHaveFreeCC($cap_id,$period){
        $query="SELECT $period FROM `captain_wallet` WHERE `cap_id`='".$cap_id."'";
        $row = mysqli_fetch_array(mysqli_query($this->con, $query));
        $freeCC= $row[$period];
        if($freeCC>0){
            $query1="UPDATE `captain_wallet` SET $period = $period - 1 WHERE `captain_wallet`.`cap_id` = $cap_id";
            mysqli_query($this->con, $query1);
            return 1;
        } else {
            return $this->CheckMyHaveCC($cap_id,$period);
        }
    }
    private function CheckMyHaveCC($cap_id,$period){
        $query="SELECT cap_cc FROM `captain_wallet` WHERE `cap_id`='".$cap_id."'";
        $row = mysqli_fetch_array(mysqli_query($this->con, $query));
        $CC= $row['cap_cc'];
        $period1=$period."_price";
        $query2="SELECT $period1 FROM `captain_plan_price` WHERE 1";
        $row2 = mysqli_fetch_array(mysqli_query($this->con, $query2));
        $price= $row2[$period1];
        if($CC>$price){
            $query1="UPDATE `captain_wallet` SET `cap_cc` = (`cap_cc`-$price) WHERE `captain_wallet`.`cap_id` = $cap_id";
            mysqli_query($this->con, $query1);
            $date= $this->getDate();
            $this->DocProcessAcceptOfferMarketFromCaptain($cap_id, $price, "Null", "AddOffer", $date);
            return 2;
        } else {
            return 0;
        }
    }
     private function DocProcessAcceptOfferMarketFromCaptain($cap_id,$bit,$offer_id,$type_process,$date){
        $query="INSERT INTO `captain_proc` (`p_id`, `cap_id`, `proc_type`, `proc_value`, `proc_info`,`date`)"
                . " VALUES (NULL, '".$cap_id."', '".$type_process."', '".$bit."', '".$offer_id."','".$date."')";
        mysqli_query($this->con, $query);
        $this->id_proc = $this->con->insert_id;
    }
    private function UpdateDocProcessAcceptOfferMarketFromCaptain($id,$result){
        if($result==2){
            $query="UPDATE `captain_proc` SET `proc_info`='".$id."' WHERE `p_id`='".$this->id_proc."'";
            mysqli_query($this->con, $query);
        }
    }

    public function InsertOffer($ven_id,$sub_id,$city,$offer_title,$offer_disc,$offer_pic1,$offer_pic2,$offer_pic3,$offer_pic4,$offer_pic5,$offer_pic6,$end_date,$cost,$address){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));$date_creat_acc= $this->getDate();
        $timeA = new DateTime("now",new DateTimeZone('GMT+3'));
        $date_creat_pic=$datetime->format('YmdHis');
        $timeB = new DateInterval("PT".$end_date."H0M0S"); 
        $timeA->add($timeB);
        
        $period=  "AP"."$end_date"."H";
        
        $result= $this->CheckMyHaveFreeCC($ven_id,$period);
        if($result==1||$result==2){
            $query="INSERT INTO `captain_offer`(`offer_id` ,`cap_id`,`sub_id`, `city`, `offer_title`, `offer_disc`, `offer_pic1`, `offer_pic2`, `offer_pic3`, `offer_pic4`, `offer_pic5`, `offer_pic6`, `offer_start`, `offer_end`,`isEnd`,`isPaid`,`cost`,`chkd`,`address`)"
                . " VALUES ( NULL ,'".$ven_id."', '".$sub_id."','".$city."', '".$offer_title."', '".$offer_disc."', '".$this->Insertpic($offer_pic1, $ven_id,$date_creat_pic,"insert1")."', '".$this->Insertpic($offer_pic2, $ven_id, $date_creat_pic,"insert2")."', '".$this->Insertpic($offer_pic3, $ven_id, $date_creat_pic,"insert3")."', '".$this->Insertpic($offer_pic4, $ven_id, $date_creat_pic,"insert4")."', '".$this->Insertpic($offer_pic5, $ven_id, $date_creat_pic,"insert5")."', '".$this->Insertpic($offer_pic6, $ven_id, $date_creat_pic,"insert6")."', '".$date_creat_acc."', '".$timeA->format('Y-m-d H:i:s')."','0','0','".$cost."','0','".$address."')";
            if (mysqli_query($this->con, $query)){
                $id = $this->con->insert_id;
                $this->UpdateDocProcessAcceptOfferMarketFromCaptain($id,$result);
                return $result;
            } else {
                return 0;
            }
        } else {
            return 3;
        }
            
    }
    private function Insertpic($offer_pic,$ven_id,$date_creat_acc,$picName){
        if($offer_pic==""){
            return $actualpath1="";
        } else {
            $path = "ImageOfferCaptain/$picName$ven_id$date_creat_acc.png";
            file_put_contents($path,base64_decode($offer_pic));
            return $actualpath1 = "http://captain-care.org/ccapp/OfferCaptain/$path";
        }
    }

    public function UpdateOffer($id,$city,$offer_title,$offer_disc,$offer_pic1,$offer_pic2,$offer_pic3,$offer_pic4,$offer_pic5,$offer_pic6,$cost,$address){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        $date_creat_pic=$datetime->format('YmdHis');
        $this->GetIdForDelet($id);
        
        $query="UPDATE `captain_offer` SET `city` = '".$city."', `offer_title` = '".$offer_title."', `offer_disc` = '".$offer_disc."', `offer_pic1` = '".$this->Insertpic($offer_pic1, $id, $date_creat_pic,"U1")."', `offer_pic2` = '".$this->Insertpic($offer_pic2, $id, $date_creat_pic,"U2")."', `offer_pic3` = '".$this->Insertpic($offer_pic3, $id, $date_creat_pic,"U3")."', `offer_pic4` = '".$this->Insertpic($offer_pic4, $id, $date_creat_pic,"U4")."', `offer_pic5` = '".$this->Insertpic($offer_pic5, $id, $date_creat_pic,"U5")."', `offer_pic6` = '".$this->Insertpic($offer_pic6, $id, $date_creat_pic,"U6")."',`cost` = '".$cost."',`chkd` = '0',`address`='".$address."' WHERE `captain_offer`.`offer_id` = '".$id."'";
        return $this->ReadQuery($query);
    }
    public function DeleteOffer($id){
       $this->GetIdForDelet($id);
       
        $query="DELETE FROM `captain_offer` WHERE `captain_offer`.`offer_id` = '".$id."'";
        return $this->ReadQuery($query);
    }
    public function endOffer($id){
        $query="UPDATE `captain_offer` SET `isEnd` = '1' WHERE `captain_offer`.`offer_id` = '".$id."'";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }

    private function GetIdForDelet($id){
       $this->DeletePic1($id);
       $this->DeletePic2($id);
       $this->DeletePic3($id);
       $this->DeletePic4($id);
       $this->DeletePic5($id);
       $this->DeletePic6($id);
    }

    private function DeletePic1($id){
        $query1="SELECT captain_offer.offer_pic1 FROM captain_offer WHERE captain_offer.offer_id='".$id."'";
        $result= mysqli_query($this->con, $query1);
        $pic1= mysqli_fetch_row($result);
        $pic=$pic1[0];
        $this->CheakForImage($pic);
    }
    private function DeletePic2($id){
        $query1="SELECT captain_offer.offer_pic2 FROM captain_offer WHERE captain_offer.offer_id='".$id."'";
        $result= mysqli_query($this->con, $query1);
        $pic1= mysqli_fetch_row($result);
        $pic=$pic1[0];
        $this->CheakForImage($pic);
    }
    private function DeletePic3($id){
        $query1="SELECT captain_offer.offer_pic3 FROM captain_offer WHERE captain_offer.offer_id='".$id."'";
        $result= mysqli_query($this->con, $query1);
        $pic1= mysqli_fetch_row($result);
        $pic=$pic1[0];
        $this->CheakForImage($pic);
    }
     private function DeletePic4($id){
        $query1="SELECT captain_offer.offer_pic4 FROM captain_offer WHERE captain_offer.offer_id='".$id."'";
        $result= mysqli_query($this->con, $query1);
        $pic1= mysqli_fetch_row($result);
        $pic=$pic1[0];
        $this->CheakForImage($pic);
    }
     private function DeletePic5($id){
        $query1="SELECT captain_offer.offer_pic5 FROM captain_offer WHERE captain_offer.offer_id='".$id."'";
        $result= mysqli_query($this->con, $query1);
        $pic1= mysqli_fetch_row($result);
        $pic=$pic1[0];
        $this->CheakForImage($pic);
    }
     private function DeletePic6($id){
        $query1="SELECT captain_offer.offer_pic6 FROM captain_offer WHERE captain_offer.offer_id='".$id."'";
        $result= mysqli_query($this->con, $query1);
        $pic1= mysqli_fetch_row($result);
        $pic=$pic1[0];
        $this->CheakForImage($pic);
    }
    private function CheakForImage($pic){
        if($pic==""){
        } else {
            $this->DeleteImage($pic); 
        }
    }
    private function DeleteImage($pic){
        if(file_exists(str_replace("http://captain-care.org/ccapp/OfferCaptain/", "", $pic))){
            unlink(str_replace("http://captain-care.org/ccapp/OfferCaptain/", "", $pic));
        } else {
        }
    }
    public function ChekIsEndDate($id){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        $datetimeServer=$datetime->format('Y-m-d H:i:s'); 
        $query=$this->con->prepare("SELECT * FROM `captain_offer`  WHERE `captain_offer`.`cap_id`='".$id."'");
        $query->execute();
        $result=$query->get_result();
        while($row=mysqli_fetch_assoc($result)){
            if($row['offer_end']<$datetimeServer){
                $this->UpdateEndDate($row['offer_id']);
            }
        }
    }
    private function UpdateEndDate($id){
        $query="UPDATE `captain_offer` SET `isEnd` = '1' WHERE `captain_offer`.`offer_id` = '".$id."'";
        mysqli_query($this->con, $query);
    }
    public function SelectMyOffer($id){
        $query=$this->con->prepare("SELECT captain_offer.offer_id,captain_offer.cap_id,captain_offer.sub_id,sub_category.c_id,sub_category.sub_name,sub_category.sub_name_ar,captain_offer.city,captain_offer.offer_title, captain_offer.offer_disc,captain_offer.offer_pic1,captain_offer.offer_pic2,captain_offer.offer_pic3,captain_offer.offer_pic4,captain_offer.offer_pic5,captain_offer.offer_pic6,captain_offer.offer_start,captain_offer.offer_end,captain_offer.isEnd,captain_offer.address,captain_offer.cost FROM captain_offer,sub_category WHERE captain_offer.cap_id='".$id."' AND sub_category.s_id=captain_offer.sub_id  ORDER BY `captain_offer`.`offer_id` DESC ");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    }
    
    
    public function SelectOfferMarket($cap_id,$ven_id,$offer_id){
        
        if($this->CheckOfferIsEnd($offer_id)){
            return 1;
        }else if($this->CheckIsSaveProcess($cap_id,$ven_id,$offer_id)){
            return 2;
        }else{
             $query =$this->con->prepare("SELECT vendor_offer.offer_id,vendor_offer.ven_id,vendor_offer.sub_id,vendor_offer.city,vendor_offer.offer_title,vendor_offer.offer_disc, vendor_offer.offer_pic1,vendor_offer.offer_pic2,vendor_offer.offer_pic3,vendor_offer.offer_pic4,vendor_offer.offer_pic5,vendor_offer.offer_pic6,
vendor_offer.offer_start,vendor_offer.offer_end,vendor_offer.isEnd,vendor.ven_name,vendor.ven_address,vendor.ven_mobile, vendor.ven_city,vendor.ven_photo_url,vendor.ven_token ,vendor.ven_lon,vendor.ven_lat,(select fav_id from captain_fav where captain_fav.vendor_offer_id=vendor_offer.offer_id and captain_fav.captain_id=$cap_id) as isfav , vendor_offer.isPaid,vendor_offer.cost , (SELECT TRUNCATE(avg(`cap_rank`), 2) FROM `save_process` WHERE `ven_id`=vendor_offer.ven_id) AS eval FROM vendor_offer,vendor 
WHERE  vendor_offer.chkd = '1' AND vendor_offer.offer_id=$offer_id AND vendor.ven_id=$ven_id ");
            $query->execute();
            $result=$query->get_result();
             $array=array();
            while($row=mysqli_fetch_assoc($result)){
                 $array[]=$row;
             }
            return $array;
        }
       
    }
    
    private function CheckOfferIsEnd($offer_id){
        $date_creat_acc= $this->getDate();
        $query=$this->con->prepare("SELECT * FROM vendor_offer WHERE vendor_offer.offer_end >= '$date_creat_acc' AND vendor_offer.offer_id=$offer_id");
         $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
           $array[]=$row;
        }
        if($array==null){
            return true;
        }else{
            return false;
        }
        
    }
    private function CheckIsSaveProcess($cap_id,$ven_id,$offer_id){
        $query=$this->con->prepare("SELECT * FROM save_process WHERE save_process.ven_id=$ven_id AND save_process.cap_id=$cap_id AND save_process.id_offer_ven=$offer_id");
         $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
           $array[]=$row;
        }
        if($array==null){
            return false;
        }else{
            return true;
        }
    }
    
    
    public function SelectCaptainOffer($sub_id,$ven_id){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        $date=$datetime->format('Y-m-d H:i:s');     
        $query=$this->con->prepare(" SELECT captain_offer.offer_id,captain_offer.cap_id,captain_offer.sub_id,captain_offer.city,captain_offer.offer_title,captain_offer.offer_disc, captain_offer.offer_pic1,captain_offer.offer_pic2,captain_offer.offer_pic3,captain_offer.offer_pic4,captain_offer.offer_pic5,captain_offer.offer_pic6, captain_offer.offer_start,captain_offer.offer_end,captain_offer.isEnd,captain.cap_name,captain.cap_mobile,captain.cap_city,captain.cap_photo_url,captain.cap_token,captain_offer.isPaid,captain_offer.cost,captain_offer.address,
(SELECT TRUNCATE(avg(`ven_rank`), 2) FROM `save_process` WHERE `cap_id`=captain_offer.cap_id)AS eval,(select fav_id from vendor_fav where vendor_fav.captain_offer_id=captain_offer.offer_id and vendor_fav.vendor_id =$ven_id) as isfav FROM captain_offer,captain WHERE captain_offer.`sub_id`=$sub_id and captain_offer.`cap_id` Not IN( SELECT `cap_id` FROM `vendor_block` WHERE `ven_id`=$ven_id UNION SELECT `cap_id` FROM `captain_block` WHERE `ven_id`=$ven_id ) AND captain_offer.cap_id=captain.cap_id AND captain_offer.isEnd='0' AND captain_offer.chkd='1' AND captain_offer.offer_id NOT IN (SELECT captain_notify.ven_offer_id FROM captain_notify WHERE 
                                  captain_notify.type='acceptoffercaptain' AND captain_notify.cap_id=captain_offer.cap_id
                                  AND captain_notify.ven_id=$ven_id)  ORDER BY `captain_offer`.`offer_id` DESC ");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
           $array[]=$row;
        }
        return $array;
    }
    
    
   /* $sql="SELECT captain_offer.offer_id,captain_offer.cap_id,captain_offer.sub_id,captain_offer.city,captain_offer.offer_title,captain_offer.offer_disc, captain_offer.offer_pic1,captain_offer.offer_pic2,captain_offer.offer_pic3,captain_offer.offer_pic4,captain_offer.offer_pic5,captain_offer.offer_pic6, captain_offer.offer_start,captain_offer.offer_end,captain_offer.isEnd,captain.cap_name,captain.cap_mobile,captain.cap_city,captain.cap_photo_url,captain.cap_token FROM captain_offer,captain WHERE captain_offer.`sub_id`=1 and captain_offer.`cap_id` Not IN( SELECT `cap_id` FROM `vendor_block` WHERE `ven_id`=2 UNION SELECT `cap_id` FROM `captain_block` WHERE `ven_id`=2 ) AND captain_offer.cap_id=captain.cap_id AND captain_offer.offer_end >= '2019-03-2' AND captain_offer.isEnd=0 ";
$result=mysqli_query($con,$sql);
$rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
print_r($rows);*/
}
 /* public function getAllTokens_Market(){
        $stmt = $this->con->prepare("SELECT vendor.ven_token FROM vendor WHERE vendor.ven_token NOT LIKE '0'");//query select all token market and not select market block
        $stmt->execute(); 
        $result = $stmt->get_result();
        $tokens = array(); 
        while($token = $result->fetch_assoc()){
            array_push($tokens, $token['ven_token']);
        }
        return $tokens; 
    }*/
   /* private function saveNotification($offer_id,$date){
        $stmt=$this->con->prepare("SELECT vendor.ven_id FROM vendor WHERE vendor.ven_token NOT LIKE '0'");
        $stmt->execute(); 
        $result = $stmt->get_result();
        while($row=mysqli_fetch_assoc($result)){
            $this->SaveTableNotification($row['ven_id'], $offer_id, $date);
        }
    }
    private function SaveTableNotification($id_ven,$offer_id,$date){
        $query="INSERT INTO `vendor_notify` (`ven_id`, `cap_offer_id`, `type`, `isSeen`, `notify_date`)"
                . " VALUES ( '".$id_ven."', '$offer_id', 'offer', '0', '".$date."')";
        mysqli_query($this->con, $query);
    }*/