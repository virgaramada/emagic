<?php
final class UserRoleEnum {
	const SUPERUSER   = "SUP"; // super user
    const GAS_STATION_OWNER    = "OWN"; // gas station owner	
    const PERTAMINA     = "PTM"; // gas station monitor
    const BPH_MIGAS = "BPH"; // gas station dist monitor
    const DEPOT = "DEP"; // depot
    const GAS_STATION_OPERATOR = "OPE"; // gas station operator
    const GAS_STATION_ADMINISTRATOR = "ADM"; // gas station admin	
    const GAS_STATION_USER = "USE"; // gas station user == operator
    const POWER_USER = "PUS"; // power user
    
    private function __construct(){}
    
   public static function values() {
            return array(
                         GAS_STATION_OPERATOR => "OPE",
                         GAS_STATION_ADMINISTRATOR => "ADM",
                         GAS_STATION_USER => "USE");       	
    }
    public static function names() {
            return array( 
                         "Operator" => "OPE",
                         "Admin SPBU" => "ADM",
                         "User Biasa" => "USE");       	
    }
    
    public static function allValues() {
            return array(SUPERUSER => "SUP", 
                         GAS_STATION_OWNER => "OWN", 
                         PERTAMINA => "PTM",
                         BPH_MIGAS => "BPH",
                         DEPOT => "DEP",
                         GAS_STATION_OPERATOR => "OPE",
                         GAS_STATION_ADMINISTRATOR => "ADM",
                         GAS_STATION_USER => "USE",
                         POWER_USER => "PUS");       	
    }
    public static function allNames() {
            return array("Superuser" => "SUP", 
                         "Pemilik SPBU" => "OWN", 
                         "Pertamina" => "PTM",
                         "BPH Migas" => "BPH",
                         "Depot" => "DEP",
                         "Operator" => "OPE",
                         "Admin SPBU" => "ADM",
                         "User Biasa" => "USE",
                         "Admin Aplikasi" => "PUS");       	
   }
   
   public static function allValuesNoSuperuser() {
            return array(GAS_STATION_OWNER => "OWN", 
                         PERTAMINA => "PTM",
                         BPH_MIGAS => "BPH",
                         DEPOT => "DEP",
                         GAS_STATION_OPERATOR => "OPE",
                         GAS_STATION_ADMINISTRATOR => "ADM",
                         GAS_STATION_USER => "USE" /*,
                         POWER_USER => "PUS"*/);       	
    }
    public static function allNamesNoSuperuser() {
            return array("Pemilik SPBU" => "OWN", 
                         "Pertamina" => "PTM",
                         "BPH Migas" => "BPH",
                         "Depot" => "DEP",
                         "Operator" => "OPE",
                         "Admin SPBU" => "ADM",
                         "User Biasa" => "USE"/*,
                         "Admin Aplikasi" => "PUS"*/);       	
   }
   
   
}
?>
