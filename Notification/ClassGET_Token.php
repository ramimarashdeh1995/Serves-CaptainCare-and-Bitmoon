<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassGET_Token
 *
 * @author Rami
 */
class ClassGET_Token {
    private $con;
    
    function __construct() {
        require '../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
    public function getAllTokens_Captain(){
        $stmt = $this->con->prepare("SELECT captain.cap_token FROM captain");//query select all token captain and not select captain block
        $stmt->execute(); 
        $result = $stmt->get_result();
        $tokens = array(); 
        while($token = $result->fetch_assoc()){
            array_push($tokens, $token['cap_token']);
        }
        return $tokens; 
    }
 
    //getting a specified token to send push to selected captain
    public function getTokenByID_Captain($id){
        $stmt = $this->con->prepare("SELECT captain.cap_token FROM captain WHERE captain.cap_id = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute(); 
        $result = $stmt->get_result()->fetch_assoc();
        return array($result['cap_token']);        
    }
    
    
    /*
     * get token from market and send notinfication to market 
     */
     public function getAllTokens_Market(){
        $stmt = $this->con->prepare("SELECT vendor.ven_token FROM vendor");//query select all token market and not select market block
        $stmt->execute(); 
        $result = $stmt->get_result();
        $tokens = array(); 
        while($token = $result->fetch_assoc()){
            array_push($tokens, $token['ven_token']);
        }
        return $tokens; 
    }
 
    //getting a specified token to send push to selected market
    public function getTokenByID_Market($id){
        $stmt = $this->con->prepare("SELECT vendor.ven_token FROM vendor WHERE vendor.ven_id = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute(); 
        $result = $stmt->get_result()->fetch_assoc();
        return array($result['ven_token']);        
    }
}
