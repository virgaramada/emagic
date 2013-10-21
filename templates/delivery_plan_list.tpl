<!-- SALES ORDER -->
 {if !empty($sales_order_list)}
 <br/>
<table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel SO</h4></td></tr>
</table>
<br/>
{*
{if !empty($dist_loc_list)}
	{section name=d loop=$dist_loc_list}
	<h4>{$dist_loc_list[d]->getLocationName()}</h4>
	
  {if !empty($inv_types)}
  
  {section name=inv loop=$inv_types} *}
		  <table  border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td>
			{*
		    <h5>{$inv_types[inv]->getInvDesc()}</h5> *}
				 
				<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
					<tr>
					<td>
				            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
				             <tr class="title">
				              <td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
				             </tr>
				              <tr class="title">
				               <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
				                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Penyetoran</td>
				                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Permintaan Kirim</td>
				                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Shift</td>
				                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Order</td>
				                <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. Rek</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SO</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SPBU</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>Int. Msg</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>Status</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				             </tr>
				               <tr class="title">
				                <td id="vertical-spacer" colspan="12"><img src="images/dot.gif" border="0"/></td>
				              </tr>
				                 {php} $total_quantity = 0;{/php}
							     {section name=c loop=$sales_order_list}
							           {* if $inv_types[inv]->getInvType() eq $sales_order_list[c]->getInvType() *}
									     {assign var=sales_order_quantity value=$sales_order_list[c]->getQuantity()}
									        <tr>
									                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
									                {if !empty($inv_types)}
									                      {section name=a loop=$inv_types}
									                         {if $inv_types[a]->getInvType() eq $sales_order_list[c]->getInvType()} 
									                               {$inv_types[a]->getInvDesc()}
									                         {/if}
									                       {/section}
									                {else}
									                     {$sales_order_list[c]->getInvType()}
									                {/if}
									                </td>
									                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getBankTransferDate()}</td>
									                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getDeliveryDate()} </td>
									                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{if $sales_order_list[c]->getDeliveryShiftNumber() eq '1'}
									                     I
									                 {elseif $sales_order_list[c]->getDeliveryShiftNumber() eq '2'}
									                     II
									                 {elseif $sales_order_list[c]->getDeliveryShiftNumber() eq '3'}
									                     III 
									                 {elseif $sales_order_list[c]->getDeliveryShiftNumber() eq '4'}
									                     IV           
									                 {/if}</td>
									                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getOrderDate()}</td>
									                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getBankName()}<br/>{$sales_order_list[c]->getBankAccNumber()}</td>
									                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getSalesOrderNumber()}</td>
									                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getStationId()}</td>
									                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getQuantity()} ltr</td>
									                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$sales_order_list[c]->getOrderMessage()|replace:" ":"<br/>"}</td>
									                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
											       {if ($sales_order_list[c]->getOrderStatus() eq 'REQ')}
											         Sudah Order
											       {/if}
											        {if ($sales_order_list[c]->getOrderStatus() eq 'CFM')}
											         Good Issue						        
											       {/if}
											       {if ($sales_order_list[c]->getOrderStatus() eq 'PLN')}
											         Sedang Proses						        
											       {/if}
												    </td>
											         <td><img src="images/dot.gif" border="0" height="1" width="10"/>
											 	 {if ($smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'DEP') and $sales_order_list[c]->getOrderStatus() eq 'REQ'}
											      <a href='DeliveryPlanAction.php?method=viewSalesOrder&amp;sales_order_id={$sales_order_list[c]->getSalesOrderId()}{php} echo ("&amp;".strip_tags(SID));{/php}'>Pilih</a> 
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
									           {php} $total_quantity = bcadd($total_quantity, $this->_tpl_vars['sales_order_quantity']); {/php}   
							              {* /if *}
							     {/section}
							  <tr>
				                <td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
				              </tr>
				              <tr style="font-weight:bold;">
				                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Total SO</td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>{php} echo number_format($total_quantity, 2, ',','.'); {/php} ltr</td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
	                           </tr>   
				              <tr>
				                <td colspan="12" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
				              </tr>
				              <tr><td colspan="12" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedSalesOrderList}</td></tr>
				             
				      </table>
					  </td>
						</tr>
						</table>
				
		     </td>
		   </tr>
		 </table>
    {* {/section}
    {/if}
  {/section}
{/if} *}
{/if}
<br/>
<!-- DELIVERY PLAN -->
{if !empty($delivery_plan_list) }
<table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel Jadwal Pengiriman</h4></td></tr>
</table>
<br/>

