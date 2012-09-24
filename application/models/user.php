<?php

class User extends Eloquent {

     public static $timestamps = true;

     public function phones()
     {
          return $this->has_many('Phone');
     }

}