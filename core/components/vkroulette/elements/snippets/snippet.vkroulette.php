<?php
// listing of variables from 'properties.vkroulette.php' to understand phpStorm
/** @var $name1 */
/**	@var $name2 */
/**	@var $name3 */
/**	@var $tplmember */

/** @var array $scriptProperties */
/** @var vkroulette $vkroulette */
$vkroulette = $modx->getService('vkroulette','vkroulette',$modx->getOption('vkroulette_core_path',null,$modx->getOption('core_path').'components/vkroulette/').'model/vkroulette/',$scriptProperties);

/** @var pdoTools $pdoTools */
//$pdoTools = $modx->getService('pdoTools');

if (!($vkroulette instanceof vkroulette)) return '';
//if (!($vkroulette instanceof vkroulette) || !($pdoTools instanceof pdoTools)) return '';


// ----------------------------------

//printf('<br>начальное значение $tplmember - <br>');
//print_r($tplmember);
if (empty($tplmember)) {$tplmember = 'tpl.vkroulette.member';}


if (!$member = $modx->getObject('vkrmembers',"")) {
	return $modx->lexicon('vkroulette_member_err_ns');
}

$placeholders = $member->toArray();
$placeholders['name1'] = $name1;
//$placeholders['message'] = 'here is the text of the message';
$placeholders['description'] = 'description here';
$placeholders['name2'] = 'f***ing name 2';
$placeholders['parameters_token'] = $modx->getOption('vkroulette_groupparam_token');

//$output = !empty($tplmember)
//	? $pdoTools->getChunk($tplmember, $placeholders)
//	: 'Parameter "tplmember" is empty';

//printf('<br>обработанный ПДО тулс $output - <br>');
//print_r($output);
// ----------------------------------

$output = $modx->getChunk($tplmember, $placeholders);

$q = $modx->newQuery('vkrmembers');
//printf('<br>начальный запрос - <br>');
//print_r($q);

$q->limit(1000);
$t=$q->prepare();
//printf('<br>подготовленный запрос - <br>');
//print_r($t);

$q_result=$t->execute();
//printf('<br>выполненный запрос - <br>');
//print_r($q_result);

$q_result = $t->fetchall(PDO::FETCH_ASSOC);
//printf('<br>полученный массив - <br>');
//$vkroulette->pretty_print($q_result,false);

//// а теперь попробуем получить нашу таблицу через "getCollection"
//$view_table = $modx->getCollection('vkrmembers');		// ограничить например в 20 строк тут нельзя
//foreach ($view_table as $res) {
//	$output .= '<h2>'.$res->get('uid').'</h2>';
//	$output .= '<p>'.$res->get('first_name').'</p>';
//	$output .= '<p><small>Дата: '.$res->get('link').'</small></p>';
//}

// выполним заполнение базы
$fill_res = array();
$vkroulette->fillmembers($fill_res);
$vkroulette->pretty_print($fill_res,false);

/* by default just return output */
return '';