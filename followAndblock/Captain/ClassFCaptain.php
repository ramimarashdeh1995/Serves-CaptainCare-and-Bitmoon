<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassFCaptain
 *
 * @author Rami
 */
class ClassFCaptain {
    private $con;
    
    function __construct() {
        require '../../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
    public function AddFollowCaptain($cap_id,$ven_id){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        $date=$datetime->format('Y-m-d H:i:s');
        $query="INSERT INTO `captain_follow` (`cap_id`, `ven_id`, `f_date`) VALUES ('".$cap_id."', '".$ven_id."', '".$date."')";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
    public function UnFollowCaptain($f_id){
        $query="DELETE FROM `captain_follow` WHERE `captain_follow`.`f_id` = '".$f_id."'";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
    public function UnfollowCaptain2($cap_id,$ven_id){
        $query="DELETE FROM `captain_follow` WHERE `captain_follow`.`cap_id` = '".$cap_id."' AND `captain_follow`.`ven_id` = '".$ven_id."'";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }

    private function IsMarketFollowingCaptain($ven_id,$cap_id){
        $query="SELECT * FROM `captain_follow` WHERE `cap_id` = '".$cap_id."' AND `ven_id` = '".$ven_id."' ";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return false;
        }
        else{
            return true;
        }
    }
    private function DeletFollowCaptain($ven_id,$cap_id){
        $query="DELETE FROM `captain_follow` WHERE `cap_id`='".$cap_id."' AND `ven_id`='".$ven_id."'";
        mysqli_query($this->con, $query);
    }

     private function IsCaptainFollowinMarket($ven_id,$cap_id){
        $query="SELECT * FROM `vendor_follow` WHERE `cap_id` = '".$cap_id."' AND `ven_id` = '".$ven_id."' ";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return false;
        }
        else{
            return true;
        }
    }
    private function DeletFollowMarket($ven_id,$cap_id){
        $query="DELETE FROM `vendor_follow` WHERE `cap_id`='".$cap_id."' AND `ven_id`='".$ven_id."'";
        mysqli_query($this->con, $query);
    }
    public function BlockCaptain($ven_id,$cap_id){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        $date=$datetime->format('Y-m-d H:i:s');
        if($this->IsMarketFollowingCaptain($ven_id, $cap_id)){
            $this->DeletFollowCaptain($ven_id, $cap_id);
        }
        if($this->IsCaptainFollowinMarket($ven_id, $cap_id)){
            $this->DeletFollowMarket($ven_id, $cap_id);
        }
        $query="INSERT INTO `vendor_block` (`ven_id`, `cap_id`, `b_date`) VALUES ('".$ven_id."', '".$cap_id."', '".$date."')";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
    public function UnBlockCaptain($b_id){
        $query="DELETE FROM `vendor_block` WHERE `vendor_block`.`b_id` = '".$b_id."'";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
    public function SelectFolloingCaptain($cap_id){
        $query=$this->con->prepare("SELECT vendor.ven_id,vendor.ven_name,vendor.ven_mobile,vendor.ven_city,vendor.ven_address,vendor.ven_lon,vendor.ven_lat, vendor.ven_photo_url,vendor.ven_token FROM vendor,vendor_follow WHERE vendor.ven_id=vendor_follow.ven_id AND vendor_follow.cap_id='".$cap_id."'");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    }//,(select fav_id from vendor_fav where vendor_fav.captain_offer_id=captain_offer.offer_id and vendor_fav.vendor_id =$ven_id) as isfollow
    //,(select vendor_follow.cap_id from vendor_follow where vendor_follow.cap_id=captain_follow.cap_id and vendor_follow.ven_id =captain_follow.ven_id) as isfollow
    
    //(select vendor_follow.cap_id from vendor_follow where vendor_follow.cap_id=captain_follow.cap_id and vendor_follow.ven_id =captain_follow.ven_id) as isfollow
    public function SelectFollowers($cap_id){
         $query=$this->con->prepare("SELECT vendor.ven_id,vendor.ven_name,vendor.ven_mobile,vendor.ven_city,vendor.ven_address,vendor.ven_lon,vendor.ven_lat, vendor.ven_photo_url,vendor.ven_token,(select vendor_follow.cap_id from vendor_follow where vendor_follow.cap_id=captain_follow.cap_id and vendor_follow.ven_id =captain_follow.ven_id) as isfollow FROM vendor,captain_follow WHERE captain_follow.ven_id=vendor.ven_id AND captain_follow.cap_id='".$cap_id."'");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    }
    public function SelectBlock($cap_id){
        $query=$this->con->prepare("SELECT vendor.ven_id,vendor.ven_name,vendor.ven_photo_url,vendor.ven_token,captain_block.b_id 
FROM vendor,captain_block
WHERE vendor.ven_id=captain_block.ven_id AND captain_block.cap_id='".$cap_id."'");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    }
}
