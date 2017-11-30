<?php
/**
 * Remove an Item
 */
class vkrouletteItemRemoveProcessor extends modObjectRemoveProcessor {
	public $checkRemovePermission = true;
	public $objectType = 'vkrouletteItem';
	public $classKey = 'vkrouletteItem';
	public $languageTopics = array('vkroulette');

}

return 'vkrouletteItemRemoveProcessor';