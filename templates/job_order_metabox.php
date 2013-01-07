<?php
// Create field definitions
$fields = array(
	'jobOrderID' => array(
		'label' => 'Job Order ID',
		'help_text' => '',
		'widget' => 'text'
	),
	'address' => array(
		'label' => 'Address',
		'help_text' => '',
		'widget' => 'text'
	),
	'benefits' => array(
		'label' => 'Benefits',
		'help_text' => '',
		'widget' => 'text'
	),
	'billRateCategoryID' => array(
		'label' => 'Bill Rate Category ID',
		'help_text' => '',
		'widget' => 'text'
	),
	'bonusPackage' => array(
		'label' => 'Bonus Package',
		'help_text' => '',
		'widget' => 'text'
	),
	'branchCode' => array(
		'label' => 'Branch Code',
		'help_text' => '',
		'widget' => 'text'
	),
	'certificationList' => array(
		'label' => 'Certification List',
		'help_text' => '',
		'widget' => 'text'
	),
	'clientBillRate' => array(
		'label' => 'Client Bill Rate',
		'help_text' => '',
		'widget' => 'text'
	),
	'clientContactID' => array(
		'label' => 'Client Contact ID',
		'help_text' => '',
		'widget' => 'text'
	),
	'clientCorporationID' => array(
		'label' => 'Client Corporation ID',
		'help_text' => '',
		'widget' => 'text'
	),
	'correlatedCustomDate1-3' => array(
		'label' => 'Correlated Custom Date1-3',
		'help_text' => '',
		'widget' => 'text'
	),
	'correlatedCustomFloat1-3' => array(
		'label' => 'Correlated Custom Float1-3',
		'help_text' => '',
		'widget' => 'text'
	),
	'correlatedCustomInt1-3' => array(
		'label' => 'Correlated Custom Int1-3',
		'help_text' => '',
		'widget' => 'text'
	),
	'correlatedCustomText1-10' => array(
		'label' => 'Correlated Custom Text1-10',
		'help_text' => '',
		'widget' => 'text'
	),
	'correlatedCustomTextBlock1-10' => array(
		'label' => 'Correlated Custom Text Block1-10',
		'help_text' => '',
		'widget' => 'textarea'
	),
	'costCenter' => array(
		'label' => 'Cost Center',
		'help_text' => '',
		'widget' => 'text'
	),
	'customDate1-3' => array(
		'label' => 'Custom Date1-3',
		'help_text' => '',
		'widget' => 'text'
	),
	'customFloat1-3' => array(
		'label' => 'Custom Float1-3',
		'help_text' => '',
		'widget' => 'text'
	),
	'customInt1-3' => array(
		'label' => 'Custom Int1-3',
		'help_text' => '',
		'widget' => 'text'
	),
	'customText1-20' => array(
		'label' => 'Custom Text1-20',
		'help_text' => '',
		'widget' => 'text'
	),
	'customTextBlock1-5' => array(
		'label' => 'Custom Text Block1-5',
		'help_text' => '',
		'widget' => 'textarea'
	),
	'dateAdded' => array(
		'label' => 'Date Added',
		'help_text' => '',
		'widget' => 'text'
	),
	'dateClosed' => array(
		'label' => 'Date Closed',
		'help_text' => '',
		'widget' => 'text'
	),
	'dateEnd' => array(
		'label' => 'Date End',
		'help_text' => '',
		'widget' => 'text'
	),
	'dateLastExported' => array(
		'label' => 'Date Last Exported',
		'help_text' => '',
		'widget' => 'text'
	),
	'degreeList' => array(
		'label' => 'Degree List',
		'help_text' => '',
		'widget' => 'text'
	),
	'description' => array(
		'label' => 'Description',
		'help_text' => '',
		'widget' => 'textarea'
	),
	'durationWeeks' => array(
		'label' => 'Duration Weeks',
		'help_text' => '',
		'widget' => 'text'
	),
	'educationDegree' => array(
		'label' => 'Education Degree',
		'help_text' => '',
		'widget' => 'text'
	),
	'employmentType' => array(
		'label' => 'Employment Type',
		'help_text' => '',
		'widget' => 'text'
	),
	'externalCategoryID' => array(
		'label' => 'External Category ID',
		'help_text' => '',
		'widget' => 'text'
	),
	'externalID' => array(
		'label' => 'External ID',
		'help_text' => '',
		'widget' => 'text'
	),
	'feeArrangement' => array(
		'label' => 'Fee Arrangement',
		'help_text' => '',
		'widget' => 'text'
	),
	'hoursOfOperation' => array(
		'label' => 'Hours Of Operation',
		'help_text' => '',
		'widget' => 'text'
	),
	'hoursPerWeek' => array(
		'label' => 'Hours Per Week',
		'help_text' => '',
		'widget' => 'text'
	),
	'isClientEditable' => array(
		'label' => 'Is Client Editable',
		'help_text' => '',
		'widget' => 'text'
	),
	'isDeleted' => array(
		'label' => 'Is Deleted',
		'help_text' => '',
		'widget' => 'text'
	),
	'isInterviewRequired' => array(
		'label' => 'Is Interview Required',
		'help_text' => '',
		'widget' => 'text'
	),
	'isJobcastPublished' => array(
		'label' => 'Is Jobcast Published',
		'help_text' => '',
		'widget' => 'text'
	),
	'isOpen' => array(
		'label' => 'Is Open',
		'help_text' => '',
		'widget' => 'text'
	),
	'isPublic' => array(
		'label' => 'Is Public',
		'help_text' => '',
		'widget' => 'text'
	),
	'jobBoardList' => array(
		'label' => 'Job Board List',
		'help_text' => '',
		'widget' => 'text'
	),
	'numOpenings' => array(
		'label' => 'Num Openings',
		'help_text' => '',
		'widget' => 'text'
	),
	'onSite' => array(
		'label' => 'On Site',
		'help_text' => '',
		'widget' => 'text'
	),
	'optionsPackage' => array(
		'label' => 'Options Package',
		'help_text' => '',
		'widget' => 'text'
	),
	'ownerID' => array(
		'label' => 'Owner ID',
		'help_text' => '',
		'widget' => 'text'
	),
	'payRate' => array(
		'label' => 'Pay Rate',
		'help_text' => '',
		'widget' => 'text'
	),
	'publicDescription' => array(
		'label' => 'Public Description',
		'help_text' => '',
		'widget' => 'textarea'
	),
	'publishedZip' => array(
		'label' => 'Published Zip',
		'help_text' => '',
		'widget' => 'text'
	),
	'reasonClosed' => array(
		'label' => 'Reason Closed',
		'help_text' => '',
		'widget' => 'text'
	),
	'reportTo' => array(
		'label' => 'Report To',
		'help_text' => '',
		'widget' => 'text'
	),
	'reportToClientContactID' => array(
		'label' => 'Report To Client Contact ID',
		'help_text' => '',
		'widget' => 'text'
	),
	'responseUserID' => array(
		'label' => 'Response User ID',
		'help_text' => '',
		'widget' => 'text'
	),
	'salary' => array(
		'label' => 'Salary',
		'help_text' => '',
		'widget' => 'text'
	),
	'salaryUnit' => array(
		'label' => 'Salary Unit',
		'help_text' => '',
		'widget' => 'text'
	),
	'skillList' => array(
		'label' => 'Skill List',
		'help_text' => '',
		'widget' => 'text'
	),
	'source' => array(
		'label' => 'Source',
		'help_text' => '',
		'widget' => 'text'
	),
	'startDate' => array(
		'label' => 'Start Date',
		'help_text' => '',
		'widget' => 'text'
	),
	'status' => array(
		'label' => 'Status',
		'help_text' => '',
		'widget' => 'text'
	),
	'taxRate' => array(
		'label' => 'Tax Rate',
		'help_text' => '',
		'widget' => 'text'
	),
	'taxStatus' => array(
		'label' => 'Tax Status',
		'help_text' => '',
		'widget' => 'text'
	),
	'title' => array(
		'label' => 'Title',
		'help_text' => '',
		'widget' => 'text'
	),
	'travelRequirements' => array(
		'label' => 'Travel Requirements',
		'help_text' => '',
		'widget' => 'text'
	),
	'type' => array(
		'label' => 'Type',
		'help_text' => '',
		'widget' => 'text'
	),
	'willRelocate' => array(
		'label' => 'Will Relocate',
		'help_text' => '',
		'widget' => 'text'
	),
	'willSponsor' => array(
		'label' => 'Will Sponsor',
		'help_text' => '',
		'widget' => 'text'
	),
	'workersCompRateID' => array(
		'label' => 'Workers Comp Rate ID',
		'help_text' => '',
		'widget' => 'text'
	),
	'yearsRequired' => array(
		'label' => 'Years Required',
		'help_text' => '',
		'widget' => 'text'
	),
);	
?>
<table> 
<?php foreach($fields as $field => $data) : ?>
  <tr valign="top">
		<th class="metabox_label_column"><label for="<?php echo $field; ?>"><?php echo _e($data['label'], $field); ?></label></th>
		<td>
		<?php if($data['widget'] == 'text') : ?>
			<input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>" value="<?php echo get_post_meta($post->ID, $field, true); ?>" />
		<?php elseif($data['widget'] == 'textarea') : ?>
			<textarea id="<?php echo $field; ?>" name="<?php echo $field; ?>" rows="8" cols="40"><?php echo get_post_meta($post->ID, $field, true); ?></textarea>
		<?php endif; ?>	
		<?php if(!empty($data['help_text'])) : ?>
			<p class="help"><?php echo $data['help_text']; ?></p>
		<?php endif; ?>
		</td>
	<tr>
<?php endforeach; ?>
</table>