{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
    
    <td>
    <form name="sales_order_search_form" method="post" action="DeliveryRealisationAction.php{php} echo ("?".strip_tags(SID));{/php}">
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
    {if !empty($deliveryRealisation) or !empty($salesOrder)}
	<form name="delivery_realisation_form" method="post" action="DeliveryRealisationAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
           
          
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
               <tr>
                 <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>
                 {if !empty($deliveryRealisation)}Ubah{elseif !empty($salesOrder)}Konfirmasi{/if} Realisasi Pengiriman</td>
              </tr>
               <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              
               {if !empty($deliveryRealisation)}
               
               <!-- edit and reconfirm delivery realisation -->
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="delivery_realisation_id" value="{$deliveryRealisation->getDeliveryRealisationId()}"/>
                 
                
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. Sales Order (SO)</td>
                <td><input type="text" name="sales_order_number" value="{$deliveryRealisation->getSalesOrderNumber()}" onfocus="this.blur()" class="disabled"/>
                 
                  </td>
                </tr>
                
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. SPBU</td>
                <td><input type="text" name="station_id" value="{$deliveryRealisation->getStationId()}" onfocus="this.blur()" class="disabled"/></td>
              </tr>
               <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              {assign var=gas_station_address value=$deliveryRealisation->getStationId()}
              {if !empty($gas_stations)}
                       {section name=gs loop=$gas_stations}
                         {if !empty($gas_stations[gs]) and $gas_stations[gs]->getStationId() eq $deliveryRealisation->getStationId()} 
                           {assign var=gas_station_address value=$gas_stations[gs]->getStationAddress()} 
                         {/if}
                       {/section}
              {/if}
              <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat SPBU</td>
                <td><textarea rows="1" cols="1" name="station_address" onfocus="this.blur();" class="disabled">{$gas_station_address}</textarea>
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
                     <option value="{$inv_types[c]->getInvType()}" {if $deliveryRealisation->getInvType() eq $inv_types[c]->getInvType()} selected="selected" {/if}>{$inv_types[c]->getInvDesc()}</option>
                     {/section}
                  {/if}
               </select>
               </td>
               </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
                  <td><input type="text" name="quantity" value="{$deliveryRealisation->getQuantity()}" onfocus="this.blur()" class="disabled"/> Liter</td>
              </tr>
              
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. mobil</td>
                  <td><input type="text" name="plate_number" value="{$deliveryRealisation->getPlateNumber()}" onchange="this.value=this.value.toUpperCase();"/>
                          
                  </td>
              </tr>
               <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Nama driver</td>
                  <td><input type="text" name="driver_name" value="{$deliveryRealisation->getDriverName()}" />
                          
                  </td>
              </tr>
              
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
                
                 <tr>
                 <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jam Pengiriman </td>
                 <td>{html_select_time use_24_hours=true display_seconds=false display_meridian=false}</td>
                </tr>
                <script type="text/javascript">
				   recalculateDate('Delivery_Date_', document.delivery_realisation_form, '{$deliveryRealisation->getDeliveryDate()}');
				   recalculateTime('Time_', document.delivery_realisation_form, '{$deliveryRealisation->getDeliveryTime()}');
				</script>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                 <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Shift</td>
                  <td>
                   <select name="delivery_shift_number">
                     <option value="1" {if $deliveryRealisation->getDeliveryShiftNumber() eq '1'}selected=selected {/if}>I</option>
                     <option value="2" {if $deliveryRealisation->getDeliveryShiftNumber() eq '2'}selected=selected {/if}>II</option>
                     <option value="3" {if $deliveryRealisation->getDeliveryShiftNumber() eq '3'}selected=selected {/if}>III</option>
                     <option value="4" {if $deliveryRealisation->getDeliveryShiftNumber() eq '4'}selected=selected {/if}>IV</option>
               </select></td>
               </tr>
               <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Keterangan</td>
                  <td> <textarea rows="1" cols="1" name="delivery_message">{$deliveryRealisation->getDeliveryMessage()}</textarea>
                  </td>
              </tr>
               
              <!-- end edit and reconfirm delivery realisation -->
               {elseif !empty($salesOrder)}
	               <input type="hidden" name="method" value="create"/>
                  <!-- confirm delivery realisation -->

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
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. SPBU</td>
                <td><input type="hidden" name="station_id" value="{$salesOrder->getStationId()}"/>
                 {$salesOrder->getStationId()}
                  </td>
              </tr>
               <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              {assign var=gas_station_address value=$salesOrder->getStationId()}
              {if !empty($gas_stations)}
                       {section name=gs loop=$gas_stations}
                         {if !empty($gas_stations[gs]) and $gas_stations[gs]->getStationId() eq $salesOrder->getStationId()} 
                           {assign var=gas_station_address value=$gas_stations[gs]->getStationAddress()} 
                         {/if}
                       {/section}
              {/if}
              <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat SPBU</td>
                <td><textarea rows="1" cols="1" name="station_address" onfocus="this.blur();" class="disabled">{$gas_station_address}</textarea>
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
              <input type="hidden" name="quantity" value="{$salesOrder->getQuantity()}"/>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
                  <td>{$salesOrder->getQuantity()} Liter</td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. mobil</td>
                  <td><input type="text" name="plate_number" value="{$smarty.post.plate_number}" onchange="this.value=this.value.toUpperCase();"/>
                          
                  </td>
              </tr>
               <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Nama driver</td>
                  <td><input type="text" name="driver_name" value="{$smarty.post.driver_name}" />
                          
                  </td>
              </tr>
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
                
                 <tr>
                 <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jam Pengiriman </td>
                 <td>{html_select_time use_24_hours=true display_seconds=false display_meridian=false}</td>
                </tr>
                <script type="text/javascript">
				   recalculateDate('Delivery_Date_', document.delivery_realisation_form, '{$salesOrder->getDeliveryDate()}');
				</script>
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
      {include file="delivery_realisation_list.tpl"}
     
    </td>
  </tr>
</table>
{include file="footer.tpl"}
