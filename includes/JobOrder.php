<?php
if(!class_exists('JobOrder'))
{
	/**
	 * A JobOrder class that provides both Bullhorn and various WP related functionality
	 */
	class JobOrder
	{
		const POST_TYPE	= "job_order";
		private $_meta	= array(
			'jobOrderID',
			'address_address1',
			'address_city',
			'address_countryID',
			'address_state',
			'address_zip',
			'benefits',
			'billRateCategoryID',
			'bonusPackage',
			'branchCode',
			'certificationList',
			'clientBillRate',
			'clientContactID',
			'clientCorporationID',
			'correlatedCustomDate1-3',
			'correlatedCustomFloat1-3',
			'correlatedCustomInt1-3',
			'correlatedCustomText1-10',
			'correlatedCustomTextBlock1-10',
			'costCenter',
			'customDate1-3',
			'customFloat1-3',
			'customInt1-3',
			'customText1-20',
			'customTextBlock1-5',
			'dateAdded',
			'dateClosed',
			'dateEnd',
			'dateLastExported',
			'degreeList',
			'description',
			'durationWeeks',
			'educationDegree',
			'employmentType',
			'externalCategoryID',
			'externalID',
			'feeArrangement',
			'hoursOfOperation',
			'hoursPerWeek',
			'isClientEditable',
			'isDeleted',
			'isInterviewRequired',
			'isJobcastPublished',
			'isOpen',
			'isPublic',
			'jobBoardList',
			'numOpenings',
			'onSite',
			'optionsPackage',
			'ownerID',
			'payRate',
			'publicDescription',
			'publishedZip',
			'reasonClosed',
			'reportTo',
			'reportToClientContactID',
			'responseUserID',
			'salary',
			'salaryUnit',
			'skillList',
			'source',
			'startDate',
			'status',
			'taxRate',
			'taxStatus',
			'title',
			'travelRequirements',
			'type',
			'willRelocate',
			'willSponsor',
			'workersCompRateID',
			'yearsRequired',
		);

		/**
		 * The Constructor
		 */
		public function __construct()
		{
			// register actions
			add_action('init', array(&$this, 'init'));
			add_action('admin_init', array(&$this, 'admin_init'));
		} // END public function __construct()

		/**
		 * hook into WP's init action hook
		 */
		public function init()
		{
			// Initialize Post Type
			$this->create_post_type();
			add_action('save_post', array(&$this, 'save_post'));
		} // END public function init()

		/**
		 * hook into WP's admin_init action hook
		 */
		public function admin_init()
		{
			// Add metaboxes
			add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
		} // END public function admin_init()

		/**
		 * Create the post type
		 */
		public function create_post_type()
		{
			register_post_type(self::POST_TYPE,
				array(
					'labels' => array(
						'name' => __(sprintf('%ss', ucwords(str_replace("_", " ", self::POST_TYPE)))),
						'singular_name' => __(ucwords(str_replace("_", " ", self::POST_TYPE)))
					),
					'public' => true,
					'has_archive' => true,
					'yarpp_support' => true,
					'taxonomies' => array( 'post_tag', 'category' ),
					'description' => __("Job Orders from the Bullhorn API"),
					'supports' => array(
						'title', 'editor', 'excerpt',
					),
				)
			);
		}

		/**
		 * hook into WP's add_meta_boxes action hook
		 */
		public function add_meta_boxes()
		{
			// Add this metabox to every selected post
			add_meta_box(
				sprintf('id_wp_bullhorn_%s_section', self::POST_TYPE),
				sprintf('%s Information', ucwords(str_replace("_", " ", self::POST_TYPE))),
				array(&$this, 'add_inner_meta_boxes'),
				self::POST_TYPE
    	);
		} // END public function add_meta_boxes()

		/**
		 * called off of the add meta box
		 */
		public function add_inner_meta_boxes($post)
		{
			// Render the job order metabox
			include(sprintf("%s/../templates/%s_metabox.php", dirname(__FILE__), self::POST_TYPE));
		} // END public function add_inner_meta_boxes($post)

        /**
         * Save the metaboxes for this custom post type
         */
        public function save_post($post_id)
        {
            // verify if this is an auto save routine.
            // If it is our form has not been submitted, so we dont want to do anything
            if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            {
                return;
            }

            $data = array();
            if(isset($_POST['post_type']))
            {
                $data = $_POST;
            }
            else
            {
                global $post_data;
                $data = $post_data;
            }

        	if($data['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
        	{
        		if(!empty($data['jobOrderID']))
        		{
        			foreach($this->_meta as $field)
        			{
        				// Update the post's meta field
        				update_post_meta($post_id, $field, $data[$field]);
        			}
        		}
        	}
        	else
        	{
        		return;
        	} // if($data['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
        } // END public function save_post($post_id)

		/**
		 * Sync the JobOrders from Bullhorn's API
		 */
		public function sync()
		{
            global $wpdb;

            // Import the required api classes
            require_once(sprintf("%s/api/JobOrder.php", dirname(__FILE__)));
            require_once(sprintf("%s/api/Connection.php", dirname(__FILE__)));

			// Create a connection to bullhorn
			$bh_connection = new BullhornConnection(get_option('bh_username'), get_option('bh_password'), get_option('bh_api_key'));
			$bh_job_order = new BullhornJobOrder();

			// Query for all job order JobOrderIDs
			if(($arr_ids = $bh_job_order->query($bh_connection)) != False)
			{
				// Unpublish all job-order posts
				$wpdb->query(
				    sprintf("
				        UPDATE $wpdb->posts
    				    SET post_status = 'pending'
    				    WHERE post_type = '%s'",
    				    self::POST_TYPE
				    )
				);

				// Get all of the job-order that are active currently
				$jobs = $bh_job_order->get_multiple($bh_connection, $arr_ids);
				foreach($jobs as $job)
				{

					if (get_option( 'bh_publish_status' ) == '1') {

							// Only publish open, public jobs that are not deleted
							if($job->isPublic == '1' && $job->isOpen == '1' && $job->isDeleted != '1' && $job->status == 'Open')
							{
								$post = array(
								'post_status' => 'publish',
								'post_type' => self::POST_TYPE,
								'post_title' => (string)$job->title,
								'post_content' => (string)$job->description,
								'post_excerpt' => (string)$job->excerpt,
								'post_author' => 1,
								'filter' => true
								);
							}
							else
							{
								$post = array(
								'post_status' => 'draft',
								'post_type' => self::POST_TYPE,
								'post_title' => (string)$job->title,
								'post_content' => (string)$job->description,
								'post_excerpt' => (string)$job->excerpt,
								'post_author' => 1,
								'filter' => true
								);
							} // END if($job->isPublic == '1' && $job->isOpen == '1' && $job->isDeleted != '1' && $job->status == 'Open')

					} else {

							$post = array(
							'post_status' => 'draft',
							'post_type' => self::POST_TYPE,
							'post_title' => (string)$job->title,
							'post_content' => (string)$job->description,
							'post_excerpt' => (string)$job->excerpt,
							'post_author' => 1,
							'filter' => true
							);

					} // END if (get_option( 'bh_publish_status' ) == '1')

					// Try to get a post with this JobOrderID
					$post_id = $wpdb->get_var(
						sprintf("
							SELECT post_id
							FROM $wpdb->postmeta
							WHERE meta_key = 'jobOrderID'
							AND meta_value = %s
							LIMIT 1",
							$job->jobOrderID
						)
					);

					// Insert or update a post depending on whther the
					// JobOrderID exists in the system already
					if($post_id != 0)
					{
						$post['ID'] = $post_id;
						$post_id = wp_update_post($post);
					}
					else
					{
						$post_id = wp_insert_post($post);
					}

					// If post_id
					if(!empty($post_id) && $post_id > 0)
					{
						// then update all of the metadata
						foreach($job as $field_name => $field_value)
						{
						    if(is_object($field_value))
						    {
						        foreach($field_value as $key => $value)
						        {
						            @update_post_meta($post_id, sprintf("%s_%s", $field_name, $key), (string)$value);
						        }
						    }
						    else
						    {
						        @update_post_meta($post_id, $field_name, (string)$field_value);
						    }
						} // END foreach($this->_meta as $field_name)
					} // END if(!empty($post_id) && $post_id > 0)
				} // END foreach($jobs as $job)
			} // END if(($arr_ids = $bh_job_order->query($bh_connection)) != False)
		} // END public function sync()
	} // END class JobOrder
} // END if(!class_exists('JobOrder'))
