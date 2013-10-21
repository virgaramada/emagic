 {if !empty($inv_type_list)}
	 {if !empty($gas_stations)}
	<div id="vertical-spacer">
       <img src="images/dot.gif" border="0"/><h4>Tabel Monitoring SPBU</h4>
	</div>
	<br/>
	
		{if !empty($dist_loc_list)}
			{php} $dist_idx = 1; {/php}
				{section name=d loop=$dist_loc_list}
				<h4>{$dist_loc_list[d]->getLocationName()}</h4>
				
			
				{php} $inv_idx = 1; {/php}
			     {section name=d loop=$inv_type_list}
			    <h5>{$inv_type_list[d]->getInvDesc()}</h5>
			     <div id="div-outer-table">
			            <table border="0" cellspacing="0" cellpadding="0" class="sortable" id="station_monitor_table_{php} echo ($dist_idx); {/php}_{php} echo ($inv_idx); {/php}">
			             
			             <thead>
			              <tr>
			                <th id="index_number"><img src="images/dot.gif" border="0" height="1" width="10"/>No</th> 
			                <th id="gas_station"><img src="images/dot.gif" border="0" height="1" width="10"/>SPBU</th>
			                <th id="gas_address"><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat</th>
			                <th id="supply_value"><img src="images/dot.gif" border="0" height="1" width="10"/>Suplai</th>
			                <th id="sales_value"><img src="images/dot.gif" border="0" height="1" width="10"/>Penjualan</th>
			                 <th id="average_price"><img src="images/dot.gif" border="0" height="1" width="10"/>Harga</th>
			                 <th id="stock"><img src="images/dot.gif" border="0" height="1" width="10"/>Sisa Stok</th>
			                 <th id="tank_cap"><img src="images/dot.gif" border="0" height="1" width="10"/>Kp. Tanki</th>
			                 <th id="empty_tank"><img src="images/dot.gif" border="0" height="1" width="10"/>R. Kosong</th>
			                 <th id="stock_percentage_{php} echo ($dist_idx); {/php}_{php} echo ($inv_idx); {/php}"><img src="images/dot.gif" border="0" height="1" width="10"/>% Stok</th>
			                 <th><img src="images/dot.gif" border="0" height="1" width="10"/></th>
			             </tr>
			             </thead>
			             <tbody>
			             
			                {foreach from=$gas_stations key=k item=v name=gas_station_list}
			                {if $inv_type_list[d]->getInvType() eq $k}
			                   {php} $st_number = 1; {/php}
				                {section name=s loop=$v}
							        <tr {foreach from=$stock_percentage key=ky item=vl}
							             {if $ky eq ($inv_type_list[d]->getInvType()|cat:'_'|cat:$v[s]->getStationId())}
							                             {if $vl eq 50} 
							                                class="yellow_alert"
							                             {elseif $vl gt 50}
							                                class="green_alert"
							                             {else}   
							                                class="red_alert"
							                             {/if}  
			                                           {/if}
			                                           {/foreach}>
							               <td><img src="images/dot.gif" border="0" height="1" width="10"/>
							               {php} echo($st_number); {/php}
							               </td> 
							                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
							                         {$v[s]->getStationId()}
							                </td>
							                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
							                         {$v[s]->getStationAddress()}
				                             </td>
							                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
							                 {foreach from=$inv_supply key=a item=b}
							                       
							                           {if $a eq ($inv_type_list[d]->getInvType()|cat:'_'|cat:$v[s]->getStationId())}
							                             {$b}
			                                           {/if}
							                 {/foreach} Ltr
							                 </td>
							                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
							                  {foreach from=$all_sales key=c item=e}
							                       
							                           {if $c eq ($inv_type_list[d]->getInvType()|cat:'_'|cat:$v[s]->getStationId())}
							                             {$e}
			                                           {/if}
							                 {/foreach} Ltr</td>
							                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
							                 Rp {foreach from=$avg_prices key=p item=q}
							                       
							                           {if $p eq ($inv_type_list[d]->getInvType()|cat:'_'|cat:$v[s]->getStationId())}
							                             {$q}
			                                           {/if}
							                 {/foreach}</td>
							                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
							                 {foreach from=$last_stock key=r item=u}
							                       
							                           {if $r eq ($inv_type_list[d]->getInvType()|cat:'_'|cat:$v[s]->getStationId())}
							                             
														 {php} echo number_format($this->_tpl_vars['u'], 2, '.', ','); {/php}
			                                           {/if}
							                 {/foreach} Ltr</td>
							                 <td><img src="images/dot.gif" border="0" height="1" width="10"/>
							                 {foreach from=$tank_cap key=x item=y}
							                       
							                           {if $x eq ($inv_type_list[d]->getInvType()|cat:'_'|cat:$v[s]->getStationId())}
							                             {$y}
			                                           {/if}
							                 {/foreach} Ltr</td>
									         <td><img src="images/dot.gif" border="0" height="1" width="10"/>
									         {foreach from=$empty_tank key=aKey item=aValue}
							                       
							                           {if $aKey eq ($inv_type_list[d]->getInvType()|cat:'_'|cat:$v[s]->getStationId())}
							                             {$aValue}
			                                           {/if}
							                 {/foreach} Ltr</td>
									           <td><img src="images/dot.gif" border="0" height="1" width="10"/>
									           {foreach from=$stock_percentage key=ky item=vl}
							                       
							                           {if $ky eq ($inv_type_list[d]->getInvType()|cat:'_'|cat:$v[s]->getStationId())}
							                             {$vl} 
			                                           {/if}
							                 {/foreach}%</td>
									         <td><img src="images/dot.gif" border="0" height="1" width="5"/><a href="SalesOrderAction.php?station_id={$v[s]->getStationId()}{php} echo ("&amp;".strip_tags(SID));{/php}">SO</a><img src="images/dot.gif" border="0" height="1" width="5"/></td>
							        </tr>
							        {php} $st_number = $st_number + 1; {/php}
							        {/section}
							       
						        {/if}
						         
			                {/foreach}
			          
			              </tbody>
			      </table>
			      
			      <script type="text/javascript">
			         sortTable($('station_monitor_table_{php} echo($dist_idx); {/php}_{php} echo($inv_idx); {/php}'), 10);
			      </script>
			      
				 </div>
				 {php} $inv_idx = $inv_idx + 1; {/php}
					{/section}
		    <!-- end iteration -->
		{php} $dist_idx = $dist_idx + 1; {/php}
		{/section}
		{/if}
	{/if}
{/if}
