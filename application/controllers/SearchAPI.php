<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH. 'libraries/REST_Controller.php');

class SearchAPI extends REST_Controller {

    public function index(){
        echo "Yeah!";
    }
}