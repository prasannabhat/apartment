<?php

class User extends Eloquent {

     public static $timestamps = true;

     public function phones()
     {
          return $this->has_many('Phone');
     }

     public function set_password($password)
     {
        $this->set_attribute('password', Hash::make($password));
     }

}