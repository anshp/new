<?php

namespace Employee\Model;

 class Employee
 {
     public $username;
     public $password;

     public function exchangeArray($data)
     {
         $this->username = (!empty($data['username'])) ? $data['username'] : null;
         $this->password  = (!empty($data['password'])) ? $data['password'] : null;
     }
 }