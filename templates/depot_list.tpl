{if !empty($depot_list)}

<table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel Depot</h4></td></tr>
</table>
<br/>
<table border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
	<table border="0" cellspacing="0" cellpadding="0" id="inner-table">
         <tr class="title">
                  <td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
         </tr>
         <tr class="title">
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Kode</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Nama</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Alamat</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
        </tr>
        <tr class="title">
          <td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
        </tr>

        {section name=c loop=$depot_list}
        <tr>
         
           <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$depot_list[c]->getDepotCode()}</td>
           <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$depot_list[c]->getDepotName()}</td>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$depot_list[c]->getDepotAddress()}</td>
		  <td><a href="DepotAction.php?method=edit&amp;depot_id={$depot_list[c]->getDepotId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a>
		  {if ($smarty.session.user_role == 'SUP' || $smarty.session.user_role == 'PUS')} 
		    <img src="images/dot.gif" border="0" height="1" width="1"/> 
		     <a id="depot_delete_{$smarty.section.c.index}" href="DepotAction.php?method=delete&amp;depot_id={$depot_list[c]->getDepotId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a>
		  {/if}
		  </td>
        </tr>
          {/section}
         <tr><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
         <tr><td colspan="4" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedTankCapacityList}</td></tr>
         {if ($smarty.session.user_role == 'SUP' || $smarty.session.user_role == 'PUS')}
            <tr>
              <td colspan="4" align="right"><a id="depot_delete_all" href="DepotAction.php?method=deleteAll{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a><img src="images/dot.gif" border="0" height="1" width="10"/></td>
            </tr>
            <tr>
              <td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
          {/if}  
      </table>
	  </td>
		</tr>
		</table>
{/if}