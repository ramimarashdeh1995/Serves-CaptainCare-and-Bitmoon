<?php

class ClassContract{
 private $con;
    
    function __construct() {
        require '../connection_database/connection_DB.php';
        $db=new connection_DB();
        $this->con=$db->DB();       
    }
    public function getContract(){
        $query="SELECT * FROM `Contract` WHERE `contract_id` = 1 ";
        $resylt= mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($resylt);

    }
}