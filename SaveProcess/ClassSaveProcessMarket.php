<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassSaveProcess
 *
 * @author Rami
 */
class ClassSaveProcessMarket {
    public $con;
    
    function __construct() {
        require '../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();
    }
    
    private function getDate(){
        $datetime=new DateTime("now",new DateTimeZone('GMT+3'));
        
        return $dateStart=$datetime->format('Y-m-d H:i:s');
    }

    public function getPush($titel,$message,$image,$type,$offer_id) {
        $res = array();
        $res['data']['title'] = $titel;
        $res['data']['message'] = $message;
        $res['data']['image'] = $image;
        $res['data']['type'] = $type;
        $res['data']['offer_id'] = $offer_id;
        return $res;
    }
    public function getPush1($titel,$message,$image,$type,$offer_id,$userID,$address,$offer_title) {
        $res = array();
        $res['data']['title'] = $titel;
        $res['data']['message'] = $message;
        $res['data']['image'] = $image;
        $res['data']['type'] = $type;
        $res['data']['offer_id'] = $offer_id;
        $res['data']['userid'] = $userID;
        $res['data']['address'] = $address;
         $res['data']['offer_title'] = $offer_title;
        return $res;
    }
    public function getPush2($titel,$message,$image,$type,$offer_id,$userID,$address,$offer_title,$lon,$lat,$price,$timeend,$minit){
         $res = array();
        $res['data']['title'] = $titel;
        $res['data']['message'] = $message;
        $res['data']['image'] = $image;
        $res['data']['type'] = $type;
        $res['data']['offer_id'] = $offer_id;
        $res['data']['userid'] = $userID;
        $res['data']['address'] = $address;
        $res['data']['offer_title'] = $offer_title;
        $res['data']['lon'] = $lon;
        $res['data']['lat'] = $lat;
        $res['data']['price'] = $price;
        $res['data']['hour'] = $timeend;
        $res['data']['minute'] = $minit;
        return $res;
    }
    
    public function getAllTokens_Market($id){
        $stmt = $this->con->prepare("SELECT vendor.ven_token FROM vendor WHERE vendor.ven_token NOT LIKE '0' and  vendor.ven_id='".$id."'");//query select all token market and not select market block
        $stmt->execute(); 
        $result = $stmt->get_result();
        $tokens = array(); 
        while($token = $result->fetch_assoc()){
            array_push($tokens, $token['ven_token']);
        }
        return $tokens; 
    }
    
    public function getAllTokens_Captain($id){
        $stmt = $this->con->prepare("SELECT captain.cap_token FROM captain WHERE captain.cap_token NOT LIKE '0' and  captain.cap_id='".$id."'");//query select all token market and not select market block
        $stmt->execute(); 
        $result = $stmt->get_result();
        $tokens = array(); 
        while($token = $result->fetch_assoc()){
            array_push($tokens, $token['cap_token']);
        }
        return $tokens; 
    }
     
    private function SaveTableNotification($id_ven,$offer_id,$date){
        $query="INSERT INTO `vendor_notify` (`ven_id`, `cap_offer_id`, `type`, `isSeen`, `notify_date`)"
                . " VALUES ( '".$id_ven."', '$offer_id', 'accoffermarket', '0', '".$date."')";
        mysqli_query($this->con, $query);
    }
    
    private function SaveTableNotificationCaptain($cap_id,$offer_id,$date,$type){
        $query="INSERT INTO `captain_notify` (`cap_id`, `ven_offer_id`, `type`, `isSeen`, `notify_date`)"
                . " VALUES ( '".$cap_id."', '$offer_id', '".$type."', '0', '".$date."')";
        mysqli_query($this->con, $query);
    }
    
     private function SaveTableNotificationCaptain_edit($cap_id,$offer_id,$date,$type,$ven_id){
        $query="INSERT INTO `captain_notify` (`cap_id`, `ven_offer_id`,`ven_id`, `type`, `isSeen`, `notify_date`)"
                . " VALUES ( '".$cap_id."', '$offer_id','$ven_id', '".$type."', '0', '".$date."')";
        mysqli_query($this->con, $query);
    }

