{include file="header.tpl"}

<table  border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
     {if ($smarty.session.user_role == 'SUP' || $smarty.session.user_role == 'PUS')}
	<form name="inventory_type_form" method="post" action='InventoryTypeAction.php{php} echo ("?".strip_tags(SID));{/php}'>
      <table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
          <div class="tabulation">
				<span class="active-tabForm ">
				{if !empty($inventoryType)} Ubah {else} Tambah {/if} Inventory
				</span>
			</div>
			<div class="tabbodycolored">
          <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            
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
                           <input type="text" name="inventory_type" value="{$inventoryType->getInvType()}" onchange="this.value=this.value.toUpperCase();"/>                       
                    {else}
                       <input type="text" name="inventory_type" value="" onchange="this.value=this.value.toUpperCase();"/>
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
                    <input type="submit" name="submit" value="Proses" id="submit" class="button"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
                </tr>
                <tr>
                <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
             
            </table>
            </div>
			<div class="tabbtmcolored"></div>
          </td>
        </tr>
      </table>
	  </form>
	   {/if}
      {include file="inventory_type_list.tpl"}
    </td>
  </tr>
</table>

{include file="footer.tpl"}
