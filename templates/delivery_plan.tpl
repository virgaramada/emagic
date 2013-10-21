{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
    
    <td>
    <form name="sales_order_search_form" method="post" action="DeliveryPlanAction.php{php} echo ("?".strip_tags(SID));{/php}">
			<input type="hidden" name="method" value="viewSalesOrder"/>
			<table  border="0" cellspacing="0" cellpadding="1" id="so_search">
			<tr>
							<td>
						     <table border="0" cellspacing="0" cellpadding="0" id="so_search_inner">
			                   <tr>
			                    <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			                   </tr>
			                   <tr>
			                      <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. Sales Order (SO)</td>
			                      <td><img src="images/dot.gif" border="0" height="1" width="10"/><input type="text" name="sales_order_number" value="{$smarty.post.sales_order_number}" style="width:150px" maxlength="20"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                      </tr>
			                      <tr>
			                    <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			                   </tr>
			                   
			                   <tr>
			                   <td colspan="2"id="submit-button" align="right"><input type="submit" name="submit" value="Cari" id="submit" class="button"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                   </tr>
			                   <tr>
			                    <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			                   </tr>
			                 </table>
			</td>
			</tr>
			</table>
		</form>
		<br/>
		
    {if !empty($deliveryPlan) or !empty($salesOrder)}
	<form name="delivery_plan_form" method="post" action="DeliveryPlanAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
          
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
               <tr>
                 <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>
                 {if !empty($deliveryPlan)}Ubah{elseif !empty($salesOrder)}Konfirmasi{/if} Jadwal Pengiriman</td>
              </tr>
               <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              
               {if !empty($deliveryPlan)}
               
               <!-- edit and reconfirm delivery plan -->
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="delivery_plan_id" value="{$deliveryPlan->getDeliveryPlanId()}"/>
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                
                 <tr>
                 <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal Pengiriman </td>
                 <td>{html_select_date end_year='+1' field_order=DMY prefix='Delivery_Date_'}</td>
                </tr>
                
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                <script type="text/javascript">
				   recalculateDate('Delivery_Date_', document.delivery_plan_form, '{$deliveryPlan->getDeliveryDate()}');
				</script>
                <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. Sales Order (SO)</td>
                <td><input type="text" name="sales_order_number" value="{$deliveryPlan->getSalesOrderNumber()}" onfocus="this.blur()" class="disabled"/>
                  </td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis BBM</td>
                  <td><select name="inv_type" onfocus="this.blur();" class="disabled">
                  {if !empty($inv_types)}
                     {section name=c loop=$inv_types}
                     <option value="{$inv_types[c]->getInvType()}" {if $deliveryPlan->getInvType() eq $inv_types[c]->getInvType()} selected="selected" {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {/section}
                  {/if}
               </select>
               </td>
               </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. SPBU</td>
                <td><input type="text" name="station_id" value="{$deliveryPlan->getStationId()}" onfocus="this.blur()" class="disabled"/></td>
              </tr>
               <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              {assign var=gas_station_address value=$deliveryPlan->getStationId()}
              {if !empty($gas_stations)}
                       {section name=gs loop=$gas_stations}
                         {if !empty($gas_stations[gs]) and $gas_stations[gs]->getStationId() eq $deliveryPlan->getStationId()} 
                           {assign var=gas_station_address value=$gas_stations[gs]->getStationAddress()} 
                         {/if}
                       {/section}
              {/if}
              <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat SPBU</td>
                <td><textarea rows="1" cols="1" name="station_address" onfocus="this.blur();">{$gas_station_address}</textarea></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
                  <td><input type="text" name="quantity" value="{$deliveryPlan->getQuantity()}" onfocus="this.blur()" class="disabled"/> Liter</td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                 <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Shift</td>
                  <td>
                   <select name="delivery_shift_number">
                     <option value="1" {if $deliveryPlan->getDeliveryShiftNumber() eq '1'}selected=selected {/if}>I</option>
                     <option value="2" {if $deliveryPlan->getDeliveryShiftNumber() eq '2'}selected=selected {/if}>II</option>
                     <option value="3" {if $deliveryPlan->getDeliveryShiftNumber() eq '3'}selected=selected {/if}>III</option>
                     <option value="4" {if $deliveryPlan->getDeliveryShiftNumber() eq '4'}selected=selected {/if}>IV</option>
               </select></td>
               </tr>
               <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Keterangan</td>
                  <td> <textarea rows="1" cols="1" name="delivery_message">{$deliveryPlan->getDeliveryMessage()}</textarea>
                  </td>
              </tr>
               
              <!-- end edit and reconfirm delivery plan -->
               {elseif !empty($salesOrder)}
	               <input type="hidden" name="method" value="create"/>
                  <!-- confirm delivery plan -->
                  
                   <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                
                 <tr>
                 <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal Pengiriman </td>
                 <td>{html_select_date end_year='+1' field_order=DMY prefix='Delivery_Date_'}</td>
                </tr>
                <script type="text/javascript">
				   recalculateDate('Delivery_Date_', document.delivery_plan_form, '{$salesOrder->getDeliveryDate()}');
				</script>
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. Sales Order (SO)</td>
                <td><input type="hidden"  name="sales_order_number" value="{$salesOrder->getSalesOrderNumber()}"/>
                 {$salesOrder->getSalesOrderNumber()}
                  </td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis BBM</td>
                  <td><input type="hidden" value="{$salesOrder->getInvType()}" name="inv_type"/>
                    
                  {if !empty($inv_types)}
                     {section name=c loop=$inv_types}                    
	                     {if $salesOrder->getInvType() eq $inv_types[c]->getInvType()}
	                        {$inv_types[c]->getInvDesc()}
	                     {/if}
                     {/section}
                  {/if}
               </td>
               </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              {if ($salesOrder->getStationId())}
              <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. SPBU</td>
                <td><input type="hidden" name="station_id" value="{$salesOrder->getStationId()}"/>
                 {$salesOrder->getStationId()}
                  </td>
              </tr>
              {/if}
               <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              {if ($salesOrder->getStationId())}
              	
				  {assign var=gas_station_address value=$salesOrder->getStationId()}
				  {if ($gas_stations)}
						   {section name=gs loop=$gas_stations}
						   	
							 {if !empty($gas_stations[gs]) and $gas_stations[gs]->getStationId() eq $salesOrder->getStationId()} 
							   {assign var=gas_station_address value=$gas_stations[gs]->getStationAddress()} 
							 {/if}
						   {/section}
				  {/if}
              	{/if}
              <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat SPBU</td>
                <td><textarea rows="1" cols="1" name="station_address" onfocus="this.blur();" class="disabled">{$gas_station_address}</textarea>
                  </td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <input type="hidden" name="quantity" value="{$salesOrder->getQuantity()}"/>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
                  <td>{$salesOrder->getQuantity()} Liter </td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                 <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Shift</td>
                  <td>
                   <select name="delivery_shift_number">
                     <option value="1" {if $salesOrder->getDeliveryShiftNumber() eq '1'}selected=selected {/if}>I</option>
                     <option value="2" {if $salesOrder->getDeliveryShiftNumber() eq '2'}selected=selected {/if}>II</option>
                     <option value="3" {if $salesOrder->getDeliveryShiftNumber() eq '3'}selected=selected {/if}>III</option>
                     <option value="4" {if $salesOrder->getDeliveryShiftNumber() eq '4'}selected=selected {/if}>IV</option>
               </select></td>
               </tr>
               <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Keterangan</td>
                  <td> <textarea rows="1" cols="1" name="delivery_message">{$smarty.post.delivery_message}</textarea>
                  </td>
              </tr>
               
                  <!-- end confirm delivery plan -->
               {/if}
                
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
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
            
          </td>
        </tr>
      </table>
	  </form>
	  {/if}
	  <table border="0" cellspacing="0" cellpadding="0">
      <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
      </table>
      {include file="delivery_plan_list.tpl"}
      
    </td>
  </tr>
</table>
{include file="footer.tpl"}