    public function SaveOfferMarketFree($ven_id,$cap_id,$id_offer_market){
        
        $dateStart= $this->getDate();
        $bet=10;
        
        $result1= $this->CheckCaptainBet($cap_id,$bet,$id_offer_market,$dateStart);
        
        if($result1==2){
            $InformationCaptain= $this->getInformationCaptain($cap_id);
            $cap_name=$InformationCaptain['cap_name'];
            $cap_Rank=$InformationCaptain['Rank'];
        
            $query="INSERT INTO `save_process` (`save_id`, `ven_id`, `cap_id`, `end_process`, `ven_rank`, `cap_rank`, `start_date`, `end_date`, `id_offer_cap`, `id_offer_ven`, `token`,`end_cap`)"
                    . " VALUES (NULL, '".$ven_id."', '".$cap_id."', '0', NULL, NULL, '".$dateStart."', NULL, NULL, '".$id_offer_market."', '".$bet."','0')";
            if(mysqli_query($this->con, $query)){
                $save_id=$this->con->insert_id;
                $this->SaveTableNotification($ven_id,$save_id, $dateStart);
                return $this->getPush($cap_name,$cap_Rank,null,"saveoffermarket",$save_id);
            } else {
                return 0;
            }
        } else {
            return $result1;
        }   
        
    }
    
    public function SaveOfferCaptainFree($cap_id,$ven_id,$offer_id){
        if($this->CheckIfSaveProcessCaptain($ven_id,$cap_id,$offer_id)){
            return 9;
        }else{
            $dateStart= $this->getDate();
            $bet=10;
        
            $result1= $this->CheckCaptainBet($cap_id,$bet,$offer_id,$dateStart);
        
            if($result1==2){
                $InformationCaptain= $this->getInformationCaptain($cap_id);
                $cap_name=$InformationCaptain['cap_name'];
                $cap_Rank=$InformationCaptain['Rank'];
        
                $query="INSERT INTO `save_process` (`save_id`, `ven_id`, `cap_id`, `end_process`, `ven_rank`, `cap_rank`, `start_date`, `end_date`, `id_offer_cap`, `id_offer_ven`, `token`,`end_cap`)"
                    . " VALUES (NULL, '".$ven_id."', '".$cap_id."', '0', NULL, NULL, '".$dateStart."', NULL, '".$offer_id."',NULL , '".$bet."','0')";
                if(mysqli_query($this->con, $query)){
                    $save_id=$this->con->insert_id;
                
                    $this->StopAcceptOfferCaptain($offer_id);
                
                    $this->SaveTableNotification($ven_id,$save_id, $dateStart);
                
                    return $this->getPush($cap_name,$cap_Rank,null,"saveoffercaptain",$save_id);
                } else {
                    return 0;
                }
            } else {
                return $result1;
            }   
        }
        
    }
    private function CheckIfSaveProcessCaptain($ven_id,$cap_id,$offer_id){
        $query="SELECT * FROM save_process WHERE save_process.ven_id='".$ven_id."' AND save_process.cap_id='".$cap_id."' AND save_process.id_offer_cap='".$offer_id."'";
        $row = mysqli_fetch_array(mysqli_query($this->con, $query));
        if($row>0){
            return true;
        }else{
            return false;
        }
    }

    private function getInformationCaptain($cap_id){
        $information=array();
        $query="SELECT * FROM `captain` WHERE cap_id='".$cap_id."'";
        $row = mysqli_fetch_array(mysqli_query($this->con, $query));
        $information['cap_name']= $row['cap_name'];
        $information['cap_id']=$row['cap_id'];
        $information['point']=$row['cap_point'];
        
        $querygetRankCaptain="SELECT TRUNCATE(avg(`ven_rank`), 2) as eval FROM `save_process` WHERE `cap_id`='".$cap_id."'  ";
        $rowgetRank= mysqli_fetch_array(mysqli_query($this->con, $querygetRankCaptain));
        $information['Rank']=$rowgetRank['eval'];
        
        return $information;
    }
    
