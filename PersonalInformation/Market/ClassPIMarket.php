<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassPIMarket
 *
 * @author Rami
 */
class ClassPIMarket {
    private $con;
    function __construct() {
        require '../../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
    public function IsCaptainFollowingMarket($cap_id,$ven_id){
        $query="SELECT * FROM vendor_follow WHERE vendor_follow.cap_id='".$cap_id."' AND vendor_follow.ven_id='".$ven_id."'";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return 0;
        }
        else{
            return 1;
        }
    }
    public function SelectInformationMarket($id){
        $query="SELECT vendor.ven_id,vendor.ven_name,vendor.ven_mobile,vendor.ven_city,vendor.ven_address,vendor.ven_lon,vendor.ven_lat,vendor.ven_photo_url, vendor.about_me,vendor.ven_isActive,vendor.venl,vendor.Blocked,vendor.ven_token,vendor_wallet.w_id,vendor_wallet.vendor_cc,vendor_wallet.PO4H,
vendor_wallet.PO8H,vendor_wallet.PO24H,vendor_wallet.PO72H,vendor_wallet.PO120H,vendor_wallet.PO168H,
vendor_wallet.AP4H,vendor_wallet.AP8H,vendor_wallet.AP24H,vendor_wallet.AP72H,vendor_wallet.AP120H,
vendor_wallet.AP168H,vendor_wallet.RPR,vendor_wallet.APR,vendor_wallet.vendor_plan,vendor_wallet.vendor_plan_end,
vendor_plan.plan_id,vendor_plan.plan_name_en,vendor_plan.plan_name_ar,vendor_plan.plan_logo,vendor_plan.plan_period,
vendor_plan.plan_price ,(SELECT TRUNCATE(avg(`cap_rank`), 2) as eval FROM `save_process` WHERE `ven_id`=$id)as eval FROM vendor,vendor_wallet,vendor_plan 
WHERE vendor_wallet.vendor_id=vendor.ven_id AND vendor_wallet.vendor_plan=vendor_plan.plan_id AND vendor.ven_id=$id";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);
    }
    public function SelectInformaionMarketFromCaptain($ven_id){
        $query="SELECT vendor.ven_id,vendor.ven_name,vendor.ven_mobile,vendor.ven_city,vendor.ven_address,vendor.ven_lon,vendor.ven_lat,vendor.ven_photo_url, vendor.about_me,vendor.ven_isActive,vendor.Blocked,vendor.ven_token,(SELECT TRUNCATE(avg(`cap_rank`), 2) as eval FROM `save_process` WHERE `ven_id`=$ven_id)as eval FROM vendor WHERE vendor.ven_id='".$ven_id."'";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);
    }
    public function SelectCounterMarketFollowers($ven_id){
        $query="SELECT COUNT(captain_follow.ven_id) FROM captain_follow WHERE captain_follow.ven_id='".$ven_id."'";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);
    }
    public function SelectCounterMarketFollowing($ven_id){
        $query="SELECT COUNT(vendor_follow.ven_id) FROM vendor_follow WHERE vendor_follow.ven_id='".$ven_id."'";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);
    }
     public function SelectCounterMarketBlock($ven_id){
        $query="SELECT COUNT(vendor_block.ven_id) FROM vendor_block WHERE vendor_block.ven_id='".$ven_id."'";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);
    }
    
    // Update About Me : 
    public function UpdateAboutMarket($ven_id,$about){
        $query="UPDATE `vendor` SET `about_me` = '".$about."' WHERE `vendor`.`ven_id` = '".$ven_id."'";
        if (mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
    
}
