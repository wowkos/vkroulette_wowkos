<?php
//echo 'Hello world';die;
/**
 * Class vkrouletteMainController
 */
abstract class vkrouletteMainController extends modExtraManagerController {
	/** @var vkroulette $vkroulette */
	public $vkroulette;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('vkroulette_core_path', null, $this->modx->getOption('core_path') . 'components/vkroulette/');
		require_once $corePath . 'model/vkroulette/vkroulette.class.php';

		$this->vkroulette = new vkroulette($this->modx);

		$this->addCss($this->vkroulette->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->vkroulette->config['jsUrl'] . 'mgr/vkroulette.js');
		$this->addHtml('<script type="text/javascript">
		Ext.onReady(function() {
			vkroulette.config = ' . $this->modx->toJSON($this->vkroulette->config) . ';
			vkroulette.config.connector_url = "' . $this->vkroulette->config['connectorUrl'] . '";
		});
		</script>');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('vkroulette:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends vkrouletteMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}