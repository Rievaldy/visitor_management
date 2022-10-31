//[Dashboard Javascript]

//Project:	UltimatePro Admin - Responsive Admin Template
//Primary use:   Used only for the main dashboard (index.html)


$(function () {

  'use strict';


	
	
	
		
		$("#linearea").sparkline([32,24,26,24,32,26,40,34,22,24], {
			type: 'line',
			width: '100%',
			height: '100',
			lineColor: '#17b3a3',
			fillColor: '#17b3a3',
			lineWidth: 2,
		});
	
		
		$("#lineToday").sparkline([32,24,26,24,32,26,40,34,22,24], {
			type: 'line',
			width: '100%',
			height: '85',
			lineColor: '#ffffff',
			fillColor: 'rgba(255, 255, 255, 0)',
			lineWidth: 2,
			spotRadius: 3,
		});
	//***************************
       // Stacked Area chart
       //***************************
        var stackedbarcolumnChart = echarts.init(document.getElementById('stacked-column'));
        var option = {
            
             // Setup grid
                grid: {
                    x: 40,
                    x2: 40,
                    y: 45,
                    y2: 25
                },

                // Add tooltip
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // Axis indicator axis trigger effective
                        type : 'shadow'        // The default is a straight line, optionally: 'line' | 'shadow'
                    }
                },

                // Add custom colors
                color: ['#17b3a3', '#0bb2d4', '#3e8ef7', '#faa700', '#ff4c52'],

                // Enable drag recalculate
                calculable: true,

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                }],

                // Add series
                series : [
                    
                    {
                        name:'Data1',
                        type:'bar',
                        stack: 'data1',
                        data:[178, 241, 210, 147, 299, 358, 487]
                    },
                    {
                        name:'Data2',
                        type:'bar',
                        data:[875, 845, 985, 1254, 1425, 1235, 1425],
                        markLine : {
                            itemStyle:{
                                normal:{
                                    lineStyle:{
                                        type: 'dashed'
                                    }
                                }
                            },
                            data : [
                                [{type : 'min'}, {type : 'max'}]
                            ]
                        }
                    },
                    {
                        name:'Data3',
                        type:'bar',
                        barWidth : 12,
                        stack: 'data',
                        data:[654, 758, 754, 854, 1245, 1100, 1140]
                    },
                    {
                        name:'Data4',
                        type:'bar',
                        stack: 'data',
                        data:[104, 134, 125, 158, 245, 236, 278]
                    },
                    {
                        name:'Data5',
                        type:'bar',
                        stack: 'data',
                        data:[54, 123, 147, 85, 165, 158, 123]
                    },
                    {
                        name:'Data6',
                        type:'bar',
                        stack: 'data',
                        data:[21, 84, 79, 86, 135, 158, 210]
                    }
                ]
                // Add series
                
        };
        stackedbarcolumnChart.setOption(option);
	
	
/*****E-Charts function start*****/
		
	if( $('#e_chart_3').length > 0 ){
		var eChart_3 = echarts.init(document.getElementById('e_chart_3'));
		var data = [{
			value: 5713,
			name: ''
		}, {
			value: 8458,
			name: ''
		}, {
			value: 1254,
			name: ''
		}, {
			value: 2589,
			name: ''
		}, {
			value: 7458,
			name: ''
		}, {
			value: 6325,
			name: ''
		}, {
			value: 8452,
			name: ''
		}, {
			value: 9563,
			name: ''
		}, {
			value: 1125,
			name: ''
		}, {
			value: 8546,
			name: ''
		}];
		var option3 = {
			tooltip: {
				show: true,
				trigger: 'item',
				backgroundColor: 'rgba(33,33,33,1)',
				borderRadius:0,
				padding:10,
				formatter: "{b}: {c} ({d}%)",
				textStyle: {
					color: '#fff',
					fontStyle: 'normal',
					fontWeight: 'normal',
					fontFamily: "'Open Sans', sans-serif",
					fontSize: 12
				}	
			},
			series: [{
				type: 'pie',
				selectedMode: 'single',
				radius: ['100%', '30%'],
				color: ['#7460ee', '#e4eaec', '#26c6da', '#1e88e5', '#ffb22b', '#fc4b6c', '#7231F5', '#E6155E', '#fcc525', '#6B534C'],
				labelLine: {
					normal: {
						show: false
					}
				},
				data: data
			}]
		};
		eChart_3.setOption(option3);
		eChart_3.resize();
	}

