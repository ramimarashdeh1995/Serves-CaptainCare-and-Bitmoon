<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassPICaptain
 *
 * @author Rami
 */
class ClassPICaptain {    
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

    public function IsMarketFollowingCaptain($cap_id,$ven_id){
        $query="SELECT * FROM captain_follow WHERE captain_follow.cap_id='".$cap_id."' AND captain_follow.ven_id='".$ven_id."'";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return 0;
        }
        else{
            return 1;
        }
    }
    public function SelectInformationCaptain($id){
        $query="SELECT captain.cap_id,captain.cap_name,captain.cap_username,captain.cap_mobile,captain.cap_city,captain.cap_photo_url,captain.cap_isActive,captain.cap_token,captain.Blocked,captain.about_me,captain.cap_point,captain_wallet.w_id,captain_wallet.cap_cc,captain_wallet.PO2H,captain_wallet.PO4H,captain_wallet.PO12H,captain_wallet.PO24H,captain_wallet.AP4H,captain_wallet.AP8H,captain_wallet.AP24H,captain_wallet.AP72H,captain_wallet.RPR,captain_wallet.APR,captain_wallet.captain_plan,captain_wallet.captain_plan_end,captain_plan.plan_id,captain_plan.plan_name_en,captain_plan.plan_name_ar,captain_plan.plan_logo,DATEDIFF(captain_wallet.captain_plan_end,'".$this->getDate()."')as plan_period , (SELECT TRUNCATE(avg(`ven_rank`), 2)  FROM `save_process` WHERE `cap_id`=$id)AS eval
FROM captain,captain_wallet,captain_plan WHERE captain_wallet.cap_id=captain.cap_id AND captain_plan.plan_id=captain_wallet.captain_plan AND captain.cap_id = '$id'";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);
    }

    public function SelectInformaionCaptainFromMarket($cap_id){
        $query="SELECT captain.cap_id,captain.cap_name,captain.cap_mobile,captain.cap_city,captain.cap_photo_url,captain.about_me,captain.cap_isActive,captain.cap_token,captain.Blocked, (SELECT TRUNCATE(avg(`ven_rank`), 2)  FROM `save_process` WHERE `cap_id`=$cap_id)AS eval FROM captain WHERE captain.cap_id='".$cap_id."'";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);
    }
    public function SelectCounterCaptainFollowers($cap_id){
        $query="SELECT COUNT(vendor_follow.cap_id) FROM vendor_follow WHERE vendor_follow.cap_id='".$cap_id."'";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);
    }
    public function SelectCounterCaptainFollowing($cap_id){
        $query="SELECT COUNT(captain_follow.cap_id) FROM captain_follow WHERE captain_follow.cap_id='".$cap_id."'";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);
    }
    public function SelectCounterCaptainBlock($cap_id){
        $query="SELECT COUNT(captain_block.cap_id) FROM captain_block WHERE captain_block.cap_id='".$cap_id."'";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);
    }
    
    // Update About Me : 
    public function UpdateAboutCaptain($cap_id,$about){
        $query="UPDATE `captain` SET `about_me` = '".$about."' WHERE `captain`.`cap_id` = '".$cap_id."'";
        if (mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
}
