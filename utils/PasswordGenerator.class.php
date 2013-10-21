<?php
	// Configuration definitions, move to config.php
$CONFIG['security']['password_generator'] = array(
	"C" => array('characters' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 'minimum' => 4, 'maximum' => 6),
	"S" => array('characters' => "!@()-_=+?*^&", 'minimum' => 1, 'maximum' => 2),
	"N" => array('characters' => '1234567890', 'minimum' => 2, 'maximum' => 2)
);

class PasswordGenerator {
	public function STEM_GeneratePassword(){
		// Create the meta-password
		$sMetaPassword = "";

		global $CONFIG;
		$ahPasswordGenerator = $CONFIG['security']['password_generator'];
		foreach ($ahPasswordGenerator as $cToken => $ahPasswordSeed) {
		      $sMetaPassword .= str_repeat($cToken, rand($ahPasswordSeed['minimum'], $ahPasswordSeed['maximum']));
		}
		$sMetaPassword = str_shuffle($sMetaPassword);

		// Create the real password
		$arBuffer = array();
		for ($i = 0; $i < strlen($sMetaPassword); $i ++)
		$arBuffer[] = $ahPasswordGenerator[(string)$sMetaPassword[$i]]['characters'][rand(0, strlen($ahPasswordGenerator[$sMetaPassword[$i]]['characters']) - 1)];

		return implode("", $arBuffer);
	}
}
?>