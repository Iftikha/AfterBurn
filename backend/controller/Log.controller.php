<?php

    require_once __DIR__ . "/../models/Log.model.php";

    class LogController{
        public function __construct(private $conn){}

        public function saveLogs($logs){
            $headers = getallheaders();
            if(isset($headers['Token'])){
                $token = $headers['Token'];
                $decoded = AuthMiddleware::verifyToken($token);
                if(!$decoded){
                    http_response_code(400);
                    $err = new ErrorHandler("Invalid Token.", 400);
                    return json_encode($err->throwError());
                }
                $log = new Log($logs);
                if($log->save($this->conn)){
                    $logs = $log->getLogs($this->conn, $decoded['id']);
                    return json_encode($logs);
                }else{
                    $err = new ErrorHandler("Log creation failed.", 500);
                    http_response_code(500);
                    return json_encode($err->throwError());
                }
            }else{
                $err = new ErrorHandler("Token not provided.", 404);
                http_response_code(404);
                return json_encode($err->throwError());
            }
        }

        public function getLogs(){
             $headers = getallheaders();
            if(isset($headers['Token'])){
                $token = $headers['Token'];
                $decoded = AuthMiddleware::verifyToken($token);
                if(!$decoded){
                    http_response_code(400);
                    $err = new ErrorHandler("Invalid Token.", 400);
                    return json_encode($err->throwError());
                }
                $logs = Log::getLogs($this->conn, $decoded['id']);
                if($logs === 0){
                    $err = new ErrorHandler("No log found.", 404);
                    http_response_code(404);
                    return json_encode($err->throwError());
                }
                return json_encode($logs, JSON_PRETTY_PRINT);
            }else{
                $err = new ErrorHandler("Token not provided.", 404);
                http_response_code(404);
                return json_encode($err->throwError());
            }
        }
    }

?>