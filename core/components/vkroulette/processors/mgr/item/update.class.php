<?php
/**
 * Update an Item
 */
class vkrouletteItemUpdateProcessor extends modObjectUpdateProcessor {
	public $objectType = 'vkrouletteItem';
	public $classKey = 'vkrouletteItem';
	public $languageTopics = array('vkroulette');
	public $permission = 'update_document';
}

return 'vkrouletteItemUpdateProcessor';