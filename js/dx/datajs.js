var dataSource = [
	{ argument : '1', value1 : 7112092358160.297125, value2 : 0.155, value3 : 'A', value4 : '2016-01-01 01:01:01:000', value5 : true },
	{ argument : 'q', value1 : 5121162151255.187109, value2 : 0.195, value3 : 'A', value4 : '2016-02-02 01:01:01:001', value5 : false },
	{ argument : 'a', value1 : 3132125214529.161279, value2 : 0.165, value3 : 'A', value4 : '2016-03-01 02:01:01:002', value5 : true },
	{ argument : 'z', value1 : 3142013512513.454750, value2 : 0.128, value3 : 'A', value4 : '2016-04-01 01:02:01:003', value5 : false },
	{ argument : '2', value1 : 9152412512195.566804, value2 : 15.93, value3 : 'A', value4 : '2016-05-01 01:01:02:004', value5 : true },
	{ argument : 'w', value1 : 6162511512165.678533, value2 : 0.304, value3 : 'B', value4 : '2016-06-01 01:03:01:005', value5 : false },
	{ argument : 's', value1 : 821016012517.129792, value2 : 1.358, value3 : 'A', value4 : '2016-07-01 03:01:01:006', value5 : false },
	{ argument : 'x', value1 : 121215521555.210987, value2 : 0.116, value3 : 'A', value4 : '2016-08-03 01:01:01:007', value5 : true },
	{ argument : '3', value1 : 7123214512535.323916, value2 : 1.279, value3 : 'B', value4 : '2016-09-01 01:01:01:008', value5 : false },
	{ argument : 'e', value1 : 124013512535.500000, value2 : 0.128, value3 : 'A', value4 : '2016-10-04 01:01:01:009', value5 : true },
	{ argument : 'd', value1 : 725445472525.668040, value2 : 0.930, value3 : 'B', value4 : '2016-11-01 04:01:01:010', value5 : false },
	{ argument : 'c', value1 : 6521451151256.523933, value2 : 0.304, value3 : 'A', value4 : '2016-12-01 01:04:01:012', value5 : true }
];

