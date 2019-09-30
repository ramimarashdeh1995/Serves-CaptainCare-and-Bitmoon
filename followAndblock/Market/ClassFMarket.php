<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassFMarket
 *
 * @author Rami
 */
class ClassFMarket {
     private $con;
    
    function __construct() {
        require '../../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
    public function AddFollowMarket($ven_id,$cap_id){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        $date=$datetime->format('Y-m-d H:i:s');
        $query="INSERT INTO `vendor_follow` (`ven_id`, `cap_id`, `f_date`) VALUES ('".$ven_id."', '".$cap_id."', '".$date."')";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
    public function UnFollowMarket($f_id){
        $query="DELETE FROM `vendor_follow` WHERE `vendor_follow`.`f_id` = '".$f_id."'";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
     public function UnfollowMarket2($cap_id,$ven_id){
        $query="DELETE FROM `vendor_follow` WHERE `vendor_follow`.`cap_id` = '".$cap_id."' AND `vendor_follow`.`ven_id` = '".$ven_id."'";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
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

    public function BlockMarket($ven_id,$cap_id){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        $date=$datetime->format('Y-m-d H:i:s');
        if($this->IsCaptainFollowinMarket($ven_id, $cap_id)){
            $this->DeletFollowMarket($ven_id, $cap_id);
        }
        if($this->IsMarketFollowingCaptain($ven_id, $cap_id)){
            $this->DeletFollowCaptain($ven_id, $cap_id);
        }
        $query="INSERT INTO `captain_block` (`cap_id`, `ven_id`, `b_date`) VALUES ('".$cap_id."', '".$ven_id."', '".$date."')";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
    public function UnBlockMarket($b_id){
        $query="DELETE FROM `captain_block` WHERE `captain_block`.`b_id` = '".$b_id."'";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
     public function SelectFolloingMarket($ven_id){
        $query=$this->con->prepare("SELECT captain.cap_id,captain.cap_name,captain.cap_mobile,captain.cap_city,
captain.cap_photo_url,captain.cap_token FROM captain,captain_follow
WHERE captain.cap_id = captain_follow.cap_id AND captain_follow.ven_id='".$ven_id."'");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    } //,(select captain_follow.ven_id from captain_follow where captain_follow.ven_id=vendor_follow.ven_id and vendor_follow.cap_id =captain_follow.cap_id) as isfollow
    public function SelectFollowers($ven_id){
        
         $query=$this->con->prepare("SELECT captain.cap_id,captain.cap_name,captain.cap_mobile,captain.cap_city,
captain.cap_photo_url,captain.cap_token,(select captain_follow.ven_id from captain_follow where captain_follow.ven_id=vendor_follow.ven_id and vendor_follow.cap_id =captain_follow.cap_id) as isfollow FROM captain,vendor_follow
WHERE captain.cap_id = vendor_follow.cap_id AND vendor_follow.ven_id='".$ven_id."'");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    }
    public function SelectBlock($ven_id){
        $query=$this->con->prepare("SELECT captain.cap_id,captain.cap_name,captain.cap_photo_url,captain.cap_token,vendor_block.b_id 
FROM captain,vendor_block
WHERE captain.cap_id=vendor_block.cap_id AND vendor_block.ven_id='".$ven_id."'");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    }
}
