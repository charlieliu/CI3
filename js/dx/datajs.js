var dataSource = [
	{ argument : '1', value1 : 1120.92, value2 : 1.358, value3 : 160.297, value4 : 125.1, value5 : 170 },
	{ argument : 'q', value1 : 1221.87, value2 : 0.116, value3 : 155.109, value4 : 125.2, value5 : 155 },
	{ argument : 'a', value1 : 1322.16, value2 : 1.279, value3 : 145.239, value4 : 125.3, value5 : 135 },
	{ argument : 'z', value1 : 1420.50, value2 : 0.128, value3 : 135.547, value4 : 125.4, value5 : 135 },
	{ argument : '2', value1 : 1524.04, value2 : 15.93, value3 : 125.668, value4 : 125.5, value5 : 195 },
	{ argument : 'w', value1 : 1625.33, value2 : 0.304, value3 : 115.785, value4 : 125.6, value5 : 165 },
	{ argument : 's', value1 : 1210.92, value2 : 1.358, value3 : 160.297, value4 : 125.1, value5 : 170 },
	{ argument : 'x', value1 : 1212.87, value2 : 0.116, value3 : 155.109, value4 : 125.2, value5 : 155 },
	{ argument : '3', value1 : 1232.16, value2 : 1.279, value3 : 145.239, value4 : 125.3, value5 : 135 },
	{ argument : 'e', value1 : 1240.50, value2 : 0.128, value3 : 135.547, value4 : 125.4, value5 : 135 },
	{ argument : 'd', value1 : 1254.04, value2 : 15.93, value3 : 125.668, value4 : 125.5, value5 : 195 },
	{ argument : 'c', value1 : 1652.33, value2 : 0.304, value3 : 115.785, value4 : 125.6, value5 : 165 }
];

var columns = [
	{ dataField: 'argument', caption: 'Arg.', dataType: 'string', },
	'value1',
	{ dataField: 'value1', caption: 'currency', dataType: 'number', format: 'currency', },
	'value2',
	{ dataField: 'value2', caption: 'percent', dataType: 'number', format: 'percent' },
	'value3',
	{ dataField: 'value3', caption: 'fixedPoint', dataType: 'number', format: 'fixedPoint', precision: 2 },
	'value4',
	{ dataField: 'value4', caption: 'decimal', dataType: 'number', format: 'decimal', },
	'value5',
	{
		dataField: 'value5',
		caption: 'customizeText',
		// dataType: 'number',
		// format: 'currency',
		// customizeText: function (cellInfo) {
		// 	return cellInfo.value;
		// }
	},
];

var totalItems = [
	{ column: 'argument', summaryType: 'count', },
	{ column: 'currency', summaryType: 'sum', valueFormat: 'currency' },
	{ column: 'percent', summaryType: 'min', valueFormat: 'percent' },
	{ column: 'fixedPoint', summaryType: 'max', valueFormat: 'fixedPoint', precision: 4 },
	{ column: 'decimal', summaryType: 'avg', valueFormat: 'decimal' },
];
$(document).ready(function(){
	$('#gridContainer').dxDataGrid({
		// data
		dataSource: dataSource,
		// display columns
		columns: columns,
		// auto width
		columnAutoWidth: true,
		// set page size / Index
		paging: {
			pageSize: 10,
			pageIndex: 0
		},
		// data sort
		sorting: {
			mode: 'multiple'
		},
		// column resize
		allowColumnResizing: true,
		// move column
		allowColumnReordering: true,
		// column search
		filterRow: {
			visible: true
		},
		// group data
		groupPanel: {
			visible: true
		},
		// data summary
		summary: {
			totalItems: totalItems
		}
	});
})