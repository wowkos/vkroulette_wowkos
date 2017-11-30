<?php
/**
 * Get an Item
 */
class vkrouletteItemGetProcessor extends modObjectGetProcessor {
	public $objectType = 'vkrouletteItem';
	public $classKey = 'vkrouletteItem';
	public $languageTopics = array('vkroulette:default');
}

return 'vkrouletteItemGetProcessor';