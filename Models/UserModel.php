<?php

require_once 'Model.php';

class UserModel extends Model {

    public $app;
    public $userId = null;
    
    
    function __construct($app) {
        $this->app = $app;
    }
    
    public function authenticate() {
         $body = $this->app->request->getBody();
         $details = json_decode($body, true);
         $username = $details['username'];
         $password = $details['password'];
         
         $query = "Select * from `users` where `username` = '$username' and `password` = '$password'";
         $result = $this->fetchOne($query);
         
         $data = array();
         if(!empty($result)) {
              $token = md5(time().rand().$result['id']);
              $userId = $result['id'];
              $query = "Update `users` SET `token` = '$token' where `id` = '$userId'";
              $this->query($query);
              $data['status'] = '200';
              $data['token'] = $token;
         } else {
              $data['error'] = 'Credentials Not Correct';
         }
         
         echo json_encode($data);  
    }
    
    public function checkToken($token) {
         if(empty($token)) {
              return false;
         }
         
         $query = "Select * from `users` where `token` = '$token'";
         $result = $this->fetchOne($query);
         if(empty($result)) {
             return false;
         } else {
             $this->userId = $result['id'];
             return true;
         }
    }


}