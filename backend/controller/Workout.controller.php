<?php

require_once __DIR__ .'/../models/Workout.model.php';
require_once __DIR__ .'/../models/Diet.model.php';
class WorkoutController
{
    public function __construct(private $conn){}
    private array $user;

    private function getPrompt()
    {
        $prompt = "You are a fitness trainer. Create a workout and diet plan. USER INFO:Age: {$this->user['age']}, Gender: {$this->user['gender']}, Weight: {$this->user['weight']}kg, Target: {$this->user['targetweight']}kg, Height: {$this->user['height']}cm, Goal: {$this->user['goal']}, Level: {$this->user['difficultyLevel']}, Time to acheive goal: {$this->user['timeCommitment']}, Type: {$this->user['workoutType']}, Budget: {$this->user['budget']} 
                    OUTPUT: Give me a JSON objects like this:
                    {
                    \"workout\": {
                        \"weeks\": 4,
                        \"day1\": {\"focus\": \"Upper Body\", \"exercises\": [\"Push-ups 3x10\", \"Squats 3x12\"]},
                        \"day2\": {\"focus\": \"Lower Body\", \"exercises\": [\"Lunges 3x10\", \"Plank 3x30s\"]}
                    },
                    \"diet\": {
                        \"calories\": 1800,
                        \"day1\": {\"breakfast\": \"Oats + banana\", \"lunch\": \"Chicken rice\", \"dinner\": \"Fish + vegetables\"},
                        \"day2\": {\"breakfast\": \"Eggs + toast\", \"lunch\": \"Salad + protein\", \"dinner\": \"Pasta + lean meat\"}
                    },
                    \"intensity\": \"Begineer\",
                    }
                    Important Notes:
                    - Diffculty level if ranges from beginner to advanced than make it normal workout with respect to the time commitment.
                    - If difficulty level is 'deadly', 'killer' or something like that than make the workout plan 10x harder than advanced plan.
                    - It should be as if user is trying to make body in one day if it's deadly or killer.
                    - The workout plan should follow a single pattern i.e you'll divide the plan in 6 days per week, like monday = day1, tuesday = day2, wednesday = day3, thursday = day4, friday = day5, saturday = day6, sunday = day7(rest).
                    - Don;t use anyother pattern just give the workout and diet output as i told you above.

                    Rules:
                    - Only JSON output, no extra text
                    - Keep within budget
                    - Match difficulty level
                    - Also give a valid difficulty level in json, like beginner, intermediate, advanced, or extreme.

                    CRITICAL NAMING RULES:
                    - Use EXACTLY: day1, day2, day3, day4 (lowercase, no spaces, no underscores)
                    - Use EXACTLY: workout, diet, weeks, focus, exercises, calories, breakfast, lunch, dinner
                    - Do NOT use: Day1, day_1, Day_1, DAY1, or any other variations
                    - Follow the JSON structure EXACTLY as shown above
                    - Only JSON output, no extra text
                    - Make plans different from each other
                    - Keep within budget
                    - Match difficulty level
                    ";

        return $prompt;

    }


    public function GenerateWorkout(string $user)
    {
        $this->user = json_decode($user, true);
        if($this->user){
            $prompt = self::getPrompt();
            $aiRes = useGenAi($prompt);

            $workout = preg_replace('/```(json)?|```/', '', $aiRes);
            return $workout;
        }
    }

    public function saveWorkout($token, $user){        
            $decoded = AuthMiddleware::verifyToken($token);
            if(!$decoded){
                http_response_code(404);
                $err = new ErrorHandler("Token not provided.", 404);
                return json_encode($err->throwError());
            }
            $allowGen = GenMiddleware::genMiddle($decoded['id'], $this->conn);
            if($allowGen !== true){
                return $allowGen;
            }
            $res = self::GenerateWorkout(json_encode($user));
            $workout_array = json_decode($res, true);
            $workout_json = self::createWorkout($workout_array);
            $diet_json = self::createDiet($workout_array);
            $Diet = new Diet($diet_json);
            $Workout = new Workout($workout_json);
            $week = $workout_array['workout']['weeks'];
            $intensity = $workout_array['intensity'];
            if($Workout->save($this->conn, $user, $week, $intensity) && $Diet->save($this->conn, $user)){
                $res = [];
                $res['workout'] = $Workout->getWorkout($this->conn, $user['id']);
                $res['diet'] = $Diet->getDiet($this->conn, $user['id']);
                http_response_code(201);
                return json_encode($res);
            }else{
                $err =new ErrorHandler("Workout creation failed.", 500);
                return json_encode($err->throwError());
            }
        }

    private function createWorkout(array $workout) :string{
        $workout_part = $workout['workout'];
        $workout_json = json_encode($workout_part);
        return $workout_json;
    }

    private function createDiet(array $workout){
        $diet_part = $workout['diet'];
        return json_encode($diet_part);
    }
    public function getWorkout($token){
        $decoded = AuthMiddleware::verifyToken($token);
        if($decoded){
            $uid = $decoded['id'];
            $workout = Workout::getWorkout($this->conn, $uid);
            if(!$workout){
                http_response_code(404);
                $err = new ErrorHandler("No workout found.", 404);
                return json_encode($err->throwError());
            }
            return json_encode($workout);
        }else{
            http_response_code(400);
            $err = new ErrorHandler("Invalid token.", 400);
            return json_encode($err->throwError());
        }
    }
    public function getDiet($token){
        $decoded = AuthMiddleware::verifyToken($token);
        if($decoded){
            $uid = $decoded['id'];
            $diet = Diet::getDiet($this->conn, $uid);
            if(!$diet){
                http_response_code(404);
                $err = new ErrorHandler("No workout found.", 404);
                return json_encode($err->throwError());
            }
            return json_encode($diet);
        }else{
            http_response_code(400);
            $err = new ErrorHandler("Invalid token.", 400);
            return json_encode($err->throwError());
        }
    }
}

?>