<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classplancaptain
 *
 * @author Rami
 */
class classplancaptain {
    private $con;
    
    function __construct() {
        require '../../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
    public function getPlanPackeg(){
         $query=$this->con->prepare("SELECT * FROM `captain_plan`");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
           $array[]=$row;
        }
        return $array; 
    }
        public function getccPackeg(){
         $query=$this->con->prepare("SELECT * FROM `cc_package` ");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
           $array[]=$row;
        }
        return $array; 
    }
    public function UpdatePlane($cap_id,$plan_id){
        $InformationPlan=$this->getInformationPlan($plan_id);
        $costPlan=$InformationPlan['cost'];
         $end_datePlan=$InformationPlan['plan_period'];
         $RPR=$InformationPlan['RPR'];
         $APR=$InformationPlan['APR'];
        $PO2= $InformationPlan['PO2H'];
        $PO4= $InformationPlan['PO4H'];
        $PO12= $InformationPlan['PO12H'];
        $PO24= $InformationPlan['PO24H'];
        $AP4= $InformationPlan['AP4H'];
         $AP8=$InformationPlan['AP8H'];
         $AP24=$InformationPlan['AP24H'];
        $AP72= $InformationPlan['AP72H'];
        
        $result=$this->CheckIsYourHaveCC($cap_id,$costPlan);
        $timeA = new DateTime("now",new DateTimeZone('GMT+3'));
$timeB = new DateInterval('P'.$end_datePlan.'M'); 
$timeA->add($timeB);
$date1 =$timeA->format('Y-m-d H:i:s');
        if($result==1){
            $query="UPDATE `captain_wallet` SET `cap_cc` = `cap_cc`-'$costPlan', `PO2H` = '$PO2', `PO4H` = '$PO4', `PO12H` = '$PO12', `PO24H` = '$PO24', `AP4H` = '$AP4', `AP8H` = '$AP8', `AP24H` = '$AP24', `AP72H` = '$AP72', `RPR` = '$RPR', `APR` = '$APR', `captain_plan` = '$plan_id', `captain_plan_end` = '$date1' WHERE `captain_wallet`.`cap_id` = $cap_id";
            if(mysqli_query($this->con,$query)){
                $sql2 = "INSERT INTO `captain_proc` (`p_id`, `cap_id`, `proc_type`, `proc_value`, `proc_info`, `date`) VALUES (NULL, '".$cap_id."' , 'change_plan', '".$costPlan."' , '".$plan_id."','".$date1."' )";
                mysqli_query($this->con,$sql2);
                return $result;
            }else{
                return 0;
            }
        }else if($result==2){
            return $result;
        }
        
    }
    private function getInformationPlan($id){
         $information=array();
         $query="SELECT * FROM `captain_plan` WHERE `plan_id` = $id";
         $row= mysqli_fetch_array(mysqli_query($this->con, $query));
         $information['cost']=$row['plan_price'];
         $information['plan_id']=$row['plan_id'];
         $information['plan_period']=$row['plan_period'];
         $information['RPR']=$row['RPR'];
         $information['APR']=$row['APR'];
         $information['PO2H']=$row['PO2H'];
         $information['PO4H']=$row['PO4H'];
         $information['PO12H']=$row['PO12H'];
         $information['PO24H']=$row['PO24H'];
         $information['AP4H']=$row['AP4H'];
         $information['AP8H']=$row['AP8H'];
         $information['AP24H']=$row['AP24H'];
         $information['AP72H']=$row['AP72H'];

         return $information;
    }
    private function CheckIsYourHaveCC($id,$cc){
         $query="SELECT * FROM `captain_wallet` WHERE `cap_id` = $id";
         $row= mysqli_fetch_array(mysqli_query($this->con, $query));
         $cost=$row['cap_cc'];
         
         if($cost>$cc){
             return 1;
         }else{
             return 2;
         }
        
    }
}
