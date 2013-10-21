<?php
require_once 'classes/UserManager.class.php';
require_once 'vo/UserRole.class.php';

require_once 'classes/TemplateEngine.class.php';
require_once 'classes/LogManager.class.php';

require_once 'classes/PaginateIt.class.php';
require_once 'classes/UserRoleEnum.class.php';
require_once 'utils/Validate.php';
include("classes/Charts.php");

if (empty ($_REQUEST['PHPSESSID'])) {
	$tpl_engine = TemplateEngine::getEngine();

	$tpl_engine->assign("errors", array ("session_expired" => "Anda harus login terlebih dahulu"));
	$tpl_engine->display('login.tpl');

} else {
	session_id($_REQUEST['PHPSESSID']);
	session_start();
	
}

function findAll($tpl_engine = NULL) {
	$pageNumber = @ $_REQUEST['page'];
	$user_mgr = new UserManager();
	$totalData = (int) $user_mgr->countAllNoSuperuserAndOwner($_SESSION["station_id"]);

	if (empty ($pageNumber)) {
		$pageNumber = 1;
	}
	$itemsPerPage = 10;
	$PaginateIt = new PaginateIt();
	$PaginateIt->SetItemsPerPage($itemsPerPage);
	$PaginateIt->SetItemCount($totalData);
	$PaginateIt->SetCurrentPage($pageNumber);
	$pageIndex = ((int) $pageNumber * $itemsPerPage - $itemsPerPage);
	if ($pageIndex > $totalData) {
		$pageIndex = 0;
	}
	$result = $user_mgr->findAllNoSuperuserAndOwner($pageIndex, $itemsPerPage, $_SESSION["station_id"]);
	if (!empty ($tpl_engine)) {
		$tpl_engine->assign("roles", UserRoleEnum::names());
		$tpl_engine->assign("active_roles", UserRoleEnum::allNames());
		$tpl_engine->assign("paginatedUserList", $PaginateIt->GetPageLinks());
	}
	return $result;
}
?>
<?php
    ///Sample 1
 
   $strXML  = "<chart showValue='1' subcaption='Product in percent' yAxisName='Percentages' showPercentValues='1' pieSliceDepth='30' showBorder='1' decimals='2' yAxisMinValue='0' yAxisMaxValue='100' numberSuffix='%25' labelDisplay='Rotate' slantLabels='1' lowerLimit='0' upperLimit='100' majorTMNumber='7' showTickValues='0' majorTMHeight='8' minorTMNumber='0' showToolTip='0' majorTMThickness='3' gaugeOuterRadius='130' gaugeOriginX='100' gaugeOriginY='170' gaugeStartAngle='125' gaugeScaleAngle='70' placeValuesInside='1' gaugeInnerRadius='115' annRenderDelay='0' pivotFillMix='{000000},{FFFFFF}' pivotFillRatio='50,50' showPivotBorder='1' pivotBorderColor='444444' pivotBorderThickness='2' showShadow='0' pivotRadius='18' pivotFillType='linear' chartTopMargin='100'>";
   
   $strXML .= "<dials>";
   $strXML .= "<dial value='68' borderAlpha='0' bgColor='FF0000' baseWidth='6' topWidth='6' radius='120' valueX='150' valueY='120'/>";
   $strXML .= "</dials>";

   $strXML .="<trendpoints>";
   $strXML .="<point value='0' displayValue='E' alpha='0'/>";
   $strXML .="<point value='100' displayValue='F' alpha='0'/>";
   $strXML .="</trendpoints>";

   $strXML .="<annotations>";
   $strXML .="<annotationGroup xPos='100' yPos='170'>";
   $strXML .="<annotation type='arc' xPos='0' yPos='0' radius='145' innerRadius='132' startAngle='53' endAngle='127' showBorder='1' borderColor='444444' borderThickness='2'/>";
   $strXML .="<annotation type='arc' xPos='0' yPos='0' radius='145' innerRadius='132' startAngle='53' endAngle='110' showBorder='1' color='ffffff' borderColor='444444' borderThickness='2'/>";
   $strXML .="</annotationGroup>";

   $strXML .="<annotationGroup xPos='90' yPos='60' showBelow='1'>";
   $strXML .="<annotation type='image' xPos='0' yPos='0' url='Resources/Fuel.swf' xScale='50' yScale='50'/>";
   $strXML .="</annotationGroup>";
   $strXML .="</annotations>";

   $strXML .="<styles>";
   $strXML .="<definition>";
   $strXML .="<style name='trendValueFont' type='font' bold='1' size='12'/>";
   $strXML .="<style type='font' name='myValueFont' bgColor='F1f1f1' borderColor='999999'/>";
   $strXML .="</definition>";
   $strXML .="<application>";
   $strXML .="<apply toObject='TRENDVALUES' styles='trendValueFont'/>";
   $strXML .="<apply toObject='Value' styles='myValueFont' />";
   $strXML .="</application>";
   $strXML .="</styles>";
 
   $strXML .= "</chart>";
   $strChart = renderChart("Widgets/AngularGauge.swf", "", $strXML, "stationTank1", 200, 200, false, false);
   
   ///Sample 2
   
   $strXML2  = "<chart showValue='1' subcaption='Product in percent' yAxisName='Percentages' showPercentValues='1' pieSliceDepth='30' showBorder='1' decimals='2' yAxisMinValue='0' yAxisMaxValue='100' numberSuffix='%25' labelDisplay='Rotate' slantLabels='1' lowerLimit='0' upperLimit='100' majorTMNumber='7' showTickValues='0' majorTMHeight='8' minorTMNumber='0' showToolTip='0' majorTMThickness='3' gaugeOuterRadius='130' gaugeOriginX='100' gaugeOriginY='170' gaugeStartAngle='125' gaugeScaleAngle='70' placeValuesInside='1' gaugeInnerRadius='115' annRenderDelay='0' pivotFillMix='{000000},{FFFFFF}' pivotFillRatio='50,50' showPivotBorder='1' pivotBorderColor='444444' pivotBorderThickness='2' showShadow='0' pivotRadius='18' pivotFillType='linear' chartTopMargin='100'>";
  
   $strXML2 .= "<dials>";
   $strXML2 .= "<dial value='80' borderAlpha='0' bgColor='FF0000' baseWidth='6' topWidth='6' radius='120' valueX='150' valueY='120'/>";
   $strXML2 .= "</dials>";

   $strXML2 .="<trendpoints>";
   $strXML2 .="<point value='0' displayValue='E' alpha='0'/>";
   $strXML2 .="<point value='100' displayValue='F' alpha='0'/>";
   $strXML2 .="</trendpoints>";

   $strXML2 .="<annotations>";
   $strXML2 .="<annotationGroup xPos='100' yPos='170'>";
   $strXML2 .="<annotation type='arc' xPos='0' yPos='0' radius='145' innerRadius='132' startAngle='53' endAngle='127' showBorder='1' borderColor='444444' borderThickness='2'/>";
   $strXML2 .="<annotation type='arc' xPos='0' yPos='0' radius='145' innerRadius='132' startAngle='53' endAngle='110' showBorder='1' color='ffffff' borderColor='444444' borderThickness='2'/>";
   $strXML2 .="</annotationGroup>";
   $strXML2 .="<annotationGroup xPos='90' yPos='60' showBelow='1'>";
   $strXML2 .="<annotation type='image' xPos='0' yPos='0' url='Resources/Fuel.swf' xScale='50' yScale='50'/>";
   $strXML2 .="</annotationGroup>";
   $strXML2 .="</annotations>";

   $strXML2 .="<styles>";
   $strXML2 .="<definition>";
   $strXML2 .="<style name='trendValueFont' type='font' bold='1' size='12'/>";
   $strXML2 .="<style type='font' name='myValueFont' bgColor='F1f1f1' borderColor='999999'/>";
   $strXML2 .="</definition>";
   $strXML2 .="<application>";
   $strXML2 .="<apply toObject='TRENDVALUES' styles='trendValueFont'/>";
   $strXML2 .="<apply toObject='Value' styles='myValueFont' />";
   $strXML2 .="</application>";
   $strXML2 .="</styles>";
 
   $strXML2 .= "</chart>";
   $strChart2 = renderChart("Widgets/AngularGauge.swf", "", $strXML2, "stationTank2", 200, 200, false, false);
   
   $tpl_engine = TemplateEngine::getEngine();
   $result = findAll($tpl_engine);
   $tpl_engine->assign("dashboard_tank_1", $strChart);
   $tpl_engine->assign("dashboard_tank_2", $strChart2);
   $tpl_engine->display('dashboard.tpl');
?>