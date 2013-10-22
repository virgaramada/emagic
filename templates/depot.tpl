{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
	<form name="depot_form" method="post" action="DepotAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
          
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>{if !empty($depot)} Ubah {else} Tambah {/if} Depot</td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              
              {if !empty($depot)}
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="depot_id" value="{$depot->getDepotId()}"/>
               {else}
               <input type="hidden" name="method" value="create"/>
               {/if}
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Kode Depot</td>
                  <td>
                     {if !empty($depot)}
                    <input type="text" name="depot_code" value="{$depot->getDepotCode()}" onfocus="this.blur();" class="disabled"/>
                    {else}
                    <input type="text" name="depot_code" value="{$smarty.post.depot_code}" />
                     {/if}
                  </td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                 <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Nama Depot</td>
                  <td>
                  {if !empty($depot)}
                  <input type="text" name="depot_name" value="{$depot->getDepotName()}"/>
                  {else}
                    <input type="text" name="depot_name" value="{$smarty.post.depot_name}"/>
                  {/if} </td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat Depot</td>
                  <td>
                  {if !empty($depot)}
                  <textarea rows="1" cols="1" name="depot_address">{$depot->getDepotAddress()}</textarea>
                  {else}
                   <textarea rows="1" cols="1" name="depot_address">{$smarty.post.depot_address}</textarea>
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
             
          </td>
        </tr>
      </table>
	  </form>
      {include file="depot_list.tpl"}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
