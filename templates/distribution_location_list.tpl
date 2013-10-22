{if !empty($dist_locations)}
<table border="0" cellspacing="0" cellpadding="0">
<tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel Wilayah Penyaluran</h4></td></tr>
</table>
<br/>
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
            <table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr class="title"><td colspan="5" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
              <tr class="title">
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Kode Wilayah</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Nama Wilayah</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Supply Point</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Sales Area Manager</td>
		        <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
        </tr>
        <tr class="title"><td colspan="5" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
        </tr>

        {section name=c loop=$dist_locations}
        <tr>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$dist_locations[c]->getLocationCode()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$dist_locations[c]->getLocationName()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$dist_locations[c]->getSupplyPoint()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$dist_locations[c]->getSalesAreaManager()}</td>
		        <td><a href="DistributionLocationAction.php?method=edit&amp;dist_loc_id={$dist_locations[c]->getLocationId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a>
		        <img src="images/dot.gif" border="0" height="1" width="1"/> <a id="dist_loc_delete_{$smarty.section.c.index}" href="DistributionLocationAction.php?method=delete&amp;dist_loc_id={$dist_locations[c]->getLocationId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a></td>
        </tr>
          {/section}
         <tr><td colspan="5" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
         <tr><td colspan="5" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedDistributionLocationList}</td></tr>
         
            <tr><td colspan="5" align="right"><a id="dist_loc_delete_all" href="DistributionLocationAction.php?method=deleteAll{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a><img src="images/dot.gif" border="0" height="1" width="10"/></td></tr>
            <tr><td colspan="5" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
          
      </table>
	  </td>
		</tr>
		</table>
{/if}