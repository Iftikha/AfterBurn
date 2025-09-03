<?php

    class ConnectionMiddleware{
        public static function allowConnection(){
            $headers = getallheaders();
            if(isset($headers['RequestSender'])){
                $reqSender = $headers['RequestSender'];
                if($reqSender === 'AfterBurn'){
                    return;
                }
            }
            die("Connection Blocked!");
        }
    }

?>