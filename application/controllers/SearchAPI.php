<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Elasticsearch\ClientBuilder;

require(APPPATH. 'libraries/REST_Controller.php');
require 'vendor/autoload.php';


class SearchAPI extends REST_Controller {

    var $host = ['http://localhost:9200'];
    var $q = '';

    public function __construct()
    {
        parent::__construct();

    }

    public function index_get() {
        $data['returncode'] = "00";
        $data['message'] = "Hi";

        $this->response($data);
    }

    public function test_get_all_get() {

        $client = ClientBuilder::create()
            ->setHosts($this->host)
            ->build();

        $params = [
            "index"=> "sample_index_1",
            "type"=> "products",
            "body"=> [
                "query"=> [
                    "match_all"=>[]
                ]
            ]
        ];

        $response = $client->search($params);
        $this->response($response);
    }

    public function get_shop_0001_get() {
        $client = ClientBuilder::create()
            ->setHosts($this->host)
            ->build();

        $params = [
            "index"=> "sample_index_1",
            "type"=> "products",
            "body"=> [
                "query"=> [
                    "match"=>[
                        "ShopId" => "0001"
                    ]
                ]
            ]
        ];

        $response = $client->search($params);
        $this->response($response);
    }

    public function get_shop_0002_get() {
        $client = ClientBuilder::create()
            ->setHosts($this->host)
            ->build();

        $params = [
            "index"=> "sample_index_1",
            "type"=> "products",
            "body"=> [
                "query"=> [
                    "match"=>[
                        "ShopId" => "0002"
                    ]
                ]
            ]
        ];

        $response = $client->search($params);
        $this->response($response);
    }

    public function search_get() {
        $this->q = $this->get('q');

        $client = ClientBuilder::create()
            ->setHosts($this->host)
            ->build();

        $params = [
            "index"=> "sample_index_2",
            "type"=> "products",
            "body"=> [
                "query"=> [
                    "bool"=> [
                        "must"=>[
                            "match"=> [
                                "Description" => "* $this->q *"
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $response = $client->search($params);
        $this->response($response);
    }
}