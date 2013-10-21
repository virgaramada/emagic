{include file="header.tpl"}
<table border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
   
    <td>
    
	<form name="station_mgt_form" method="post" action="StationManagementAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
          {if !empty($gas_station)}
          <input type="hidden" name="method" value="update"/>
          <input type="hidden" name="original_station_id" value="{$gas_station->getStationId()}"/>
          {else}
          <input type="hidden" name="method" value="create"/>
           {/if}
		   <div class="tabulation">
				<span class="active-tabForm ">
				Data SPBU
				</span>
			</div>
			<div class="tabbodycolored">
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
           
                            
              <tr>
                <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>No SPBU(*)</td>
                <td>
                {if !empty($gas_station)}
                <input type="text" name="station_id" value="{$gas_station->getStationId()}"/>
                {else}
                <input type="text" name="station_id" value="{$smarty.post.station_id}"/>
                {/if}
                </td>
              </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Wilayah Penyaluran(*)</td>
                  <td>
                   <select name="location_code">
                  {if !empty($gas_station)}
	                  {if !empty($dist_locations)}
	                     {section name=c loop=$dist_locations}
	                        <option value="{$dist_locations[c]->getLocationCode()}" {if $gas_station->getLocationCode() eq $dist_locations[c]->getLocationCode()}selected=selected {/if}>{$dist_locations[c]->getLocationName()}</option>
	                     {/section}
	                  {/if}
	                  
	             {else}
	                  {if !empty($dist_locations)}
	                     {section name=c loop=$dist_locations}
	                        <option value="{$dist_locations[c]->getLocationCode()}" {if $smarty.post.location_code eq $dist_locations[c]->getLocationCode()}selected=selected {/if}>{$dist_locations[c]->getLocationName()}</option>
	                     {/section}
	                  {/if}
                  {/if}
                  </select>
                  </td>
                </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat SPBU(*)</td>
                  <td>{if !empty($gas_station)}
                   <textarea rows="1" cols="1" name="station_address">{$gas_station->getStationAddress()}</textarea>
                     {else}
                    <textarea rows="1" cols="1" name="station_address">{$smarty.post.station_address}</textarea>
                     {/if}</td>
                  
                </tr>
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              
             
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jarak SPBU ke Supply Point(*)</td>
                  <td>
                  {if !empty($gas_station)}
                  <input type="text" name="supply_point_distance" value="{$gas_station->getSupplyPointDistance()}"/>
                  {else}
                  <input type="text" name="supply_point_distance" value="{$smarty.post.supply_point_distance}"/>
                  {/if}
                  Km</td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Maks. Toleransi(*)</td>
                  <td>
                  {if !empty($gas_station)}
                  <input type="text" name="max_tolerance" value="{$gas_station->getMaxTolerance()}"/>
                  {else}
                  <input type="text" name="max_tolerance" value="{$smarty.post.max_tolerance}"/>
                  {/if}
                  Menit</td>
                </tr>
                
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3"><img src="images/dot.gif" border="0" height="1" width="10"/>
                <span style="text-decoration:underline;font-weight:bold;">Data Pemilik</span></td>
              </tr>
              <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Nama depan (*)</td>
                  <td>
                   {if !empty($user_role)}
                  <input type="text" name="first_name" value="{$user_role->getFirstName()}"/>
                  {else}
                  <input type="text" name="first_name" value="{$smarty.post.first_name}"/>
                  {/if}
                  </td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Nama belakang</td>
                  <td>
                  {if !empty($user_role)}
                  <input type="text" name="last_name" value="{$user_role->getLastName()}"/>
                  {else}
                  <input type="text" name="last_name" value="{$smarty.post.last_name}"/>
                  {/if}
                  </td>
                </tr>
                
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>E-mail</td>
                  <td>
                  {if !empty($user_role)}
                  <input type="text" name="email_address" value="{$user_role->getEmailAddress()}"/>
                  {else}
                  <input type="text" name="email_address" value="{$smarty.post.email_address}"/>
                  {/if}
                  </td>
                </tr>
              {if empty($user_role)}  
              <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              
              <tr>
                <td colspan="3"><img src="images/dot.gif" border="0" height="1" width="10"/>
                <span style="text-decoration:underline;font-weight:bold;">Data Akses</span></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Login (*)</td>
                  <td><input type="text" name="user_name" value="{$smarty.post.user_name}"/></td>
              </tr>
               
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Kata sandi (*)</td>
                  <td><input type="password" name="user_password" value="{$smarty.post.user_password}"/></td>
              </tr>
              {/if}
              
                <tr>
                  <td colspan="3" align="right">
                    <input type="submit" name="submit" value="Proses" id="submit"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
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
	   
      <table border="0" cellspacing="0" cellpadding="0">
           <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
      </table>
              
      {include file="station_management_list.tpl"}
    
    </td>
  </tr>
</table>
{include file="footer.tpl"}
