<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Elasticsearch\ClientBuilder;


require 'vendor/autoload.php';

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	    $host = [
	        'http://localhost:9200'
        ];


        $client = ClientBuilder::create()
            ->setHosts($host)
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
        echo "<pre>";
        print_r($response);

		$this->load->view('welcome_message');
	}
}
