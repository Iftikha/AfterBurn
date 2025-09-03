<?php

    use Firebase\JWT\JWT;
    use FireBase\Jwt\Key;

    class User {
        public function __construct(
            public $name,                         // Required
            public $email,                        // Required
            public $password,                     // Required
            public $confirmPassword,              // Required
            public $age,                          // Required
            public $gender,                       // Required
            public $weight,                       // Required
            public $targetWeight,                 // Required
            public $height,                       // Required
            public $goal,                         // Required
            public $difficultyLevel,              // Required
            public $timeCommitment,               // Required
            public $budget,                       // Required
            public $workoutType,                  // Required
            public $fitnessLevelCurrent,          // Required
            public $description = " ",            // Optional
        ){
            if(empty($name) || empty($email) || empty($password) || empty($confirmPassword) || empty($age) || 
            empty($gender) || empty($weight) || empty($targetWeight)|| empty($height) || empty($goal) || empty($workoutType)
            || empty($difficultyLevel) || empty($timeCommitment) || empty($budget) || empty($fitnessLevelCurrent)){
                throw new Exception("All fields are required.");
        }
    }

    // Check krega k jo humne passwords diye hain kia wo match krte hain ya nahi
    private function verifyPassword(){
        if($this->password !== $this->confirmPassword){
            throw new Exception("Passwords do not matched.");
        }
        return true;
    }

    // Hash generate krega
    private function hashPassword(){
        if($this->verifyPassword()){
            return password_hash($this->password, PASSWORD_BCRYPT);
        }
        return false;
    }

    // User ko save kre ga DB main
public function save($conn){
    $hashedPassword = self::hashPassword();
    if($hashedPassword !== false) {  // Check for false instead of truthy
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, age, gender, weight, targetWeight, height, goal, difficultyLevel, timeCommitment, budget, workoutType, description, fitnessLevelCurrent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            'sssssssssssssss',
            $this->name,                  // s: string
            $this->email,                 // s: string
            $hashedPassword,              // s: string
            $this->age,                   // s: string
            $this->gender,                // s: string
            $this->weight,                // s: string
            $this->targetWeight,          // s: string
            $this->height,                // s: string
            $this->goal,                  // s: string
            $this->difficultyLevel,       // s: string
            $this->timeCommitment,        // s: string
            $this->budget,                // s: string
            $this->workoutType,           // s: string
            $this->fitnessLevelCurrent,   // s: string (moved to correct position)
            $this->description            // s: string (moved to correct position)
        );
        
        // Execute the statement
        if(!$stmt->execute()) {
            throw new Exception("Error saving user: " . $stmt->error);
        }
        
        // Close the statement
        $stmt->close();
        
        return true;
    } else {
        throw new Exception("Password hashing failed");
    }
}

    // User ko get krega DB se Email ko match kr k
    public static function getUserByEmail($conn, $email){
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? ");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        if($stmt->error){
            throw new Exception("Error finding user: " . $stmt->error);
        }
        $result = $stmt->get_result();
        if($result->num_rows === 0){
            throw new Exception("No user found.");
        }
        $row = $result->fetch_assoc();
        return $row;
    }

    // Jo current user ki class bani hai usko get krega after signup is done
    public function getCurrentUser($conn){
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? ");
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        if($stmt->error){
            throw new Exception("An error occured: " . $stmt->error);
        }
        $result = $stmt->get_result();
        if($result->num_rows === 0){
            throw new Exception("No user found.");
        }
        $row = $result->fetch_assoc();
        return $row;
    }

    // User k lia token gen krega signup k baad
    public function genToken($conn){
        $issued_at = time();
        $expiry = $issued_at + (14 * 24 * 60 * 60); // 14 days;
        $user = self::getCurrentUser($conn);
        $payload = [
            "id" => $user['id'],
            "email" => $user['email'],
            "ist" => $issued_at,
            "exp" => $expiry
        ];

        $token = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
        return $token;
    }

    // User k lia token gen krega login k baad
    public static function getToken($conn, $email){
        $user = self::getUserByEmail($conn, $email);
        $issued_at = time();
        $expiry = $issued_at + (14 * 24 * 60 * 60); // 14 days;
        $payload = [
            "id" => $user['id'],
            "email" => $user['email'],
            "ist" => $issued_at,
            "exp" => $expiry
        ];

        $token = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
        return $token;
    }

    // Check krega k user exist krta hai ya nahi matlab new user hai ya old.
    public function checkIfExists($conn){
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? ");
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        if($stmt->error){
            throw new Exception("An Error occured: " . $stmt->error);
        }
        $result = $stmt->get_result();
        if($result->num_rows !== 0 ){
            return true;
        }
        return false;
    }
};
?>