var columns = [
	{ dataField: 'argument', caption: 'Arg.', dataType: 'string', width: '90px', fixed: true},
	'value1',
	{ dataField: 'value1', dataType: 'boolean', caption: 'value1-boolean', },
	{ dataField: 'value1', dataType: 'string', caption: 'value1-string', width: '200px' },
	{ dataField: 'value1', dataType: 'number', caption: 'value1-number', },
	{ dataField: 'value1', dataType: 'date', caption: 'value1-date', },
	{ dataField: 'value1', dataType: 'number', caption: 'currency', format: 'currency', width: '200px' },
	{ dataField: 'value1', dataType: 'number', caption: 'fixedPoint', format: 'fixedPoint', precision: 8, width: '250px' },
	{ dataField: 'value1', dataType: 'number', caption: 'decimal', format: 'decimal', width: '200px' },
	{ dataField: 'value1', dataType: 'number', caption: 'exponential', format: 'exponential', },
	{ dataField: 'value1', dataType: 'number', caption: 'largeNumber', format: 'largeNumber', },
	{ dataField: 'value1', dataType: 'number', caption: 'thousands', format: 'thousands', },
	{ dataField: 'value1', dataType: 'number', caption: 'millions', format: 'millions', },
	{ dataField: 'value1', dataType: 'number', caption: 'billions', format: 'billions', },
	{ dataField: 'value1', dataType: 'number', caption: 'trillions', format: 'trillions', },
	'value2',
	{ dataField: 'value2', dataType: 'boolean', caption: 'value2-boolean', },
	{ dataField: 'value2', dataType: 'string', caption: 'value2-string', },
	{ dataField: 'value2', dataType: 'number', caption: 'value2-number', },
	{ dataField: 'value2', dataType: 'date', caption: 'value2-date', },
	{ dataField: 'value2', dataType: 'number', caption: 'percent', format: 'percent', width: '150px' },
	'value3',
	{ dataField: 'value3', dataType: 'boolean', caption: 'value3-boolean', },
	{ dataField: 'value3', dataType: 'string', caption: 'value3-string', },
	{ dataField: 'value3', dataType: 'number', caption: 'value3-number', },
	{ dataField: 'value3', dataType: 'date', caption: 'value3-date', },
	'value4',
	{ dataField: 'value4', dataType: 'boolean', caption: 'value4-boolean', },
	{ dataField: 'value4', dataType: 'string', caption: 'value4-string', },
	{ dataField: 'value4', dataType: 'number', caption: 'value4-number', },
	{ dataField: 'value4', dataType: 'date', caption: 'value4-date', },
	{ dataField: 'value4', dataType: 'date', caption: 'longDate', format: 'longDate', },
	{ dataField: 'value4', dataType: 'date', caption: 'longTime', format: 'longTime', },
	{ dataField: 'value4', dataType: 'date', caption: 'monthAndDay', format: 'monthAndDay', },
	{ dataField: 'value4', dataType: 'date', caption: 'monthAndYear', format: 'monthAndYear', },
	{ dataField: 'value4', dataType: 'date', caption: 'quarterAndYear', format: 'quarterAndYear', },
	{ dataField: 'value4', dataType: 'date', caption: 'shortDate', format: 'shortDate', },
	{ dataField: 'value4', dataType: 'date', caption: 'shortTime', format: 'shortTime', },
	{ dataField: 'value4', dataType: 'date', caption: 'millisecond', format: 'millisecond', },
	{ dataField: 'value4', dataType: 'date', caption: 'day', format: 'day', },
	{ dataField: 'value4', dataType: 'date', caption: 'month', format: 'month', },
	{ dataField: 'value4', dataType: 'date', caption: 'quarter', format: 'quarter', },
	{ dataField: 'value4', dataType: 'date', caption: 'year', format: 'year', },
	{ dataField: 'value4', dataType: 'date', caption: 'yyyy/MM/dd HH:mm:ss', format: 'yyyy/MM/dd HH:mm:ss', },
	'value5',
	{ dataField: 'value5', dataType: 'boolean', caption: 'value5-boolean', },
	{ dataField: 'value5', dataType: 'string', caption: 'value5-string', },
	{ dataField: 'value5', dataType: 'number', caption: 'value5-number', },
	{ dataField: 'value5', dataType: 'date', caption: 'value5-date', },
];

var totalItems = [
	{ column: 'argument', summaryType: 'count', },
	{ column: 'currency', valueFormat: 'currency', summaryType: 'sum' },
	{ column: 'currency', valueFormat: 'currency', summaryType: 'min' },
	{ column: 'currency', valueFormat: 'currency', summaryType: 'max' },
	{ column: 'currency', valueFormat: 'currency', summaryType: 'avg' },
	{ column: 'percent', valueFormat: 'percent', summaryType: 'sum' },
	{ column: 'percent', valueFormat: 'percent', summaryType: 'min' },
	{ column: 'percent', valueFormat: 'percent', summaryType: 'max' },
	{ column: 'percent', valueFormat: 'percent', summaryType: 'avg' },
	{ column: 'fixedPoint', valueFormat: 'fixedPoint', summaryType: 'sum', precision: 2 },
	{ column: 'fixedPoint', valueFormat: 'fixedPoint', summaryType: 'min', precision: 2 },
	{ column: 'fixedPoint', valueFormat: 'fixedPoint', summaryType: 'max', precision: 2 },
	{ column: 'fixedPoint', valueFormat: 'fixedPoint', summaryType: 'avg', precision: 2 },
	{ column: 'decimal', valueFormat: 'decimal', summaryType: 'sum' },
	{ column: 'decimal', valueFormat: 'decimal', summaryType: 'min' },
	{ column: 'decimal', valueFormat: 'decimal', summaryType: 'max' },
	{ column: 'decimal', valueFormat: 'decimal', summaryType: 'avg' },
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