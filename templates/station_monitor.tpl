{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
	<form name="station_monitor_form" method="post" action="StationMonitorAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>

            <input type="hidden" name="type" value="SEARCH"/>
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>SPBU Monitor</td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
                            
              <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis BBM</td>
                <td><select name="inventory_type" onchange="displayAveragePrice();">
                  {if !empty($inv_types)}
                     {section name=c loop=$inv_types}
                     <option value="{$inv_types[c]->getInvType()}" {if $smarty.post.inventory_type eq $inv_types[c]->getInvType()}selected=selected {/if}>{$inv_types[c]->getInvDesc()}</option>                     
                     {/section}
                  {/if}
               </select></td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Wilayah Penyaluran</td>
                  <td>{if !empty($dist_locations)}
                     {section name=c loop=$dist_locations}
                     <input type="radio"  onclick="displaySupplyPoint();" name="dist_loc_id" value="{$dist_locations[c]->getLocationId()}" {if $smarty.post.dist_loc_id eq $dist_locations[c]->getLocationId()}checked=checked {/if}/>{$dist_locations[c]->getLocationName()}                    
                     {/section}
                  {/if}</td>
                </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Total Suplai</td>
                  <td><input type="text" name="total_supply" value="{$total_supply}" onfocus="this.blur()" class="disabled"/>Liter</td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Total Penjualan</td>
                  <td><input type="text" name="total_sales" value="{$total_sales}" onfocus="this.blur()" class="disabled"/>Liter</td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Total Sisa Stok</td>
                  <td><input type="text" name="total_stock" value="{$total_last_stock}" onfocus="this.blur()" class="disabled"/>Liter</td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah SPBU</td>
                  <td><input type="text" name="total_gas_station" value="{$number_of_gas_station}" onfocus="this.blur()" class="disabled"/></td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Harga Rata2 Per Ltr</td>
                  <td id="average_price" class="text_bold"></td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Total % Stok</td>
                  <td class="text_bold"><input type="text" name="total_stock_percentage" value="{$total_stock_percentage}" onfocus="this.blur()" class="disabled"/>%</td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal Penyaluran</td>
                  <td>{html_select_date start_year='-2' end_year='+2' field_order=DMY prefix=StartDate_} s/d 
                   {html_select_date start_year='-2' end_year='+2' field_order=DMY prefix=EndDate_}</td>
                </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Sales Area Manager</td>
                  <td id="sales_area_manager" class="text_bold"></td>
                </tr>
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Supply Point</td>
                  <td id="supply_point" class="text_bold"></td>
                </tr>
                <tr>
                  <td colspan="3" align="right">
                    <input type="submit" name="submit" value="Cari" id="submit"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
                </tr>
                 <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
            </table>
                     
          </td>
        </tr>
      </table>
	  </form>  
      <table border="0" cellspacing="0" cellpadding="0">
      <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
      </table>
              
      {include file="station_monitor_list.tpl"}
      
    </td>
  </tr>
</table>
{include file="footer.tpl"}
