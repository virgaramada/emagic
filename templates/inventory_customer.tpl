{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
    
    <td>
	<form name="inventory_customer_form" method="post" action="InventoryCustomerAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
			<div class="tabulation">
				<span class="active-tabForm ">
				{if !empty($inventoryCustomer)}Ubah{else}Tambah{/if} Tipe Penyaluran
				</span>
			</div>
			<div class="tabbodycolored">
          
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
              
               {if !empty($inventoryCustomer)}
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="cust_id" value="{$inventoryCustomer->getCustId()}"/>
               {else}
               <input type="hidden" name="method" value="create"/>
               {/if}
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Kode</td>
                  <td>
                     {if !empty($inventoryCustomer)}
                        {if ($smarty.session.user_role == 'SUP' || $smarty.session.user_role == 'PUS')}
                          <input type="text" name="customer_type" value="{$inventoryCustomer->getCustomerType()}" onchange="this.value=this.value.toUpperCase();"/>
                        {else}
                          <input type="text" name="customer_type" value="{$inventoryCustomer->getCustomerType()}" onfocus="this.blur();" class="disabled"/>
                        {/if}
                  {else}
                    <input type="text" name="customer_type" value="" onchange="this.value=this.value.toUpperCase();" />
                  {/if}
                  </td>
                  <tr>
                    <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Keterangan</td>
                   <td>
                    {if !empty($inventoryCustomer)}
                  <input type="text" name="customer_desc" value="{$inventoryCustomer->getCustomerDesc()}"/>
                  {else}
                    <input type="text" name="customer_desc" value=""/>
                  {/if}</td>
                </tr>
                <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Kategori</td>
                <td>
                    <select name="category">
                     {if !empty($inventoryCustomer)}
                     <option value="SALES" {if $inventoryCustomer->getCategory() == 'SALES'}selected=selected {/if}>Penjualan</option>
                     <option value="OWN_USE" {if $inventoryCustomer->getCategory() == 'OWN_USE'}selected=selected {/if}>Own Use</option>
                     {* <option value="LOSS" {if $inventoryCustomer->getCategory() == 'LOSS'}selected=selected {/if}>Losses</option> *}
                     {else}
                     <option value="SALES" {if $smarty.post.category == 'SALES'}selected=selected {/if}>Penjualan</option>
                     <option value="OWN_USE" {if $smarty.post.category == 'OWN_USE'}selected=selected {/if}>Own Use</option>
                     {* <option value="LOSS" {if $smarty.post.category == 'LOSS'}selected=selected {/if}>Losses</option> *}
                     {/if}
               </select>
               
                  </td>
                </tr>
                <tr>
                  <td colspan="3" id="submit-button" align="right">
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
      {include file="inventory_customer_list.tpl"}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
