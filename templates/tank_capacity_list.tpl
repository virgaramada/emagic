{if !empty($gas_station_list)}
<table border="0" cellspacing="0" cellpadding="0">
<tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel SPBU</h4></td></tr>
</table>
<br/>
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
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
		        <td>
		         {if ($smarty.session.user_role == 'SUP' || $smarty.session.user_role == 'PUS')}
		        <a href="TankCapacityAction.php?method=selectStation&amp;station_id={$gas_station_list[c]->getStationId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Pilih</a>
		        {/if} </td>
 		  
        </tr>
          {/section}
         <tr><td colspan="6" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
         <tr><td colspan="6" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedGasStationList}</td></tr>

      </table>
	  </td>
		</tr>
		</table>
{/if}

{if !empty($tank_capacity_list)}

<table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel Kapasitas Tanki</h4></td></tr>
</table>
<br/>
<table border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
	<table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr class="title"><td colspan="5" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
              <tr class="title">
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>No SPBU</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>No. Tanki</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Kp. Tanki</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
        </tr>
        <tr class="title">
          <td colspan="5" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
        </tr>

        {section name=c loop=$tank_capacity_list}
        <tr>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>
          {if !empty($inv_types)}
			          {section name=d loop=$inv_types}
			            {if $tank_capacity_list[c]->getInvType() == $inv_types[d]->getInvType()}
			             {$inv_types[d]->getInvDesc()}
			            {/if}
			          {/section}
          {/if}</td>
           <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$tank_capacity_list[c]->getStationId()}</td>
           <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$tank_capacity_list[c]->getTankNumber()}</td>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$tank_capacity_list[c]->getTankCapacity()} Liter</td>
		  <td><a href="TankCapacityAction.php?method=edit&amp;inv_id={$tank_capacity_list[c]->getId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a>
		  {if ($smarty.session.user_role == 'SUP' || $smarty.session.user_role == 'PUS')} 
		    <img src="images/dot.gif" border="0" height="1" width="1"/> 
		     <a id="tank_cap_delete_{$smarty.section.c.index}" href="TankCapacityAction.php?method=delete&amp;inv_id={$tank_capacity_list[c]->getId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a>
		  {/if}
		  </td>
        </tr>
          {/section}
         <tr><td colspan="5" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
         <tr><td colspan="5" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedTankCapacityList}</td></tr>
         {if ($smarty.session.user_role == 'SUP' || $smarty.session.user_role == 'PUS')}
             <tr><td colspan="5" align="right"><a id="tank_cap_delete_all" href="TankCapacityAction.php?method=deleteAll{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a><img src="images/dot.gif" border="0" height="1" width="10"/></td>
            </tr>
            <tr><td colspan="5" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
          {/if}  
      </table>
	  </td>
		</tr>
		</table>
{/if}