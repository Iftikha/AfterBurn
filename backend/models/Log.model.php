<?php

    class Log{
        public function __construct(private array $log){}

        public function save($conn){
            $stmt = $conn->prepare("INSERT INTO logs (user_id, workout_id, week, day, exercise, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('iiiiss', $this->log['user_id'], $this->log['workout_id'], $this->log['week'], $this->log['day'], $this->log['exercise'], $this->log['status']);
            $stmt->execute();
            if($stmt->error){
                throw new Exception("Failed to save logs: {$stmt->error}");
            }
            return true;
        }

        public static function getLogs($conn, $uid){
            $stmt = $conn->prepare("SELECT * FROM logs WHERE user_id = ?");
            $stmt->bind_param("i", $uid);
            $stmt->execute();
            if($stmt->error){
                throw new Exception("Failed to get logs: ", $stmt->error);
            }
            $result = $stmt->get_result();
            if($result->num_rows === 0){
                return [];
            }
            $data = [];
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }

    }

?>