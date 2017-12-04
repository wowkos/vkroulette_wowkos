<?php
/**
 * Remove an Item
 */
class vkrmembersRemoveProcessor extends modObjectRemoveProcessor {
	public $checkRemovePermission = true;
	public $objectType = 'vkrmembers';
	public $classKey = 'vkrmembers';
	public $languageTopics = array('vkroulette');

}

return 'vkrmembersRemoveProcessor';