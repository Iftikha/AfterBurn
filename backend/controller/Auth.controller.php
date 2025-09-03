<?php

    require_once __DIR__ . "/../models/User.model.php";

    class AuthController{
        public function __construct( private $conn ){}

        public function register($data){
            $NewUser = new User($data['name'], $data['email'], $data['password'], $data['confirmPassword'], $data['age'], $data['gender'], $data['weight'], $data['targetWeight'], $data['height'], $data['goal'], $data['difficultyLevel'], $data['timeCommitment'], $data['budget'], $data['fitnessLevelCurrent'], $data['description']);

            if(!$NewUser->checkIfExists($this->conn)){
                if($NewUser->save($this->conn)){
                    $token = $NewUser->genToken($this->conn);
                    $userData = $NewUser->getCurrentUser($this->conn);
                    $response['token'] = $token;
                    $response['user'] = json_encode($userData);
                    http_response_code(201);
                    return json_encode($response);
                }else{
                    http_response_code(500);
                    $err = new ErrorHandler("Registration failed.", 500);
                    return json_encode($err->throwError());
                }
            }else{
                http_response_code(409);
                $err = new ErrorHandler("User already exists.", 409);
                return json_encode($err->throwError());
            }
        }
        
        public function login($data){
            $email = $data['email'];
            $password = $data['password'];
            
            $fetchedUser = User::getUserByEmail($this->conn, $email);
            
            if($fetchedUser){
                $corrPass = $fetchedUser['password'];
                
                $matched = password_verify($password, $corrPass);
                if($matched){
                    $token = User::getToken($this->conn, $email);
                    $response['token'] = $token;
                    $response['user'] = json_encode($fetchedUser);
                    http_response_code(200);
                    return json_encode($response);
                }else{
                    http_response_code(400);
                    $err = new ErrorHandler("Incorrect email or password", 400);
                    return json_encode($err->throwError());
                }
            }else{
                http_response_code(404);
                $err = new ErrorHandler("User not found.", 404);
                return json_encode($err->throwError());
            }
        }

        public function getUser($token){
            $decoded = AuthMiddleware::verifyToken($token);
            if($decoded){
                $email = $decoded['email'];
                $user = User::getUserByEmail($this->conn, $email);
                $res['user'] = $user;
                return json_encode($res);
            }
            else{
                http_response_code(400);
                $err = new ErrorHandler("Invalid Token.", 400);
                return json_encode($err->throwError());
            }
        }
    }

?>