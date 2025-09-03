<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

    class AuthMiddleware{
        public function __construct(private $conn){}
        public static function verifyToken($token){
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
            return (array) $decoded;
        }
        
        public function getUser($token){
            $decoded_array = self::verifyToken($token);
            $user = User::getUserByEmail($this->conn, $decoded_array['email']);
            return $user;
        }
    }

?>