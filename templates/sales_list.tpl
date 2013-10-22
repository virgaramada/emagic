
<table
	border="0" cellspacing="0" cellpadding="0" id="sales-report">
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<!-- supply bbm -->
	{if !empty($gas_types)}
	<tr>
		<td colspan="2">Suplai BBM :</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{php} $gas_supply = 0;{/php} {section name=c loop=$gas_types}
	<tr>
		<td><b>- {$gas_types[c]->getInvDesc()}</b></td>
		<td align="right" class="amount">{if !empty($inv_supply)} {foreach
		from=$inv_supply key=k item=v} {if $k == $gas_types[c]->getInvType()}
		= {php} echo number_format($this->_tpl_vars['v'], 2, ',','.'); {/php}
		ltr {php} $gas_supply = bcadd($gas_supply,$this->_tpl_vars['v']);
		{/php} {/if} {/foreach} {/if}</td>
	</tr>
	{/section} {/if}
	<!-- total supply -->
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Total Suplai BBM {$actual_date}</td>
		<td align="right">= {php} echo number_format($gas_supply, 2, ',','.');
		{/php} ltr</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<!-- supply pelumas -->
	{if !empty($lub_types)}
	<tr>
		<td colspan="2">Suplai Pelumas :</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{php} $lub_supply = 0;{/php} {section name=d loop=$lub_types}
	<tr>
		<td><b>- {$lub_types[d]->getInvDesc()}</b></td>
		<td align="right" class="amount">{if !empty($inv_supply)} {foreach
		from=$inv_supply key=a item=b} {if $a == $lub_types[d]->getInvType()}
		= {php} echo number_format($this->_tpl_vars['b'], 0, ',','.'); {/php}
		unit {php} $lub_supply = bcadd($lub_supply,$this->_tpl_vars['b']);
		{/php} {/if} {/foreach} {/if}</td>
	</tr>
	{/section} {/if}
	<!-- total supply pelumas -->
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Total Suplai Pelumas {$actual_date}</td>
		<td align="right">= {php} echo number_format($lub_supply, 2, ',','.');
		{/php} unit</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<!-- penjualan BBM -->
	{if !empty($gas_types)}
	<tr>
		<td colspan="2">Penjualan BBM :</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{php} $s = 0; {/php} {section name=c loop=$gas_types}
	<tr>
		<td colspan="2"><b>- {$gas_types[c]->getInvDesc()}</b> 
		{if	!empty($total_output_inventory)}
		<ul>
			{section name=a loop=$total_output_inventory} 
				{if	$total_output_inventory[a]->getInvType() ==	$gas_types[c]->getInvType()} 
					{assign var=output_inv value=$total_output_inventory[a]->getOutputValue()} 
					{assign var=output_prc value=$total_output_inventory[a]->getUnitPrice()} 
					{php} $s =	bcadd($s, $this->_tpl_vars['output_inv']); {/php}
					<li><font class="small-font"> Rp 
					{php}
					 echo (int)($this->_tpl_vars['output_inv']*$this->_tpl_vars['output_prc']);
					{/php}
					({$total_output_inventory[a]->getOutputValue()} ltr @ Rp
					{$total_output_inventory[a]->getUnitPrice()}) tgl
					{$total_output_inventory[a]->getOutputDate()} utk 
					{if	!empty($cust_types)} 
						{section name=y loop=$cust_types} 
							{if	$total_output_inventory[a]->getCustomerType() == $cust_types[y]->getCustomerType()}
							    {$cust_types[y]->getCustomerDesc()} 
							{/if} 
						{/section} 
					{/if} </font></li>
				{/if} 
			{/section}
		</ul>
		{/if}</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{php} $o = 0; {/php}
	<tr>
		<td><strong>Total Penjualan {$gas_types[c]->getInvDesc()}</strong></td>
		<td class="amount">{if !empty($total_output_inventory)} {section
		name=jj loop=$total_output_inventory} {if
		$total_output_inventory[jj]->getInvType() ==
		$gas_types[c]->getInvType()} {assign var=o_inv
		value=$total_output_inventory[jj]->getOutputValue()} {php} $o =
		bcadd($o, $this->_tpl_vars['o_inv']); {/php} {/if} {/section} {/if}
		{php} echo number_format($o, 0, ',','.'); {/php} Liter {if
		!empty($total_sales_inventory)} {foreach from=$total_sales_inventory
		key=k item=v} {if $k == $gas_types[c]->getInvType()} = Rp {php} echo
		number_format($this->_tpl_vars['v'], 2, ',','.'); {/php} {/if}
		{/foreach} {/if}</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>

	<tr>
		<td><strong>Prosentase {$gas_types[c]->getInvDesc()} Terjual </strong></td>
		<td class="amount">{if !empty($inv_supply)} {foreach from=$inv_supply
		key=k item=v} {if $k == $gas_types[c]->getInvType()} {php}
		bcscale(100); $div_result = 0; if ($o != 0 && $this->_tpl_vars['v'] !=
		0) { $div_result = bcdiv($o, $this->_tpl_vars['v']); } echo
		number_format(bcmul($div_result, 100), 5, ',','.'); {/php} % {/if}
		{/foreach} {/if}</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{/section} {/if}
	<!-- penjualan pelumas -->
	{if !empty($lub_types)}
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2">Penjualan Pelumas :</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{php} $l = 0; {/php} {section name=c loop=$lub_types}
	<tr>
		<td colspan="2"><b>- {$lub_types[c]->getInvDesc()}</b> 
		{if !empty($total_output_inventory)}
		<ul>
			{section name=a loop=$total_output_inventory} 
				{if	$total_output_inventory[a]->getInvType() ==	$lub_types[c]->getInvType()} 
					{assign var=output_inv value=$total_output_inventory[a]->getOutputValue()}
					{assign var=output_prc value=$total_output_inventory[a]->getUnitPrice()}  
					{php} $l =	bcadd($l, $this->_tpl_vars['output_inv']); {/php}
					<li><font class="small-font"> Rp 
					{php}
					 echo (int)($this->_tpl_vars['output_inv']*$this->_tpl_vars['output_prc']);
					{/php}
					({$total_output_inventory[a]->getOutputValue()} unit @ Rp
					{$total_output_inventory[a]->getUnitPrice()}) tgl
					{$total_output_inventory[a]->getOutputDate()} utk 
					{if !empty($cust_types)} 
						{section name=y loop=$cust_types} 
							{if $total_output_inventory[a]->getCustomerType() == $cust_types[y]->getCustomerType()}
							    {$cust_types[y]->getCustomerDesc()} 
							{/if} 
						{/section} 
					{/if}</font></li>
				{/if} 
			{/section}
		</ul>
		{/if}</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{php} $t = 0; {/php}
	<tr>
		<td><strong>Total Penjualan {$lub_types[c]->getInvDesc()}</strong></td>
		<td class="amount">{if !empty($total_output_inventory)} {section
		name=jj loop=$total_output_inventory} {if
		$total_output_inventory[jj]->getInvType() ==
		$lub_types[c]->getInvType()} {assign var=t_inv
		value=$total_output_inventory[jj]->getOutputValue()} {php} $t =
		bcadd($t, $this->_tpl_vars['t_inv']); {/php} {/if} {/section} {/if}
		{php} echo number_format($t, 0, ',','.'); {/php} Unit {if
		!empty($total_sales_inventory)} {foreach from=$total_sales_inventory
		key=k item=v} {if $k == $lub_types[c]->getInvType()} = Rp {php} echo
		number_format($this->_tpl_vars['v'], 2, ',','.'); {/php} {/if}
		{/foreach} {/if}</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>

	<tr>
		<td><strong>Prosentase Penjualan {$lub_types[c]->getInvDesc()} </strong></td>
		<td class="amount">{if !empty($inv_supply)} {foreach from=$inv_supply
		key=k item=v} {if $k == $lub_types[c]->getInvType()} {php}
		bcscale(100); $div_result = 0; if ($t != 0 && $this->_tpl_vars['v'] !=
		0) { $div_result = bcdiv($t, $this->_tpl_vars['v']); } echo
		number_format(bcmul($div_result, 100), 5, ',','.'); {/php} % {/if}
		{/foreach} {/if}</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{/section} {/if}
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Total Penjualan {$actual_date}</td>
		<td align="right">= Rp {php} bcscale(2); $total_sales =
		bcadd($this->_tpl_vars['total_sales'],0); echo
		number_format($total_sales, 2, ',','.'); {/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<!-- ##### OWN USE  ##### -->
	<!-- own-use BBM -->
	{if !empty($gas_types)}
	<tr>
		<td colspan="2">BBM 'Own-Use' :</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{php} $b = 0; {/php} {section name=c loop=$gas_types}
	<tr>
		<td colspan="2"><b>- {$gas_types[c]->getInvDesc()}</b> 
		{if !empty($total_ownuse_output_inventory)}
		<ul>
		{section name=a loop=$total_ownuse_output_inventory} 
			{if	$total_ownuse_output_inventory[a]->getInvType() == $gas_types[c]->getInvType()}
			{assign var=output_inv value=$total_ownuse_output_inventory[a]->getOutputValue()}
			{assign var=output_prc value=$total_ownuse_output_inventory[a]->getUnitPrice()}  
				<li><font class="small-font"> Rp 
				{php}
			     echo (int)($this->_tpl_vars['output_inv']*$this->_tpl_vars['output_prc']);
			    {/php}
				({$total_ownuse_output_inventory[a]->getOutputValue()} ltr @ Rp	{$total_ownuse_output_inventory[a]->getUnitPrice()}) 
				tgl	{$total_ownuse_output_inventory[a]->getOutputDate()} utk 
				{if !empty($cust_types)} 
					{section name=y loop=$cust_types} 
						{if	$total_ownuse_output_inventory[a]->getCustomerType() ==	$cust_types[y]->getCustomerType()}
						{$cust_types[y]->getCustomerDesc()} 
						{/if} 
					{/section} 
				{/if}</font></li>
			{/if} 
		{/section}
			</ul>
		{/if}</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{php} $g_own_use = 0; {/php}
	<tr>
		<td><strong>Total {$gas_types[c]->getInvDesc()} 'Own-Use' </strong></td>
		<td class="amount">{if !empty($total_ownuse_output_inventory)}
		{section name=jj loop=$total_ownuse_output_inventory} {if
		$total_ownuse_output_inventory[jj]->getInvType() ==
		$gas_types[c]->getInvType()} {assign var=g_ou
		value=$total_ownuse_output_inventory[jj]->getOutputValue()} {php}
		$g_own_use = bcadd($g_own_use, $this->_tpl_vars['g_ou']); {/php} {/if}
		{/section} {/if} {php} echo number_format($g_own_use, 0, ',','.');
		{/php} Liter {if !empty($total_ownuse_sales_inventory)} {foreach
		from=$total_ownuse_sales_inventory key=k item=v} {if $k ==
		$gas_types[c]->getInvType()} = Rp {php} echo
		number_format($this->_tpl_vars['v'], 2, ',','.'); {/php} {/if}
		{/foreach} {/if}</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>

	<tr>
		<td><strong>Prosentase Pengeluaran {$gas_types[c]->getInvDesc()}
		'Own-Use' </strong></td>
		<td class="amount">{if !empty($inv_supply)} {foreach from=$inv_supply
		key=k item=v} {if $k == $gas_types[c]->getInvType()} {php}
		bcscale(100); $div_result = 0; if ($g_own_use != 0 &&
		$this->_tpl_vars['v'] != 0) { $div_result = bcdiv($g_own_use,
		$this->_tpl_vars['v']); } echo number_format(bcmul($div_result, 100),
		5, ',','.'); {/php} % {/if} {/foreach} {/if}</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{/section} {/if}
	<!-- pelumas on-use -->
	{if !empty($lub_types)}
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2">Pelumas 'Own-Use' :</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{section name=c loop=$lub_types}
	<tr>
		<td colspan="2"><b>- {$lub_types[c]->getInvDesc()}</b> 
		{if !empty($total_ownuse_output_inventory)}
		<ul>
				{section name=a loop=$total_ownuse_output_inventory} 
					{if	$total_ownuse_output_inventory[a]->getInvType() == $lub_types[c]->getInvType()} 
						{assign var=ownuse_inv_lub value=$total_ownuse_output_inventory[a]->getOutputValue()} 
						{assign var=ownuse_prc_lub value=$total_ownuse_output_inventory[a]->getUnitPrice()}
						
						<li><font class="small-font"> Rp 
						{php}
					     echo (int)($this->_tpl_vars['ownuse_inv_lub']*$this->_tpl_vars['ownuse_prc_lub']);
					    {/php}
						({$total_ownuse_output_inventory[a]->getOutputValue()} unit @ Rp
						{$total_ownuse_output_inventory[a]->getUnitPrice()}) tgl
						{$total_ownuse_output_inventory[a]->getOutputDate()} utk 
						{if !empty($cust_types)} 
							{section name=y loop=$cust_types} 
								{if $total_ownuse_output_inventory[a]->getCustomerType() ==	$cust_types[y]->getCustomerType()}
									{$cust_types[y]->getCustomerDesc()} 
								{/if} 
							{/section} 
						{/if}</font></li>
					{/if} 
				{/section}
		</ul>
		{/if}</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{php} $l_own_use = 0; {/php}
	<tr>
		<td><strong>Total {$lub_types[c]->getInvDesc()} 'Own-Use' </strong></td>
		<td class="amount">{if !empty($total_ownuse_output_inventory)}
		{section name=jj loop=$total_ownuse_output_inventory} {if
		$total_ownuse_output_inventory[jj]->getInvType() ==
		$lub_types[c]->getInvType()} {assign var=l_ou
		value=$total_ownuse_output_inventory[jj]->getOutputValue()} {php}
		$l_own_use = bcadd($l_own_use, $this->_tpl_vars['l_ou']); {/php} {/if}
		{/section} {/if} {php} echo number_format($l_own_use, 0, ',','.');
		{/php} Unit {if !empty($total_ownuse_sales_inventory)} {foreach
		from=$total_ownuse_sales_inventory key=k item=v} {if $k ==
		$lub_types[c]->getInvType()} = Rp {php} echo
		number_format($this->_tpl_vars['v'], 2, ',','.'); {/php} {/if}
		{/foreach} {/if}</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>

	<tr>
		<td><strong>Prosentase Pengeluaran {$lub_types[c]->getInvDesc()}
		'Own-Use' </strong></td>
		<td class="amount">{if !empty($inv_supply)} {foreach from=$inv_supply
		key=k item=v} {if $k == $lub_types[c]->getInvType()} {php}
		bcscale(100); $div_result = 0; if ($l_own_use != 0 &&
		$this->_tpl_vars['v'] != 0) { $div_result = bcdiv($l_own_use,
		$this->_tpl_vars['v']); } echo number_format(bcmul($div_result, 100),
		5, ',','.'); {/php} % {/if} {/foreach} {/if}</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{/section} {/if}
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Total Pengeluaran 'OWN-USE' {$actual_date}</td>
		<td align="right">= Rp {php} echo
		number_format($this->_tpl_vars['total_ownuse_sales'], 2, ',','.');
		{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<!-- REAL STOCK -->
	
	
	{if !empty($gas_types)} 
	{php} $total_real_stock = 0; {/php} 
	{php} $total_real_stock_value = 0; {/php} 
		{if	!empty($real_stock_list)}
		
		<tr>
			<td colspan="2"><i><b>Real Stok BBM</b></i> :</td>
		</tr>
			{section name=c loop=$gas_types}
			<tr>
				<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
					border="0" /></td>
			</tr>
			<tr>
				<td><b>- Real stok {$gas_types[c]->getInvDesc()} {$actual_date}</b></td>
				<td align="right" class="amount">
				{foreach from=$real_stock_list key=k item=v} 
				 {if $k == $gas_types[c]->getInvType()} 
				 {foreach from=$v key=h item=i}
				  {assign var=gas_real_stock value=$i} 
				  {assign var=gas_real_stock_value value=$h}
				  <i>{php} echo number_format($this->_tpl_vars['h'], 2, ',','.'); {/php} Liter</i>
				  = Rp 
				  {php} echo number_format($this->_tpl_vars['i'], 2, ',','.'); {/php}
				  {php} $total_real_stock = bcadd($total_real_stock, $this->_tpl_vars['gas_real_stock']);{/php} 
				  {php} $total_real_stock_value = bcadd($total_real_stock_value, $this->_tpl_vars['gas_real_stock_value']);{/php} 
				  {/foreach}
				 {/if} 
				{/foreach}</td>
			</tr>
			{/section} 
		{/if} 
	{/if}
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>

	<!-- total stock bbm -->
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Total Real Stok BBM {$actual_date}</td>
		<td align="right">
		<i>{php} 
		bcscale(2); 
		echo number_format($total_real_stock_value, 2, ',','.' ); 
		{/php} Liter</i>
		= Rp {php} bcscale(2); echo
		number_format($total_real_stock, 2, ',','.' ); {/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>


	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	
	
	<!-- END REAL STOCK -->
	<!-- #### LOSS  ##### -->

	<!-- START BBM LOSSES -->
	{php} $total_stock_losses = 0; {/php} 
	{php} $total_stock_losses_value = 0; {/php} 
	
	
	{if !empty($gas_types)} 
	
		{if	!empty($stock_losses)}
		
		<tr>
			<td colspan="2"><i><b>Kerugian BBM</b></i> :</td>
		</tr>
			{section name=c loop=$gas_types}
			<tr>
				<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
					border="0" /></td>
			</tr>
			<tr>
				<td><b>- Kerugian {$gas_types[c]->getInvDesc()} {$actual_date}</b></td>
				<td align="right" class="amount">
				{foreach from=$stock_losses key=k item=v} 
				 {if $k == $gas_types[c]->getInvType()} 
				 {foreach from=$v key=h item=i}
				  {assign var=gas_stock_losses value=$i} 
				  {assign var=gas_stock_losses_value value=$h}
				  <i>{php} echo number_format($this->_tpl_vars['h'], 2, ',','.'); {/php} Liter</i>
				  = Rp 
				  {php} echo number_format($this->_tpl_vars['i'], 2, ',','.'); {/php}
				  {php} $total_stock_losses = bcadd($total_stock_losses, $this->_tpl_vars['gas_stock_losses']);{/php} 
				  {php} $total_stock_losses_value = bcadd($total_stock_losses_value, $this->_tpl_vars['gas_stock_losses_value']);{/php} 
				  {/foreach}
				 {/if} 
				{/foreach}</td>
			</tr>
			{/section} 
		{/if} 
	{/if}
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>

	<!-- total stock bbm -->
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Total Kerugian BBM {$actual_date}</td>
		<td align="right">
		<i>{php} 
		bcscale(2); 
		echo number_format($total_stock_losses_value, 2, ',','.' ); 
		{/php} Liter</i>
		= Rp {php} bcscale(2); echo
		number_format($total_stock_losses, 2, ',','.' ); {/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>


	
	
		<!-- END BBM LOSSES -->
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>


	<!-- PROFIT BBM -->
	{php} $gas_value = array(); {/php} {if !empty($gas_types)}
	<tr>
		<td colspan="2">Keuntungan BBM :</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{section name=c loop=$gas_types}
	<tr>
		<td><b>- {$gas_types[c]->getInvDesc()}</b> <!--({$gas_types[c]->getInvType()})-->
		{if !empty($total_margin_inventory)} {foreach
		from=$total_margin_inventory key=k item=v} {if $k ==
		$gas_types[c]->getInvType()} <i>margin = {$v->getMarginValue()}%</i>
		{/if} {/foreach} {/if}</td>
		<td align="right" class="small-font">{if
		!empty($total_sales_inventory)} {foreach from=$total_sales_inventory
		key=k item=v} {if $k == $gas_types[c]->getInvType()} {if
		!empty($total_margin_inventory)} {foreach from=$total_margin_inventory
		key=ky item=val} {if $ky == $k} <i>({$val->getMarginValue()}% x Rp
		{php} echo number_format($this->_tpl_vars['v'], 2, ',','.'); {/php})</i>
		{assign var=gas_margin_value value=$val->getMarginValue()} = Rp {php}
		bcscale(2); $gas_profit =
		bcmul($this->_tpl_vars['v'],$this->_tpl_vars['gas_margin_value']);
		echo number_format(($gas_profit * 0.01), 2, ',','.'); $gas_value =
		array_merge($gas_value, array($gas_profit)); {/php} {/if} {/foreach}
		{/if} {/if} {/foreach} {/if}</td>
	</tr>
	{/section} {/if}
	<!-- profit Pelumas -->
	{php} $lub_value = array(); {/php} {if !empty($lub_types)}
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2">Keuntungan Pelumas :</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{section name=c loop=$lub_types}
	<tr>
		<td><b>- {$lub_types[c]->getInvDesc()}</b> <!--({$lub_types[c]->getInvType()})-->
		{if !empty($total_margin_inventory)} {foreach
		from=$total_margin_inventory key=ky item=val} {if $ky ==
		$lub_types[c]->getInvType()} <i>margin = {$val->getMarginValue()}%</i>
		{/if} {/foreach} {/if}</td>
		<td align="right" class="small-font">{if
		!empty($total_sales_inventory)} {foreach from=$total_sales_inventory
		key=k item=v} {if $k == $lub_types[c]->getInvType()} {if
		!empty($total_margin_inventory)} {foreach from=$total_margin_inventory
		key=ky item=val} {if $ky == $k} <i>({$val->getMarginValue()}% x Rp
		{php} echo number_format($this->_tpl_vars['v'], 2, ',','.'); {/php})</i>
		{assign var=lub_margin_value value=$val->getMarginValue()} = Rp {php}
		bcscale(2); $lub_profit =
		bcmul($this->_tpl_vars['v'],($this->_tpl_vars['lub_margin_value']));
		$lub_value = array_merge($lub_value, array($lub_profit)); echo
		number_format(($lub_profit * 0.01), 2, ',','.'); {/php} {/if}
		{/foreach} {/if} {/if} {/foreach} {/if}</td>
	</tr>
	{/section} {/if}

	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>

	<tr class="title">
		<td>Margin Profit {$actual_date}</td>
		<td align="right">= Rp {php} bcscale(2); $profit_array =
		array_merge($lub_value, $gas_value); $total_profit = 0;
		foreach($profit_array as $key => $value) { $total_profit =
		bcadd($total_profit,$value); } $margin_profit = ($total_profit *
		0.01); echo number_format($margin_profit, 2, ',','.'); {/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<!-- overhead cost -->
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	{php} $ovh = 0;{/php}
	<tr>
		<td colspan="2">Biaya Overhead {$actual_date} : {if
		!empty($overhead_cost_list)} <font class="small-font">
		<ul>
			{section name=c loop=$overhead_cost_list} {assign var=overhead_value
			value=$overhead_cost_list[c]->getOvhValue()}
			<li>{$overhead_cost_list[c]->getOvhDesc()} tgl
			{$overhead_cost_list[c]->getOvhDate()} = Rp
			{$overhead_cost_list[c]->getOvhValue()}</li>
			{php} $ovh = bcadd($ovh,$this->_tpl_vars['overhead_value']); {/php}
			{/section}
		</ul>
		</font> {/if}</td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Total Biaya Overhead {$actual_date}</td>
		<td align="right">= Rp {php} echo number_format($ovh, 2,
		',','.');{/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
</table>
<!-- net profit -->
<table border="0" cellspacing="0" cellpadding="0" id="net-profit">
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr class="title">
		<td>Gross Profit {$actual_date}</td>
		<td align="right">= Rp {php} bcscale(2); $gross_profit =
		bcsub($margin_profit,$this->_tpl_vars['total_ownuse_sales']);
		$gross_profit = bcsub($gross_profit, $ovh); echo
		number_format($gross_profit, 2, ',','.'); {/php}</td>
	</tr>
	<tr>
		<td colspan="2" id="horizontal-line"><img src="images/dot.gif" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" align="right" id="display-detail"><a
			href="javascript:void(0)"
			onclick="displayDiv('sales-report', 'net-profit', true);">Detail</a><img
			src="images/dot.gif" border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" id="vertical-spacer"><img src="images/dot.gif"
			border="0" /></td>
	</tr>
</table>
