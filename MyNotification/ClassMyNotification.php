<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassMyNotification
 *
 * @author Rami
 */
class ClassMyNotification {
    private $con;
    
    function __construct() {
        require '../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
     private function getDate(){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        
        return $dateStart=$datetime->format('Y-m-d H:i:s');
    }


    
    private function ReadQueryVendor($query){
        $result= mysqli_query($this->con, $query);
        if($result){
            $array=array();
            while($rew=mysqli_fetch_assoc($result)){
                $array[]=$rew;
                
            }
            return $array;
        } else {
            return 0;
        }
    
    }
    private function getOfferMarket($offerid,$idN){
        $date=$this->getDate();
        $array=array();
        $query="SELECT vendor.ven_name,vendor.ven_city,vendor.ven_address,vendor.ven_lon,vendor.ven_lat,vendor.ven_photo_url,
vendor_offer.offer_id,vendor_offer.ven_id,vendor_offer.sub_id,vendor_offer.city,vendor_offer.offer_title,vendor_offer.offer_disc,vendor_offer.cost,(TIMEDIFF(vendor_offer.offer_end,'$date') ) as timeend ,vendor_offer.isEnd ,(SELECT captain_notify.notify_date FROM captain_notify WHERE captain_notify.notify_id=$idN) as dateend
FROM vendor_offer,vendor WHERE vendor_offer.ven_id=vendor.ven_id AND vendor_offer.offer_id=$offerid";
        $row= mysqli_fetch_array(mysqli_query($this->con, $query));
        $array['name']=$row['ven_name'];
        $array['city']=$row['ven_city'];
        $array['address']=$row['ven_address'];
        $array['lon']=$row['ven_lon'];
        $array['lat']=$row['ven_lat'];
        $array['imag']=$row['ven_photo_url'];
        $array['offerid']=$row['offer_id'];
        $array['ven_id']=$row['ven_id'];
        $array['sub_id']=$row['sub_id'];
        $array['city_offer']=$row['city'];
        $array['title']=$row['offer_title'];
        $array['disc']=$row['offer_disc'];
        $array['cost']=$row['cost'];
        $array['time']=$row['timeend'];
         $array['type']="offerVendor";
          $array['dateend']=$row['dateend'];
           $array['isend']=$row['isEnd'];
        
        return $array;

    }
    
    private function getOfferCaptain($idOffer,$ven_id,$idN){
         $date=$this->getDate();
        $array=array();
        $query="SELECT vendor.ven_name,vendor.ven_city,vendor.ven_address,vendor.ven_lon,vendor.ven_lat,vendor.ven_photo_url,vendor.ven_id,
captain_offer.offer_id,captain_offer.sub_id,captain_offer.city,captain_offer.offer_title,captain_offer.offer_disc,captain_offer.cost ,( TIMEDIFF(captain_offer.offer_end,'$date')) as timeend , captain_offer.isEnd ,(SELECT captain_notify.notify_date FROM captain_notify WHERE captain_notify.notify_id=$idN) as dateend
FROM captain_offer,vendor WHERE captain_offer.offer_id=$idOffer AND vendor.ven_id=$ven_id";
        $row= mysqli_fetch_array(mysqli_query($this->con, $query));
        $array['name']=$row['ven_name'];
        $array['city']=$row['ven_city'];
        $array['address']=$row['ven_address'];
        $array['lon']=$row['ven_lon'];
        $array['lat']=$row['ven_lat'];
        $array['imag']=$row['ven_photo_url'];
        $array['offerid']=$row['offer_id'];
        $array['ven_id']=$row['ven_id'];
        $array['sub_id']=$row['sub_id'];
        $array['city_offer']=$row['city'];
        $array['title']=$row['offer_title'];
        $array['disc']=$row['offer_disc'];
        $array['cost']=$row['cost'];
        $array['time']=$row['timeend'];
        $array['type']="offerCaptain";
        $array['dateend']=$row['dateend'];
        $array['isend']=$row['isEnd'];
        return $array;
    
    }
    
     private function ReadQueryCaptain($query){
        $result= mysqli_query($this->con, $query);
        if($result){
            $array=array();
            while($row=mysqli_fetch_assoc($result)){
                 if($row['type'] == "offer" ){
                    $OFFERMARKET=$this->getOfferMarket($row['ven_offer_id'],$row['notify_id']);
                    
                    $array[]=$OFFERMARKET;
                    
                  
                     
                }else if($row['type']=="acceptoffercaptain"){
                     $OFFERCAPTAIN=$this->getOfferCaptain($row['ven_offer_id'],$row['ven_id'],$row['notify_id']);
                    
                     $array[]=$OFFERCAPTAIN;
                }
            }
            return $array;
        } else {
            return 0;
        }
    
    }

    public function SelectAllNotificationCaptain($id){
        $query="SELECT * FROM captain_notify WHERE captain_notify.cap_id='".$id."' ORDER BY `captain_notify`.`notify_id` DESC ";
        return $this->ReadQueryCaptain($query);
    }
    
    
    
     public function SelectAllNotificationMarket($id){
        $query="SELECT vendor_notify.notify_id,vendor_notify.cap_offer_id,vendor_notify.type,vendor_notify.isSeen,vendor_notify.notify_date, captain_offer.cap_id,captain_offer.sub_id,captain_offer.city,captain_offer.offer_title,captain_offer.offer_disc,captain_offer.offer_pic1, captain_offer.offer_start,captain_offer.offer_end,captain_offer.isEnd,captain_offer.isPaid,captain_offer.cost,captain_offer.address, captain.cap_name,captain.cap_photo_url,captain.cap_mobile FROM vendor_notify,captain_offer,captain WHERE vendor_notify.ven_id=$id AND vendor_notify.type LIKE 'offer' AND vendor_notify.cap_offer_id=captain_offer.offer_id AND captain_offer.cap_id=captain.cap_id ORDER BY `vendor_notify`.`notify_id` DESC";
        return $this->ReadQueryVendor($query);
    }
}

/*
  $array['name']=$OFFERMARKET['name'];
                    $array['city']=$OFFERMARKET['city'];
                     $array['address']=$OFFERMARKET['address'];
                   $array['lon']=$OFFERMARKET['lon'];
                   $array['lat']=$OFFERMARKET['lat'];
                     $array['imag']=$OFFERMARKET['imag'];
                     $array['offerid']=$OFFERMARKET['offerid'];
                      $array['ven_id']=$OFFERMARKET['ven_id'];
                     $array['sub_id']=$OFFERMARKET['sub_id'];
                      $array['city_offer']=$OFFERMARKET['city_offer'];
                    $array['title']=$OFFERMARKET['title'];
                     $array['disc']=$OFFERMARKET['disc'];
                     $array['cost']=$OFFERMARKET['cost'];
                     */
/*
 $array['name']=$OFFERCAPTAIN['name'];
                    $array['city']=$OFFERCAPTAIN['city'];
                     $array['address']=$OFFERCAPTAIN['address'];
                   $array['lon']=$OFFERCAPTAIN['lon'];
                   $array['lat']=$OFFERCAPTAIN['lat'];
                     $array['imag']=$OFFERCAPTAIN['imag'];
                     $array['offerid']=$OFFERCAPTAIN['offerid'];
                      $array['ven_id']=$OFFERCAPTAIN['ven_id'];
                     $array['sub_id']=$OFFERCAPTAIN['sub_id'];
                      $array['city_offer']=$OFFERCAPTAIN['city_offer'];
                    $array['title']=$OFFERCAPTAIN['title'];
                     $array['disc']=$OFFERCAPTAIN['disc'];
                     $array['cost']=$OFFERCAPTAIN['cost'];
*/