    private function getPersonalInformationMarket($id){
         $information=array();
         $query="select * from vendor where ven_id= '".$id."'";
         $row= mysqli_fetch_array(mysqli_query($this->con, $query));
         $information['ven_name']=$row['ven_name'];
         $information['ven_address']=$row['ven_address'];
         $information['ven_photo_url']=$row['ven_photo_url'];
         $information['lon']=$row['ven_lon'];
         $information['lat']=$row['ven_lat'];
         

       /* $querygetRankCaptain="SELECT TRUNCATE(avg(`cap_rank`), 2) as eval FROM `save_process` WHERE `ven_id`='".$id."'  ";
        $rowgetRank= mysqli_fetch_array(mysqli_query($this->con, $querygetRankCaptain));
        $information['Rank']=$rowgetRank['eval'];*/
        return $information;
     }
     private function getRankMark($id){
          $information=array();
          $querygetRankCaptain="SELECT TRUNCATE(avg(`cap_rank`), 2) as eval FROM `save_process` WHERE `ven_id`='".$id."'  ";
        $rowgetRank= mysqli_fetch_array(mysqli_query($this->con, $querygetRankCaptain));
        $information['rank']=$rowgetRank['eval'];
        return $information;
     }
     
    private function CheckCaptainBet($cap_id,$bit,$id_offer_market,$date){
        $query="SELECT cap_cc FROM `captain_wallet` WHERE `cap_id`='".$cap_id."'";
        $row = mysqli_fetch_array(mysqli_query($this->con, $query));
        $freeCC= $row['cap_cc'];
        if($freeCC>10){
            $query1="UPDATE `captain_wallet` SET cap_cc = cap_cc - $bit WHERE `captain_wallet`.`cap_id` = $cap_id";
            mysqli_query($this->con, $query1);
            $this->DocProcessAcceptOfferMarketFromCaptain($cap_id, $bit, $id_offer_market,"bet",$date);
            return 2;
        } else {
            return 3;
        }
    }
    
    private function DocProcessAcceptOfferMarketFromCaptain($cap_id,$bit,$offer_id,$type_process,$date){
        $query="INSERT INTO `captain_proc` (`p_id`, `cap_id`, `proc_type`, `proc_value`, `proc_info`,`date`)"
                . " VALUES (NULL, '".$cap_id."', '".$type_process."', '".$bit."', '".$offer_id."','".$date."')";
        mysqli_query($this->con, $query);
    }
    
    public function EndOfferMarket($idSave,$idVen,$idCap,$rank){
        $dateend= $this->getDate();
        
        
        $InformationMarket= $this->getPersonalInformationMarket($idVen);
        $nameMarket=$InformationMarket['ven_name'];
        $img_market=$InformationMarket['ven_photo_url'];
        
        $query="UPDATE `save_process` SET `end_process` = '1', `ven_rank` = '".$rank."', `end_date` = '".$dateend."' WHERE `save_process`.`save_id` = '".$idSave."'";
        mysqli_query($this->con, $query);
        
        if($this->CheckFreeAcceptMarket($idVen)){
            $this->GetAPRFomMarket($idVen);
        } else {
            $this->GetCCFromMarket($idVen,$idSave);
        }
       // $this->DocProcessAcceptOfferMarketFromCaptain($idCap, $bet, $idSave,"refundbet",$dateend);
       // $query2="UPDATE `captain_wallet` SET `cap_cc` = `cap_cc`+ '$bet' WHERE `captain_wallet`.`cap_id` = $idCap";
        //mysqli_query($this->con,$query2);
        $this->SaveTableNotificationCaptain($idCap, $idSave, $dateend,"rank");
         
         return $this->getPush($nameMarket, null, $img_market, "rank", $idSave);
    }
    
    private function CheckFreeAcceptMarket($id){
         $query="SELECT `APR` FROM `vendor_wallet` WHERE `vendor_id`='".$id."'";
        $row = mysqli_fetch_array(mysqli_query($this->con, $query));
        $CC= $row['APR'];      
        if($CC>0){
            return true;
        } 
        return false;
    }
    
    private function GetCCFromMarket($id,$idSave){
        $date= $this->getDate();
        $query1="UPDATE `vendor_wallet` SET `vendor_cc` = `vendor_cc`-1 WHERE `vendor_wallet`.`vendor_id` = '".$id."'";
        mysqli_query($this->con, $query1);
        $query3="INSERT INTO `vendor_proc` (`p_id`, `ven_id`, `proc_type`, `proc_value`, `proc_info`, `date`)"
                 . " VALUES (NULL, '".$id."', 'offercomm', '1', '".$idSave."', '".$date."')";
         mysqli_query($this->con, $query3);
    }
    
