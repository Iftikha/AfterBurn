<?php

    class Cors{
        public function __construct(){
            $this->origins = [
             $_ENV['ORIGIN_LOCAL'],
             $_ENV['ORIGIN_PROD'],   
            ];
            $this->environment = $_ENV['ENV'];
        }
        private $origins = [];

        private $environment;

        public function handleCors(){
            $origin = $_SERVER['HTTP_ORIGIN'];
            if(in_array($origin, $this->origins))
            header("Access-Control-Allow-Origin: $origin");
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Token");
            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                http_response_code(200);
                exit;
            }
        }
    }

?>