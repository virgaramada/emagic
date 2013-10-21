{if !empty($gas_station_list)}
<table border="0" cellspacing="0" cellpadding="0">
<tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
</table>
<br/>
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
	<div class="tabulation">
				<span class="active-tabForm ">
				Tabel SPBU
				</span>
			</div>
			<div class="tabbodycolored">
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr class="title"><td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
              <tr class="title">
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>No SPBU</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Wilayah Penyaluran</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jarak ke Supply Point</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Maks. Toleransi</td>
		        <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
        </tr>
        <tr class="title"><td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
        </tr>

        {section name=c loop=$gas_station_list}
        <tr>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$gas_station_list[c]->getStationId()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$gas_station_list[c]->getStationAddress()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
                
                {if !empty($dist_locations)}
                     {section name=d loop=$dist_locations}
                        {if ($dist_locations[d]->getLocationCode() eq $gas_station_list[c]->getLocationCode())}
                            {$dist_locations[d]->getLocationName()}
                        {/if}
                     {/section}
                {/if}
                </td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
                {if ($gas_station_list[c]->getSupplyPointDistance())}
                  {$gas_station_list[c]->getSupplyPointDistance()} Km
                {/if}
                </td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
                {if ($gas_station_list[c]->getMaxTolerance())}
                {$gas_station_list[c]->getMaxTolerance()} Menit
                {/if}
                </td>
		        <td><a href="StationManagementAction.php?method=edit&amp;station_id={$gas_station_list[c]->getStationId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a>
		         <img src="images/dot.gif" border="0" height="1" width="1"/>
		 {if !($gas_station_list[c]->getStationStatus())}
		      <a href="StationManagementAction.php?method=activateStation&amp;station_id={$gas_station_list[c]->getStationId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Aktifkan</a>
		  {else}
		      {if ($gas_station_list[c]->getStationStatus() eq 'REGISTERED')} 
	 		  <a href="StationManagementAction.php?method=passivateStation&amp;station_id={$gas_station_list[c]->getStationId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Non-aktifkan</a> 
	 		  {else} 
	 		  <a href="StationManagementAction.php?method=activateStation&amp;station_id={$gas_station_list[c]->getStationId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Aktifkan</a>
	 		  {if ($smarty.session.user_role == 'SUP' || $smarty.session.user_role == 'PUS')}
		      <img src="images/dot.gif" border="0" height="1" width="1"/>
	 		  <a id="station_mgt_delete_{$smarty.section.c.index}" href="StationManagementAction.php?method=delete&amp;station_id={$gas_station_list[c]->getStationId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a>
	 		  {/if}
	 		  
	 		  {/if}
		 {/if}
		           
 		  </td>
 		  
        </tr>
          {/section}
         <tr><td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
         <tr><td colspan="6" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedGasStationList}</td></tr>

      </table>
	  </div>
	  <div class="tabbtmcolored"></div>
	  </td>
		</tr>
		</table>
{/if}