{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
	<form name="work_in_capital_form" method="post" action="CashFlowAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>

            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>Cari Cash Flow</td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
                            
              <input type="hidden" name="type" value="SEARCH"/>
              
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal awal</td>
                  <td>{html_select_date start_year='-2' end_year='+2' field_order=DMY prefix=StartDate_}</td>
                </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal akhir</td>
                  <td>{html_select_date start_year='-2' end_year='+2' field_order=DMY prefix=EndDate_}</td>
                </tr>
                <tr>
                  <td colspan="3" align="right">
                    <input type="submit" name="submit" value="Cari" id="submit"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
                </tr>
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
            </table>
                  
          </td>
        </tr>
        
      </table>
	  </form>     
      <table border="0" cellspacing="0" cellpadding="0">
      <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
      </table>
      {if !empty($smarty.post.StartDate_Day)}         
      {include file="cash_flow_list.tpl"}
      {/if}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
