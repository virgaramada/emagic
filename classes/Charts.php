<?php

function encodeDataURL($strDataURL, $addNoCacheStr=false) {
  
    if ($addNoCacheStr==true) {
      
		if (strpos(strDataURL,"?")<>0)
			$strDataURL .= "&FCCurrTime=" . Date("H_i_s");
		else
			$strDataURL .= "?FCCurrTime=" . Date("H_i_s");
    }

	return urlencode($strDataURL);
}

function datePart($mask, $dateTimeStr) {
    @list($datePt, $timePt) = explode(" ", $dateTimeStr);
    $arDatePt = explode("-", $datePt);
    $dataStr = "";
  
    if (count($arDatePt) == 3) {
        list($year, $month, $day) = $arDatePt;
    
        switch ($mask) {
        case "m": return $month;
        case "d": return $day;
        case "y": return $year;
        }
       
        return (trim($month . "/" . $day . "/" . $year));
    }
    return $dataStr;
}

function renderChart($chartSWF, $strURL, $strXML, $chartId, $chartWidth, $chartHeight, $debugMode, $registerWithJS) {

	if ($strXML=="")
        $tempData = "//Set the dataURL of the chart\n\t\tchart_$chartId.setDataURL(\"$strURL\")";
    else
        $tempData = "//Provide entire XML data using dataXML method\n\t\tchart_$chartId.setDataXML(\"$strXML\")";

    $chartIdDiv = $chartId . "Div";
    $ndebugMode = boolToNum($debugMode);
    $nregisterWithJS = boolToNum($registerWithJS);

$render_chart = <<<RENDERCHART

	<!-- START Script Block for Chart $chartId -->
	<div id="$chartIdDiv" align="center">
		Chart.
	</div>
	<script type="text/javascript">	
		//Instantiate the Chart	
		var chart_$chartId = new FusionCharts("$chartSWF", "$chartId", "$chartWidth", "$chartHeight", "$ndebugMode", "$nregisterWithJS");
		$tempData
		chart_$chartId.setTransparent(true);
		//Finally, render the chart.
		chart_$chartId.render("$chartIdDiv");
	</script>	
	<!-- END Script Block for Chart $chartId -->
RENDERCHART;

  return $render_chart;
}

function renderChartHTML($chartSWF, $strURL, $strXML, $chartId, $chartWidth, $chartHeight, $debugMode) {
  
    $strFlashVars = "&chartWidth=" . $chartWidth . "&chartHeight=" . $chartHeight . "&debugMode=" . boolToNum($debugMode);
    if ($strXML=="")
      
        $strFlashVars .= "&dataURL=" . $strURL;
    else
      
        $strFlashVars .= "&dataXML=" . $strXML;

$HTML_chart = <<<HTMLCHART
	<!-- START Code Block for Chart $chartId -->
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="$chartWidth" height="$chartHeight" id="$chartId">
		<param name="allowScriptAccess" value="always" />
		<param name="movie" value="$chartSWF"/>		
		<param name="FlashVars" value="$strFlashVars" />
		<param name="quality" value="high" />
		<embed src="$chartSWF" FlashVars="$strFlashVars" quality="high" width="$chartWidth" height="$chartHeight" name="$chartId" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
	<!-- END Code Block for Chart $chartId -->
HTMLCHART;

  return $HTML_chart;
}

function boolToNum($bVal) {
    return (($bVal==true) ? 1 : 0);
}
?>