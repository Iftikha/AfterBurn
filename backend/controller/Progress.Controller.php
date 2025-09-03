<?php

    require_once __DIR__ . "/../models/Progress.model.php";

    class ProgressController{
        public function __construct(private $conn){}

        public function getProgressByWeek($week){
            $headers = getallheaders();
            if(isset($headers['Token'])){
                $token = $headers['Token'];
                $decoded = AuthMiddleware::verifyToken($token);
                if(!$decoded){
                    http_response_code(400);
                    $err = new ErrorHandler("Invalid Token", 400);
                    return json_encode($err->throwError());
                }
                $progress_array = Progress::getProgress($this->conn,  $decoded['id'], $week);
                if($progress_array){
                    return json_encode($progress_array);
                }
                else{
                    $err = new ErrorHandler("No record found for week " . $week, 404);
                    http_response_code(404);
                    return json_encode($err->throwError());
                }
            }else{
                $err = new ErrorHandler( "No token provided.", 404);
                http_response_code(404);
                return json_encode($err->throwError());
            }
        }

        public function getAllProgress(){
            $headers = getallheaders();
            if(isset($headers['Token'])){
                $token = $headers['Token'];
                $decoded = AuthMiddleware::verifyToken($token);
                if(!$decoded){
                    http_response_code(400);
                    $err = new ErrorHandler("Invalid Token", 400);
                    return json_encode($err->throwError());
                }
                $progress_array = Progress::getProgress($this->conn, $decoded['id']);
                return json_encode($progress_array);
            }else{
                $err = new ErrorHandler( "No token provided.", 404);
                http_response_code(404);
                return json_encode($err->throwError());
            }
        }

        public function saveProgress($request){
            $headers = getallheaders();
            if(isset($headers['Token'])){
                $token = $headers['Token'];
                $decoded = AuthMiddleware::verifyToken($token);
                if(!$decoded){
                    http_response_code(400);
                    $err = new ErrorHandler("Invalid Token.", 400);
                    return json_encode($err->throwError());
                }
                $progressArr = json_decode($request, true);
                $progress = new Progress($request);
                if($progress->save($this->conn)){
                    $progressArray = $progress->getProgress($this->conn, $decoded['id'], $progressArr['week']);
                    return json_encode($progressArray);
                }else{
                    $err = new ErrorHandler("Failed to save progress.", 500);
                    http_response_code(500);
                    return json_encode($err->throwError());
                }
            }else{
                http_response_code(500);
                $err = new ErrorHandler("No token provided.", 404);
                return json_encode($err->throwError());
            }
        }


    }

?>