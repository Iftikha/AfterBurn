<?php

    class Workout{

        // Private variables;
        private $workout;
        
        public function __construct(string $workout){
            $this->workout = $workout;
        }

        public function save($conn, array $user, $weeks, $intensity){
            $timeCommitment = strval($weeks) . " weeks";
            $workoutType = $user['workoutType'];
            $user_id = $user['id'];
            $workout_json = json_encode($this->workout);
            $stmt = $conn->prepare("INSERT INTO workouts (user_id, workout, timeCommitment, intesity, workoutType) VALUE (?, ?, ?, ?, ?)");
            $stmt->bind_param('issss', $user_id, $workout_json, $timeCommitment, $intensity, $workoutType);
            $stmt->execute();
            if($stmt->error){
                throw new Exception("Failed to save workout: " . $stmt->error);
            }
            return true;
        }

        public static function getWorkout($conn, $user_id){
            $stmt = $conn->prepare("SELECT * FROM workouts WHERE user_id = ? ");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            if($stmt->error){
                throw new Exception("Failed fetching workout: " . $stmt->error);
            }
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row;
        }

    }

?>