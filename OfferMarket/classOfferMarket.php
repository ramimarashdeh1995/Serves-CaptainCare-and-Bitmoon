<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classOfferMarket
 *
 * @author Rami
 */
class classOfferMarket {
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
     public function getAllTokens_Captain(){
        $stmt = $this->con->prepare("SELECT captain.cap_token FROM captain WHERE captain.cap_token NOT LIKE '0'");//query select all token captain and not select captain block
        $stmt->execute(); 
        $result = $stmt->get_result();
        $tokens = array(); 
        while($token = $result->fetch_assoc()){
            array_push($tokens, $token['cap_token']);
        }
        return $tokens; 
    }
    private function CheckMarketCC($ven_id){
        $query="SELECT vendor_cc FROM `vendor_wallet` WHERE `vendor_id`='".$ven_id."'";
        $row = mysqli_fetch_array(mysqli_query($this->con, $query));
        $CC= $row['vendor_cc'];      
        if($CC>0){
            return true;
        } else {
            return false;
        }
    }

    private function CheckMyHaveFreeCC($ven_id,$period){
        if($this->CheckMarketCC($ven_id)){
            $query="SELECT $period FROM `vendor_wallet` WHERE `vendor_id`='".$ven_id."'";
            $row = mysqli_fetch_array(mysqli_query($this->con, $query));
            $freeCC= $row[$period];
            if($freeCC>0){
                $query1="UPDATE `vendor_wallet` SET $period = $period - 1 WHERE `vendor_wallet`.`vendor_id` = $ven_id";
                mysqli_query($this->con, $query1);
                return 1;
            } else {
                return $this->CheckMyHaveCC($ven_id,$period);
            }
        } else {
            return 4;
        }
    }
    private function CheckMyHaveCC($ven_id,$period){
        $query="SELECT vendor_cc FROM `vendor_wallet` WHERE `vendor_id`='".$ven_id."'";
        $row = mysqli_fetch_array(mysqli_query($this->con, $query));
        $CC= $row['vendor_cc'];
        $period1=$period."_price";
        $query2="SELECT $period1 FROM `vendor_plan_price` WHERE 1";
        $row2 = mysqli_fetch_array(mysqli_query($this->con, $query2));
        $price= $row2[$period1];
        if($CC>$price){
            $query1="UPDATE `vendor_wallet` SET `vendor_cc` = (`vendor_cc`-$price) WHERE `vendor_wallet`.`vendor_id` = $ven_id";
            mysqli_query($this->con, $query1);
            $this->InsertTableVendorProcess($ven_id, $price);
            return 2;
        } else {
            return 0;
        }
    }
    private function InsertTableVendorProcess($idVen,$price){
        $date= $this->getDate();
         $query3="INSERT INTO `vendor_proc` (`p_id`, `ven_id`, `proc_type`, `proc_value`, `proc_info`, `date`) "
                 . "VALUES (NULL, '".$idVen."', 'AddOffer', '".$price."', 'Null', '".$date."')";
         mysqli_query($this->con, $query3);
         $this->id_proc= $this->con->insert_id;
    }
    private function UpdateTableVendorProcess($id,$result){
         if($result==2){
            $query="UPDATE `vendor_proc` SET `proc_info`='".$id."' WHERE `p_id`='".$this->id_proc."'";
            mysqli_query($this->con, $query);
        }
    }

