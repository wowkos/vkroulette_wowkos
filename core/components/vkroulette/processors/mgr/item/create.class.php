<?php
/**
 * Create an Item
 */
class vkrouletteItemCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'vkrouletteItem';
	public $classKey = 'vkrouletteItem';
	public $languageTopics = array('vkroulette');
	public $permission = 'new_document';


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$alreadyExists = $this->modx->getObject('vkrouletteItem', array(
			'name' => $this->getProperty('name'),
		));
		if ($alreadyExists) {
			$this->modx->error->addField('name', $this->modx->lexicon('vkroulette_item_err_ae'));
		}

		return !$this->hasErrors();
	}

}

return 'vkrouletteItemCreateProcessor';