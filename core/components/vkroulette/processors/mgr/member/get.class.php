<?php
/**
 * Get an Item
 */
class vkrmembersGetProcessor extends modObjectGetProcessor {
	public $objectType = 'vkrmembers';
	public $classKey = 'vkrmembers';
	public $languageTopics = array('vkroulette:default');
}

return 'vkrmembersGetProcessor';