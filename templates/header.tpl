<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>E-MAGIC</title>
 <meta http-equiv="pragma" content="no-cache"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>

<link href="./css/menu.css" media="all" rel="stylesheet" type="text/css" />
<link href="./css/styles.css" media="all" rel="stylesheet" type="text/css" />
<link href="./css/datepicker/datepicker.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript">
   {php} $scriptName = explode('/', $_SERVER["SCRIPT_NAME"]);{/php}
   var contextPath = '{php} echo ("/". $scriptName[1]); {/php}';
</script>
<script type="text/javascript" src="./js/prototype.js"></script>
<script type="text/javascript" src="./js/scriptaculous.js?load=builder,effects,dragdrop,controls,slider"></script>
<script type="text/javascript" src="./js/tools.js"></script>
<script type="text/javascript" src="./js/datepicker.js">{ldelim}"describedby":"fd-dp-aria-describedby"{rdelim}</script>
{if (!empty($smarty.session.user_role))}
  <script type="text/javascript" src="./js/ypSlideOutMenusC.js"></script>
  <script type="text/javascript" src="./js/fabtabulous.js"></script>
  <script type="text/javascript" src="./js/tablekit.js"></script>
  <script type="text/javascript" src="./js/fastinit.js"></script>
  <script type="text/javascript" src="./js/tablekit-loader.js"></script>
		
  
{/if}
</head>
<body>
{php}echo ("<div id=\"container\">");{/php}
{include file="banner.tpl"}
{if (!empty($smarty.session.user_role))}
    {include file="horizontal_menu.tpl"}
{/if}
<br/>
{php}echo ("<div id=\"body_container\">");{/php}
  
