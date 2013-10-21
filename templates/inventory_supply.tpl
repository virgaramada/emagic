{include file="header.tpl"}

<table  border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
    <td>
	 <form name="inventory_supply_form" method="post" action="InventorySupplyAction.php{php} echo ("?".strip_tags(SID));{/php}">
	  <input type="hidden" name="niap_number" value="00000" />
      <table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
			<div class="tabulation">
				<span class="active-tabForm ">
				{if !empty($inventorySupply)} Ubah {else} Tambah {/if} Suplai <font id="supply_inv_type" class="title">BBM</font>
				</span>
			</div>
			<div class="tabbodycolored">
         
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
            
               {if !empty($inventorySupply)}
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="inv_id" value="{$inventorySupply->getInvId()}"/>
               {else}
               <input type="hidden" name="method" value="create"/>
               {/if}
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
                  <td>
                    <select name="inventory_type" onchange="displaySupplyUnit();">
                  {if !empty($inv_types)}
                     {section name=c loop=$inv_types}
                     {if !empty($inventorySupply)}
                     <option value="{$inv_types[c]->getInvType()}" {if $inventorySupply->getInvType() == $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {else}
                     <option value="{$inv_types[c]->getInvType()}" {if $smarty.post.inventory_type == $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {/if}
                     {/section}
                  {/if}
               </select></td>
               </tr>
               {*
				<tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Tanki</td>
                  <td>
                    <select name="inventory_type" onchange="displaySupplyUnit();">
   					<!-- if bbm=premium select tanki where bbm.tanki=premium and spbu=user -->
                     <option value="1">Tanki 1</option>
                     <option value="2">Tanki 2</option>

               </select></td>
               </tr>
               *}     
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
                  <td>
                    {if !empty($inventorySupply)}
                  <input type="text" name="supply_value" value="{$inventorySupply->getSupplyValue()}" />
                  {else}
                   <input type="text" name="supply_value" value="{$smarty.post.supply_value}" />
                  {/if} <font id="inv_unit">Liter</font></td>
                </tr>
                {*
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah Terima Riil</td>
                  <td>
                    {if !empty($inventorySupply)}
                  <input type="text" name="supply_value" value="{$inventorySupply->getSupplyValue()}" />
                  {else}
                   <input type="text" name="supply_value" value="{$smarty.post.supply_value}" />
                  {/if} <font id="inv_unit">Liter</font></td>
                </tr>
                *}
                <tr>
                 <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal suplai </td>
                 <td>{html_select_date start_year='-2' end_year='+2' field_order=DMY}</td>
                </tr>
                {*
                {if !empty($inventorySupply)}
                	<script type="text/javascript">
		             recalculateDate('Date_', document.inventory_supply_form, '{$inventorySupply->getSupplyDate()}');
		          </script>
		        {/if}
		        <tr>
		        	<td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jam Kedatangan</td>
		        	<td><input type='text' name='jam_kedatangan' id='jam_kedatangan'></td>
		        </tr>
		        
		        <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Shift</td>
                  <td>
                    <select name="inventory_type" onchange="displaySupplyUnit();">
   					<!-- if bbm=premium select tanki where bbm.tanki=premium and spbu=user -->
                     <option value="1">Shift 1</option>
                     <option value="2">Shift 2</option>
					 <option value="3">Shift 3</option>
               </select></td>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>NIAP</td>
                  <td>
                    {if !empty($inventorySupply)}
                  <input type="text" name="niap_number" value="{$inventorySupply->getNiapNumber()}" />
                  {else}
                   <input type="text" name="niap_number" value="{$smarty.post.niap_number}" />
                  {/if}
                  </td>
                </tr>
               
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Nama Supir</td>
                  <td>
                    {if !empty($inventorySupply)}
                  <input type="text" name="nama_supir" value="{$inventorySupply->getNiapNumber()}" />
                  {else}
                   <input type="text" name="nama_supir" value="{$smarty.post.niap_number}" />
                  {/if}
                  </td>
                </tr>
                 *}
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. Polisi</td>
                  <td>
                    {if !empty($inventorySupply)}
                  <input type="text" name="plate_number" value="{$inventorySupply->getPlateNumber()}" onchange="this.value=this.value.toUpperCase();"/>
                  {else}
                   <input type="text" name="plate_number" value="{$smarty.post.plate_number}" onchange="this.value=this.value.toUpperCase();"/>
                  {/if}
                  </td>
                </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. Delivery Order (DO)</td>
                  <td>
                    {if !empty($inventorySupply)}
                  <input type="text" name="delivery_order_number" value="{$inventorySupply->getDeliveryOrderNumber()}" />
                  {else}
                    <input type="text" name="delivery_order_number" value="{$smarty.post.delivery_order_number}" />
                  {/if}
                  </td>
                </tr>
                <tr>
                  <td colspan="3" align="right">
                    <input type="submit" name="submit" value="Proses" id="submit" class="button"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
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
      {include file="inventory_supply_list.tpl"}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
