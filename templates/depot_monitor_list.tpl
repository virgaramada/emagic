<!-- DELIVERY Realisation -->
{if !empty($delivery_realisation_list)}
<table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel Realisasi Pengiriman</h4></td></tr>
</table>
<br/>
{if !empty($dist_loc_list)}
	{section name=d loop=$dist_loc_list}
	<h4>{$dist_loc_list[d]->getLocationName()}</h4>
	
  {if !empty($inv_type_list)}
  
  {section name=inv loop=$inv_type_list}
  <table  border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td>
    <h5>{$inv_type_list[inv]->getInvDesc()}</h5>
	     
	       
			<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
				<tr>
				<td>
			     <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
			             <tr class="title"><td colspan="10" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			             </tr>
			              <tr class="title">
			                  
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SO</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. SPBU</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat SPBU</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. mobil</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Nama driver</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tgl Kirim</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Shift</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Keterangan</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			             </tr>
			               <tr class="title">
			                <td id="vertical-spacer" colspan="10"><img src="images/dot.gif" border="0"/></td>
			              </tr>
			              {php} $total_quantity = 0;{/php}
					     {section name=c loop=$delivery_realisation_list}
					        {if $inv_type_list[inv]->getInvType() eq $delivery_realisation_list[c]->getInvType()}
					        {assign var=delivery_quantity value=$delivery_realisation_list[c]->getQuantity()}
					        <tr>
				                 
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getSalesOrderNumber()}</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getStationId()}</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
				                     
				                     {if !empty($gas_stations)}
				                       {section name=gs loop=$gas_stations}
				                         {if $gas_stations[gs]->getStationId() eq $delivery_realisation_list[c]->getStationId()}
				                            {$gas_stations[gs]->getStationAddress()}
				                         {/if}
				                       {/section}
				                     {/if}
				                 </td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getQuantity()} ltr</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getPlateNumber()}</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getDriverName()}</td>
				                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$delivery_realisation_list[c]->getDeliveryDate()}&#160;{$delivery_realisation_list[c]->getDeliveryTime()} </td>
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
					                <td colspan="10" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					              </tr>
					              <tr>
					                <td colspan="10" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					              </tr>
					              {php} $total_quantity = bcadd($total_quantity, $this->_tpl_vars['delivery_quantity']); {/php}
					          {/if}    
					     {/section}
					     <tr>
			                <td colspan="10" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			              </tr>
			              <tr style="font-weight:bold;">
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>Total Realisasi</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                  
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/>
			                  {php} echo number_format($total_quantity, 2, ',','.'); {/php} ltr</td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
			                  <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
                           </tr>
			           <tr>
			                <td colspan="10" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
			              </tr>
			              <tr>
			                <td colspan="10" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedDeliveryRealisationList}</td>
			              </tr>
			              
			      </table>
				  </td>
			   </tr>
			</table>
        
         </td>
	   </tr>
	   </table>
     {/section}
    {/if}
  {/section}
  <br/>
  <table border="0" cellspacing="0" cellpadding="0">
       <tr>
	       <td colspan="10" align="right"><input type="button" alt="Excel export" title="Excel export" id="Excel" class="buttonExcel" onclick="excelExport()" value=""/></td>
	  </tr>
</table>
  
{/if}
{/if}
