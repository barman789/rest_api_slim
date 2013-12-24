<?php

/**
* @author Sandeep <barman789@gmail.com>
*/

Class SlimApiClass{
	
/**
 * This is the response from the API
 *
 * @var json
 * @access public
 */
	public $response = '';	
	
/**
 * This is the base URL 
 *
 * @var string
 * @access private
 */
	private $_base_url = 'https://localhost/';

/**
 * Constructor
 */
 function __construct() {

 }


/**
 * Authenticate User
 *
 * @return void
 * @access public
 */
  public function authentication( $username = null, $password = null ) { 	

        $url = $this->_base_url . 'authenticate';
        $options = array();
        $options['post'] = true;
        $options['data']['username'] = $username;
        $options['data']['password'] = $password;
        $this->_callAPI($url, $options);
        //Print $this->response here to check the output. On Success, it will return token to be used in other calls.  
 }    

/**
 * get all Properties belonging to the given User
 *
 * @return void
 * @access public
 */
  public function getAll( $token = null) { 	

        $url = $this->_base_url . 'properties';
        $options = array();
        $options['headers'] = $token;
        $this->_callAPI($url);
 }    

/**
 * get Detail of Property
 *
 * @return void
 * @access public
 */
  public function getDetail( $token = null, $property_id = null ) { 	

        $url = $this->_base_url . 'properties/' . $property_id;
        $options = array();
        $options['headers'] = $token;        
        $this->_callAPI($url);
 }   
 
/**
 * Delete Property
 *
 * @return array
 * @access void
 */
  public function delete( $token = null, $property_id = null ) { 	

        $url = $this->_base_url . 'properties/' . $property_id;
        $options = array();
        $options['headers'] = $token;
        $options['delete'] = true;
        $this->_callAPI($url, $options);
 }

/**
 * Add Property
 *
 * @return void
 * @access public
 */
  public function add( $token = null, $data = array() ) { 	

        $url = $this->_base_url . 'properties';
        $options = array();
        $options['headers'] = $token;
        $options['post'] = true;
        $options['data']['name'] = $data['name'];
        $options['data']['description'] = $data['description'];
        $this->_callAPI($url, $options);
 }                  

/**
 * Edit a Property
 *
 * @return void
 * @access public
 */
  public function edit( $token = null, $data = array() ) { 	

        $url = $this->_base_url . 'properties/' . $data['id'];
        $options = array();
        $options['headers'] = $token;        
        $options['put'] = true;
        $options['data'] = $data;
        $this->_callAPI($url, $options);
 } 
  
/**
 * calls the API
 *
 * @return void
 * @access private
 */
  private function _callAPI( $url, $options = array() ) { 

        $ch = curl_init();
        
        if(isset($options['data'])) {
             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($options['data']));
             curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
        }
        
        if(isset($options['put'])) {
             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        }

        if(isset($options['post'])) {
             curl_setopt($ch, CURLOPT_POST, true);
        }        
        
        if(isset($options['delete'])) {
             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }        
        
        if(isset($options['headers'])) {
             curl_setopt($ch, CURLOPT_USERPWD, 'token:'.$options['headers']);
        }        
        
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
        curl_setopt($ch, CURLOPT_USERPWD, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);        		
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $this->response = curl_exec($ch);
        curl_close($ch);
  }
}
?>