<?php

$properties = array();

$tmp = array(
	'tplmember' => array(
		'type' => 'textfield',
		'value' => 'tpl.vkroulette.member',
	),
	'id' => array(
		'type' => 'numberfield',
		'value' => '',
	),
	'name1' => array(
		'type' => 'textfield',
		'value' => 'property -name-1-',
	),
	'name2' => array(
		'type' => 'textfield',
		'value' => 'property -name-2-',
	),
	'message' => array(
		'type' => 'textfield',
		'value' => 'initial form of message',
	),
	'description' => array(
		'type' => 'textfield',
		'value' => "and description here",
	),
	'toPlaceholder' => array(
		'type' => 'combo-boolean',
		'value' => false,
	),
);

foreach ($tmp as $k => $v) {
	$properties[] = array_merge(
		array(
			'name' => $k,
			'desc' => PKG_NAME_LOWER . '_prop_' . $k,
			'lexicon' => PKG_NAME_LOWER . ':properties',
		), $v
	);
}

return $properties;