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
				              <td colspan="13" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
				             </tr>
				              <tr class="title">
				                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
				                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Setor</td>
				                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Kirim</td>
				                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Shift</td>
				                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Order</td>
				                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Terima</td>
				                <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. Rek</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SO</td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SPBU</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>Int. Msg</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>Status</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				             </tr>
				               <tr class="title">
				                <td id="vertical-spacer" colspan="13"><img src="images/dot.gif" border="0"/></td>
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
									                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
									                 {if ($sales_order_list[c]->getReceiveDate())}
									                 {$sales_order_list[c]->getReceiveDate()}
									                 {/if}
									                 </td>
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
											 	 {if ($smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'DEP') and $sales_order_list[c]->getOrderStatus() eq 'PLN'}
											      <a href='DeliveryRealisationAction.php?method=viewSalesOrder&amp;sales_order_id={$sales_order_list[c]->getSalesOrderId()}{php} echo ("&amp;".strip_tags(SID));{/php}'>Pilih</a> 
									   					<img src="images/dot.gif" border="0" height="1" width="1"/> 
											      {/if}
												    </td>
												    
									        </tr>
									        <tr>
									                <td colspan="13" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
									              </tr>
									              <tr>
									                <td colspan="13" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
									              </tr>
									           {php} $total_quantity = bcadd($total_quantity, $this->_tpl_vars['sales_order_quantity']); {/php}   
							              {* /if *}
							     {/section}
							  <tr>
				                <td colspan="13" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
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
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>{php} echo number_format($total_quantity, 2, ',','.'); {/php} ltr</td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
				                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
	                           </tr>   
				              <tr>
				                <td colspan="13" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
				              </tr>
				              <tr><td colspan="13" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedSalesOrderList}</td></tr>
				             
				      </table>
					  </td>
						</tr>
						</table>
				
		     </td>
		   </tr>
		 </table>
  {*   {/section}
    {/if}
  {/section}
{/if} *}
{/if}
<br/>
<!-- DELIVERY Realisation -->
{if !empty($delivery_realisation_list)}
<table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel Realisasi Pengiriman</h4></td></tr>
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
	      {if !empty($delivery_realisation_list)}
	       
			<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
				<tr>
				<td>
			     <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
			             <tr class="title"><td colspan="13" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			             </tr>
			              <tr class="title">
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SO</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SPBU</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat SPBU</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. mobil</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Nama driver</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Penerimaan</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Good Issue</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>GAP</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Shift</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Keterangan</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			             </tr>
			               <tr class="title">
			                <td id="vertical-spacer" colspan="13"><img src="images/dot.gif" border="0"/></td>
			              </tr>
			              {php} $total_quantity = 0;{/php}
					     {section name=c loop=$delivery_realisation_list}
					        {if $inv_types[inv]->getInvType() eq $delivery_realisation_list[c]->getInvType()}
					         {assign var=delivery_quantity value=$delivery_realisation_list[c]->getQuantity()}
					         {assign var=good_issue_date value=$delivery_realisation_list[c]->getDeliveryDate()}
					         {assign var=receive_date value=""}
					         {assign var=max_tolerance value=""}
					         {assign var=good_issue_time value=$delivery_realisation_list[c]->getDeliveryTime()}
					         {assign var=has_receive_date value="false"}
					        <tr>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$inv_types[inv]->getInvDesc()}</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getSalesOrderNumber()}</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getStationId()}</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
				                     
				                     {if ($gas_stations)}
				                       {section name=gs loop=$gas_stations}
				                         {if ($gas_stations[gs] and $delivery_realisation_list[c]) and $gas_stations[gs]->getStationId() eq $delivery_realisation_list[c]->getStationId()}
				                            {$gas_stations[gs]->getStationAddress()}
				                         {/if}
				                       {/section}
				                     {/if}
				                 </td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getQuantity()} ltr</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getPlateNumber()}</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getDriverName()}</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
				                 {if !empty($sales_order_list)}
						                   {section name=so loop=$sales_order_list}
						                     {if ($sales_order_list[so]->getSalesOrderNumber() eq $delivery_realisation_list[c]->getSalesOrderNumber() )}
						                       {if ($sales_order_list[so]->getReceiveDate())}
						                       {$sales_order_list[so]->getReceiveDate()}
						                       {/if}
						                      
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
						                        {assign var=receive_date value=$sales_order_list[so]->getReceiveDate()}
						                        {assign var=has_receive_date value="true"}
						                        {/if}
						                     {/if}
						                   {/section}
						          {/if}
						          {if ($gas_stations)}
				                       {section name=gs loop=$gas_stations}
				                         {if ($gas_stations[gs] and $delivery_realisation_list[c]) and $gas_stations[gs]->getStationId() eq $delivery_realisation_list[c]->getStationId()}
				                            {assign var=max_tolerance value=$gas_stations[gs]->getMaxTolerance()}
				                         {/if}
				                       {/section}
				                     {/if}
				                    
						          {if $has_receive_date eq 'true'}
						             {php} 
						             
						                        list($day, $month, $year) = explode("/" , $this->_tpl_vars['good_issue_date']);
						                        list($hour, $minute) = explode( ":" , $this->_tpl_vars['good_issue_time']);
						                        list($oday, $omonth, $oyear) = explode("/" , $this->_tpl_vars['receive_date']);
                                                $oyear_with_sep = explode(" ", $oyear);
                                                list($ohour, $ominute, $osecond) = explode(":" , $oyear_with_sep[1]);
						                        
						                        $dl_date =  mktime( (int) $hour, (int) $minute, 0, ((int) $month), (int) $day, (int) $year);
						                        $o_date =  mktime( (int) $ohour, (int) $ominute, (int) $osecond, ((int) $omonth), (int) $oday, (int) $oyear);
						                        $diff = (($o_date - $dl_date) / 60);
						                        
						                        echo("<span ");
						                        if ((double) $diff > (double) $this->_tpl_vars['max_tolerance']) {
						                           echo("class='red_alert'");
						                        } else {
						                           echo("class='green_alert'");
						                        }
						                        echo(">");
						                        echo number_format($diff, 1, ',','');
						                        echo("</span>");
						             {/php}Menit
						             {/if}
						              
				                 </td>
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
				                 <td>{$delivery_realisation_list[c]->getDeliveryMessage()|replace:" ":"<br/>"}</td>
							     <td>
							     {if ($smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'DEP')}
							      <a href='DeliveryRealisationAction.php?method=edit&amp;delivery_realisation_id={$delivery_realisation_list[c]->getDeliveryRealisationId()}{php} echo ("&amp;".strip_tags(SID));{/php}'>Ubah</a> 
					   					<img src="images/dot.gif" border="0" height="1" width="1"/> 
							      {/if}
								</td>
					        </tr>
					        <tr>
					                <td colspan="13" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					              </tr>
					              <tr>
					                <td colspan="13" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					              </tr>
					              {php} $total_quantity = bcadd($total_quantity, $this->_tpl_vars['delivery_quantity']); {/php}
					          {/if}    
					     {/section}
					     <tr>
			                <td colspan="13" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			              </tr>
			              <tr style="font-weight:bold;">
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Total Realisasi</td>
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
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
                           </tr>
			           <tr>
			                <td colspan="13" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			              </tr>
			              <tr><td colspan="13" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedDeliveryRealisationList}</td></tr>
			              
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