/*****E-Charts function end*****/	
// table
	$('#invoice-list').DataTable({
	  'paging'      : true,
	  'lengthChange': false,
	  'searching'   : false,
	  'ordering'    : true,
	  'info'        : true,
	  'autoWidth'   : true,
	});	
	

	
	
	// ------------------------------
    // Basic pie chart
    // ------------------------------
    // based on prepared DOM, initialize echarts instance
        var basicpieChart = echarts.init(document.getElementById('basic-pie'));
        var option = {
            // Add title
                title: {
                    text: 'Top 10 Products Sale',
                    subtext: 'In This Month',
                    x: 'center'
                },

                // Add tooltip
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },

                // Add legend
                legend: {
                    orient: 'vertical',
                    x: 'left',
                    data: ['iPhone X', 'Mi tv4 55', 'S9 plus', 'Pixal 2', 'Macbook Air', 'iPhone 8 plus', ' Mi Note 7', 'Lg G9', 'iMac 21', 'Google Home']
                },

                // Add custom colors
                color: ['#0bb2d4', '#17b3a3', '#3e8ef7', '#faa700', '#ff4c52'],

                // Display toolbox
                toolbox: {
                    show: true,
                    orient: 'vertical',
                    feature: {
                        mark: {
                            show: true,
                            title: {
                                mark: 'Markline switch',
                                markUndo: 'Undo markline',
                                markClear: 'Clear markline'
                            }
                        },
                        dataView: {
                            show: true,
                            readOnly: false,
                            title: 'View data',
                            lang: ['View chart data', 'Close', 'Update']
                        },
                        magicType: {
                            show: true,
                            title: {
                                pie: 'Switch to pies',
                                funnel: 'Switch to funnel',
                            },
                            type: ['pie', 'funnel'],
                            option: {
                                funnel: {
                                    x: '25%',
                                    y: '20%',
                                    width: '50%',
                                    height: '70%',
                                    funnelAlign: 'left',
                                    max: 1548
                                }
                            }
                        },
                        restore: {
                            show: true,
                            title: 'Restore'
                        },
                        saveAsImage: {
                            show: true,
                            title: 'Same as image',
                            lang: ['Save']
                        }
                    }
                },

                // Enable drag recalculate
                calculable: true,

                // Add series
                series: [{
                    name: 'Top Sales',
                    type: 'pie',
                    radius: '70%',
                    center: ['50%', '57.5%'],
                    data: [
                        {value: 335, name: 'iPhone X'},
                        {value: 310, name: 'Mi tv4 55'},
                        {value: 234, name: 'S9 plus'},
                        {value: 135, name: 'Pixal 2'},
                        {value: 1548, name: 'Macbook Air'},
                        {value: 1548, name: 'iPhone 8 plus'},
                        {value: 1548, name: 'Mi Note 7'},
                        {value: 1548, name: 'Lg G9'},
                        {value: 1548, name: 'iMac 21'},
                        {value: 1548, name: 'Google Home'}
                    ]
                }]
        };
    
        basicpieChart.setOption(option);
	



//dashboard_daterangepicker
	
	if(0!==$("#dashboard_daterangepicker").length) {
		var n=$("#dashboard_daterangepicker"),
		e=moment(),
		t=moment();
		n.daterangepicker( {
			startDate:e, endDate:t, opens:"left", ranges: {
				Today: [moment(), moment()], Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")], "Last 7 Days": [moment().subtract(6, "days"), moment()], "Last 30 Days": [moment().subtract(29, "days"), moment()], "This Month": [moment().startOf("month"), moment().endOf("month")], "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
			}
		}
		, a),
		a(e, t, "")
	}
	function a(e, t, a) {
		var r="",
		o="";
		t-e<100||"Today"==a?(r="Today:", o=e.format("MMM D")): "Yesterday"==a?(r="Yesterday:", o=e.format("MMM D")): o=e.format("MMM D")+" - "+t.format("MMM D"), n.find(".subheader_daterange-date").html(o), n.find(".subheader_daterange-title").html(r)
	}
	
	
}); // End of use strict

		
// easypie chart
	$(function() {
		'use strict'
		$('.easypie').easyPieChart({
			easing: 'easeOutBounce',
			onStep: function(from, to, percent) {
				$(this.el).find('.percent').text(Math.round(percent));
			}
		});
		var chart = window.chart = $('.easypie').data('easyPieChart');
		$('.js_update').on('click', function() {
			chart.update(Math.random()*200-100);
		});
	});// End of use strict


                


