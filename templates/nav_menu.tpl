{* OLD MENU (NOT USE ANYMORE)
{if (!empty($smarty.session.user_fn))}
<table border="0" cellspacing="0" cellpadding="0" id="user-name">
 <tr><td class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>
  {if $smarty.session.user_role ne 'PTM'}
         SPBU {$smarty.session.station_id}
   {else}
         {$smarty.session.user_fn}&#160;{$smarty.session.user_ln}
   {/if}
         </td></tr>
         {if $smarty.session.user_role ne 'PTM'}
          <tr>
               <td id="horizontal-line"><img src="images/dot.gif" border="0" height="1" width="1"/></td>
          </tr>
          <tr>
             <td class="title"><img src="images/dot.gif" border="0" height="1" width="10"/>
              {$smarty.session.user_fn}&#160;{$smarty.session.user_ln}
             </td>
          </tr>
         {/if}
</table>
<br />
{/if}

<table border="0" cellspacing="0" cellpadding="1" id="nav-outer">
        <tr>
          <td>
            <table border="0" cellspacing="0" cellpadding="0" id="nav-inner">
			<tr>
                <td id="vertical-spacer"><img src="images/dot.gif" border="0" id="vertical-spacer"/></td>
              </tr>
			<tr>
                <td id="select-menu"><img src="images/dot.gif" border="0" />Silahkan pilih menu</td>
            </tr>
              <tr>
                <td id="vertical-spacer"><img src="images/dot.gif" border="0"/></td>
              </tr>
              <tr>
               <td>
	              <ul>
	              {if !empty($smarty.session.user_role)}
	                <a href="LoginAction.php?method=logout{php} echo ("&".strip_tags(SID));{/php}"><li>Keluar</li></a><img src="images/dot.gif" border="0" id="horizontal-spacer"/>
	             {/if}
	           {if ($smarty.session.user_role ne 'PTM')} 
	             <a href="InventoryTypeAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Manajemen Inventory</li></a><img src="images/dot.gif" border="0" id="horizontal-spacer"/>
	             {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE')}
	                <a href="TankCapacityAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Manajemen Kp Tanki</li></a><img src="images/dot.gif" border="0" id="horizontal-spacer"/>
	              {/if}
	             <a href="InventoryCustomerAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Manajemen Tipe Penyaluran</li></a><img src="images/dot.gif" border="0" id="horizontal-spacer"/>
	             {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN')}
	             <a href="InventoryPriceAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Manajemen Harga Per Unit</li></a><img src="images/dot.gif" border="0" id="horizontal-spacer"/>
	             <a href="InventoryMarginAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Manajemen Margin</li></a><img src="images/dot.gif" border="0" id="horizontal-spacer"/>
	             <a href="WorkInCapitalAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Manajemen Modal</li></a><img src="images/dot.gif" border="0" id="horizontal-spacer"/>
	              {/if}
	              
               	<a href="OverheadCostAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Manajemen Biaya Overhead</li></a><img src="images/dot.gif" border="0" id="horizontal-spacer"/>
                <a href="InventorySupplyAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Manajemen Suplai</li></a><img src="images/dot.gif" border="0" id="horizontal-spacer"/>
                <a href="InventoryOutputAction.php?productType=BBM{php} echo ("&".strip_tags(SID));{/php}"><li>Stand Meter</li></a>
                <a href="InventoryOutputAction.php?productType=LUB{php} echo ("&".strip_tags(SID));{/php}"><li>Penyaluran Pelumas</li></a>
                <a href="SalesOrderAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Permintaan Pengiriman</li></a><img src="images/dot.gif" border="0" id="horizontal-spacer"/>
                 {if ($smarty.session.user_role eq 'ADM')}
	                <a href="UserManagementAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Administrasi User</li></a><img src="images/dot.gif" border="0" id="horizontal-spacer"/>
	              {/if}
	            
	              <li>Sisa Stok
	                 <ul><a href="CheckStockAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Harian</li></a>
	                 <a href="CheckStockAction.php?type=MONTHLY{php} echo ("&".strip_tags(SID));{/php}"><li>Bulanan</li></a>
	                 <a href="CheckStockAction.php?type=YEARLY{php} echo ("&".strip_tags(SID));{/php}"><li>Tahunan</li></a>
	                 <a href="CheckStockAction.php?type=SEARCH{php} echo ("&".strip_tags(SID));{/php}"><li>Arsip</li></a></ul><img src="images/dot.gif" border="0" id="horizontal-spacer"/></li>
	              
	               {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN')}
	                  <li>Cash Flow
	                 <ul><a href="CashFlowAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Harian</li></a>
	                 <a href="CashFlowAction.php?type=MONTHLY{php} echo ("&".strip_tags(SID));{/php}"><li>Bulanan</li></a>
	                 <a href="CashFlowAction.php?type=YEARLY{php} echo ("&".strip_tags(SID));{/php}"><li>Tahunan</li></a>
	                 <a href="CashFlowAction.php?type=SEARCH{php} echo ("&".strip_tags(SID));{/php}"><li>Arsip</li></a></ul><img src="images/dot.gif" border="0" id="horizontal-spacer"/></li>
	              {/if}
	             
	              {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE')}
	                <li>Laporan <ul><a href="SalesReportAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Harian</li></a>
	                            <a href="SalesReportAction.php?type=MONTHLY{php} echo ("&".strip_tags(SID));{/php}"><li>Bulanan</li></a>
	                            <a href="SalesReportAction.php?type=YEARLY{php} echo ("&".strip_tags(SID));{/php}"><li>Tahunan</li></a>
	                            <a href="SalesReportAction.php?type=SEARCH{php} echo ("&".strip_tags(SID));{/php}"><li>Arsip</li></a></ul><img src="images/dot.gif" border="0" id="horizontal-spacer"/></li>
	              {/if}
	              {else}
	              	<a href="StationMonitorAction.php{php} echo ("?".strip_tags(SID));{/php}"><li>Monitor SPBU</li></a><img src="images/dot.gif" border="0" id="horizontal-spacer"/>
	             {/if}  
	              </ul>
               </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      *}