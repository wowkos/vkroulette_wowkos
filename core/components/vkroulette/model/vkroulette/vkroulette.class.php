<?php
/**
 * The base class for vkroulette.
 */

class vkroulette {
	/* @var modX $modx */
	public $modx;
	/* @var vkrouletteControllerRequest $request */
	protected $request;
	public $initialized = array();
	public $chunks = array();


	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('vkroulette_core_path', $config, $this->modx->getOption('core_path') . 'components/vkroulette/');
		$assetsUrl = $this->modx->getOption('vkroulette_assets_url', $config, $this->modx->getOption('assets_url') . 'components/vkroulette/');
		$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/',
			'imagesUrl' => $assetsUrl . 'images/',
			'connectorUrl' => $connectorUrl,

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			'processorsPath' => $corePath . 'processors/'
		), $config);

		$this->modx->addPackage('vkroulette', $this->config['modelPath']);
		$this->modx->lexicon->load('vkroulette:default');
	}


//	/**
//	 * Initializes vkroulette into different contexts.
//	 *
//	 * @access public
//	 *
//	 * @param string $ctx The context to load. Defaults to web.
//	 */
//	public function initialize($ctx = 'web') {
//		switch ($ctx) {
//			case 'mgr':
//				if (!$this->modx->loadClass('vkroulette.request.vkrouletteControllerRequest', $this->config['modelPath'], true, true)) {
//					return 'Could not load controller request handler.';
//				}
//				$this->request = new vkrouletteControllerRequest($this);
//
//				return $this->request->handleRequest();
//				break;
//			case 'web':
//
//				break;
//			default:
//				/* if you wanted to do any generic frontend stuff here.
//				 * For example, if you have a lot of snippets but common code
//				 * in them all at the beginning, you could put it here and just
//				 * call $vkroulette->initialize($modx->context->get('key'));
//				 * which would run this.
//				 */
//				break;
//		}
//		return true;
//	}
//
//
//	/**
//	 * Gets a Chunk and caches it; also falls back to file-based templates
//	 * for easier debugging.
//	 *
//	 * @access public
//	 *
//	 * @param string $name The name of the Chunk
//	 * @param array $properties The properties for the Chunk
//	 *
//	 * @return string The processed content of the Chunk
//	 */
//	public function getChunk($name, array $properties = array()) {
//		$chunk = null;
//		if (!isset($this->chunks[$name])) {
//			$chunk = $this->modx->getObject('modChunk', array('name' => $name), true);
//			if (empty($chunk)) {
//				$chunk = $this->_getTplChunk($name, $this->config['chunkSuffix']);
//				if ($chunk == false) {
//					return false;
//				}
//			}
//			$this->chunks[$name] = $chunk->getContent();
//		}
//		else {
//			$o = $this->chunks[$name];
//			$chunk = $this->modx->newObject('modChunk');
//			$chunk->setContent($o);
//		}
//		$chunk->setCacheable(false);
//
//		return $chunk->process($properties);
//	}
//
//
//	/**
//	 * Returns a modChunk object from a template file.
//	 *
//	 * @access private
//	 *
//	 * @param string $name The name of the Chunk. Will parse to name.chunk.tpl by default.
//	 * @param string $suffix The suffix to add to the chunk filename.
//	 *
//	 * @return modChunk/boolean Returns the modChunk object if found, otherwise
//	 * false.
//	 */
//	private function _getTplChunk($name, $suffix = '.chunk.tpl') {
//		$chunk = false;
//		$f = $this->config['chunksPath'] . strtolower($name) . $suffix;
//		if (file_exists($f)) {
//			$o = file_get_contents($f);
//			$chunk = $this->modx->newObject('modChunk');
//			$chunk->set('name', $name);
//			$chunk->setContent($o);
//		}
//
//		return $chunk;
//	}

	/**
	 * Определяем победителя текущего конкурса:
	 * 1) определяем возможность розыгрыша
	 * 		дата и время начала розыгрыша должны соответствовать
	 * 		в таблице победителей не должно быть текущей даты розыгрыша - "vkroulette_winners"
	 * 2) считываем таблицу участников текущего конкурса - "vkroulette_members"
	 * 		(она содержит только текущих участников, т.к. после определения победителя очищается)
	 * 3) формируем общее пространство диапазонов шансов на победу
	 *		+ 20% каждому участнику, сделавшему новый репост записи текущего розыгрыша
	 * 		(колич участников * 100%) + (колич участников * количество бонусов)
	 * 4) получаем случайное число из нашего пространства на победу
	 * 5) выявляем нашего победителя из общего пространства
	 * 		??? ??? ??? НУЖНО ЛИ СОРТИРОВАТЬ ТАБЛИЦУ ??? ??? ???
	 * 		последовательно увеличиваем диапазон, пока не достигнем нашего победного значения
	 * 		на ком остановились, тот и победитель
	 * 6) добавляем нового победителя в таблицу победителей - "vkroulette_winners"
	 * 7) очищаем таблицу текущих участников - "vkroulette_members"
	 *
	 * @return bool
	 */
	function findwinner(){
		return true;
	}

	/**
	 * Заполнение таблицы участников текущего конкурса:
	 * 1) определяем возможность заполнения
	 *        если это день розыгрыша победителя, то формирование таблицы должно ограничиваться по времени
	 *        после розыгрыша начальное заполнение таблицы будет определено следующим днём
	 * 2) определяем текущих участников розыгрыша:
	 *        - считываем всех участников текущей группы
	 *        - считываем список людей, сделавших репост нашей записи
	 *        - считываем список людей, сделавших НОВЫЙ репост нашей записи в текущем розыгрыше
	 * 3) формируем конечную таблицу/массив для записи в таблицу
	 *        -
	 * 4) заполняем таблицу "vkroulette_members":
	 *        ??? ??? ??? наверно не имеет смысла заморачиваться и динамически добавлять/удалять людей ??? ??? ???
	 *        ??? ??? ??? просто очистил таблицу и заново её заполнил, отсортировав участников по uid ??? ??? ???
	 *        - очищаем текущую таблицу - "vkroulette_members"
	 *        - сортируем таблицу участников по uid
	 *        - формируем mySQL запрос
	 *            ??? ??? ??? есть ли ограничения на количество одновременно добавляемых строк ??? ??? ???
	 *            - разбиваем запрос на несколько этапов по Х штук (например 100)
	 *        - исполняем запрос на добавление участников
	 *
	 * @param $fill_res
	 *
	 * @return bool
	 */
	function fillmembers(&$fill_res){
		// 1) проверка можно ли запускать функцию
		//if count($vkconf) < 3 return false;

		// 2) определяем текущих участников розыгрыша
			// подготавливаем переменные
		$group_id = $this->modx->getOption('vkroulette_groupparam_id');			// 155335527
		//$post_id = $this->modx->getOption('vkroulette_groupparam_post_id');		// 1
		$post_id = 1;
		$alias = $this->modx->uri;
		$alias = $alias["alias"];
		$site_url = $_SERVER['SERVER_NAME'];
		$total = 0;
		$vk_config = array(
			'group_id' 		=> $group_id,				// 155335527
			'post_id'		=> $post_id,				// 1
			'app_id'        => $this->modx->getOption('vkroulette_groupparam_app_id'),			// 6226105
			'api_secret'    => $this->modx->getOption('vkroulette_groupparam_secret_key'),		// 8UuENGyjxrenGWIVBQRj
			'access_token' 	=> $this->modx->getOption('vkroulette_groupparam_token'),			// be9809dd91736d97ae63f7d2d5e98b0c04ff48a250cdd93f1ebb0c059898a8156c0211dfc9580ca8c83fd
			'callback_url'  => 'http://'.$site_url.'/'.$alias,
			'fields' 		=> 'photo_200,members_count',											// поля для получения инфы о группе
			'owner_id' 		=> '-'.$group_id,
			'offset' 		=> 0,
			'v' 			=> '5.27',
		);
		ini_set('default_charset', 'utf-8');
		error_reporting(E_ALL);

			// подключаем файлы работы с api vk

		require_once $this->modx->getOption('base_path') . '/vkroulette/_build/includes/VK.php';
		require_once $this->modx->getOption('base_path') . '/vkroulette/_build/includes/VKException.php';

		$vk = new VK\VK($vk_config['app_id'], $vk_config['api_secret'], $vk_config['access_token']);

			// получаем информацию о группе
		$info_group = $vk->api('groups.getById', $vk_config);
		if ($info_group['response']) { // проверка на успешный запрос
//			print_r('<img src="' . $info_group['response'][0]['photo_200'] . '">'); // вывод информации
//			print_r('<p> Всего участников в группе: '. $info_group['response'][0]['members_count'].'</p>');
			$total = $info_group['response'][0]['members_count'];
		}

			// получаем список всех участников группы
		$membersGroups = array();
		$this->getMembers25k($group_id, $membersGroups, $total, $vk);

			// получаем список людей, сделавших репость записи
		$users_repost = $vk->api('wall.getReposts', $vk_config);
		$users_repost = $users_repost['response']['profiles'];

			// выведем оба списка для визуального сравнения массивов
		$this->pretty_print($membersGroups,false);
		$this->pretty_print($users_repost,false);

			// выводим список людей сделавших репост и состоящих в группе
		//print_r($users_repost);
		//array($new_array);
		//echo "<ul> Сделало репост:";
		foreach ($users_repost as $rep_user)
		{
			$in_group = "нет";

			if (in_array($rep_user['uid'],$membersGroups)){
				$in_group = "да";
				$fill_res[] = $rep_user;
			}
			else
				continue;   // не выводим, если не состоит в группе
			//echo "<tr><td>$rep_user[first_name] $rep_user[last_name]</td><td>$in_group</td>></tr>";
		}
		//echo "</ul>";

		//$users_repost_ids = array();
		//foreach($users_repost as $user_vk){
		//    $users_repost_ids[] = $user_vk['uid'];
		//}
		//print_r($users_repost_ids);

		//print_r($membersGroups);
		//$membersGroups = array_intersect($membersGroups, $users_repost_ids);
		//print_r($membersGroups);
		//return str_replace("[+members_count+]", $info_group, $modx->getChunk($outerTpl));

// определяем случайного члена группы
		$win_id = mt_rand(0,count($fill_res)-1);
		//print_r($new_array[$win_id]);
		print_r ('Наш победитель:<p><h3><a href="https://vk.com/'.$fill_res[$win_id]['screen_name'].'">'.$fill_res[$win_id]['first_name'].' '.$fill_res[$win_id]['last_name'].'</a></h3></p>');
	}

	/**
	 * Функция считывает подписчиков группы и записывает их в массив $membersGroups
	 *
	 * @param $group_id - ID сообщества
	 * @param $membersGroups - получаемый массив участников
	 * @param $len - количество участников сообщества
	 * @param $vk - объект для работы с api vk
	 *
	 * @return void
	 */
	function getMembers25k ($group_id, &$membersGroups, $len, $vk) {

		$code =  'var members = API.groups.getMembers({"group_id": ' . $group_id . ', "v": "5.27", "sort": "id_asc", "count": "1000", "offset": ' . count($membersGroups) . '}).items;' // делаем первый запрос и создаем массив
			.	'var offset = 1000;' // это сдвиг по участникам группы
			.	'while (offset < 25000 && (offset + ' . count($membersGroups) . ') < ' . $len . ')' // пока не получили 20000 и не прошлись по всем участникам
			.	'{'
			.	'members = members + "," + API.groups.getMembers({"group_id": ' . $group_id . ', "v": "5.27", "sort": "id_asc", "count": "1000", "offset": (' . count($membersGroups) . ' + offset)}).items;' // сдвиг участников на offset + мощность массива
			.	'offset = offset + 1000;' // увеличиваем сдвиг на 1000
			.	'};'
			.	'return members;';
		//print_r($code); die("asdasdasdasd");
		$data = $vk->api("execute", array('code' => $code));
		if ($data['response']) {
			// print_r($data); die("123123132");
			// $membersGroups = $membersGroups.concat(JSON.parse("[" + data.response + "]")); // запишем это в массив
			//$array = explode(',', $data['response']);
			// print_r($data['response']); die();
			//  $membersGroups = array_merge($membersGroups, $array); // запишем это в массив
			$membersGroups = array_merge($membersGroups, $data['response']);
			// print_r($membersGroups);
//                $('.member_ids').html('Загрузка: ' + membersGroups.length + '/' + members_count);
			if ($len >  count($membersGroups)) {// если еще не всех участников получили
				sleep(rand(0, 1));
				$this->getMembers25k($group_id, $membersGroups, $len, $vk); // задержка [0,1]  с. после чего запустим еще раз
			}
			else { // если конец то
				// print_r("Готово");
				//print_r($membersGroups);

				$user = $vk->api('users.get', array( // вызов запроса на информацию о сообществе и получения количества участников и фотографии 200х200 px
					// 'user_ids' => $membersGroups[0],
					'fields' => 'nickname,crop_photo,photo_50, photo_100, photo_200_orig, photo_200, photo_400_orig, photo_max, photo_max_orig, sex'
				));
				// print_r( $user);
			}
		} else {
			// print_r($data); // в случае ошибки выведем её
		}

	}

	/**
	 * Выводит массив в виде дерева
	 *
	 * @param mixed $in - Массив или объект, который надо обойти
	 * @param boolean $opened - Раскрыть дерево элементов по-умолчанию или нет?
	 *
	 * @return void
	 */
	function pretty_print($in,$opened = true){
		if($opened)
			$opened = ' open';
		if(is_object($in) or is_array($in)){
			echo '<div>';
			echo '<details'.$opened.'>';
			echo '<summary>';
			echo (is_object($in)) ? 'Object {'.count((array)$in).'}':'Array ['.count($in).']';
			echo '</summary>';
			$this->pretty_print_rec($in, $opened);
			echo '</details>';
			echo '</div>';
		}
	}
	function pretty_print_rec($in, $opened, $margin = 10){
		if(!is_object($in) && !is_array($in))
			return;

		foreach($in as $key => $value){
			if(is_object($value) or is_array($value)){
				echo '<details style="margin-left:'.$margin.'px" '.$opened.'>';
				echo '<summary>';
				echo (is_object($value)) ? $key.' {'.count((array)$value).'}':$key.' ['.count($value).']';
				echo '</summary>';
				$this->pretty_print_rec($value, $opened, $margin+10);
				echo '</details>';
			}
			else{
				switch(gettype($value)){
					case 'string':
						$bgc = 'red';
						break;
					case 'integer':
						$bgc = 'green';
						break;
				}
				echo '<div style="margin-left:'.$margin.'px">'.$key . ' : <span style="color:'.$bgc.'">' . $value .'</span> ('.gettype($value).')</div>';
			}
		}
	}
}