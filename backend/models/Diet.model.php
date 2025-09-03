<?php

    class Diet{

        // Private variables;
        private $diet;
        
        public function __construct(string $diet){
            $this->diet = $diet;
        }

        public function save($conn, array $user){
            $user_id = $user['id'];
            $diet_json = json_encode($this->diet);
            $stmt = $conn->prepare("INSERT INTO diets (user_id, diet) VALUE (?, ?)");
            $stmt->bind_param('is', $user_id, $diet_json);
            $stmt->execute();
            if($stmt->error){
                throw new Exception("Failed to save diet: " . $stmt->error);
            }
            return true;
        }

        public static function getDiet($conn, $user_id){
            $stmt = $conn->prepare("SELECT * FROM diets WHERE user_id = ? ");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            if($stmt->error){
                throw new Exception("Failed fetching diet: " . $stmt->error);
            }
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row;
        }

    }

?>