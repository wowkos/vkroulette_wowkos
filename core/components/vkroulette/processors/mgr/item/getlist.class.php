<?php
/**
 * Get a list of Items
 */
class vkrouletteItemGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'vkrouletteItem';
	public $classKey = 'vkrouletteItem';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'DESC';
	public $renderers = '';


	/**
	 * @param xPDOQuery $c
	 *
	 * @return xPDOQuery
	 */
	public function prepareQueryBeforeCount(xPDOQuery $c) {
		return $c;
	}


	/**
	 * @param xPDOObject $object
	 *
	 * @return array
	 */
	public function prepareRow(xPDOObject $object) {
		$array = $object->toArray();

		return $array;
	}

}

return 'vkrouletteItemGetListProcessor';