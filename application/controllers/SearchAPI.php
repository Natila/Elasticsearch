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
                        "should"=> [
                            [
                                "match"=> [
                                    "Description" => "* $this->q *"
                                ]
                            ],
                            [
                                "match"=> [
                                    "BrandName" => "* $this->q *"
                                ]
                            ],
                            [
                                "match"=> [
                                    "CategoryName"=> "* $this->q *"
                                ]
                            ]
                        ]
                    ]
                ],
                "aggs"=> [
                    "AllBrands"=> [
                      "terms"=> [
                          "field"=> "BrandId"
                      ],
                      "aggs"=> [
                          "BrandName"=> [
                              "terms"=> [
                                  "field"=> "BrandName"
                              ]
                          ]
                      ]
                    ],
                    "AllCategories"=> [
                        "terms"=> [
                            "field"=> "CategoryId"
                        ],
                        "aggs"=> [
                            "CategoryName"=> [
                                "terms"=> [
                                    "field"=> "CategoryName"
                                ]
                            ]
                        ]
                    ],
                    "AllAttributes"=> [
                       "nested"=> [
                           "path"=> "Attributes"
                       ],
                        "aggs"=> [
                            "Attributes"=> [
                                "terms"=> [
                                   "field"=> "Attributes.AttributeId"
                                ],
                                "aggs"=> [
                                    "AttributeValue"=> [
                                        "nested"=> [
                                            "path"=> "Attributes.AttributeValue"
                                        ],
                                        "aggs"=> [
                                            "AttributeValueName"=> [
                                                "terms"=> [
                                                    "field"=> "Attributes.AttributeValue.AttributeValueName"
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $response = $client->search($params);
        $this->response($response);
    }

    public function search_suggestion_get() {
        $suggestion_result  = $this->_get_suggesetion();
    }

    private function _get_suggesetion() {
        $this->q = $this->get('q');

        $client = ClientBuilder::create()
            ->setHosts($this->host)
            ->build();

        $params = [
            "index"=> "sample_index_2",
            "type"=> "products",
            "body"=> [
                "suggest"=> [
                    "text"=> $this->q,
                    "suggestProductDescription"=> [
                        "term"=> [
                            "field"=> "Description"
                        ]
                    ],
                    "suggestCategoryName"=> [
                        "term"=> [
                            "field"=> "CategoryName"
                        ]
                    ],
                    "suggestBrandName"=> [
                        "term"=> [
                            "field"=> "BrandName"
                        ]
                    ]
                ]
            ]
        ];

        $response = $client->search($params);
        return json_decode($response);
    }
}