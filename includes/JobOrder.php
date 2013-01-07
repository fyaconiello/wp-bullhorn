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
			'address',
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

			if($_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
			{
				if(!empty($_POST['jobOrderID']))
				{
					foreach($this->_meta as $field)
					{
						// Update the post's meta field
						update_post_meta($post_id, $field, $_POST[$field]);
					}
				}
			}
			else
			{
				return;
			} // if($_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
		} // END public function save_post($post_id)
	} // END class JobOrder
} // END if(!class_exists('JobOrder'))