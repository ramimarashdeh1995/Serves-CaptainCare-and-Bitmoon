<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classplanmarket
 *
 * @author Rami
 */
class classplanmarket {

    private $con;
    
    function __construct() {
        require '../../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
public function getPlanPackeg(){
         $query=$this->con->prepare("SELECT * FROM `vendor_plan`");
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
    
    public function UpdatePlane($ven_id,$plan_id){
        $Information=$this->getInformationPlan($plan_id);
        $costPlan=$Information['plan_price'];
        
        $result=$this->CheckIsYourHaveCC($ven_id,$costPlan);
        if($result==1){
           $plan_period= $Information['plan_period'];
           $plan_price= $Information['plan_price'];
           $RPR= $Information['RPR'];
           $APR= $Information['APR'];
           $PO4H= $Information['PO4H'];
           $PO8H= $Information['PO8H'];
           $PO24H= $Information['PO24H'];
           $PO72H= $Information['PO72H'];
           $PO120H= $Information['PO120H'];
           $PO168H= $Information['PO168H'];
           $AP4H= $Information['AP4H'];
           $AP8H= $Information['AP8H'];
           $AP24H= $Information['AP24H'];
           $AP72H= $Information['AP72H'];
           $AP120H= $Information['AP120H'];
           $AP168H= $Information['AP168H'];
           
           $timeA = new DateTime("now",new DateTimeZone('GMT+3'));
$date2 =$timeA->format('Y-m-d H:i:s');
$timeB = new DateInterval('P'.$plan_period.'M'); 
$timeA->add($timeB);
$date1 =$timeA->format('Y-m-d H:i:s');
           
            $query="UPDATE `vendor_wallet` SET `vendor_cc`= `vendor_cc`-'".$plan_price."',`PO4H`='".$PO4H."',`PO8H`='".$PO8H."',`PO24H`='".$PO24H."',`PO72H`='".$PO72H."',`PO120H`='".$PO120H."',`PO168H`='".$PO168H."',`AP4H`='".$AP4H."',`AP8H`='".$AP8H."',`AP24H`='".$AP24H."',`AP72H`='".$AP72H."',`AP120H`='".$AP120H."',`AP168H`='".$AP168H."',`RPR`='".$RPR."',`APR`='".$APR."',`vendor_plan`='".$plan_id."',`vendor_plan_end`='".$date1."' WHERE `vendor_id`=$ven_id";
            if(mysqli_query($this->con,$query)){
                  $queryProce="INSERT INTO `vendor_proc` (`p_id`, `ven_id`, `proc_type`, `proc_value`, `proc_info`, `date`) VALUES (NULL, '".$ven_id."', 'change_plan', '".$plan_id."', '".$costPlan."', '".$date2."')";
                  mysqli_query($this->con,$queryProce);
                return $result;
            }else{
                return 0;
            }
            
        }else if($result==2){
            return $result;
        }
        
        
    }
    private function getInformationPlan($id){
        $INformation =array();
         $sql10="SELECT `plan_id`,`plan_period`,`plan_price`,`RPR`,`APR`,`PO4H`,`PO8H`,`PO24H`,`PO72H`,`PO120H`,`PO168H`,`AP4H`,`AP8H`,`AP24H`,`AP72H`,`AP120H`,`AP168H` FROM `vendor_plan` WHERE `plan_id`=$id ";
         $result10=$this->con->query($sql10);
        if($result10->num_rows>0){
            $row10=$result10->fetch_assoc();
            $INformation['plan_id']=$row10["plan_id"];
            $INformation['plan_period']=$row10["plan_period"];
            $INformation['plan_price']=$row10["plan_price"];
            $INformation['RPR']=$row10["RPR"];
            $INformation['APR']=$row10["APR"];
            $INformation['PO4H']=$row10["PO4H"];
            $INformation['PO8H']=$row10["PO8H"];
            $INformation['PO24H']=$row10["PO24H"];
            $INformation['PO72H']=$row10["PO72H"];
            $INformation['PO120H']=$row10["PO120H"];
            $INformation['PO168H']=$row10["PO168H"];
            $INformation['AP4H']=$row10["AP4H"];
            $INformation['AP8H']=$row10["AP8H"];
            $INformation['AP24H']=$row10["AP24H"];
            $INformation['AP72H']=$row10["AP72H"];
            $INformation['AP120H']=$row10["AP120H"];
            $INformation['AP168H']=$row10["AP168H"];
        }
        return $INformation;
    }
    
    private function CheckIsYourHaveCC($id,$cc){
         $query="SELECT * FROM `vendor_wallet` WHERE `vendor_id` = $id";
         $row= mysqli_fetch_array(mysqli_query($this->con, $query));
         $cost=$row['vendor_cc'];
         
         if($cost>$cc){
             return 1;
         }else{
             return 2;
         }
        
    }

    
 }
