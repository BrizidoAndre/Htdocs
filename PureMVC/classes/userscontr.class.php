<?php
include "users.class.php";

class UsersContr extends Users{

        public function createUser($name, $lastName){
            $this->setUser($name, $lastName);
        }

}