{include file="header.tpl"}

<table  border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
	<form name="distribution_location_form" method="post" action="DistributionLocationAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
          
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>
                {if !empty($distributionLocation)} Ubah {else} Tambah{/if} Wilayah Penyaluran</td>
              </tr>
              <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              
              {if !empty($distributionLocation)}
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="dist_loc_id" value="{$distributionLocation->getLocationId()}"/>
              
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Kode wilayah <i>*</i></td>
                  <td><img src="images/dot.gif" border="0" height="1" width="20"/>
                  <input type="text" name="location_code" value="{$distributionLocation->getLocationCode()}" onchange="this.value=this.value.toUpperCase();"/></td>
               </tr>
                <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Nama wilayah<i>*</i></td>
                  <td><img src="images/dot.gif" border="0" height="1" width="20"/>
                  <input type="text" name="location_name" value="{$distributionLocation->getLocationName()}"/></td>
               </tr>
               <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Supply point<i>*</i></td>
                  <td><img src="images/dot.gif" border="0" height="1" width="20"/>
                  <input type="text" name="supply_point" value="{$distributionLocation->getSupplyPoint()}"/></td>
               </tr>
                <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Sales Area Manager<i>*</i></td>
                  <td><img src="images/dot.gif" border="0" height="1" width="20"/>
                  <input type="text" name="sales_area_manager" value="{$distributionLocation->getSalesAreaManager()}"/></td>
               </tr>
               <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Depot</td>
                  <td><select name="depot_code">
                  {if !empty($depot_list)}
                     {section name=c loop=$depot_list}
                      <option value="{$depot_list[c]->getDepotCode()}" {if $distributionLocation->getDepotCode() eq $depot_list[c]->getDepotCode()} selected="selected" {/if}>{$depot_list[c]->getDepotName()}</option>
                     {/section}
                  {/if}
               </select>
               </td>
              </tr>
             
               
               {else}
               <input type="hidden" name="method" value="create"/>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Kode wilayah <i>*</i></td>
                  <td><img src="images/dot.gif" border="0" height="1" width="20"/>
                  <input type="text" name="location_code" value="{$smarty.post.location_code}" onchange="this.value=this.value.toUpperCase();"/></td>
               </tr>
                <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Nama wilayah<i>*</i></td>
                  <td><img src="images/dot.gif" border="0" height="1" width="20"/>
                  <input type="text" name="location_name" value="{$smarty.post.location_name}"/></td>
               </tr>
               <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Supply point<i>*</i></td>
                  <td><img src="images/dot.gif" border="0" height="1" width="20"/>
                  <input type="text" name="supply_point" value="{$smarty.post.supply_point}"/></td>
               </tr>
                <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Sales Area Manager<i>*</i></td>
                  <td><img src="images/dot.gif" border="0" height="1" width="20"/>
                  <input type="text" name="sales_area_manager" value="{$smarty.post.sales_area_manager}"/></td>
               </tr>
               <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Depot</td>
                  <td><select name="depot_code">
                  {if !empty($depot_list)}
                     {section name=c loop=$depot_list}
                      <option value="{$depot_list[c]->getDepotCode()}" {if $smarty.post.depot_code eq $depot_list[c]->getDepotCode()} selected="selected" {/if}>{$depot_list[c]->getDepotName()}</option>
                     {/section}
                  {/if}
               </select>
               </td>
              </tr>
               {/if}
                
                <tr>
                  <td colspan="3" align="right">
                    <input type="submit" name="submit" value="Proses" id="submit"/><img src="images/dot.gif" border="0" height="1" width="10"/>
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
      {include file="distribution_location_list.tpl"}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
