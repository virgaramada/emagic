<?php
require_once 'libs/Smarty-2.6.26/Smarty.class.php';

class TemplateEngine {

	public static function getEngine($engine_type='smarty') {
		$engine = NULL;
		switch ($engine_type) {
			case "smarty":
				$engine = new Smarty();
				$engine->caching = 0;
	            $engine->debugging = false;
				break;
			case "savant":
				// TODO integrate savant template engine
				break;					
		}
        return $engine;

	}
}
?>
