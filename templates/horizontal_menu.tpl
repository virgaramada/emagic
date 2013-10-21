{if (!empty($smarty.session.user_fn))}
<div id="user-name">
  <span class="title">
   {if $smarty.session.user_role ne 'PTM'}
         {$smarty.session.user_fn}&#160;{$smarty.session.user_ln}&#160;{if not empty($smarty.session.station_id)}SPBU&#160;{$smarty.session.station_id}{/if}
   {else}
         {$smarty.session.user_fn}&#160;{$smarty.session.user_ln}
   {/if}
   </span>
   </div>
{/if}

<div id="menubar">
	           {if ($smarty.session.user_role ne 'PTM')} 
	           
	            {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE' or $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}
	             <a id="act0" href="javascript:void(0);" title="Mgt SPBU">Mgt. SPBU</a>
	            {/if}
	            {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE')}      
	             <a id="act1" href="javascript:void(0);" title="Sisa Stok">Sisa Stok</a>
	            {/if}    
	            
	             {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN')}
	               <a id="act2" href="javascript:void(0);" title="Cash Flow">Cash Flow</a>
	             {/if}
	             
	              {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE')}
	                <a id="act3" href="javascript:void(0);" title="Laporan">Laporan</a>    
	              {/if}
	              
	               {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}
					<a id="act4" href="javascript:void(0);" title="Admin">Admin</a>    
	              {/if}
	              
	              {if ($smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'DEP')}
					<a id="act5" href="javascript:void(0);" title="Pengiriman">Pengiriman</a>    
	              {/if}
	              
	              {if ($smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'BPH')}
					<a title="Monitor Depot" href="DepotMonitorAction.php{php} echo ("?".strip_tags(SID));{/php}">Monitor Depot</a>    
	              {/if}
	              
	           {/if}
	           {if ($smarty.session.user_role eq 'PTM')}
	              	<a title="Monitor SPBU" href="StationMonitorAction.php{php} echo ("?".strip_tags(SID));{/php}">Monitor SPBU</a>
	           {/if} 
	           
	           {if !empty($smarty.session.user_role)}
	                <a title="Keluar" href="LoginAction.php?method=logout{php} echo ("&".strip_tags(SID));{/php}">Keluar</a>
               {/if} 
</div>
{if ($smarty.session.user_role ne 'PTM')} 	
	{if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE' or $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}              
	<div id="menu1Container">
		<div id="menu1Content" class="menu">
			<div class="options">
			      {if $smarty.session.user_role eq 'SUP'}
		            <a href="InventoryTypeAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Inventory</a>
		          {/if}  
	             {if ($smarty.session.user_role eq 'PUS' or $smarty.session.user_role eq 'SUP')}
	                <a href="TankCapacityAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Kp Tanki</a>
	              {/if}
	              {if $smarty.session.user_role eq 'SUP'}
	             <a href="InventoryCustomerAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Tipe Penyaluran</a>
	             {/if}
	             {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN')}
	             <a href="InventoryPriceAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Harga Per Unit</a>
	             <a href="InventoryMarginAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Margin</a>
	             <a href="WorkInCapitalAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Modal</a>
	              {/if}
	              {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE')}
	               <a href="OverheadCostAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Biaya Overhead</a>
	                <a href="InventorySupplyAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Suplai</a>
	                <a href="InventoryOutputAction.php?productType=BBM{php} echo ("&".strip_tags(SID));{/php}">Stand Meter</a>
	                <a href="RealStockAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Real Stock</a>
	                <a href="InventoryOutputAction.php?productType=LUB{php} echo ("&".strip_tags(SID));{/php}">Penyaluran Pelumas</a>
	                <a href="SalesOrderAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Sales Order</a>
	                <a href="SalesOrderRealisationAction.php{php} echo ("?".strip_tags(SID));{/php}">Penerimaan Pengiriman</a>
	              {/if}
	              {if ($smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}
						<a title="Wilayah Penyaluran" href="DistributionLocationAction.php{php} echo ("?".strip_tags(SID));{/php}">Wilayah Penyaluran</a>    
		              {/if}
			</div>
		</div>
	</div>
	{/if}
{/if}
{if $smarty.session.user_role ne 'PTM' and $smarty.session.user_role ne 'DEP' and $smarty.session.user_role ne 'BPH' and ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE')}
<div id="menu2Container">
	<div id="menu2Content" class="menu">
		<div class="options">
			<a href="CheckStockAction.php{php} echo ("?".strip_tags(SID));{/php}">Harian</a>
	                 <a href="CheckStockAction.php?type=MONTHLY{php} echo ("&".strip_tags(SID));{/php}">Bulanan</a>
	                 <a href="CheckStockAction.php?type=YEARLY{php} echo ("&".strip_tags(SID));{/php}">Tahunan</a>
	                 <a href="CheckStockAction.php?type=SEARCH{php} echo ("&".strip_tags(SID));{/php}">Arsip</a>
		</div>
	</div>
</div>
{/if}
{if $smarty.session.user_role ne 'PTM' and $smarty.session.user_role ne 'DEP' and $smarty.session.user_role ne 'BPH' and ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN')}
<div id="menu3Container">
	<div id="menu3Content" class="menu">
		<div class="options">
		              <a href="CashFlowAction.php{php} echo ("?".strip_tags(SID));{/php}">Harian</a>
	                 <a href="CashFlowAction.php?type=MONTHLY{php} echo ("&".strip_tags(SID));{/php}">Bulanan</a>
	                 <a href="CashFlowAction.php?type=YEARLY{php} echo ("&".strip_tags(SID));{/php}">Tahunan</a>
	                 <a href="CashFlowAction.php?type=SEARCH{php} echo ("&".strip_tags(SID));{/php}">Arsip</a>
		</div>
	</div>
</div>
{/if}
{if $smarty.session.user_role ne 'PTM' and $smarty.session.user_role ne 'DEP' and $smarty.session.user_role ne 'BPH' and ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE')}
<div id="menu4Container">
	<div id="menu4Content" class="menu">
		<div class="options">
		                        <a href="SalesReportAction.php{php} echo ("?".strip_tags(SID));{/php}">Harian</a>
	                            <a href="SalesReportAction.php?type=MONTHLY{php} echo ("&".strip_tags(SID));{/php}">Bulanan</a>
	                            <a href="SalesReportAction.php?type=YEARLY{php} echo ("&".strip_tags(SID));{/php}">Tahunan</a>
	                            <a href="SalesReportAction.php?type=SEARCH{php} echo ("&".strip_tags(SID));{/php}">Arsip</a>
		</div>
	</div>
</div>
{/if}
{if $smarty.session.user_role ne 'PTM' and $smarty.session.user_role ne 'DEP' and $smarty.session.user_role ne 'BPH' and ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}
<div id="menu5Container">
	<div id="menu5Content" class="menu">
		<div class="options">
		{if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN')}
		                        <a href="UserManagementAction.php{php} echo ("?".strip_tags(SID));{/php}">User</a>
		 {/if}                       
								{if ($smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}
	                           <a href="StationManagementAction.php{php} echo ("?".strip_tags(SID));{/php}">SPBU</a>
							    {/if}
							     {if ($smarty.session.user_role eq 'SUP')}
							        <a href="SuperuserManagementAction.php{php} echo ("?".strip_tags(SID));{/php}">User</a>
							     {/if}
							     {if ($smarty.session.user_role eq 'PUS')}
							        <a href="PowerUserManagementAction.php{php} echo ("?".strip_tags(SID));{/php}">User</a>
							     {/if}
		</div>
	</div>
</div>
{/if}

{if $smarty.session.user_role ne 'PTM' and ($smarty.session.user_role eq 'DEP' or $smarty.session.user_role eq 'SUP')}
<div id="menu6Container">
	<div id="menu6Content" class="menu">
		<div class="options">		
		     <a href="DeliveryPlanAction.php{php} echo ("?".strip_tags(SID));{/php}">Penjadwalan</a>
	         <a href="DeliveryRealisationAction.php{php} echo ("?".strip_tags(SID));{/php}">Realisasi</a>				
		</div>
	</div>
</div>
{/if}
