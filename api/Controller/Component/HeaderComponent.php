<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Network\Response;

class HeaderComponent extends Component
{
    public $components = ['RequestHandler'];


    public function initialize(array $config)
    {

    }

    public function setResponse($code,$message) {

        $this->response->statusCode($code);
        $this->response->body(json_encode(["message"=>$message]));
        return $this->response;

    }
}