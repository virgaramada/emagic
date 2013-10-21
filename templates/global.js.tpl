{if !empty($smarty.session.user_role)}
<script type="text/javascript">
{if !empty($inv_all_price_list)}
	var customerTypes = new Array();
	{if !empty($cust_types)}
	     customerTypes = new Array(
	     {section name=t loop=$cust_types}
	            '{$cust_types[t]->getCustomerType()}|{$cust_types[t]->getCategory()}'
	            {if $smarty.section.t.index < ($smarty.section.t.total - 1)},{/if}
	     {/section}
	     );
	{/if}
	function selectOwnUse() {ldelim}
	       if (document.inventory_output_form) {ldelim}
	             var ii = document.inventory_output_form.customer_type.options.selectedIndex;
	             var jj = 0;
	             var pp = 0;
	             for(pp = 0; pp < customerTypes.length; pp++) {ldelim}
		             if (document.inventory_output_form.customer_type.options[ii].value == customerTypes[pp].split('|')[0]) {ldelim}
		                ownUse = customerTypes[pp].split('|')[1];
		                if (document.getElementById("own-use")) {ldelim}
			                if (ownUse == 'OWN_USE') {ldelim}
			                   document.getElementById("own-use").innerHTML = 'Own Use';
			                {rdelim}
			                else if (ownUse == 'SALES') {ldelim}
			                    document.getElementById("own-use").innerHTML = 'Penjualan';
			                {rdelim}
			                 else if (ownUse == 'LOSS') {ldelim}
			                    document.getElementById("own-use").innerHTML = 'Losses';
			                {rdelim}
	                    {rdelim}
	                    if (document.getElementById("own-use-value")) {ldelim}
	                        document.getElementById("own-use-value").value = ownUse;
	                     {rdelim}
		             {rdelim}
	             {rdelim}
	       {rdelim}
	{rdelim}
	
	var unitPrices = new Array(
	{section name=c loop=$inv_all_price_list}
	       '{$inv_all_price_list[c]->getUnitPrice()}'
        {if $smarty.section.c.index < ($smarty.section.c.total - 1)},{/if}
	{/section} );
	var invTypes = new Array(
	{section name=d loop=$inv_all_price_list}
	       '{$inv_all_price_list[d]->getInvType()}|{$inv_all_price_list[d]->getCategory()}'
        {if $smarty.section.d.index < ($smarty.section.d.total - 1)},{/if}
	{/section} );
		
	function getUnitPrice() {ldelim}
		var ii = document.inventory_output_form.inventory_type.options.selectedIndex;
	    var index;
	    var invType = document.inventory_output_form.inventory_type.options[ii].value;
	    var i;
	    var unitPrice;
	    var selectedOwnUse;
	    if (document.getElementById("own-use-value")) {ldelim}
	        selectedOwnUse = document.getElementById("own-use-value").value;
	     {rdelim}
	    for (i=0;i<invTypes.length;i++) {ldelim}
	        if (invTypes[i] == invType + '|' + selectedOwnUse) {ldelim}
	            index = i;
	        {rdelim}
	    {rdelim}
	    if (typeof(index) == 'undefined') {ldelim}
	         index = 0;
	    {rdelim}
	    unitPrice = unitPrices[index];
	    document.getElementById("unit-price").innerHTML = "Rp " + unitPrice;
	    if (document.getElementById("unit-price-value")) {ldelim}
	        document.getElementById("unit-price-value").value = unitPrice;
	   {rdelim}
	{rdelim}
	selectOwnUse();
	getUnitPrice();

