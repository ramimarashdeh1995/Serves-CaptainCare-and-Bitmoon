<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_market
 *
 * @author Rami
 */
class class_market {
    private $con;
    
    function __construct() {
        require '../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
    private function chick_email($email){
        $query="SELECT * FROM `vendor` where ven_mobile = '".$email."' ";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return false;
        }
        else{
            return true;
        }
    }
    private function chick_send_request($email){
        $query="SELECT * FROM `vendor_temp` where ven_mobile='".$email."' ";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return false;
        }
        else{
            return true;
        }
    }
     public function validationMobileNumber($ven_mobile){
         if($this->chick_email($ven_mobile)){
            return 2;
        }elseif ($this->chick_send_request($ven_mobile)) {
            return 3;
        }else{
            return 1;
        }
    }

    public function signUp($ven_name,$ven_city,$ven_address,$ven_email,$ven_password,$ven_trad,$token){
        if($this->chick_email($ven_email)){
            return 2;
        }elseif ($this->chick_send_request($ven_email)) {
            return 3;
        } else {
            $ven_password1= md5($ven_password);
            $datetime=new DateTime("now",new DateTimeZone('GMT+3'));

            $is=0;
            $date_creat_acc=$datetime->format('Y-m-d H:i:s');
                               
            $path = "image_trad_temp/$ven_email.png";
            $actualpath = "http://captain-care.org/ccapp/control_market/$path";
            
            $query="INSERT INTO `vendor_temp`"
                    . " (`ven_name`, `ven_mobile`, `ven_password`, `ven_city`, `ven_address`, `ven_trad_url`, `ven_date_created`, `token`)"
                    . " VALUES ('".$ven_name."', '".$ven_email."', '".$ven_password1."', '".$ven_city."', '".$ven_address."','".$actualpath."', '".$date_creat_acc."','".$token."')";
            return $this->readQuery($query,$path,$ven_trad);
        }
    }
    /*
    public function varificationEmail($ven_name,$ven_city,$ven_address,$ven_email,$ven_password,$ven_trad,$code){
        $query="SELECT * FROM `varfication_email` WHERE `email` LIKE '$ven_email' AND `cod` LIKE '$code' ";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1===0){
            return 5;
        }else{
            return $this->signUp($ven_name, $ven_city, $ven_address, $ven_email, $ven_password, $ven_trad);
        }
    }
    public function CreatvarificationEmail($email){
        if($this->chick_email($email)){
            return 2;
        }elseif ($this->chick_send_request($email)) {
            return 3;
        } else {
            $code=substr((mt_rand()),0,7);
            $to=$email;
            $sub="Varification Email";
            $message="This your code Varification ".$code;
            if(mail($to,$sub,$message)){
                return $this->isEmail($email,$code);
            } else {
                return 4;
            }
        }
    }
     public function CreatvarificationEmailForUpdatePassword($email){
        if ($this->chick_send_request($email)) {
            return 3;
        } else {
            $code=substr((mt_rand()),0,7);
            $to=$email;
            $sub="Varification Email";
            $message="This your code Varification ".$code;
            if(mail($to,$sub,$message)){
                return $this->isEmail($email,$code);
            } else {
                return 4;
            }
        }
    }
    private function isEmail($email,$code){
        $query="SELECT * FROM `varfication_email` where email = '".$email."' ";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            $query="INSERT INTO `varfication_email` (`email`, `cod`) VALUES ('".$email."', '".$code."')";
            return $this->readOneQuery($query);
        }
        else{
            $query="UPDATE `varfication_email` SET `cod` = '".$code."' WHERE `varfication_email`.`email`='".$email."'";
            return $this->readOneQuery($query);
        }
    }
    private function readOneQuery($query){
        $result=mysqli_query($this->con, $query);
        if($result){
            return 1;
        } else {
            return 0;
        }
    }*/

    private function readQuery($query,$path,$image){
        $result= mysqli_query($this->con, $query);        
        if($result){
            file_put_contents($path,base64_decode($image));
            /* @var $service2 type */
            return 1;
        }else{
            return 0;
        }
    }
   




    /* process log in vendor */
    /*----------------------------------------------*/
    /*----------------------------------------------*/
    
    private function is_log_in_email($ven_email){
       $query="SELECT * FROM `vendor` where ven_mobile = '".$ven_email."' ";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return false;
        }
        else{
            return true;
        }
    }
    private function is_log_in_password($ven_password){
       $query="SELECT * FROM `vendor` where ven_password = '".$ven_password."' ";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return false;
        }
        else{
            return true;
        }
    }
    public function true_log_in($ven_email,$ven_password){
        $password= md5($ven_password);
        $query="SELECT vendor.ven_id,vendor.ven_name,vendor.ven_mobile,vendor.ven_city,vendor.ven_address,vendor.ven_lon,vendor.ven_lat,
vendor.ven_trad_url,vendor.ven_photo_url,vendor.about_me,vendor.ven_isActive,vendor.venl,vendor.Blocked,vendor.ven_token,
(SELECT TRUNCATE(avg(`cap_rank`), 2) FROM `save_process` WHERE `ven_id`=vendor.ven_id)AS eval FROM vendor WHERE vendor.ven_password = '".$password."'and vendor.ven_mobile='".$ven_email."'";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);
    }
    public function log_in($ven_email,$ven_password){
        $password1= md5($ven_password);
        if($this->chick_send_request($ven_email)){
            return 4;
        }else{
            if($this->is_log_in_email($ven_email)&&$this->is_log_in_password($password1)){
            return 1;
        }else if(!$this->is_log_in_email($ven_email)&&!$this->is_log_in_password($password1)){
            return 0;
        }else if(!$this->is_log_in_email($ven_email)){
            return 2;
        }else if(!$this->is_log_in_password($password1)){
            return 3;
        }
        }
        
    }
    
     /* Update Password */
    /* ------------------------ */
    /* ------------------------ */
    
   /* public function varificationEmailandUpdatePassword($ven_email,$ven_password,$code){
        $query="SELECT * FROM `varfication_email` WHERE `email` LIKE '$ven_email' AND `cod` LIKE '$code' ";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1===0){
            return 5;
        }else{
            return $this->UpdatePassword($ven_email,$ven_password);
        }
    }*/
    
    public function UpdatePassword($email,$ven_password){
        $password= md5($ven_password);
        $query="UPDATE `vendor` SET `ven_password` = '".$password."'WHERE `vendor`.`ven_mobile` = ".$email;
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
    
    /*Update Information Profile */
    /*---------------------------------*/
    /*---------------------------------*/
    
    public function UpdateName($id,$name){
        $query="UPDATE `vendor` SET `ven_name` = '".$name."' WHERE `vendor`.`ven_id` = '".$id."'";
        if(mysqli_query($this->con, $query)){
            return 1;
        }else{
            return 0;
        }
    }
    public function UpdateImageProfile($id,$image){
        $path = "ImageProfile/$image.png";
        $actualpath = "http://captain-care.org/ccapp/control_market/$path";
        
        $query="UPDATE `vendor` SET `ven_photo_url` = '".$actualpath."' WHERE `vendor`.`ven_id` = '".$id."' ";
        if(mysqli_query($this->con, $query)){
             file_put_contents($path,base64_decode($image));
             return 1;
        } else {
            return 0;
        }
    }
    public function UpdateLocation($id,$lon,$lat){
        $query="UPDATE `vendor` SET `ven_lon` = '".$lon."', `ven_lat` = '".$lat."' WHERE `vendor`.`ven_id` = '".$id."'";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
    public function SelectMyLocation($id){
        $query="SELECT vendor.ven_lon,vendor.ven_lat from vendor WHERE vendor.ven_id='".$id."'";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);
    }
 public function UpdatePersnalInformation($id,$name,$city,$image,$address){
     
      // move_uploaded_file($_FILES["file"]["tmp_name"],$target_dir. $newfilename);
     
        $path = "ImageProfile/$id.png";
        $actualpath = "http://captain-care.org/ccapp/control_market/$path";
        $query="UPDATE `vendor` SET `ven_name` = '$name', `ven_city` = '$city', `ven_address` = '$address', `ven_photo_url` = '$actualpath' WHERE `vendor`.`ven_id` = $id";
        if(mysqli_query($this->con, $query)){
            file_put_contents($path,base64_decode($image));
            return $this->GetInformation1Market($id);
        } else {
            return 0;
        }
    }
    private function GetInformation1Market($id){
        $query="SELECT vendor.ven_id,vendor.ven_name,vendor.ven_mobile,vendor.ven_city,vendor.ven_address,vendor.ven_photo_url,vendor.ven_isActive
,vendor.venl,vendor.Blocked,vendor.ven_token,vendor_wallet.w_id,vendor_wallet.vendor_cc,vendor_wallet.PO4H,
vendor_wallet.PO8H,vendor_wallet.PO24H,vendor_wallet.PO72H,vendor_wallet.PO120H,vendor_wallet.PO168H,
vendor_wallet.AP4H,vendor_wallet.AP8H,vendor_wallet.AP24H,vendor_wallet.AP72H,vendor_wallet.AP120H,
vendor_wallet.AP168H,vendor_wallet.RPR,vendor_wallet.APR,vendor_wallet.vendor_plan,vendor_wallet.vendor_plan_end,
vendor_plan.plan_id,vendor_plan.plan_name_en,vendor_plan.plan_name_ar,vendor_plan.plan_logo,vendor_plan.plan_period,
vendor_plan.plan_price ,(SELECT TRUNCATE(avg(`cap_rank`), 2) as eval FROM `save_process` WHERE `ven_id`=$id)as eval FROM vendor,vendor_wallet,vendor_plan 
WHERE vendor_wallet.vendor_id=vendor.ven_id AND vendor_wallet.vendor_plan=vendor_plan.plan_id AND vendor.ven_id=$id";
// $query="select * from captain where cap_id=1";
        $result= mysqli_query($this->con, $query);
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
           $array[]=$row;
        }
        return $array;
    }
    
    
     public function UpdatePasswordInApp($id,$pass,$passNow){
        $password1= md5($pass);
        if($this->CheckPassword($id,$password1)){
             $password= md5($passNow);
             $query="UPDATE `vendor` SET `ven_password` = '".$password."'WHERE `vendor`.`ven_id` = ".$id;
            if(mysqli_query($this->con, $query)){
                 return 1;
            } else {
                 return 0;
            }
        }else{
            return 2;
        }
    }
    
     private function CheckPassword($id,$password){
         $query="SELECT * FROM `vendor` where ven_id = '".$id."' and ven_password= '".$password."'";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return false;
        }
        else{
            return true;
        }

   }

    

}
