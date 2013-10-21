function sortTable(tableId, cellId) {
	var table = new TableKit(tableId, {editable:false, resizable:false});
	table.sort(cellId, -1) // sort a particular column      
}