    public function InsertPushOffer($ven_id,$sub_id,$city,$offer_title,$offer_disc,$offer_pic1,$offer_pic2,$offer_pic3,$offer_pic4,$offer_pic5,$offer_pic6,$end_date,$cost){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));   $date_creat_acc=$datetime->format('Y-m-d H:i:s');
        $date_creat_pic=$datetime->format('YmdHis');     $timeA = new DateTime("now",new DateTimeZone('GMT+3'));
        $timeB = new DateInterval("PT".$end_date."H0M0S"); 
        $timeA->add($timeB);
        
        $period= "PO"."$end_date"."H";

        $result=$this->CheckMyHaveFreeCC($ven_id, $period);
        if($result==1 || $result==2){
            $query="INSERT INTO `vendor_offer`"
                . " (`ven_id`, `sub_id`, `city`, `offer_title`, `offer_disc`, `offer_pic1`, `offer_pic2`, `offer_pic3`, `offer_pic4`, `offer_pic5`, `offer_pic6`, `offer_start`, `offer_end`, `isEnd`,`isPaid`,`cost`,`chkd`) "
                . "VALUES ( '".$ven_id."', '".$sub_id."', '".$city."', '".$offer_title."', '".$offer_disc."', '".$this->Insertpic($offer_pic1, $ven_id,$date_creat_pic,"insert1")."', '".$this->Insertpic($offer_pic2, $ven_id, $date_creat_pic,"insert2")."', '".$this->Insertpic($offer_pic3, $ven_id, $date_creat_pic,"insert3")."', '".$this->Insertpic($offer_pic4, $ven_id, $date_creat_pic,"insert4")."', '".$this->Insertpic($offer_pic5, $ven_id, $date_creat_pic,"insert5")."', '".$this->Insertpic($offer_pic6, $ven_id, $date_creat_pic,"insert6")."', '".$date_creat_acc."', '".$timeA->format('Y-m-d H:i:s')."', '0','1','".$cost."','0')";
             if(mysqli_query($this->con, $query)){
                 $id= $this->con->insert_id;
                 $this->UpdateTableVendorProcess($id,$result);
                 return $result;
            } else {
                return 0;
            }
        } else {
            return 3;
        }
        
    }
    
    public function InsertOffer($ven_id,$sub_id,$city,$offer_title,$offer_disc,$offer_pic1,$offer_pic2,$offer_pic3,$offer_pic4,$offer_pic5,$offer_pic6,$end_date,$cost){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));        $date_creat_acc=$datetime->format('Y-m-d H:i:s');
        $date_creat_pic=$datetime->format('YmdHis');        $timeA = new DateTime("now",new DateTimeZone('GMT+3'));
        $timeB = new DateInterval("PT".$end_date."H0M0S"); 
        $timeA->add($timeB);

         $period= "AP"."$end_date"."H";

        $result=$this->CheckMyHaveFreeCC($ven_id, $period);
        if($result==1 || $result==2){
             $query="INSERT INTO `vendor_offer`"
                . " (`ven_id`, `sub_id`, `city`, `offer_title`, `offer_disc`, `offer_pic1`, `offer_pic2`, `offer_pic3`, `offer_pic4`, `offer_pic5`, `offer_pic6`, `offer_start`, `offer_end`, `isEnd`,`isPaid`,`cost`,`chkd`)"
                . "VALUES ( '".$ven_id."', '".$sub_id."', '".$city."', '".$offer_title."', '".$offer_disc."', '".$this->Insertpic($offer_pic1, $ven_id, $date_creat_pic,"insert1")."', '".$this->Insertpic($offer_pic2, $ven_id, $date_creat_pic,"insert2")."', '".$this->Insertpic($offer_pic3, $ven_id, $date_creat_pic,"insert3")."', '".$this->Insertpic($offer_pic4, $ven_id, $date_creat_pic,"insert4")."', '".$this->Insertpic($offer_pic5, $ven_id, $date_creat_pic,"insert5")."', '".$this->Insertpic($offer_pic6, $ven_id, $date_creat_pic,"insert6")."', '".$date_creat_acc."', '".$timeA->format('Y-m-d H:i:s')."', '0','0','".$cost."','0')";
             if(mysqli_query($this->con, $query)){
                 $id= $this->con->insert_id;
                 $this->UpdateTableVendorProcess($id,$result);
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
            $path = "ImageOfferMarket/$picName$ven_id$date_creat_acc.png";
            file_put_contents($path,base64_decode($offer_pic));
            return $actualpath1 = "https://captain-care.org/ccapp/OfferMarket/$path";
        }
    }
    public function UpdateOffer($id,$city,$offer_title,$offer_disc,$offer_pic1,$offer_pic2,$offer_pic3,$offer_pic4,$offer_pic5,$offer_pic6,$cost){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        $date_creat_pic=$datetime->format('YmdHis');
        
        $this->GetIdForDelet($id);
        
        $query="UPDATE `vendor_offer` SET `city` = '".$city."', `offer_title` = '".$offer_title."', `offer_disc` = '".$offer_disc."', `offer_pic1` = '".$this->Insertpic($offer_pic1, $id, $date_creat_pic,"Update1")."', `offer_pic2` = '".$this->Insertpic($offer_pic2, $id, $date_creat_pic,"Update2")."', `offer_pic3` = '".$this->Insertpic($offer_pic3, $id, $date_creat_pic,"Update3")."', `offer_pic4` = '".$this->Insertpic($offer_pic4, $id, $date_creat_pic,"Update4")."', `offer_pic5` = '".$this->Insertpic($offer_pic5, $id, $date_creat_pic,"Update5")."', `offer_pic6` = '".$this->Insertpic($offer_pic6, $id, $date_creat_pic,"Update6")."',`cost`='".$cost."',`chkd`='0' WHERE `vendor_offer`.`offer_id` = '".$id."'";
        return $this->ReadQuery($query);
    }
    public function DeleteOffer($id){
        $this->GetIdForDelet($id);
        $query="DELETE FROM `vendor_offer` WHERE `vendor_offer`.`offer_id` = '".$id."'";
        return $this->ReadQuery($query);
    }
    public function endOfferMarket($id){
        $query="UPDATE `vendor_offer` SET `isEnd` = '1' WHERE `vendor_offer`.`offer_id` = '".$id."'";
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
        $query1="SELECT vendor_offer.offer_pic1 FROM vendor_offer WHERE vendor_offer.offer_id='".$id."'";
        $result= mysqli_query($this->con, $query1);
        $pic1= mysqli_fetch_row($result);
        $pic=$pic1[0];
        $this->CheakForImage($pic);
    }
    private function DeletePic2($id){
        $query1="SELECT vendor_offer.offer_pic2 FROM vendor_offer WHERE vendor_offer.offer_id='".$id."'";
        $result= mysqli_query($this->con, $query1);
        $pic1= mysqli_fetch_row($result);
        $pic=$pic1[0];
        $this->CheakForImage($pic);
    }
    private function DeletePic3($id){
        $query1="SELECT vendor_offer.offer_pic3 FROM vendor_offer WHERE vendor_offer.offer_id='".$id."'";
        $result= mysqli_query($this->con, $query1);
        $pic1= mysqli_fetch_row($result);
        $pic=$pic1[0];
        $this->CheakForImage($pic);
    }
     private function DeletePic4($id){
         $query1="SELECT vendor_offer.offer_pic4 FROM vendor_offer WHERE vendor_offer.offer_id='".$id."'";
        $result= mysqli_query($this->con, $query1);
        $pic1= mysqli_fetch_row($result);
        $pic=$pic1[0];
        $this->CheakForImage($pic);
    }
     private function DeletePic5($id){
         $query1="SELECT vendor_offer.offer_pic5 FROM vendor_offer WHERE vendor_offer.offer_id='".$id."'";
        $result= mysqli_query($this->con, $query1);
        $pic1= mysqli_fetch_row($result);
        $pic=$pic1[0];
        $this->CheakForImage($pic);
    }
     private function DeletePic6($id){
         $query1="SELECT vendor_offer.offer_pic6 FROM vendor_offer WHERE vendor_offer.offer_id='".$id."'";
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
        if(file_exists(str_replace("https://captain-care.org/ccapp/OfferMarket/", "", $pic))){
            unlink(str_replace("https://captain-care.org/ccapp/OfferMarket/", "", $pic));
        } else {
        }
    }
    public function ChekIsEndDate($id){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        $datetimeServer=$datetime->format('Y-m-d H:i:s'); 
        $query=$this->con->prepare("SELECT * FROM `vendor_offer`  WHERE `vendor_offer`.`ven_id`='".$id."'");
        $query->execute();
        $result=$query->get_result();
        while($row=mysqli_fetch_assoc($result)){
            if($row['offer_end']<$datetimeServer){
                $this->UpdateEndDate($row['offer_id']);
            }
        }
    }
    private function UpdateEndDate($id){
        $query="UPDATE `vendor_offer` SET `isEnd` = '1' WHERE `vendor_offer`.`offer_id` = '".$id."'";
        mysqli_query($this->con, $query);
    }
    public function SelectMyOffer($id){
        $query=$this->con->prepare("SELECT vendor_offer.offer_id,vendor_offer.ven_id,vendor_offer.sub_id,sub_category.c_id,sub_category.sub_name,sub_category.sub_name_ar,vendor_offer.city, vendor_offer.offer_title,vendor_offer.offer_disc,vendor_offer.offer_pic1,vendor_offer.offer_pic2,vendor_offer.offer_pic3,vendor_offer.offer_pic4, vendor_offer.offer_pic5,vendor_offer.offer_pic6,vendor_offer.offer_start,vendor_offer.offer_end,vendor_offer.isEnd FROM vendor_offer,sub_category WHERE vendor_offer.ven_id='".$id."' AND sub_category.s_id=vendor_offer.sub_id  ORDER BY `vendor_offer`.`offer_id` DESC ");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    }
     public function SelectMarketOffer($sub_id,$cap_id){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        $date=$datetime->format('Y-m-d H:i:s');     
        $query=$this->con->prepare("SELECT vendor_offer.offer_id,vendor_offer.ven_id,vendor_offer.sub_id,vendor_offer.city,vendor_offer.offer_title,vendor_offer.offer_disc, vendor_offer.offer_pic1,vendor_offer.offer_pic2,vendor_offer.offer_pic3,vendor_offer.offer_pic4,vendor_offer.offer_pic5,vendor_offer.offer_pic6,vendor_offer.offer_start,vendor_offer.offer_end,vendor_offer.isEnd,vendor.ven_name,vendor.ven_address,vendor.ven_mobile, vendor.ven_city,vendor.ven_photo_url,vendor.ven_token ,vendor.ven_lon,vendor.ven_lat,(select fav_id from captain_fav where captain_fav.vendor_offer_id=vendor_offer.offer_id and captain_fav.captain_id=$cap_id) as isfav , vendor_offer.isPaid,vendor_offer.cost , (SELECT TRUNCATE(avg(`cap_rank`), 2) FROM `save_process` WHERE `ven_id`=vendor_offer.ven_id) AS eval FROM vendor_offer,vendor WHERE vendor_offer.`sub_id`=$sub_id and vendor_offer.`ven_id` Not IN ( SELECT `ven_id` FROM `captain_block` WHERE `cap_id`=$cap_id UNION SELECT `ven_id` FROM `vendor_block` WHERE `cap_id`=$cap_id ) AND vendor_offer.ven_id=vendor.ven_id AND vendor_offer.offer_end >= '$date' AND vendor_offer.chkd = '1'  AND vendor_offer.isEnd NOT LIKE '1' AND vendor_offer.offer_id NOT IN (SELECT save_process.id_offer_ven FROM save_process WHERE  save_process.cap_id=$cap_id  and save_process.id_offer_ven=vendor_offer.offer_id) ORDER BY `vendor_offer`.`offer_id` DESC ");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    }
    
     public function SelectOfferCaptainFromNotification($cap_id,$ven_id,$offer_id){
        
        if($this->CheckOfferIsEnd($offer_id)){
            return 1;
        }else{
             $query =$this->con->prepare("SELECT captain_offer.offer_id,captain_offer.cap_id,captain_offer.sub_id,captain_offer.city,captain_offer.offer_title,captain_offer.offer_disc, captain_offer.offer_pic1,captain_offer.offer_pic2,captain_offer.offer_pic3,captain_offer.offer_pic4,captain_offer.offer_pic5,captain_offer.offer_pic6, captain_offer.offer_start,captain_offer.offer_end,captain_offer.isEnd, captain.cap_name,captain.cap_mobile,captain.cap_city,captain.cap_photo_url,captain_offer.isPaid, captain_offer.cost,captain_offer.address, (SELECT TRUNCATE(avg(`ven_rank`), 2) FROM `save_process` WHERE `cap_id`=captain_offer.cap_id)AS eval,(select fav_id from vendor_fav where vendor_fav.captain_offer_id=captain_offer.offer_id and vendor_fav.vendor_id =$ven_id) as isfav FROM captain_offer,captain WHERE captain_offer.offer_id=$offer_id AND captain_offer.cap_id=captain.cap_id  ");
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
        $query=$this->con->prepare("SELECT * FROM captain_offer WHERE captain_offer.isEnd =0 AND captain_offer.offer_id=$offer_id");
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


   /* public function IsOfferFavorite($cap_id){
        $query=$this->con->prepare("SELECT captain_fav.vendor_offer_id FROM captain_fav WHERE captain_fav.captain_id='".$cap_id."'");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    }*/
}
/*
     private function saveNotification($offer_id,$date){
        $stmt=$this->con->prepare("SELECT captain.cap_id FROM captain WHERE captain.cap_token NOT LIKE '0'");
        $stmt->execute(); 
        $result = $stmt->get_result();
        while($row=mysqli_fetch_assoc($result)){
            $this->SaveTableNotification($row['cap_id'], $offer_id, $date);
        }
    }
    private function SaveTableNotification($id_cap,$offer_id,$date){
        $query="INSERT INTO `captain_notify` (`cap_id`, `ven_offer_id`, `type`, `isSeen`, `notify_date`)"
                . " VALUES ( '".$id_cap."', '$offer_id', 'offer', '0', '".$date."')";
        mysqli_query($this->con, $query);
    }*/
/* $offer_id=$this->con->insert_id;
            if($offer_pic1==""){
                $this->saveNotification($offer_id,$date_creat_acc);
                return $this->getPush($offer_title, $offer_disc, null, "offerMarket", $this->con->insert_id);
            } else {
                 $this->saveNotification($offer_id,$date_creat_acc);
                 return $this->getPush($offer_title, $offer_disc, $pic_offer_1, "offerMarket", $this->con->insert_id);
            }*/