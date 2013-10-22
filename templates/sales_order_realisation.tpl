<!-- DELIVERY Realisation -->
{include file="header.tpl"}
<table  border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
  
    <td>

		<form name="delivery_realisation_search_form" method="post" action="SalesOrderRealisationAction.php{php} echo ("?".strip_tags(SID));{/php}">
			<table  border="0" cellspacing="0" cellpadding="1" id="so_search">
			<tr>
							<td>
						     <table border="0" cellspacing="0" cellpadding="0" id="so_search_inner">
			                   <tr>
			                    <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			                   </tr>
			                   <tr>
			                      <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SO</td>
			                      <td><img src="images/dot.gif" border="0" height="1" width="10"/><input type="text" name="sales_order_number" value="{$smarty.post.sales_order_number}" style="width:150px" maxlength="20"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                      </tr>
			                      <tr>
			                    <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			                   </tr>
			                   
			                   <tr>
			                   <td colspan="2"id="submit-button" align="right"><input type="submit" name="submit" value="Cari" id="submit"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                   </tr>
			                   <tr>
			                    <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			                   </tr>
			                 </table>
			</td>
			</tr>
			</table>
		</form>
		
		<!-- SO Confirmation Form -->
		{if !empty($salesOrder)}
		<form name="sales_order_confirmation_form" method="post" action="SalesOrderRealisationAction.php{php} echo ("?".strip_tags(SID));{/php}">
          <input type="hidden" name="method" value="confirm"/>
           <input type="hidden" name="sales_order_number" value="{$salesOrder->getSalesOrderNumber()}"/>
      <table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
         
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
               <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
   
             
             <tr>
                <td colspan="3" class="title" id="horizontal-spacer"><img src="images/dot.gif" border="0" />
                  Konfirmasi Penerimaan BBM
                </td>

              </tr>
              <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
             
              
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
                  <td>
                   <select name="inventory_type" onfocus="this.blur()" class="disabled">
                  {if !empty($inv_types)}
                     {section name=c loop=$inv_types}
                     <option value="{$inv_types[c]->getInvType()}" {if $salesOrder->getInvType() eq $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>                     
                     {/section}
                  {/if}
               </select>
               </td>
               </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
                  <td>
                   <input type="text" name="supply_value" value="{$salesOrder->getQuantity()}" onfocus="this.blur()" class="disabled"/> Liter</td>
                </tr>
                <tr>
                 <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal suplai </td>
                 <td>{$smarty.now|date_format:'%d/%m/%Y'}</td>
                </tr>
                {*
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>NIAP</td>
                  <td>
                   <input type="text" name="niap_number" value="{$smarty.post.niap_number}" />
                  </td>
                </tr>
                *}
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. Polisi</td>
                  <td>
                  {if ($deliveryRealisation)}
                   <input type="text" name="plate_number" value="{$deliveryRealisation->getPlateNumber()}" onfocus="this.blur()" class="disabled"/>
                  {else}
                   <input type="text" name="plate_number" value="{$smarty.post.plate_number}" onchange="this.value=this.value.toUpperCase();"/>
                  {/if}
                  </td>
                </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No. Delivery Order (DO)</td>
                  <td>
                    <input type="text" name="delivery_order_number" value="{$smarty.post.delivery_order_number}" />     
                  </td>
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
	  {/if}
		<br/>
     {if !empty($delivery_realisation_list)}
		         <table border="0" cellspacing="0" cellpadding="0">
				  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel Penerimaan Pengiriman</h4> </td></tr>
				</table>
		         <br/>
		            
					<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
					
						<tr>
						<td>
					     <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
					      
					        <tr class="title"><td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					         </tr>
					              <tr class="title">
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SO</td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SPBU</td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat SPBU</td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. Mobil</td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Nama Driver</td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Shift</td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Order</td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Good Issue</td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Penerimaan</td>
					                   <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					                
					             </tr>
					               <tr class="title">
					                <td id="vertical-spacer" colspan="12"><img src="images/dot.gif" border="0"/></td>
					              </tr>
					              {php} $total_quantity = 0;{/php}
							     {section name=c loop=$delivery_realisation_list}
							       
							        {assign var=delivery_quantity value=$delivery_realisation_list[c]->getQuantity()}
							        {assign var=delivery_date value=$delivery_realisation_list[c]->getDeliveryDate()}
							        {assign var=delivery_time value=$delivery_realisation_list[c]->getDeliveryTime()}
							        {assign var=order_date value=$now}
							        {assign var=has_receive_date value="false"}
							        <tr>
						                 
						                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getSalesOrderNumber()}</td>
						                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getStationId()}</td>
						                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
						                     {if !empty($gas_station)}
						                            {$gas_station->getStationAddress()}
						                     {/if}
						                 </td>
						                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
						                 {if !empty($inv_types)}
						                   {section name=inv loop=$inv_types}
						                    {if $inv_types[inv]->getInvType() eq $delivery_realisation_list[c]->getInvType()}
						                      {$inv_types[inv]->getInvDesc()}
						                    {/if}
						                    {/section}
						                  {/if}   
						                 </td>
						                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getQuantity()} ltr</td>
						                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getPlateNumber()}</td>
						                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getDriverName()}</td>
						                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>
						                 {if $delivery_realisation_list[c]->getDeliveryShiftNumber() eq '1'}
						                     I
						                 {elseif $delivery_realisation_list[c]->getDeliveryShiftNumber() eq '2'}
						                     II
						                 {elseif $delivery_realisation_list[c]->getDeliveryShiftNumber() eq '3'}
						                     III 
						                 {elseif $delivery_realisation_list[c]->getDeliveryShiftNumber() eq '4'}
						                     IV           
						                 {/if}
						                 </td>
						                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
						                 {if !empty($sales_order_list)}
						                   {section name=so loop=$sales_order_list}
						                     {if ($sales_order_list[so]->getSalesOrderNumber() eq $delivery_realisation_list[c]->getSalesOrderNumber() )}
						                     {$sales_order_list[so]->getOrderDate()}
						                     {/if}
						                   {/section}
						                 {/if}
						                 </td>
						                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getDeliveryDate()}&#160;{$delivery_realisation_list[c]->getDeliveryTime()} </td>
						                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
						                 {if !empty($sales_order_list)}
						                   {section name=so loop=$sales_order_list}
						                     {if ($sales_order_list[so]->getSalesOrderNumber() eq $delivery_realisation_list[c]->getSalesOrderNumber() )}
						                       {if ($sales_order_list[so]->getReceiveDate())}
						                         {$sales_order_list[so]->getReceiveDate()}
						                          {assign var=has_receive_date value="true"}
						                       {/if}
						                     {/if}
						                   {/section}
						                 {/if}
						                 </td>
						                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>
											  {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN') and $has_receive_date eq 'false' }
											  <a href='SalesOrderRealisationAction.php?method=prepareConfirm&amp;sales_order_number={$delivery_realisation_list[c]->getSalesOrderNumber()}&amp;delivery_realisation_id={$delivery_realisation_list[c]->getDeliveryRealisationId()}{php} echo ("&amp;".strip_tags(SID));{/php}'>Konfirmasi</a> 
									   					<img src="images/dot.gif" border="0" height="1" width="1"/>
											{/if}
			                           </td>
							        </tr>
							        <tr>
							            <td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
							      </tr>
							       <tr>
							            <td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
							       </tr>
							       {php} $total_quantity = bcadd($total_quantity, $this->_tpl_vars['delivery_quantity']); {/php}
							          
							     {/section}
							     <tr>
					                <td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					              </tr>
					              <tr style="font-weight:bold;">
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Total Penerimaan</td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>{php} echo number_format($total_quantity, 2, ',','.'); {/php} ltr</td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
					                  
		                           </tr>
		                           {if not empty ($paginatedDeliveryRealisationList)}
					               <tr>
					                <td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					              </tr>
					              <tr><td colspan="12" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedDeliveryRealisationList}</td>
					              </tr>
					              {/if}
					              
					      </table>
						  </td>
					   </tr>
					</table>
			   
		    
		 {/if}
    </td>
  </tr>
</table>
{include file="footer.tpl"}

