{include file="header.tpl"}

<table  border="0" cellspacing="0" cellpadding="0" id="main-table">
{include file="error_message.tpl"}
  <tr>
    
    <td>
	<form name="overhead_cost_form" method="post" action="OverheadCostAction.php{php} echo ("?".strip_tags(SID));{/php}">
      <table  border="0" cellspacing="0" cellpadding="1" id="outer-table">
        <tr>
          <td>
          
            <table  border="0" cellspacing="0" cellpadding="0" id="inner-table">
            <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
                <td colspan="3" class="title" id="horizontal-spacer"><img src="images/dot.gif" border="0" />
                 {if !empty($overheadCost)} Ubah {else} Tambah {/if} Biaya Overhead
                </td>

              </tr>
              <tr><td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              
               {if !empty($overheadCost)}
              <input type="hidden" name="method" value="update"/>
              <input type="hidden" name="ovh_id" value="{$overheadCost->getOvhId()}"/>
               {else}
               <input type="hidden" name="method" value="create"/>
               {/if}
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Kode</td>
                  <td><img src="images/dot.gif" border="0" height="1" width="15"/> {if !empty($overheadCost)}
                  <input type="text" name="ovh_code" value="{$overheadCost->getOvhCode()}" onchange="this.value=this.value.toUpperCase();"/>
                  {else}
                   <input type="text" name="ovh_code" value="{$smarty.post.ovh_code}" onchange="this.value=this.value.toUpperCase();"/>
                  {/if}
                    </td>
                </tr>
               <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Deskripsi</td>
                  <td><img src="images/dot.gif" border="0" height="1" width="15"/>
                    {if !empty($overheadCost)}
                  <input type="text" name="ovh_desc" value="{$overheadCost->getOvhDesc()}" />
                  {else}
                   <input type="text" name="ovh_desc" value="{$smarty.post.ovh_desc}" />
                  {/if} </td>
                </tr>
                {php} $e_year = (int) date(Y) + 2; $this->_tpl_vars['ey'] = $e_year; {/php}
                {php} $s_year = (int) date(Y) - 2; $this->_tpl_vars['sy'] = $s_year;{/php}
                <tr>
                 <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Tanggal</td>
                 <td><img src="images/dot.gif" border="0" height="1" width="20"/>{html_select_date start_year=$sy end_year=$ey field_order=DMY}</td>
                </tr>
                {if !empty($overheadCost)}
                	<script type="text/javascript">
		             recalculateDate('Date_', document.overhead_cost_form, '{$overheadCost->getOvhDate()}');
		          </script>
		        {/if}
                <tr>
                  <td colspan="2"><img src="images/dot.gif" border="0" height="1" width="10"/>Jumlah</td>
                  <td>Rp
                    {if !empty($overheadCost)}
                  <input type="text" name="ovh_value" value="{$overheadCost->getOvhValue()}" />
                  {else}
                   <input type="text" name="ovh_value" value="{$smarty.post.ovh_value}" />
                  {/if}
                  </td>
                </tr>
                <tr>
                  <td colspan="3" align="right">
                    <input type="submit" name="submit" value="Proses" id="submit"/><img src="images/dot.gif" border="0" height="1" width="10"/></td>
                </tr>
                <tr>
                <td colspan="3" id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
                </tr>
              
            </table>
            
          </td>
        </tr>
      </table>
	  </form>
      {include file="ovh_cost_list.tpl"}
    </td>
  </tr>
</table>
{include file="footer.tpl"}
