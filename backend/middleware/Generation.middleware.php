<?php

    class GenMiddleware{
        public static function genMiddle($uid, $conn){
            $workout = Workout::getWorkout($conn, $uid);
            $diet = Diet::getDiet($conn, $uid);
            if($workout && $diet){
                http_response_code(409);
                $err = new ErrorHandler("Workout and Diet generation failed. Data duplication predicted.", 409);
                return json_encode($err->throwError());
            }
            return true;
        }
    }

?>