<?php
require_once 'libs/smarty-2.6.26/Smarty.class.php';

class TemplateEngine {

	public function getEngine($engine_type='smarty') {
		$engine = NULL;
		switch ($engine_type) {
			case "smarty":
				$engine = new Smarty();
				$engine->caching = false;
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