<?php
if(!class_exists('BullhornJobOrder'))
{
	class BullhornJobOrder
	{
        private $_messsages = array();
		
        /**
         * Constructor
         */
		public function __construct() 
		{
		    // Do Nothing
		} // END public function __construct()
		
        /**
         * Clear all of the messages in the buffer
         * return the existing buffer
         *
         * @return array
         */
        public function get_messages()
        {
            $messages = $this->_messsages;
            $this->_messages = array();

            return $messages;
        } // END public function get_messages()
		
        /**
         * Go through each id in the list of IDs and pull the DTO for that ID
         * 
         * @param BullhornConnection
         * @param array
         * @return array|bool
         */
        public function get_multiple($connection, $arr_ids)
        {
            $arr_job_orders = array();
            foreach(array_chunk($arr_ids, 20) as $chunk)
            {
                $find_request = array (
                    'session' => $connection->get_session(), 
                    'entityName' => 'JobOrder', 
                    'ids' =>  $chunk
                );

                try
                { 
                    $findResult = $connection->get_client()->findMultiple($find_request);
                    $arr_job_orders = array_merge($arr_job_orders, $findResult->return->dtos);
                }
                catch(SoapFault $fault)
                {
                    $this->_messsages[] = $fault->faultstring; 
                }
            }

            return $arr_job_orders;
        } // END public function get_multiple($connection, $arr_ids)
		
		/**
		 * Get a list of IDs that coorespond to JobOrder DTOs
		 * or false on error
		 *
		 * @param BullhornConnection
		 * @return array|bool
		 */
        public function query($connection)
        {
            $query_array = array(
                'entityName' => 'JobOrder',
                'where' => 'isOpen=1',
                'parameters' => array(),
                'distinct' => TRUE,
            );
            
            $SOAP_query = new SoapVar($query_array,  SOAP_ENC_OBJECT, "dtoQuery", "http://query.apiservice.bullhorn.com/");
            
            $request_array = array(
                'session' => $connection->get_session(), 
                'query' => $SOAP_query 
            );
            $SOAP_request = new SoapVar($request_array,  SOAP_ENC_OBJECT, "query", "http://query.apiservice.bullhorn.com/");

            try
            { 
                $queryResult = $connection->get_client()->query($SOAP_request);

                $arr_ids = array(); 
                foreach($queryResult->return->ids as $value)
                {
                    $arr_ids[] = new SoapVar($value, XSD_INTEGER, "int", "http://www.w3.org/2001/XMLSchema"); 
                }
                 
                return $arr_ids;		
            }
            catch(SoapFault $fault)
            {
                print_r($fault);
                $this->_messsages[] = $fault->faultstring; 
            }

            return False;
        } // END public function query($connection)
	} // END class BullhornJobOrder
} // END if(!class_exists('BullhornJobOrder'))