<?php

require_once 'Model.php';
require_once 'UserModel.php';

class PropertyModel extends Model {

    public $app;
    
    function __construct($app) {
        $this->app = $app;
        $this->User = new UserModel($app);
    }
    
    function getAll() {
         $token = $this->app->request->headers('PHP_AUTH_PW');
         $validToken = $this->User->checkToken($token);
         
         $data = array();
         if(!$validToken) {
              $data['error'] = 'Not Valid Token';
         } else {
              $userId = $this->User->userId;
              $query = "Select `id`, `name`, `description` from `properties` where `user_id` = '$userId'";
              $results = $this->fetchAll($query);
              $data['status'] = '200';
              $data['data'] = $results;
         }
         echo json_encode($data);  
    }

    function getDetail($property_id = null) {

         $token = $this->app->request->headers('PHP_AUTH_PW');
         $validToken = $this->User->checkToken($token);
         
         $data = array();
         if(!$validToken) {
              $data['error'] = 'Not Valid Token';
         } else {
              $userId = $this->User->userId;
              $query = "Select `id`, `name`, `description` from `properties` where `user_id` = '$userId' and `id` = '$property_id'";
              $result = $this->fetchOne($query);
              $data['status'] = '200';
              if(empty($result)) {
                 $data['error'] = 'No Record Found';
              } else {
                 $data['data'] = $result;
              }
         }
         echo json_encode($data);  
    }    


    function delete($property_id = null) {

         $token = $this->app->request->headers('PHP_AUTH_PW');
         $validToken = $this->User->checkToken($token);
         
         $data = array();
         if(!$validToken) {
              $data['error'] = 'Not Valid Token';
         } else {
              $userId = $this->User->userId;
              $query = "Select `id`, `name`, `description` from `properties` where `user_id` = '$userId' and `id` = '$property_id'";
              $result = $this->fetchOne($query);
              $data['status'] = '200';
              if(empty($result)) {
                 $data['error'] = 'No Record Found';
              } else {
                 $query = "Delete from `properties` where `id` = '$property_id'";
                 mysql_query($query);
                 $data['success'] = 'Record Deleted';
              }
         }
         echo json_encode($data);  
    }

    function add() {

         $token = $this->app->request->headers('PHP_AUTH_PW');
         $validToken = $this->User->checkToken($token);
         
         $data = array();
         if(!$validToken) {
              $data['error'] = 'Not Valid Token';
         } else {
              $userId = $this->User->userId;
              $body = $this->app->request->getBody();
              $details = json_decode($body, true);
              
              $name = $details['name'];
              $description = $details['description'];
              
              $query = "INSERT INTO `properties` (`id`, `user_id`, `name`, `description`) VALUES (NULL, '$userId', '$name', '$description');";
              $this->query($query);
              $data['status'] = '200';
              $data['success'] = 'Record Added';
         }
         echo json_encode($data);  
    }  

    function edit($property_id) {

         $token = $this->app->request->headers('PHP_AUTH_PW');
         $validToken = $this->User->checkToken($token);
         
         $data = array();
         if(!$validToken) {
              $data['error'] = 'Not Valid Token';
         } else {
              $userId = $this->User->userId;
              $query = "Select `id` from `properties` where `user_id` = '$userId' and `id` = '$property_id'";
              $result = $this->fetchOne($query);
              if(empty($result)) {
                  $data['error'] = 'No Record Found';
              } else {
                  $body = $this->app->request->getBody();
                  $details = json_decode($body, true);
                  
                  $name = @$details['name'];
                  $description = @$details['description'];
                  
                  $queryParams = array();
                  if(!empty($name)) {
                     $queryParams[] = "`name` = '$name'";
                  }
                  if(!empty($description)) {
                     $queryParams[] = "`description` = '$description'";
                  }
                  
                  $queryToUpdate = implode(',', $queryParams); 
                                    
                  if(!empty($queryToUpdate)) {
                      $query = "UPDATE `properties` SET $queryToUpdate WHERE  `properties`.`id` = '$property_id' LIMIT 1 ;";
                      $this->query($query);
                  }
                  $data['status'] = '200';
                  $data['success'] = 'Record Edited';
              }    
         }
         echo json_encode($data);  
    }              
}