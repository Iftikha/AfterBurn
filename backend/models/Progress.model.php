<?php

    class Progress{
        private $progress;
        public function __construct(string $progress)
        {
            $this->progress = json_decode($progress, true);
        }

        public function save($conn){
            $progress_json = json_encode($this->progress['progress']);
            $stmt = $conn->prepare("INSERT INTO progress (user_id, workout_id, progress, week) VALUE ( ?, ?, ?, ?)");
            $stmt->bind_param('iisi', $this->progress['user_id'], $this->progress['workout_id'], $progress_json, $this->progress['week']);
            $stmt->execute();
            if($stmt->error){
                throw new Exception("Error occured: " . $stmt->error);
            }
            return true;
        }

        public static function getProgress($conn, $uid, int $week = 0){
            $stmt = $conn->prepare("SELECT * FROM progress WHERE user_id = ?");
            $stmt->bind_param('s', $uid);
            $stmt->execute();
            if($stmt->error){
                throw new Exception("Error occured: " . $stmt->error);
            }
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                if($week === 0){
                    $res_array = [];
                    while($row = $result->fetch_assoc()){
                        $week++;
                        $res_array[$week] = $row;
                    }
                    return $res_array;
                }
                while($row = $result->fetch_assoc()){
                    if($row['week'] === $week){
                        return $row;
                    }
                }
            }
            throw new Exception("No record found.");
        }
    }

?>