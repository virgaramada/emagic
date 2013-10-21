{include file="header.tpl"}

<table  border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
	<form name="distribution_location_form" method="post" action="DistributionLocationAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
			<div class="tabulation">
				<span class="active-tabForm ">
				{if !empty($distributionLocation)} Ubah {else} Tambah{/if} Wilayah Penyaluran
				</span>
			</div>
			<div class="tabbodycolored">
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
           
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
               {/if}
                
                <tr>
                  <td colspan="3" align="right">
                    <input type="submit" name="submit" value="Proses" id="submit" class="button"/><img src="images/dot.gif" border="0" height="1" width="10"/>
                  </td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
             
            </table>
            </div>
			<div class="tabbtmcolored"></div>
          </td>
        </tr>
         
      </table>
	    </form>
      {include file="distribution_location_list.tpl"}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
