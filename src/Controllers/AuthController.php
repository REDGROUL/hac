<?php


namespace App\Controllers;


class AuthController
{


    public function checkAuth($token) {
        $key = "some_keyhehe";
        $decoded = JWT::decode($token['access'], new Key($key, 'HS256'), $headers = new stdClass());
       return (array)$decoded;

        /*
         NOTE: This will now be an object instead of an associative array. To get
         an associative array, you will need to cast it as such:
        */


    }
}