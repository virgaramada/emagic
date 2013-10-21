{include file="header.tpl"}

<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
	 <form name="inventory_output_form" id="inventory_output_form" method="post" action="InventoryOutputAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
			<div class="tabulation">
			<span class="active-tabForm ">
				{if !empty($inventoryOutput)}
                Ubah
                {else}
                Tambah
                {/if}  {if $smarty.request.productType == 'LUB'} Penyaluran Pelumas {else} Stand meter BBM {/if}
			</span>
			</div>
			<div class="tabbodycolored">
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">

             
              {if !empty($inventoryOutput)}
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="inv_id" value="{$inventoryOutput->getInvId()}"/>
               {else}
               <input type="hidden" name="method" value="create"/>
               {/if}
               <input type="hidden" name="productType" value="{$smarty.request.productType}"/>
                <tr>
                  <th>Jenis</th>
                  <td><select name="inventory_type" onchange="selectOwnUse();getUnitPrice();">
                  {if !empty($inv_types)}
                     {section name=c loop=$inv_types}
                     {if !empty($inventoryOutput)}
                     <option value="{$inv_types[c]->getInvType()}" {if $inventoryOutput->getInvType() == $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {else}
                     <option value="{$inv_types[c]->getInvType()}" {if $smarty.post.inventory_type == $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {/if}
                     {/section}
                  {/if}
               </select></td>
               </tr>
                <tr>
                  <th>Jenis Kendaraan</th>
                  <td> {if !empty($inventoryOutput)}
                     <input type="radio" name="vehicle_type" value="MBL" {if $inventoryOutput->getVehicleType() == 'MBL'}checked=checked {/if}/>Mobil
                     <input type="radio" name="vehicle_type" value="MTR" {if $inventoryOutput->getVehicleType() == 'MTR'}checked=checked {/if}/> Motor
                  {else}
                     <input type="radio" name="vehicle_type" value="MBL" {if $smarty.post.vehicle_type == 'MBL'}checked=checked {/if}/>Mobil
                     <input type="radio" name="vehicle_type" value="MTR" {if $smarty.post.vehicle_type == 'MTR'}checked=checked {/if}/>Motor
                  {/if}
               </td>
               </tr>
               {if $smarty.request.productType == 'LUB'}
               <tr>
                  <th>Jumlah Penyaluran </th>
                  <td>
                    {if !empty($inventoryOutput)}
                  <input type="text" name="output_value" value="{$inventoryOutput->getOutputValue()}"/>
                  {else}
                    <input type="text" name="output_value" value="{$smarty.post.output_value}"/>
                  {/if}Unit</td>
                </tr>
                {else}
                <input type="hidden" name="output_value" value="0.00"/>
                 <tr>
                  <th>Stand meter awal </th>
                  <td>
                    {if !empty($inventoryOutput)}
                  <input type="text" name="begin_stand_meter" id="begin_stand_meter" value="{$inventoryOutput->getBeginStandMeter()}"/>
                  {else}
                    <input type="text" name="begin_stand_meter" id="begin_stand_meter" value="{$smarty.post.begin_stand_meter}"/>
                  {/if}</td>
                </tr>
                <tr>
                  <th>Stand meter akhir </th>
                  <td>
                    {if !empty($inventoryOutput)}
                  <input type="text" name="end_stand_meter" value="{$inventoryOutput->getEndStandMeter()}"/>
                  {else}
                    <input type="text" name="end_stand_meter" value="{$smarty.post.end_stand_meter}"/>
                  {/if}</td>
                </tr>
                <tr>
                  <th>TERA</th>
                  <td>
                    {if !empty($inventoryOutput)}
                  <input type="text" name="tera_value" id="tera_value" value="{$inventoryOutput->getTeraValue()}" onchange="recalculateStandMeter();"/>
                  {else}
                    <input type="text" name="tera_value" id="tera_value" value="{$smarty.post.tera_value}" onchange="recalculateStandMeter();"/>
                  {/if}Liter</td>
                </tr>
                <tr>
                  <th>No. Dispenser</th>
                  <td>
                    {if !empty($inventoryOutput)}
                  <input type="text" name="pump_id" value="{$inventoryOutput->getPumpId()}" onchange="this.value=this.value.toUpperCase();"/>
                  {else}
                    <input type="text" name="pump_id" value="{$smarty.post.pump_id}" onchange="this.value=this.value.toUpperCase();"/>
                  {/if}</td>
                </tr>
                <tr>
                  <th>No. Nosel</th>
                  <td>
                    {if !empty($inventoryOutput)}
                  <input type="text" name="nosel_id" value="{$inventoryOutput->getNoselId()}"/>
                  {else}
                    <input type="text" name="nosel_id" value="{$smarty.post.nosel_id}"/>
                  {/if}</td>
                </tr>
                {/if}
                <tr>
                  <th>Tanggal Penyaluran</th>
                  <td>{html_select_date start_year='-2' end_year='+2' field_order=DMY }
                  {if $smarty.request.productType == 'BBM'}
                  jam {html_select_time use_24_hours=true display_seconds=false display_meridian=false}
                  {/if}</td>
                </tr>
                <tr>
                  <th id="horizontal-spacer">Harga per unit</th>
                  <td id="unit-price"></td>
                </tr>
                <input type="hidden" name="unit_price" value="" id="unit-price-value"/>
                <tr>
                  <th>Tipe penyaluran</th>
                  <td>
                    <select name="customer_type" onchange="selectOwnUse();getUnitPrice();">
                   {if !empty($cust_types)}
                     {section name=c loop=$cust_types}
                     {if !empty($inventoryOutput)}
                     <option value="{$cust_types[c]->getCustomerType()}" {if $inventoryOutput->getCustomerType() == $cust_types[c]->getCustomerType()}selected=selected {/if}>{$cust_types[c]->getCustomerDesc()}</option>
                     {else}
                     <option value="{$cust_types[c]->getCustomerType()}" {if $smarty.post.customer_type == $cust_types[c]->getCustomerType()}selected=selected {/if}>{$cust_types[c]->getCustomerDesc()}</option>
                     {/if}
                     {/section}
                  {/if}
                    </select></td>
                </tr>
                <tr>
                  <th>Kategori</th>
                  <td id="own-use"></td>
                 </tr>
                 <input type="hidden" name="category" value="" id="own-use-value"/>
                <tr>
                  <td colspan="3" align="right">
                    <input type="submit" name="submit" value="Proses" id="submit" class="button"/></td>
                </tr>

            </table>
            </div>
			<div class="tabbtmcolored"></div>
          </td>
        </tr>
      </table>
      {if !empty($inventoryOutput)}
		<script type="text/javascript">
		   recalculateDate('Date_', document.inventory_output_form, '{$inventoryOutput->getOutputDate()}');
		   recalculateTime('Time_', document.inventory_output_form, '{$inventoryOutput->getOutputTime()}');
		</script>
		{/if}
	  </form>
      {if $smarty.request.productType == 'LUB'} {include file="inventory_output_list.tpl"} {else} {include file="stand_meter_list.tpl"}{/if}
    </td>
  </tr>
</table>
<script type="text/javascript" src="./js/stand_meter.js"></script>

{include file="footer.tpl"}
