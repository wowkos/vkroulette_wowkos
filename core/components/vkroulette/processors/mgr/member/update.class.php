<?php
/**
 * Update an Item
 */
class vkrmembersUpdateProcessor extends modObjectUpdateProcessor {
	public $objectType = 'vkrmembers';
	public $classKey = 'vkrmembers';
	public $languageTopics = array('vkroulette');
	public $permission = 'update_document';
}

return 'vkrmembersUpdateProcessor';