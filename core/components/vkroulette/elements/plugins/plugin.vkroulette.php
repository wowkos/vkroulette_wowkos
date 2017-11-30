<?php

switch ($modx->event->name) {

	case 'OnManagerPageInit':
		$cssFile = MODX_ASSETS_URL.'components/vkroulette/css/mgr/main.css';
		$modx->regClientCSS($cssFile);
		break;

}