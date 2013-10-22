{include file="header.tpl"}
<table  border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
    
    <td>
      <table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
           <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
                 <tr>
			        <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			     </tr>
			     <tr>
			        <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			     </tr>
             {if !empty($messages)}
			     {foreach from=$messages key=k item=v}
			     <tr>
			       <td colspan="2" class="messages">{$v}</td>
			     </tr>
			     {/foreach}
			      
			{/if}
			     <tr>
			        <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			     </tr>
			     <tr>
			        <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			     </tr>
			</table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
{include file="footer.tpl"}
