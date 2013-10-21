<div class="menuHeader">
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

<ul id="nav">
	<li class="top"><a href="Dashboard.php{php} echo ("?".strip_tags(SID));{/php}" class="top_link"><span>Dashboard</span></a> </li>
	{if ($smarty.session.user_role ne 'PTM')} 
	           
	    {if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE' or $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}
	<li class="top"><a id="act0" href="javascript:void(0);" title="Mgt SPBU" class="top_link"><span>Mgt. SPBU</span></a>
		{if ($smarty.session.user_role ne 'PTM')} 	
			{if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE' or $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}
		<ul class="subOne">
		
			
			{if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE')}
			
			<li>
	            <a href="InventorySupplyAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Suplai</a>
			</li>
			<li>
	            <a href="InventoryOutputAction.php?productType=BBM{php} echo ("&".strip_tags(SID));{/php}">Stand Meter</a>
			</li>
			<li>
	            <a href="RealStockAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Real Stock</a>
			</li>
			
			{/if}
			
			{if ($smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}
			<li>
				<a title="Wilayah Penyaluran" href="DistributionLocationAction.php{php} echo ("?".strip_tags(SID));{/php}">Wilayah Penyaluran</a>    
		    </li>
			{/if}
		</ul>
			{/if}
		{/if}
	</li>
	<li class="top"><a id="act0" href="javascript:void(0);" title="Mgt SPBU" class="top_link"><span>Pengaturan</span></a>
	    {if ($smarty.session.user_role ne 'PTM')} 
		<ul class="subOne">
			{if $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'OWN'}
			<li>
		        <a href="InventoryTypeAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Inventory</a>
			</li>
			{/if}
			{if ($smarty.session.user_role eq 'PUS' or $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'OWN')}				
			<li>
	            <a href="TankCapacityAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Kp Tanki</a>  
			</li>
			{/if}
			{if $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'OWN'}
			<li>
	            <a href="InventoryCustomerAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Tipe Penyaluran</a>    
			</li>
			{/if}
			{if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN')}
			<li>
				<a href="InventoryPriceAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Harga Per Unit</a>
			</li>
			<li>
	            <a href="InventoryMarginAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Margin</a>
			</li>
			<li>
	            <a href="WorkInCapitalAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Modal</a>  
			</li>
			{/if}
			{if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE')}
			<li>
				<a href="OverheadCostAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Biaya Overhead</a>
			</li>
			<li>
	            <a href="InventoryOutputAction.php?productType=LUB{php} echo ("&".strip_tags(SID));{/php}">Penyaluran Pelumas</a>
			</li>
			<li>
	            <a href="SalesOrderAction.php{php} echo ("?".strip_tags(SID));{/php}">Mgt. Sales Order</a>
			</li>
			<li>
	            <a href="SalesOrderRealisationAction.php{php} echo ("?".strip_tags(SID));{/php}">Penerimaan Pengiriman</a>
	     	</li>
			{/if}
		</ul>
		{/if}
	{/if}
	{if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE')}      
	<li class="top"><a id="act1" href="javascript:void(0);" title="Sisa Stok" class="top_link"><span>Sisa Stok</span></a>
		{if $smarty.session.user_role ne 'PTM' and $smarty.session.user_role ne 'DEP' and $smarty.session.user_role ne 'BPH' and ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE')}
		<ul class="sub">
			<li>
				<a href="CheckStockAction.php{php} echo ("?".strip_tags(SID));{/php}">Harian</a>
			</li>
			<li>
				<a href="CheckStockAction.php?type=MONTHLY{php} echo ("&".strip_tags(SID));{/php}">Bulanan</a>
			</li>
			<li>
				<a href="CheckStockAction.php?type=YEARLY{php} echo ("&".strip_tags(SID));{/php}">Tahunan</a>
			</li>
			<li>
				<a href="CheckStockAction.php?type=SEARCH{php} echo ("&".strip_tags(SID));{/php}">Arsip</a>
			</li>
		</ul>
		{/if}
	</li>
	{/if}    
	            
	{if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN')}
	<li class="top"><a id="act2" href="javascript:void(0);" title="Cash Flow" class="top_link"><span>Cash Flow</span></a>
		{if $smarty.session.user_role ne 'PTM' and $smarty.session.user_role ne 'DEP' and $smarty.session.user_role ne 'BPH' and ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN')}
		<ul class="sub">
			<li>
				<a href="CashFlowAction.php{php} echo ("?".strip_tags(SID));{/php}">Harian</a>
			</li>
			<li>
				<a href="CashFlowAction.php?type=MONTHLY{php} echo ("&".strip_tags(SID));{/php}">Bulanan</a>
			</li>
			<li>
				<a href="CashFlowAction.php?type=YEARLY{php} echo ("&".strip_tags(SID));{/php}">Tahunan</a>
			</li>
			<li>
				<a href="CashFlowAction.php?type=SEARCH{php} echo ("&".strip_tags(SID));{/php}">Arsip</a>
			</li>
		</ul>
		{/if}
	</li>
	{/if}
	             
	{if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE')}
	<li class="top"><a id="act3" href="javascript:void(0);" title="Laporan" class="top_link"><span>Laporan</span></a>
		{if $smarty.session.user_role ne 'PTM' and $smarty.session.user_role ne 'DEP' and $smarty.session.user_role ne 'BPH' and ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'OPE')}
		<ul class="sub">
			<li>
				<a href="SalesReportAction.php{php} echo ("?".strip_tags(SID));{/php}">Harian</a>
			</li>
			<li>
				<a href="SalesReportAction.php?type=MONTHLY{php} echo ("&".strip_tags(SID));{/php}">Bulanan</a>
			</li>
			<li>
				<a href="SalesReportAction.php?type=YEARLY{php} echo ("&".strip_tags(SID));{/php}">Tahunan</a>
			</li>
			<li>
				<a href="SalesReportAction.php?type=SEARCH{php} echo ("&".strip_tags(SID));{/php}">Arsip</a>
			</li>
		</ul>
		{/if}
	</li>    
	{/if}
	              
	{if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}
	<li class="top"><a id="act4" href="javascript:void(0);" title="Admin" class="top_link"><span>Admin</span></a>
		{if $smarty.session.user_role ne 'PTM' and $smarty.session.user_role ne 'DEP' and $smarty.session.user_role ne 'BPH' and ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN' or $smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}
		<ul class="sub">
			{if ($smarty.session.user_role eq 'ADM' or $smarty.session.user_role eq 'OWN')}
			<li>
		        <a href="UserManagementAction.php{php} echo ("?".strip_tags(SID));{/php}">User</a>
			</li>
			{/if} 
			{if ($smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'PUS')}
			<li>
	            <a href="StationManagementAction.php{php} echo ("?".strip_tags(SID));{/php}">SPBU</a>
			</li>
			{/if}
			{if ($smarty.session.user_role eq 'SUP')}
			<li>
				<a href="SuperuserManagementAction.php{php} echo ("?".strip_tags(SID));{/php}">User</a>
			</li>
			{/if}
			{if ($smarty.session.user_role eq 'PUS')}
			<li>
				<a href="PowerUserManagementAction.php{php} echo ("?".strip_tags(SID));{/php}">User</a>
			</li>
			{/if}
		</ul>
		{/if}
	</li>    
	{/if}
	              
	{if ($smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'DEP')}
	<li class="top"><a id="act5" href="javascript:void(0);" title="Pengiriman" class="top_link"><span>Pengiriman</span></a>
		{if $smarty.session.user_role ne 'PTM' and ($smarty.session.user_role eq 'DEP' or $smarty.session.user_role eq 'SUP')}
		<ul class="sub">
			<li>
				<a href="DeliveryPlanAction.php{php} echo ("?".strip_tags(SID));{/php}">Penjadwalan</a>
			</li>
			<li>
				<a href="DeliveryRealisationAction.php{php} echo ("?".strip_tags(SID));{/php}">Realisasi</a>
			</li>
		</ul>
		{/if}
	</li>    
	{/if}
	              
	{if ($smarty.session.user_role eq 'SUP' or $smarty.session.user_role eq 'BPH')}
	<li class="top"><a title="Monitor Depot" href="DepotMonitorAction.php{php} echo ("?".strip_tags(SID));{/php}" class="top_link"><span>Monitor Depot</span></a></li>   
	{/if}
	              
	{/if}
	{if ($smarty.session.user_role eq 'PTM')}
	<li class="top"><a title="Monitor SPBU" href="StationMonitorAction.php{php} echo ("?".strip_tags(SID));{/php}" class="top_link"><span>Monitor SPBU</span></a></li>
	{/if} 
	           
	{if !empty($smarty.session.user_role)}
	<li class="top"><a title="Keluar" href="LoginAction.php?method=logout{php} echo ("&".strip_tags(SID));{/php}" class="top_link"><span>Keluar</span></a></li>
    {/if} 
</ul>
</div>




