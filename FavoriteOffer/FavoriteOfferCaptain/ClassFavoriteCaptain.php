<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassFavoriteCaptain
 *
 * @author Rami
 */
class ClassFavoriteCaptain {
    private $con;
    
    function __construct() {
        require '../../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
    
    private function getDate(){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        
        return $dateStart=$datetime->format('Y-m-d H:i:s');
    }
    
    private function CheckCaptainBet($cap_id,$bit,$id_offer_market,$date){
        $query="SELECT cap_cc FROM `captain_wallet` WHERE `cap_id`='".$cap_id."'";
        $row = mysqli_fetch_array(mysqli_query($this->con, $query));
        $freeCC= $row['cap_cc'];
        if($freeCC>10){
            $query1="UPDATE `captain_wallet` SET cap_cc = cap_cc - $bit WHERE `captain_wallet`.`cap_id` = $cap_id";
            mysqli_query($this->con, $query1);
            $this->DocProcessAcceptOfferMarketFromCaptain($cap_id, $bit, $id_offer_market,"bet",$date);
            return 2;
        } else {
            return 3;
        }
    }
    
    private function DocProcessAcceptOfferMarketFromCaptain($cap_id,$bit,$offer_id,$type_process,$date){
        $query="INSERT INTO `captain_proc` (`p_id`, `cap_id`, `proc_type`, `proc_value`, `proc_info`,`date`)"
                . " VALUES (NULL, '".$cap_id."', '".$type_process."', '".$bit."', '".$offer_id."','".$date."')";
        mysqli_query($this->con, $query);
    }
    
    public function SaveOfferMarketFree($ven_id,$cap_id,$id_offer_market){
        
        $dateStart= $this->getDate();
        $bet=10;
        
        $result1= $this->CheckCaptainBet($cap_id,$bet,$id_offer_market,$dateStart);
        
        if($result1==2){
                   
            $query="INSERT INTO `save_process` (`save_id`, `ven_id`, `cap_id`, `end_process`, `ven_rank`, `cap_rank`, `start_date`, `end_date`, `id_offer_cap`, `id_offer_ven`, `token`,`end_cap`)"
                    . " VALUES (NULL, '".$ven_id."', '".$cap_id."', '0', NULL, NULL, '".$dateStart."', NULL, NULL, '".$id_offer_market."', '".$bet."','0')";
            if(mysqli_query($this->con, $query)){
                return 1;
            } else {
                return 0;
            }
        } else {
            return $result1;
        }   
    }
   
    public function AddFavorite($cap_id,$ven_id,$Offer_ven_id){
        $date= $this->getDate();
        
        //$result= $this->SaveOfferMarketFree($ven_id, $cap_id, $Offer_ven_id);
      //  if ($result==1){
            $query="INSERT INTO `captain_fav` (`fav_id`, `captain_id`, `vendor_offer_id`, `f_date`) "
                . "VALUES (NULL, '".$cap_id."', '".$Offer_ven_id."', '".$date."')";
            if(mysqli_query($this->con, $query)){
                return 1;
            } else {
                return 0;
            }
        //} 
       // return $result;
    }
    
    // this to use in un-favorite : -- >
    
    public function FinishSaveProcessFromCaptain($cap_id,$save_id,$offerid) {
        $date_now= $this->getDate();
        $sql2="UPDATE `captain_wallet` SET `cap_cc`=`cap_cc`+7 WHERE `cap_id`='".$cap_id."'";
        mysqli_query($this->con, $sql2);
        
        $sql3="INSERT INTO `captain_proc` (`p_id`, `cap_id`, `proc_type`, `proc_value`, `proc_info`, `date`) "
                . "VALUES (NULL, '".$cap_id."', 'refundafterpunsh', '7', '".$offerid."', '".$date_now."')";
        mysqli_query($this->con, $sql3);

        $sql4="UPDATE `save_process` SET `end_process` = '1',`end_cap` = '1' WHERE `save_process`.`save_id` = '".$save_id."' ";
        mysqli_query($this->con, $sql4);
        return 1;
        
    }
    
    public function UnFavorite($cap_id,$offer_id,$save_id){
       // $this->FinishSaveProcessFromCaptain($cap_id, $save_id, $offer_id);
        $query="DELETE FROM `captain_fav` WHERE `captain_id`=$cap_id AND `vendor_offer_id`=$offer_id";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }

    public function SelelctMyFavorite($id){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        $date=$datetime->format('Y-m-d H:i:s');
        $query=$this->con->prepare("SELECT vendor_offer.offer_id,vendor_offer.ven_id,vendor_offer.sub_id,vendor_offer.city,vendor_offer.offer_title,vendor_offer.offer_disc,vendor_offer.offer_pic1,vendor_offer.offer_pic2,vendor_offer.offer_pic3,vendor_offer.offer_pic4,vendor_offer.offer_pic5,vendor_offer.offer_pic6,vendor_offer.offer_start,vendor_offer.offer_end,vendor_offer.isEnd,vendor.ven_name,vendor.ven_address,vendor.ven_mobile,vendor.ven_city,vendor.ven_photo_url,vendor.ven_token , vendor_offer.isPaid,vendor_offer.cost,vendor.ven_lon,vendor.ven_lat,
(SELECT TRUNCATE(avg(`cap_rank`), 2) FROM `save_process` WHERE `ven_id`=vendor_offer.ven_id)AS eval FROM vendor_offer,vendor WHERE vendor_offer.`ven_id` Not IN ( SELECT `ven_id` FROM `captain_block` WHERE `cap_id`=$id UNION SELECT `ven_id` FROM `vendor_block` WHERE `cap_id`=$id ) AND vendor_offer.ven_id=vendor.ven_id AND vendor_offer.offer_end >= '$date' AND vendor_offer.isEnd=0 AND vendor_offer.offer_id IN ( SELECT captain_fav.vendor_offer_id FROM captain_fav WHERE captain_fav.captain_id =$id ) AND vendor_offer.offer_id NOT IN (SELECT save_process.id_offer_ven FROM save_process WHERE save_process.cap_id=$id AND save_process.id_offer_ven=vendor_offer.offer_id)");//ORDER BY `captain_offer`.`offer_start` DESC 
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
           $array[]=$row;
        }
        return $array;
    }
}
