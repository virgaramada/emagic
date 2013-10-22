<?php
require_once 'classes/TemplateEngine.class.php';

//define("IS_DEBUG", false);
//define("IS_CACHING", false);

$tpl_engine = TemplateEngine::getEngine();
		//$tpl_engine->caching = IS_CACHING;
		//$tpl_engine->debugging = IS_DEBUG;
		$tpl_engine->assign("inv_type","PRM");
		$tpl_engine->assign("station_id","32.345678");
		$tpl_engine->display('station_key_test.tpl');
?>