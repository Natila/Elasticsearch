<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;
require 'vendor/autoload.php';


class Home extends CI_Controller{

    public function __construct()
    {
        parent::__construct();

        $this->client = new Client([
            'base_uri' => 'http://localhost:8888/Practices_ElasticSearch/'
        ]);
    }

    public function index(){

        $result = array();

        $keyword = $this->input->get('q');

        if ($keyword != '') {
            $response = $this->client->get("SearchAPI/search?q=$keyword")->getBody();
            $result = json_decode($response, true);

            $result['total'] = $result['hits']['total'];
            $result['data'] = $result['hits']['hits'];
        }

        $this->load->view('home_view', $result);
    }
}