{if !empty($dist_loc_list)}
	{section name=d loop=$dist_loc_list}
	<h4>{$dist_loc_list[d]->getLocationName()}</h4>
	
  {if !empty($inv_types)}
  
  {section name=inv loop=$inv_types}
  <table  border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td>
    <h5>{$inv_types[inv]->getInvDesc()}</h5>
	      {if !empty($delivery_plan_list)}
	       
			<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
				<tr>
				<td>
			     <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
			             <tr class="title"><td colspan="9" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			             </tr>
			              <tr class="title">
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Kirim</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SO</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SPBU</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat SPBU</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Shift</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Keterangan</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			             </tr>
			               <tr class="title">
			                <td id="vertical-spacer" colspan="9"><img src="images/dot.gif" border="0"/></td>
			              </tr>
			              {php} $total_quantity = 0;{/php}
					     {section name=c loop=$delivery_plan_list}
					        {if $inv_types[inv]->getInvType() eq $delivery_plan_list[c]->getInvType()}
					        
					        {assign var=delivery_quantity value=$delivery_plan_list[c]->getQuantity()}
					        
					        {assign var=gas_station_address value=""}
				              {if ($gas_stations)}
				                       {section name=gs loop=$gas_stations}
				                         {if  ($gas_stations[gs] and $delivery_plan_list[c]) and $gas_stations[gs]->getStationId() eq $delivery_plan_list[c]->getStationId()} 
				                           {assign var=gas_station_address value=$gas_stations[gs]->getStationAddress()} 
				                         {/if}
				                       {/section}
				              {/if}
					        <tr>
					            <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$inv_types[inv]->getInvDesc()} </td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_plan_list[c]->getDeliveryDate()} </td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_plan_list[c]->getSalesOrderNumber()}</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_plan_list[c]->getStationId()}</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$gas_station_address}</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_plan_list[c]->getQuantity()} ltr</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
				                 {if $delivery_plan_list[c]->getDeliveryShiftNumber() eq '1'}
									                     I
									                 {elseif $delivery_plan_list[c]->getDeliveryShiftNumber() eq '2'}
									                     II
									                 {elseif $delivery_plan_list[c]->getDeliveryShiftNumber() eq '3'}
									                     III 
									                 {elseif $delivery_plan_list[c]->getDeliveryShiftNumber() eq '4'}
									                     IV           
									                 {/if}
				                 </td>
				                 <td>{$delivery_plan_list[c]->getDeliveryMessage()|replace:" ":"<br/>"}</td>
							    <td>
							     {if ($smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'DEP') and $delivery_plan_list[c]->getPlanStatus() and $delivery_plan_list[c]->getPlanStatus() ne 'CFM'}
							      <a href='DeliveryPlanAction.php?method=edit&amp;delivery_plan_id={$delivery_plan_list[c]->getDeliveryPlanId()}{php} echo ("&amp;".strip_tags(SID));{/php}'>Ubah</a> 
					   					<img src="images/dot.gif" border="0" height="1" width="1"/> 
							      {/if}
								</td>
					        </tr>
					        <tr>
					          <td colspan="9" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					        </tr>
					        <tr>
					          <td colspan="9" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					        </tr>
					            {php} $total_quantity = bcadd($total_quantity, $this->_tpl_vars['delivery_quantity']); {/php}
					          {/if}    
					     {/section}
					      <tr>
			                <td colspan="9" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			              </tr>
			              <tr style="font-weight:bold;">
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Total Penjadwalan</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>
			                  {php} echo number_format($total_quantity, 2, ',','.'); {/php} ltr</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
                           </tr>
			           <tr>
			                <td colspan="9" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			              </tr>
			              <tr><td colspan="9" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedDeliveryPlanList}</td></tr>
			              
			      </table>
				  </td>
			   </tr>
			</table>
	       
         {/if}
         </td>
	   </tr>
	   </table>
     {/section}
    {/if}
  {/section}
{/if}
{/if}
