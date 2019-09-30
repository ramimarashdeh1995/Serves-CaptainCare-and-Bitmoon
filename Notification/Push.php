<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Push
 *
 * @author Rami
 */
class Push {
    private $title;
    private $message;
    private $image;
    private $type;
    private $offer_id;
    
    function __construct($title, $message, $image,$type,$offer_id) {
         $this->title = $title;
         $this->message = $message; 
         $this->image = $image; 
         $this->type=$type;
         $this->offer_id=$offer_id;
    }
    
    public function getPush() {
        $res = array();
        $res['data']['title'] = $this->title;
        $res['data']['message'] = $this->message;
        $res['data']['image'] = $this->image;
        $res['data']['type'] = $this->type;
        $res['data']['offer_id'] = $this->offer_id;
        return $res;
    }
}
