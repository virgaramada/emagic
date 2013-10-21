{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
	 <form name="inventory_margin_form" method="post" action="InventoryMarginAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
         
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>{if !empty($inventoryMargin)} Ubah {else} Tambah {/if} Margin</td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              
              {if !empty($inventoryMargin)}
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="inv_id" value="{$inventoryMargin->getInvId()}"/>
               {else}
               <input type="hidden" name="method" value="create"/>
               {/if}
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis Bahan Bakar</td>
                  <td><select name="inventory_type">
                 {if !empty($inv_types)}
                     {section name=c loop=$inv_types}
                     {if !empty($inventoryMargin)}
                     <option value="{$inv_types[c]->getInvType()}" {if $inventoryMargin->getInvType() == $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {else}
                     <option value="{$inv_types[c]->getInvType()}" {if $smarty.post.inventory_type == $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {/if}
                     {/section}
                  {/if}
                  </select></td>
                </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Margin</td>
                  <td>
                  {if !empty($inventoryMargin)}
                  <input type="text" name="margin_value" value="{$inventoryMargin->getMarginValue()}"/>
                  {else}
                    <input type="text" name="margin_value" value="{$smarty.post.margin_value}"/>
                  {/if} %</td>
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
      {include file="inventory_margin_list.tpl"}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
