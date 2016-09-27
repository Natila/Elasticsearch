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
            $result['AllBrands_filter'] = $result['aggregations']['AllBrands']['buckets'];
            $result['AllCategories_filter'] = $result['aggregations']['AllCategories']['buckets'];
            $result['AllAttributes_filter'] = $result['aggregations']['AllAttributes']['Attributes']['buckets'];

            // Attributes
            foreach ($result['AllAttributes_filter'] as $attribute) {
                if ($attribute['key'] == 1) {
                    $result['size_attribute']['key'] = "01";
                    $result['size_attribute']['data'] = $attribute['AttributeValue']['AttributeValueName']['buckets'];
                } else if ($attribute['key'] == 2) {
                    $result['color_attribute']['key'] = "02";
                    $result['color_attribute']['data'] = $attribute['AttributeValue']['AttributeValueName']['buckets'];
                }
            }
        }

        $this->load->view('home_view', $result);
    }

    public function search() {
        $keyword = $this->input->get('q');
        $respond = $this->client->get("SearchAPI/search_suggestion?q=$keyword")->getBody();
    }
}