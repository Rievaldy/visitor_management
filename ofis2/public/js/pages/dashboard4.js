//[Dashboard Javascript]

//Project:	UltimatePro Admin - Responsive Admin Template
//Primary use:   Used only for the main dashboard (index.html)


$(function () {

  'use strict';


	
		// ------------------------------
    // Nested chart
    // ------------------------------
    // based on prepared DOM, initialize echarts instance
        var nestedChart = echarts.init(document.getElementById('nested-pie'));
        var option = {
            
           tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },

                // Add legend
                legend: {
                    orient: 'vertical',
                    x: 'left',
                    data: ['OPD','ICU','OT','Heart']
                },

                // Add custom colors
                color: ['#0bb2d4', '#ff4c52', '#3e8ef7', '#faa700'],

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
                            type: ['pie', 'funnel']
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
                calculable: false,

                // Add series
                series: [

                    // Inner
                    {
                        name: 'Countries',
                        type: 'pie',
                        selectedMode: 'single',
                        radius: [0, '40%'],

                        // for funnel
                        x: '15%',
                        y: '7.5%',
                        width: '40%',
                        height: '85%',
                        funnelAlign: 'right',
                        max: 1548,

                        itemStyle: {
                            normal: {
                                label: {
                                    position: 'inner'
                                },
                                labelLine: {
                                    show: false
                                }
                            },
                            emphasis: {
                                label: {
                                    show: true
                                }
                            }
                        },

                        data: [
                            {value: 535, name: 'General'},
                            {value: 679, name: 'Emergency'}
                        ]
                    },

                    // Outer
                    {
                        name: 'Countries',
                        type: 'pie',
                        radius: ['60%', '85%'],

                        // for funnel
                        x: '55%',
                        y: '7.5%',
                        width: '35%',
                        height: '85%',
                        funnelAlign: 'left',
                        max: 1048,

                        data: [
                            {value:335, name: 'OPD'},
							{value:310, name: 'ICU'},
							{value:234, name: 'OT'},
							{value:135, name: 'Heart'}
                        ]
                    }
                ]
        };    
       
    
        nestedChart.setOption(option);
	
	
	// Callback that creates and populates a data table, instantiates the stacked column chart, passes in the data and draws it.
    var stackedColumnChart = c3.generate({
        bindto: '#stacked-column',
        size: { height: 400 },
        color: {
            pattern: ['#0bb2d4', '#ff4c52', '#faa700', '#3e8ef7']
        },

        // Create the data table.
        data: {
            columns: [
                ['General', -30, 200, 200, 400, -150, 250],
				['Emergency', 130, 100, -100, 200, -150, 50],
				['OT', -230, 200, 200, -300, 250, 250]
            ],
            type: 'bar',
            groups: [
                ["General", "Emergency"]
            ]
        },
        grid: {
            y: {
                show: true
            }
        },
    });

    // Instantiate and draw our chart, passing in some options.
    setTimeout(function() {
        stackedColumnChart.groups([
            ["data1", "Emergency", "OT"]
        ]);
    }, 1000);

    setTimeout(function() {
        stackedColumnChart.load({
            columns: [
                ['ICU', 100, -50, 150, 200, -300, -100]
            ]
        });
    }, 1500);

    setTimeout(function() {
        stackedColumnChart.groups([
            ["General", "Emergency", "OT", "ICU"]
        ]);
    }, 2000);
	
    

	
		
		$("#linearea").sparkline([2,4,8,6,8,5,6,4,8,6,6,2], {
			type: 'line',
			width: '100%',
			height: '50',
			lineColor: '#0bb2d4',
			fillColor: 'rgba(11, 178, 212, 0.5)',
			lineWidth: 1,
		});
		$("#linearea2").sparkline([2,4,4,6,8,5,6,4,8,6,6,2], {
			type: 'line',
			width: '100%',
			height: '50',
			lineColor: '#faa700',
			fillColor: 'rgba(250, 167, 0, 0.5)',
			lineWidth: 1,
		});
		$("#linearea3").sparkline([2,4,4,6,8,5,6,4,8,6,6,2 ], {
			type: 'line',
			width: '100%',
			height: '55',
			lineColor: '#ff4c52',
			fillColor: 'rgba(255, 76, 82, 0.5)',
			lineWidth: 1,
		});
	
	
	// area chart
 Morris.Area({
        element: 'area-chart3',
        data: [{
                    period: '2013',
                    data1: 0,
                    data2: 0,
                    data3: 0
                }, {
                    period: '2014',
                    data1: 55,
                    data2: 20,
                    data3: 10
                }, {
                    period: '2015',
                    data1: 25,
                    data2: 55,
                    data3: 70
                }, {
                    period: '2016',
                    data1: 65,
                    data2: 17,
                    data3: 12
                }, {
                    period: '2017',
                    data1: 35,
                    data2: 25,
                    data3: 125
                }, {
                    period: '2018',
                    data1: 30,
                    data2: 85,
                    data3: 45
                }, {
                    period: '2019',
                    data1: 15,
                    data2: 15,
                    data3: 15
                }


                ],
                lineColors: ['#17b3a3', '#3e8ef7', '#faa700'],
                xkey: 'period',
                ykeys: ['data1', 'data2', 'data3'],
                labels: ['Data 1', 'Data 2', 'Data 3'],
                pointSize: 0,
                lineWidth: 0,
                resize:true,
                fillOpacity: 0.8,
                behaveLikeLine: true,
                gridLineColor: '#e0e0e0',
                hideHover: 'auto'
        
    });
	
	
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




                


