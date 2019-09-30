<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassDiviceToken
 *
 * @author Rami
 */
class ClassDiviceToken {

    private $con;
    
    function __construct() {
        require '../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
    private function ReadQuery($query){
        if(mysqli_query($this->con, $query)){
            return 1;
        } else {
            return 0;
        }
    }

    public function UpdateTokenCaptain($id,$token){
        $query="UPDATE `captain` SET `cap_token` = '".$token."' WHERE `captain`.`cap_id` = '".$id."'";
        return $this->ReadQuery($query);
    }
    public function UpdateTokenMarket($id,$token){
        $query="UPDATE `vendor` SET `ven_token` = '".$token."' WHERE `vendor`.`ven_id` = '".$id."'";
        return $this->ReadQuery($query);
    }
    public function SignOutTokenCaptain($id){
        $query="UPDATE `captain` SET `cap_token` = '0' WHERE `captain`.`cap_id` = '".$id."'";
        return $this->ReadQuery($query);
    }
    public function SignOutTokenMarket($id){
        $query="UPDATE `vendor` SET `ven_token` = '0' WHERE `vendor`.`ven_id` = '".$id."'";
        return $this->ReadQuery($query);
    }
}
