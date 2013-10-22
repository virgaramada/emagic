{include file="header.tpl"}

<table  border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
	<form name="inventory_type_form" method="post" action='InventoryTypeAction.php{php} echo ("?".strip_tags(SID));{/php}'>
      <table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
          
          <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr><td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="2" class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>{if !empty($inventoryType)} Ubah {else} Tambah {/if} Inventory</td>
              </tr>
              <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
              
               {if !empty($inventoryType)}
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="inv_id" value="{$inventoryType->getInvId()}"/>
               {else}
               <input type="hidden" name="method" value="create"/>
               {/if}
                <tr>
                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Kode</td>
                  <td>
                     {if !empty($inventoryType)}
                        {if ($smarty.session.user_role == 'SUP' || $smarty.session.user_role == 'PUS')}
                           <input type="text" name="inventory_type" value="{$inventoryType->getInvType()}" onchange="this.value=this.value.toUpperCase();"/>
                        {else} 
                           <input type="text" name="inventory_type" value="{$inventoryType->getInvType()}" onfocus="this.blur();" class="disabled"/>
                        {/if}
                    {else}
                       <input type="text" name="inventory_type" value="{$smarty.post.inventory_type}" onchange="this.value=this.value.toUpperCase();"/>
                    {/if}
                  </td>
                  </tr>
                  <tr>
	                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Nama</td>
	                  <td>
	                    {if !empty($inventoryType)}
	                  <input type="text" name="inventory_desc" value="{$inventoryType->getInvDesc()}"/>
	                  {else}
	                    <input type="text" name="inventory_desc" value="{$smarty.post.inventory_desc}"/>
	                  {/if}
	                  </td>
                  </tr>
                  <tr>
                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
                  <td>
                  {if !empty($inventoryType)}
                     <input type="radio" id="productType_BBM" name="product_type" value="BBM" {if $inventoryType->getProductType() == 'BBM'}checked=checked {/if}/>BBM
                     <input type="radio" id="productType_LUB" name="product_type" value="LUB" {if $inventoryType->getProductType() == 'LUB'}checked=checked {/if}/> Pelumas
                  {else}
                     <input type="radio" id="productType_BBM" name="product_type" value="BBM" {if $smarty.post.product_type == 'BBM'}checked=checked {/if}/>BBM
                     <input type="radio" id="productType_LUB" name="product_type" value="LUB" {if $smarty.post.product_type == 'LUB'}checked=checked {/if}/>Pelumas
                  {/if}
                    </td>
                </tr>

                <tr>
                  <td colspan="2" align="right">
                    <input type="submit" name="submit" value="Proses" id="submit"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
                </tr>
                <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
             
            </table>
             
          </td>
        </tr>
      </table>
	  </form>
      {include file="inventory_type_list.tpl"}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
