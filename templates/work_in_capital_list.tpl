{if !empty($wic_list)}
<table border="0" cellspacing="0" cellpadding="0">
  <tr><td id="vertical-spacer"><img src="images/dot.gif" border="0"/><h4>Tabel Modal Kerja</h4></td></tr>
</table>
<br/>
<table border="0" cellspacing="0" cellpadding="1" id="outer-table">
	<tr>
	<td>
	<table border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr class="title"><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
              <tr class="title">
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Deskripsi</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
                <td><img src="images/dot.gif" border="0" height="1" width="10"/></td>
        </tr>
<tr class="title"><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
            </tr>
        {section name=c loop=$wic_list}
        {assign var=wic_value value=$wic_list[c]->getValue()}
        <tr>
          <td><img src="images/dot.gif" border="0" height="1" width="10"/>{$wic_list[c]->getDesc()}
          </td>
           <td><img src="images/dot.gif" border="0" height="1" width="10"/>Rp.
          {php}
           bcscale(2);
           echo number_format($this->_tpl_vars['wic_value'], 2, ',','.');
          {/php} 
         </td>
		  <td><a href="WorkInCapitalAction.php?method=edit&amp;id={$wic_list[c]->getId()}{php} echo ("&amp;".strip_tags(SID));{/php}">Ubah</a>
		  {if ($smarty.session.user_role eq 'OWN')}
		  <img src="images/dot.gif" border="0" height="1" width="1"/> 
		  <a id="wic_delete_{$smarty.section.c.index}" href="WorkInCapitalAction.php?method=delete&amp;id={$wic_list[c]->getId()}{php} echo ("&amp;".strip_tags(SID));{/php}" onclick="return confirm('Anda ingin menghapus data?');">Hapus</a>
		  {/if}</td>
        </tr>
          {/section}
         <tr><td colspan="4" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td></tr>
           
      </table>
	  </td>
		</tr>
		</table>
{/if}