{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
	<form name="depot_monitor_form" method="post" action="DepotMonitorAction.php{php} echo ("?".strip_tags(SID));{/php}">
     <input type="hidden" name="type" value="SEARCH"/>
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>

            
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>Depot Monitor</td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
                            
              <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis BBM</td>
                <td><select name="inventory_type">
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
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal Pengiriman</td>
                  <td>{html_select_date start_year='-2' end_year='+2' field_order=DMY prefix=Delivery_StartDate_} s/d 
                   {html_select_date start_year='-2' end_year='+2' field_order=DMY prefix=Delivery_EndDate_}</td>
                </tr>
                {if not empty($smart.post.Delivery_StartDate_Day)}
                <script type="text/javascript">
				   recalculateDate('Delivery_StartDate_', document.depot_monitor_form, '{$smart.post.Delivery_StartDate_Day}/{$smart.post.Delivery_StartDate_Month}/{$smart.post.Delivery_StartDate_Year}');
				   recalculateDate('Delivery_EndDate_', document.depot_monitor_form, '{$smart.post.Delivery_EndDate_Day}/{$smart.post.Delivery_EndDate_Month}/{$smart.post.Delivery_EndDate_Year}');
				</script>
				{/if}
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
                    <input type="submit" name="submit" value="Cari" id="submit" class="button"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
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
              
      {include file="depot_monitor_list.tpl"}
      
    </td>
  </tr>
</table>
{include file="footer.tpl"}
