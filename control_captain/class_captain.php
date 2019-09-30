<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_captain
 *
 * @author Rami
 */
class class_captain {
    private $con;
    
    function __construct() {
        require '../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
     public function read_table_cust(){
        
        $query="SELECT * FROM `captain_temp`";
        $result= mysqli_query($this->con, $query);
        
        if(! $result){
            die("error in query");
        }
        $my_arry=array();
        
        while ($row= mysqli_fetch_assoc($result)){
           $my_arry[]=$row;
                }
                echo json_encode($my_arry);
    }
    private function chick_mobile($mobile){
        $query="SELECT * FROM `captain` where cap_mobile = '".$mobile."' ";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return false;
        }
        else{
            return true;
        }
    }
    private function chick_send_request($mobile){
        $query="SELECT * FROM `captain_temp` where cap_mobile = '".$mobile."' ";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return false;
        }
        else{
            return true;
        }
    }
    public function validationMobileNumber($cap_mobile){
         if($this->chick_mobile($cap_mobile)){
            return 2;
        }elseif ($this->chick_send_request($cap_mobile)) {
            return 3;
        }else{
            return 1;
        }
    }

    public function signUp($cap_name,$cap_password,$cap_mobile,$cap_city,$cap_lic_url,$token){
        if($this->chick_mobile($cap_mobile)){
            return 2;
        }elseif ($this->chick_send_request($cap_mobile)) {
            return 3;
        } else {
            $cap_password1= md5($cap_password);
            $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
            $is=0;
            $date_creat_acc=$datetime->format('Y-m-d H:i:s');
            
            $path = "image_lic_temp/$cap_mobile.png";
            $actualpath = "http://captain-care.org/ccapp/control_captain/$path";
            
            
            $query="INSERT INTO `captain_temp` (`cap_name`, `cap_password`, `cap_mobile`, `cap_city`, `cap_lic_url`,`cap_isActive`, `cap_date_created`, `cap_token`) "
                    . "VALUES ('".$cap_name."','".$cap_password1."','".$cap_mobile."','".$cap_city."','".$actualpath."','".$is."','".$date_creat_acc."','".$token."')";
            return $this->readQuery($query,$path,$cap_lic_url);
        }
    }
    private function readQuery($query,$path,$image){
        $result= mysqli_query($this->con, $query);
        if($result){
            file_put_contents($path,base64_decode($image));
            return 1;
        }else{
            return 0;
        }
    }
    
    
    
    /* process log in captain */
    /*----------------------------------------------*/
    /*----------------------------------------------*/
    
    private function is_log_in_email($cap_mobile){
       $query="SELECT * FROM `captain` where cap_mobile = '".$cap_mobile."' ";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return false;
        }
        else{
            return true;
        }
    }
    private function is_log_in_password($cap_password){
       $query="SELECT * FROM `captain` where cap_password = '".$cap_password."' ";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return false;
        }
        else{
            return true;
        }
    }
    public function true_log_in($cap_mobile,$cap_password){
        $password= md5($cap_password);
        $query="SELECT captain.cap_id,captain.cap_name,captain.cap_username,captain.cap_mobile,captain.cap_city,captain.cap_lic_url,captain.cap_photo_url
,captain.about_me,captain.cap_point,captain.cap_isActive,captain.cap_token,captain.Blocked,
(SELECT TRUNCATE(avg(`ven_rank`), 2) FROM `save_process` WHERE `cap_id`=captain.cap_id)AS eval FROM captain WHERE captain.cap_password = '".$password."'and captain.cap_mobile='".$cap_mobile."'  ";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);
    }
    public function log_in($cap_mobile,$cap_password){
        $password1= md5($cap_password);
        if($this->chick_send_request($cap_mobile)){
            return 4;
        }
        if($this->is_log_in_email($cap_mobile)&&$this->is_log_in_password($password1)){
            return 1;
        }else if(!$this->is_log_in_email($cap_mobile)&&!$this->is_log_in_password($password1)){
            return 0;
        }else if(!$this->is_log_in_email($cap_mobile)){
            return 2;
        }else if(!$this->is_log_in_password($password1)){
            return 3;
        }
    }
    
    /* Update Password */
    /* ------------------------ */
    /* ------------------------ */
    
    public function UpdatePassword($mobile,$cap_password){
        $password= md5($cap_password);
        $query="UPDATE `captain` SET `cap_password` = '".$password."'WHERE `captain`.`cap_mobile` = ".$mobile;
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
        $query="UPDATE `captain` SET `cap_name` = '".$name."' WHERE `captain`.`cap_id` = '".$id."'";
        if(mysqli_query($this->con, $query)){
            return 1;
        }else{
            return 0;
        }
    }
    public function UpdateImageProfile($id,$image){
        $path = "ImageProfile/$image.png";
        $actualpath = "http://captain-care.org/ccapp/control_captain/$path";
        $query="UPDATE `captain` SET `cap_photo_url` = '".$actualpath."' WHERE `captain`.`cap_id` = '".$id."' ";
        if(mysqli_query($this->con, $query)){
             file_put_contents($path,base64_decode($image));
             return 1;
        } else {
            return 0;
        }
    }
    public function UpdatePersnalInformation($id,$name,$city,$image){
        $path = "ImageProfile/$id.png";
        $actualpath = "http://captain-care.org/ccapp/control_captain/$path";
        $query="UPDATE `captain` SET `cap_name` = '".$name."', `cap_city` = '".$city."', `cap_photo_url` = '".$actualpath."' WHERE `captain`.`cap_id` = $id";
        if(mysqli_query($this->con, $query)){
            file_put_contents($path,base64_decode($image));
            return $this->GetInformation1Captain($id);
        } else {
            return 0;
        }
    }
    private function GetInformation1Captain($id){
        $query="SELECT captain.cap_id,captain.cap_name,captain.cap_username,captain.cap_mobile,captain.cap_city,captain.cap_photo_url,captain.cap_isActive,captain.cap_token,captain.Blocked,captain.cap_point,captain_wallet.w_id,captain_wallet.cap_cc,captain_wallet.PO2H,captain_wallet.PO4H,captain_wallet.PO12H,captain_wallet.PO24H,captain_wallet.AP4H,captain_wallet.AP8H,captain_wallet.AP24H,captain_wallet.AP72H,captain_wallet.RPR,captain_wallet.APR,captain_wallet.captain_plan,captain_wallet.captain_plan_end,captain_plan.plan_id,captain_plan.plan_name_en,captain_plan.plan_name_ar,captain_plan.plan_logo,captain_plan.plan_period , (SELECT TRUNCATE(avg(`ven_rank`), 2)  FROM `save_process` WHERE `cap_id`=$id)AS eval
FROM captain,captain_wallet,captain_plan WHERE captain_wallet.cap_id=captain.cap_id AND captain_plan.plan_id=captain_wallet.captain_plan AND captain.cap_id = '$id' ";
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
             $query="UPDATE `captain` SET `cap_password` = '".$password."'WHERE `captain`.`cap_id` = ".$id;
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
         $query="SELECT * FROM `captain` where cap_id = '".$id."' and cap_password= '".$password."'";
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