    private function GetAPRFomMarket($id){
        $query="UPDATE `vendor_wallet` SET `APR` = `APR`-1 WHERE `vendor_wallet`.`vendor_id` = '".$id."'";
        mysqli_query($this->con, $query);
    }

    public function CaptainEvalMarket($idSave,$rank,$id_cap){
        $date= $this->getDate();
        $bet=10;
        $query="UPDATE `save_process` SET `cap_rank` = '".$rank."',`end_cap` = '1' WHERE `save_process`.`save_id` = '".$idSave."'";
        if(mysqli_query($this->con, $query)){
            $this->AddPointToCaptain($id_cap);
            $this->DocProcessAcceptOfferMarketFromCaptain($id_cap, $bet, $idSave,"refundbet",$date);
            $query2="UPDATE `captain_wallet` SET `cap_cc` = `cap_cc`+ '$bet' WHERE `captain_wallet`.`cap_id` = $id_cap";
            mysqli_query($this->con,$query2);
            return $this->getInformationCaptain($id_cap);
        } else {
            return 0;
        }
     }
     private function AddPointToCaptain($id_cap){
         $query="UPDATE `captain` SET `cap_point`=`cap_point`+100 WHERE `cap_id` = '".$id_cap."'";
         mysqli_query($this->con, $query);
     }


     private function CheckMarketCC($ven_id){
        $query="SELECT vendor_cc FROM `vendor_wallet` WHERE `vendor_id`='".$ven_id."'";
        $row = mysqli_fetch_array(mysqli_query($this->con, $query));
        $CC= $row['vendor_cc'];      
        if($CC>0){
            return true;
        } else {
            return false;
        }
    }
     
     
     // Accept Free Offer Captain from Market : 
     
     private function getInformitonOfferCaptain($id){
        $information=array();
        $query="SELECT captain_offer.offer_id,captain_offer.cap_id,captain_offer.sub_id,captain_offer.offer_title,captain_offer.offer_disc,
captain_offer.offer_start,captain_offer.offer_end,captain_offer.cost,(SELECT TIMEDIFF('".$this->getDate()."',captain_offer.offer_start) FROM captain_offer WHERE captain_offer.offer_id='".$id."') as timeend  FROM captain_offer WHERE captain_offer.offer_id='".$id."'";
        $row = mysqli_fetch_array(mysqli_query($this->con, $query));
        $information['offer_title']= $row['offer_title'];
        $information['price']=$row['cost'];
        $information['start']=$row['offer_start'];
        $information['end']=$row['offer_end'];
        $information['timeend']=$row['timeend'];
        
        return $information;
     }
     
    public function AcceptOfferCaptain ($cap_id,$ven_id,$offer_id){
         $date= $this->getDate();
         if($this->CheckMarketCC($ven_id)){
             $this->SaveTableNotificationCaptain_edit($cap_id,$offer_id,$date,"acceptoffercaptain",$ven_id);
             $InformationMarket= $this->getPersonalInformationMarket($ven_id);
             $nameMarket=$InformationMarket['ven_name'];
             $img=$InformationMarket['ven_photo_url'];
             $address=$InformationMarket['ven_address'];
             $lon=$InformationMarket['lon'];
             $lat=$InformationMarket['lat'];
             $InformationOffer=$this->getInformitonOfferCaptain($offer_id);
             $offer_title=$InformationOffer['offer_title'];
             $price=$InformationOffer['price'];
             $start=$InformationOffer['start'];
             $end=$InformationOffer['end'];
             $timeend=$InformationOffer['timeend'];
             
            // $timeend=$this->difftimeend($end,$start);
             
             $RankMarket=$this->getRankMark($ven_id);
             $rank=$RankMarket['rank'];
             
             return $this->getPush2($nameMarket, $rank, $img, "acceptoffercaptain", $offer_id,$ven_id,$address,$offer_title,$lon,$lat,$price,$timeend,null);//ERROR IMAGE
         } else {
            return 1;
         }
     }
     private function difftimeend($end,$start){
         $diff=$end-$start;
         $h=round($diff/(60*60));
         $hours=$diff/(60*60);
         $hours=$hours-$h;
         $hours=$hours*60;
         $result=$h;
         $result=$h.":".$hours;
         return $result;
     }
     
    private function StopAcceptOfferCaptain($offer_id){
         $query="UPDATE `captain_offer` SET `isEnd` = '1' WHERE `captain_offer`.`offer_id` = '".$offer_id."'";
         mysqli_query($this->con, $query);
     }
     
