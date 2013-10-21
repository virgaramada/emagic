{include file="header.tpl"}

<table  border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
    
    <td>
	<form name="inventory_price_form" method="post" action="InventoryPriceAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
            <div class="tabulation">
				<span class="active-tabForm ">
				{if !empty($inventoryPrice)} Ubah {else} Tambah{/if} Harga Per Unit
				</span>
			</div>
			<div class="tabbodycolored">
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
           
              
              {if !empty($inventoryPrice)}
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="inv_id" value="{$inventoryPrice->getInvId()}"/>
               {else}
               <input type="hidden" name="method" value="create"/>
               {/if}
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis Bahan Bakar</td>
                  <td><img src="images/dot.gif" border="0" height="1" width="20"/><select name="inventory_type">
                  {if !empty($inv_types)}
                     {section name=c loop=$inv_types}
                     {if !empty($inventoryPrice)}
                     <option value="{$inv_types[c]->getInvType()}" {if $inventoryPrice->getInvType() == $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {else}
                     <option value="{$inv_types[c]->getInvType()}" {if $smarty.post.inventory_type == $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {/if}
                     {/section}
                  {/if}
               </select></td>
               </tr>
                <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Harga Per Unit</td>
                <td><i>Rp {if !empty($inventoryPrice)}
                  <input type="text" name="unit_price" value="{$inventoryPrice->getUnitPrice()}"/>
                  {else}
                    <input type="text" name="unit_price" value="{$smarty.post.unit_price}"/>
                  {/if}</i></td>
                </tr>
                <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Kategori</td>
                <td><img src="images/dot.gif" border="0" height="1" width="15"/>
                  <select name="category">
                     {if !empty($inventoryPrice)}
                     <option value="SALES" {if $inventoryPrice->getCategory() == 'SALES'}selected=selected {/if}>Penjualan</option>
                     <option value="OWN_USE" {if $inventoryPrice->getCategory() == 'OWN_USE'}selected=selected {/if}>Own Use</option>
                     {* <option value="LOSS" {if $inventoryPrice->getCategory() == 'LOSS'}selected=selected {/if}>Losses</option> *}
                     {else}
                     <option value="SALES" {if $smarty.post.category == 'SALES'}selected=selected {/if}>Penjualan</option>
                     <option value="OWN_USE" {if $smarty.post.category == 'OWN_USE'}selected=selected {/if}>Own Use</option>
                     {* <option value="LOSS" {if $smarty.post.category == 'LOSS'}selected=selected {/if}>Losses</option> *}
                     {/if}
               </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="3" align="right">
                    <input type="submit" name="submit" value="Proses" id="submit" class="button"/><img src="images/dot.gif" border="0" height="1" width="10"/>
                  </td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
             
            </table>
			
			</div>
			<div class="tabbtmcolored"></div>
          </td>
        </tr>
         
      </table>
	    </form>
      {include file="inventory_price_list.tpl"}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
