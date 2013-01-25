<?php
if(!class_exists('BullhornConnection'))
{
	class BullhornConnection
	{
		private $_wsdl_url 	= "https://api.bullhornstaffing.com/webservices-1.1/?wsdl";
		private $_auth			= NULL;
		private $_client 		= NULL;
		private $_params 		= array(
			'trace' => 1,
			'soap_version'	=> 'SOAP_1_1',			
		);

		/**
		 * Initializes the connection to the bullhorn API
		 */
		public function __construct($username, $password, $api_key)
		{	
			// Build an Authentication Request
			$this->_auth = new stdClass();
			$this->_auth->username = $username;
			$this->_auth->password = $password;
			$this->_auth->apiKey = $api_key;			
			
			// init the client
			$this->_client = new SoapClient($this->_wsdl_url, $this->_params);
		}
		
		/**
		 * Get a client object
		 */
		public function get_client()
		{
			return $this->_client;
		}
		
		/**
		 * Sessions have a short expiration and must be refreshed with each call to the Bullhorn API
		 */
		public function get_session()
		{
			// Get the session ID
			return $this->_client->startSession($this->_auth)->return;
		}
	} // End class BullhornConnection
}