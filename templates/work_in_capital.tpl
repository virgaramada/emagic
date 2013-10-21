{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
          <form name="wic_form" method="post" action="WorkInCapitalAction.php{php} echo ("?".strip_tags(SID));{/php}">
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" class="title"><img src="images/dot.gif" border="0" height="1" width="8"/>{if !empty($workInCapital)} Ubah {/if} Modal Awal</td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              
              {if !empty($workInCapital)}
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="id" value="{$workInCapital->getId()}"/>
              <input type="hidden" name="c_code" value="{$workInCapital->getCode()}"/>
               {else}
               <input type="hidden" name="method" value="create"/>
               <input type="hidden" name="c_code" value="C_INIT"/>
               {/if}
                
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
                  <td><i>Rp</i>
                  {if !empty($workInCapital)}
                  <input type="text" name="c_value" value="{$workInCapital->getValue()}"/>
                  {else}
                    <input type="text" name="c_value" value=""/>
                  {/if} </td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Deskripsi</td>
                  <td><img src="images/dot.gif" border="0" height="1" width="15"/>
                  {if !empty($workInCapital)}
                  <input type="text" name="c_desc" value="{$workInCapital->getDesc()}"/>
                  {else}
                    <input type="text" name="c_desc" value=""/>
                  {/if}</td>
                </tr>
                <tr>
                  <td colspan="3" align="right">
                    <input type="submit" name="submit" value="Proses" id="submit"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
                </tr>
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
              
            </table>
            </form>
          </td>
        </tr>
      </table>
      {include file="work_in_capital_list.tpl"}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