{/if} 
{if !empty($inv_types)}
  var inv_types = new Array(
         {section name=c loop=$inv_types}
          '{$inv_types[c]->getInvType()}|{$inv_types[c]->getProductType()}'
            {if $smarty.section.c.index < ($smarty.section.c.total - 1)},{/if}
         {/section});
     
  function displaySupplyUnit() {ldelim}
      if (document.inventory_supply_form != null) {ldelim}
	      var ii = document.inventory_supply_form.inventory_type.options.selectedIndex;
	      var pp = 0;
	      var productType = '';
	      for(pp = 0; pp < inv_types.length; pp++) {ldelim}
	           if (document.getElementById("inv_unit") ) {ldelim}
	             if (document.inventory_supply_form.inventory_type.options[ii].value == inv_types[pp].split('|')[0]) {ldelim}
	                 productType = inv_types[pp].split('|')[1];
	                 if(productType == 'BBM') {ldelim}
	                    document.getElementById("inv_unit").innerHTML = 'Liter';
	                 {rdelim} else {ldelim}
	                    document.getElementById("inv_unit").innerHTML = 'Unit';
	                 {rdelim}
	             {rdelim}
	           {rdelim}
	      {rdelim} 
      {rdelim}
      displaySupplyType();
  {rdelim}
  
  function displaySupplyType() {ldelim}
    if (document.inventory_supply_form != null) {ldelim}
      var ii = document.inventory_supply_form.inventory_type.options.selectedIndex;
      var pp = 0;
      var productType = '';
      for(pp = 0; pp < inv_types.length; pp++) {ldelim}
           if (document.getElementById("supply_inv_type") ) {ldelim}
             if (document.inventory_supply_form.inventory_type.options[ii].value == inv_types[pp].split('|')[0] ) {ldelim}
                 productType = inv_types[pp].split('|')[1];
                 if(productType == 'BBM') {ldelim}
                    document.getElementById("supply_inv_type").innerHTML = 'BBM';
                 {rdelim} else {ldelim}
                    document.getElementById("supply_inv_type").innerHTML = 'Pelumas';
                 {rdelim}
             {rdelim}
           {rdelim}
      {rdelim}
    {rdelim} 
  {rdelim}
  displaySupplyUnit();
{/if}

var distLocations = new Array();
{if !empty($dist_locations)}
     distLocations = new Array(
     {section name=t loop=$dist_locations}
            '{$dist_locations[t]->getSupplyPoint()}|{$dist_locations[t]->getSalesAreaManager()}'
            {if $smarty.section.t.index < ($smarty.section.t.total - 1)},{/if}
     {/section}
     );
{/if}

{if !empty($avg_prices)}
     var averagePrices = new Array(
     {foreach from=$avg_prices key=k item=v name=avg} 
            '{$k}|{$v}'
            {if $smarty.foreach.avg.index < ($smarty.foreach.avg.total - 1)},{/if}
     {/foreach}
     );
     
     function displayAveragePrice() {ldelim}
          if (document.station_monitor_form != null) {ldelim}
              var ii = document.station_monitor_form.inventory_type.options.selectedIndex;
		      var pp = 0;
		      for(pp = 0; pp < averagePrices.length; pp++) {ldelim}
		           if (document.getElementById("average_price") ) {ldelim}
		             if (document.station_monitor_form.inventory_type.options[ii].value == averagePrices[pp].split('|')[0]) {ldelim}
		                 document.getElementById("average_price").innerHTML = "Rp " + averagePrices[pp].split('|')[1];
		             {rdelim}
		           {rdelim}
		      {rdelim}           
		  {rdelim} 
     {rdelim}
     displayAveragePrice();
{/if}

function displaySupplyPoint() {ldelim}
         if (document.station_monitor_form != null) {ldelim}
            for (var ii =0; ii < document.station_monitor_form.dist_loc_id.length; ii ++ ) {ldelim}
                 if (document.station_monitor_form.dist_loc_id[ii].checked) {ldelim}
                     document.getElementById("supply_point").innerHTML = distLocations[ii].split('|')[0];
                     document.getElementById("sales_area_manager").innerHTML = distLocations[ii].split('|')[1];
                 {rdelim}
            {rdelim}                     
		{rdelim} 
		 else if (document.depot_monitor_form != null) {ldelim}
            for (var ii =0; ii < document.depot_monitor_form.dist_loc_id.length; ii ++ ) {ldelim}
                 if (document.depot_monitor_form.dist_loc_id[ii].checked) {ldelim}
                     document.getElementById("supply_point").innerHTML = distLocations[ii].split('|')[0];
                     document.getElementById("sales_area_manager").innerHTML = distLocations[ii].split('|')[1];
                 {rdelim}
            {rdelim}                     
		{rdelim} 
{rdelim}
displaySupplyPoint();
</script>
{/if}