     public function SelectNowOfferMarket($id){
        $query=$this->con->prepare("SELECT captain.cap_id,captain.cap_name,captain.cap_photo_url,captain.cap_mobile,save_process.save_id,(SELECT TRUNCATE(avg(`ven_rank`), 2) "
                 . " FROM `save_process` WHERE `cap_id`=captain.cap_id)as eval FROM captain,save_process"
                 . " WHERE save_process.ven_id='".$id."' AND save_process.cap_id=captain.cap_id AND save_process.end_process=0");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
           $array[]=$row;
        }
        return $array;        
     }
     
     public function SelectOfferCaptain($id){
         $query=$this->con->prepare("SELECT vendor.ven_id,vendor.ven_name,vendor.ven_photo_url,vendor.ven_mobile,save_process.save_id,
save_process.id_offer_cap,save_process.id_offer_ven,vendor.ven_lon,vendor.ven_lat,
(SELECT vendor_offer.offer_pic1 FROM  vendor_offer WHERE vendor_offer.offer_id=save_process.id_offer_ven) as pic1,
(SELECT vendor_offer.offer_pic2 FROM  vendor_offer WHERE vendor_offer.offer_id=save_process.id_offer_ven) as pic2,
(SELECT vendor_offer.offer_pic3 FROM  vendor_offer WHERE vendor_offer.offer_id=save_process.id_offer_ven) as pic3,
(SELECT vendor_offer.offer_pic4 FROM  vendor_offer WHERE vendor_offer.offer_id=save_process.id_offer_ven) as pic4,
(SELECT vendor_offer.offer_title FROM  vendor_offer WHERE vendor_offer.offer_id=save_process.id_offer_ven) as title,
(SELECT vendor_offer.offer_disc FROM  vendor_offer WHERE vendor_offer.offer_id=save_process.id_offer_ven) as disc,
(SELECT vendor_offer.city FROM  vendor_offer WHERE vendor_offer.offer_id=save_process.id_offer_ven) as city_ven,
(SELECT vendor_offer.cost FROM  vendor_offer WHERE vendor_offer.offer_id=save_process.id_offer_ven) as cost_ven,
(SELECT vendor_offer.offer_end FROM  vendor_offer WHERE vendor_offer.offer_id=save_process.id_offer_ven) as dateend,
(SELECT captain_offer.offer_pic1 FROM  captain_offer WHERE captain_offer.offer_id=save_process.id_offer_cap) as cap_pic1,
(SELECT captain_offer.offer_pic2 FROM  captain_offer WHERE captain_offer.offer_id=save_process.id_offer_cap) as cap_pic2,
(SELECT captain_offer.offer_pic3 FROM  captain_offer WHERE captain_offer.offer_id=save_process.id_offer_cap) as cap_pic3,
(SELECT captain_offer.offer_pic4 FROM  captain_offer WHERE captain_offer.offer_id=save_process.id_offer_cap) as cap_pic4,
(SELECT captain_offer.offer_title FROM  captain_offer WHERE captain_offer.offer_id=save_process.id_offer_cap) as cap_title,
(SELECT captain_offer.offer_disc FROM  captain_offer WHERE captain_offer.offer_id=save_process.id_offer_cap) as cap_disc,
(SELECT captain_offer.cost FROM  captain_offer WHERE captain_offer.offer_id=save_process.id_offer_cap) as cost_cap,
(SELECT captain_offer.city FROM  captain_offer WHERE captain_offer.offer_id=save_process.id_offer_cap) as city_cap,
(SELECT captain_offer.offer_end FROM  captain_offer WHERE captain_offer.offer_id=save_process.id_offer_cap) as cap_dateend,
(SELECT TRUNCATE(avg(`cap_rank`), 2) FROM `save_process` WHERE `ven_id`=vendor.ven_id)as eval ,save_process.end_process
FROM vendor,save_process
WHERE save_process.cap_id='".$id."' AND save_process.ven_id=vendor.ven_id AND  save_process.end_cap ='0' ORDER BY save_process.save_id DESC ");
        $query->execute();
        $result=$query->get_result();
        $array=array();
        while($row=mysqli_fetch_assoc($result)){
           $array[]=$row;
        }
        return $array;
     }
}
