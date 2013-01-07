<?php
// Snippet to format a bunch of fields at once
echo '<pre>';
foreach($this->_meta as $key)
{
$string = "
'%s' => array(
	'label' => '%s',
	'help_text' => '',
	'widget' => 'text'
),";
echo sprintf($string, $key, ucwords(preg_replace('/([a-z])([A-Z])/', '$1 $2', $key)) );
}
echo '</pre>';	