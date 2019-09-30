<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassFavoriteMarket
 *
 * @author Rami
 */
class ClassFavoriteMarket {

     private $con;
    
    function __construct() {
        require '../../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
    
    public function AddFavorite($ven_id,$Offer_cap_id){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        $date=$datetime->format('Y-m-d H:i:s');
        $query="INSERT INTO `vendor_fav` (`fav_id`, `vendor_id`, `captain_offer_id`, `f_date`)"
                . " VALUES (NULL, '".$ven_id."', '".$Offer_cap_id."', '".$date."')";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
    
    public function UnFavorite($ven_id,$offer_id){
        $query="DELETE FROM `vendor_fav` WHERE `vendor_id`=$ven_id AND `captain_offer_id`=$offer_id";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }

    public function SelelctMyFavorite($id){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        $date=$datetime->format('Y-m-d H:i:s');
        $query=$this->con->prepare("SELECT captain_offer.offer_id,captain_offer.cap_id,captain_offer.sub_id,captain_offer.city,captain_offer.offer_title,captain_offer.offer_disc,captain_offer.offer_pic1,captain_offer.offer_pic2,captain_offer.offer_pic3,captain_offer.offer_pic4,captain_offer.offer_pic5,captain_offer.offer_pic6,captain_offer.offer_start,captain_offer.offer_end,captain_offer.isEnd,captain.cap_name,captain.cap_mobile,captain.cap_city,captain.cap_photo_url,captain.cap_token ,captain_offer.isPaid,captain_offer.cost,captain_offer.address,
(SELECT TRUNCATE(avg(`ven_rank`), 2)  FROM `save_process` WHERE `cap_id`=captain_offer.cap_id)AS eval FROM captain_offer,captain WHERE captain_offer.`cap_id` Not IN ( SELECT `cap_id` FROM `captain_block` WHERE `ven_id`=$id UNION SELECT `cap_id` FROM `vendor_block` WHERE `ven_id`=$id ) AND captain_offer.cap_id=captain.cap_id AND captain_offer.isEnd = '0' AND captain_offer.offer_id IN ( SELECT vendor_fav.captain_offer_id FROM vendor_fav WHERE vendor_fav.vendor_id =$id )");//ORDER BY `captain_offer`.`offer_start` DESC 
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
           $array[]=$row;
        }
        return $array;
    }
}
