
{if !empty($overhead_cost_list)}
<br/>
<table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel Biaya Overhead</h4></td></tr>
</table>
<br/>
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
             <tr class="title"><td colspan="5" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
              <tr class="title">
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Kode</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Deskripsi</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
                <td><img src="images/dot.gif" border="0" height="1" width="1"/></td>
        </tr>
        <tr class="title">
           <td colspan="5" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
         <tr><td colspan="5" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>            </tr>

        {section name=c loop=$overhead_cost_list}
        {assign var=overhead_value value=$overhead_cost_list[c]->getOvhValue()}
        <tr>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$overhead_cost_list[c]->getOvhCode()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$overhead_cost_list[c]->getOvhDesc()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$overhead_cost_list[c]->getOvhDate()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Rp {$overhead_cost_list[c]->getOvhValue()}</td>
		  <td><a href="OverheadCostAction.php?method=edit&amp;ovh_id={$overhead_cost_list[c]->getOvhId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a> <img src="images/dot.gif" border="0" height="1" width="1"/>
		  <a id="ovh_cost_delete_{$smarty.section.c.index}" href="OverheadCostAction.php?method=delete&amp;ovh_id={$overhead_cost_list[c]->getOvhId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a></td>
        </tr>
        
          {/section}
          <tr><td colspan="5" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
 <tr><td colspan="5" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedOvhCostList}</td></tr>
 <tr><td colspan="5" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
 
 </table>
	  </td>
		</tr>
		</table>
<table  border="0" cellspacing="0" cellpadding="0" id="inventory-supply">
		<tr>
         <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
       </tr>
       <tr>
         <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
        </tr>
         <tr class="title">

                <td>Total Biaya Overhead</td>
                <td align="right"> Rp {php} echo number_format($this->_tpl_vars['total_ovh'], 2, ',','.'); {/php}</td>
        </tr>
        <tr>
          <td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
        </tr>
        <tr>
   <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
 </tr>
<tr>
   <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
 </tr>
          {if ($smarty.session.user_role == 'ADM' || $smarty.session.user_role == 'OWN')}
 <tr>
   <td colspan="2" align="right"><a id="ovh_cost_delete_all" href="OverheadCostAction.php?method=deleteAll{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');">Hapus Semua</a></td>
 </tr>
<tr>
   <td colspan="2" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
 </tr>
      {/if}
          </table>
          
 {/if}