<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of connection_DB
 *
 * @author Rami
 */
class connection_DB {
    private $con;
    
    public function DB(){
        include_once dirname(__FILE__) . '/Config.php';

         $this->con= new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
         if(mysqli_connect_errno()){
             echo json_encode("not connect to database".mysqli_connect_error());
         }
         mysqli_query($this->con, "set character_set_server='utf8'");
         mysqli_query($this->con,"set names 'utf8'");
         return $this->con;
    }
}
