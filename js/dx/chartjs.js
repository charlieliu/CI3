$(document).ready(function(){
	var dataSource = [
		{ argument : '1', value1 : 120, value2 : 135, value3 : 160, value4 : 125, value5 : 170},
		{ argument : '2', value1 : 121, value2 : 116, value3 : 155, value4 : 125, value5 : 155},
		{ argument : '3', value1 : 122, value2 : 127, value3 : 145, value4 : 125, value5 : 135},
		{ argument : '4', value1 : 120, value2 : 128, value3 : 135, value4 : 125, value5 : 135},
		{ argument : '5', value1 : 124, value2 : 159, value3 : 125, value4 : 125, value5 : 195},
		{ argument : '6', value1 : 125, value2 : 130, value3 : 115, value4 : 125, value5 : 165}
	];

	$('#chartContainer').dxChart({
		dataSource: dataSource,
		commonSeriesSettings: {
			type: 'bar',
			argumentField: 'argument'
		},
		series: [
			{ valueField: 'value1' },
			{ valueField: 'value2' },
			{ valueField: 'value3' },
			{ valueField: 'value4' },
			{ valueField: 'value5', type: 'line', color: 'blue' }
		]
	});
})