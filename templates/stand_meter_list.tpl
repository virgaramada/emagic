{if !empty($pump_id_list)}
               {foreach from=$pump_id_list key=k item=v}
                       <table  border="0" cellspacing="0" cellpadding="0">
						 <tr>
						  <td id="vertical-spacer"><img src="images/dot.gif" border="0" height="5" width="1"/></td>
						 </tr>
						<tr>
						   <td class="title">Dispenser : {$k}</td>
						 </tr>
						 <tr>
						  <td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
						</tr>
						</table>
					      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
						   <tr>
						      <td>
					            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
					             <tr class="title">
					              <td colspan="11" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					            </tr>
					            <tr class="title">
					                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />Nosel</td>
					                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />Tanggal</td>
					                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />Awal</td>
					                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />Akhir</td>
   					                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />Sales</td>
   					                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />Tera</td>
					                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />BBM</td>
					                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />Kendaraan</td>
					                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />Untuk</td>
					                <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />Harga/unit</td>
							        <td id="horizontal-spacer"><img src="images/dot.gif" border="0" /></td>
					             </tr>
					         <tr class="title">
					          <td colspan="11" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
					        </tr>
					       {php} $total_output = 0; {/php}
                          {section name=c loop=$v}
                          
				             <tr>
      							<td id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$v[c]->getNoselId()}</td>
				                <td id="horizontal-spacer" nowrap>{$v[c]->getOutputDate()}-{$v[c]->getOutputTime()}</td>
   						           <td id="horizontal-spacer" nowrap><img src="images/dot.gif" border="0" />{$v[c]->getBeginStandMeter()} </td>
						           <td id="horizontal-spacer" nowrap><img src="images/dot.gif" border="0" />{$v[c]->getEndStandMeter()} </td>
						         {math equation="x - y" x=$v[c]->getEndStandMeter() y=$v[c]->getBeginStandMeter() assign="output_value"}  
						           <td id="horizontal-spacer" style="font-weight:bold;" nowrap><img src="images/dot.gif" border="0" /> {$output_value} ltr</td>
						           <td id="horizontal-spacer" nowrap><img src="images/dot.gif" border="0" />{$v[c]->getTeraValue()} ltr</td>
						           <td id="horizontal-spacer" nowrap><img src="images/dot.gif" border="0" />
				                {if !empty($inv_types)}
						          {section name=d loop=$inv_types}
						            {if $v[c]->getInvType() == $inv_types[d]->getInvType()}
						             {$inv_types[d]->getInvDesc()}
						          {/if}
						          {/section}
      							{/if}</td>
      							<td id="horizontal-spacer" nowrap><img src="images/dot.gif" border="0" />{if $v[c]->getVehicleType() == 'MBL'}Mobil{else}Motor{/if}</td>
      							<td id="horizontal-spacer" nowrap><img src="images/dot.gif" border="0" />
				                   {if !empty($cust_types)}
				                       {section name=y loop=$cust_types}
				                         {if $v[c]->getCustomerType() == $cust_types[y]->getCustomerType()}
				                           {$cust_types[y]->getCustomerDesc()}
				                         {/if}
				                       {/section}
				                    {/if}</td>
						           <td id="horizontal-spacer"><img src="images/dot.gif" border="0" />Rp {$v[c]->getUnitPrice()}</td>
							       <td><a href="InventoryOutputAction.php?method=edit&amp;inv_id={$v[c]->getInvId()}&amp;productType={$smarty.request.productType}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a>
								   <img src="images/dot.gif" border="0" height="1" width="1"/>
								   <a id="stand_meter_delete_{$smarty.section.c.index}" href="InventoryOutputAction.php?method=delete&amp;inv_id={$v[c]->getInvId()}&amp;productType={$smarty.request.productType}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a><img src="images/dot.gif" border="0" height="1" width="5"/></td>
						        </tr>
						        <tr><td colspan="11" id="vertical-spacer"> <img src="images/dot.gif" border="0" /></td></tr>
						        {php} $total_output = bcadd($total_output, $this->_tpl_vars['output_value']); {/php}
                         {/section}
                          
                         {php} $pumpArrayKey = "paginatedOutputList_".$this->_tpl_vars['k']; {/php}
                         
                         <tr>
			                  <td colspan="11" style="font-weight:bold;"><img src="images/dot.gif" border="0" height="1" width="10"/>Total <img src="images/dot.gif" border="0" height="1" width="10"/>{php} echo number_format($total_output, 2, ',','.'); {/php} ltr</td>
                         </tr>
                         <tr>
                           <td colspan="11" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{php} echo ($this->_tpl_vars[$pumpArrayKey]); {/php}</td>
                         </tr>
                         <tr>
                           <td colspan="11" id="vertical-spacer"> <img src="images/dot.gif" border="0" /></td>
                         </tr>
   			 </table>
   			 </td>
   			 </tr>
   			 </table>
			{/foreach}
	         <table  border="0" cellspacing="0" cellpadding="0" id="delete-all">
	          <tr><td colspan="2" id="vertical-spacer"> <img src="images/dot.gif" border="0" /></td></tr>         
			{if ($smarty.session.user_role == 'ADM' || $smarty.session.user_role == 'OWN')}
	        <tr>
	         <td colspan="2" align="right"><a id="stand_meter_delete_all" href="InventoryOutputAction.php?method=deleteAll&amp;productType={$smarty.request.productType}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a></td>
	       </tr>
	        <tr><td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0" /></td></tr>
		   {/if}
		  </table>

 {/if}