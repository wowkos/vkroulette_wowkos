<?php
/**
 * Create an Item
 */
class vkrmembersCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'vkrmembers';
	public $classKey = 'vkrmembers';
	public $languageTopics = array('vkroulette');
	public $permission = 'new_document';


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$alreadyExists = $this->modx->getObject('vkrmembers', array(
			'name' => $this->getProperty('name'),
		));
		if ($alreadyExists) {
			$this->modx->error->addField('name', $this->modx->lexicon('vkroulette_item_err_ae'));
		}

		return !$this->hasErrors();
	}

}

return 'vkrmembersCreateProcessor';