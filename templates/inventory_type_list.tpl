
{if !empty($inv_type_list)}
<table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
</table>
<br/>
<table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
		<div class="tabulation">
				<span class="active-tabForm ">
				Tabel Inventory
				</span>
			</div>
			<div class="tabbodycolored">
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
             <tr class="title"><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
              <tr class="title">
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Kode</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Nama</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jenis</td>
               
                <td><img src="images/dot.gif" border="0" height="1" width="1"/></td>
        </tr>
        <tr class="title"><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
                  
<tr><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>

        {section name=c loop=$inv_type_list}
        <tr>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$inv_type_list[c]->getInvType()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$inv_type_list[c]->getInvDesc()}</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>
                {if $inv_type_list[c]->getProductType() == 'BBM'}
                BBM
                {else}
                 Pelumas
                {/if}</td>
               
		  <td>
		 {if ($smarty.session.user_role == 'SUP' )} 
		  <a href="InventoryTypeAction.php?method=edit&amp;inv_id={$inv_type_list[c]->getInvId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a>
		 {/if}  
		  <img src="images/dot.gif" border="0" height="1" width="1"/> 
{if ($smarty.session.user_role == 'SUP')}
            <a id="inv_type_delete_{$smarty.section.c.index}" href="InventoryTypeAction.php?method=delete&amp;inv_id={$inv_type_list[c]->getInvId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a>
 {/if}
</td>
        </tr>
          {/section}
          <tr>
   <td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
 </tr>
 <tr><td colspan="4" id="horizontal-spacer"><img src="images/dot.gif" border="0" />{$paginatedInvType}</td></tr>
 {if ($smarty.session.user_role == 'SUP')}
          <tr>
   <td colspan="4" align="right"><a id="inv_type_delete_all" href="InventoryTypeAction.php?method=deleteAll{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus semua data?');" class="button">Hapus Semua</a><img src="images/dot.gif" border="0" height="1" width="10"/></td>
 </tr>
<tr>
   <td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
 </tr>
 {/if}
      </table>
	  </div>
	  <div class="tabbtmcolored"></div>
	  </td>
		</tr>
		</table>
 {/if}