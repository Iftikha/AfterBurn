<?php

    class ErrorHandler{
        public function __construct(private string $message, private int $code){}

        public function throwError(){
            return (["status" => $this->code, "message" => $this->message]);
        }
    }

?>