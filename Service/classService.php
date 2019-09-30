<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classService
 *
 * @author Rami
 */
class classService {

    private $con;
    
    function __construct() {
        require '../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
    private function ChekIsInsertService($ven_id,$cat_id,$sub_id){
        $query="SELECT * FROM `service` WHERE `cat_id` = '".$cat_id."' AND `sub_id` = '".$sub_id."' AND `ven_id` = '".$ven_id."'";
        $result= mysqli_query($this->con, $query);
        $result1= mysqli_num_rows($result);
        if($result1==0){
            return false;
        }
        else{
            return true;
        }
    }

    public function SelectAllCategory(){
        $query=$this->con->prepare("SELECT * FROM `category`");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    }
     public function SelectAllSubService(){
        $query=$this->con->prepare("SELECT * FROM `sub_category`");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    }
    public function SelectAllSup_Category($c_id){
        $query=$this->con->prepare("SELECT * FROM `sub_category` WHERE `c_id` = '".$c_id."'");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row= mysqli_fetch_assoc($result)){
            $array[]=$row;
        }
        return $array;
    }
    public function InsertService($ven_id,$cat_id,$sub_id){
        if($this->ChekIsInsertService($ven_id, $cat_id, $sub_id)){
            return 2;
        }
        $query=$this->con->prepare("INSERT INTO `service` (`cat_id`, `sub_id`, `ven_id`) VALUES (?,?,? )");
        $query->bind_param("sss",$cat_id,$sub_id,$ven_id);
        if($query->execute()){
            return 1;
        } else {
            return 0;
        }
    }
    public function SelectServce($ven_id){
        $query="SELECT sub_category.s_id,sub_category.c_id,sub_category.sub_name,sub_category.sub_name_ar FROM sub_category,service WHERE service.ven_id='".$ven_id."' and service.sub_id=sub_category.s_id";
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
    public function DeleteService($cat_id,$sub_id,$ven_id){
        $query="DELETE FROM service WHERE service.cat_id='".$cat_id."' AND service.sub_id='".$sub_id."' AND service.ven_id='".$ven_id."'";
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }
}
