/*Dashboard Init*/
"use strict"; 
/*DataTable Init*/
if ($("#datable_1").length > 0) {
	/*Checkbox Add*/
	var tdCnt=0;
	$('table tr').each(function(){
		$('<span class="form-check mb-0"><input type="checkbox" class="form-check-input check-select" id="chk_sel_'+tdCnt+'"><label class="form-check-label" for="chk_sel_'+tdCnt+'"></label></span>').appendTo($(this).find("td:first-child"));
		tdCnt++;
	});
	var targetDt = $('#datable_1').DataTable({
		"dom": '<"row"<"col-7 mb-3"<"contact-toolbar-left">><"col-5 mb-3"<"contact-toolbar-right"f>>><"row"<"col-sm-12"t>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
		"ordering": true,
		"columnDefs": [ {
			"searchable": false,
			"orderable": false,
			"targets": [0,5]
		} ],
    pagingType: 'simple_numbers',
		"order": [1, 'asc' ],
		language: { search: "",
			searchPlaceholder: "Search",
			"info": "_START_ - _END_ of _TOTAL_",
			sLengthMenu: "View  _MENU_",
			paginate: {
			  next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
			  previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
			}
		},
		"drawCallback": function () {
      $('#datable_1_wrapper').find('.pagination').addClass('custom-pagination pagination-simple justify-content-end');
    }
  });
  $('.pagination').addClass('custom-pagination pagination-simple justify-content-end');
	$(document).on( 'click', '.del-button', function () {
		targetDt.row('.selected').remove().draw( false );
		return false;
	});
	$("div.contact-toolbar-left").html('<div class="d-xxl-flex d-none align-items-center"><div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example"><button type="button" class="btn btn-outline-light active">View all</button><button type="button" class="btn btn-outline-light">Monitored</button><button type="button" class="btn btn-outline-light">Unmonitored</button></div>');
	$("div.contact-toolbar-right").addClass('d-flex justify-content-end').append('	<button class="btn btn-sm btn-outline-light ms-3"><span><span class="icon"><i class="bi bi-filter"></i></span><span class="btn-text">Filters</span></span></button>');
	$("#datable_1").parent().addClass('table-responsive');
	
	/*Select all using checkbox*/
	var  DT1 = $('#datable_1').DataTable();
	$(".check-select-all").on( "click", function(e) {
		$('.check-select').attr('checked', true);
		if ($(this).is( ":checked" )) {
			DT1.rows().select();    
			$('.check-select').prop('checked', true);			
		} else {
			DT1.rows().deselect(); 
			$('.check-select').prop('checked', false);
		}
	});
	$(".check-select").on( "click", function(e) {
		if ($(this).is( ":checked" )) {
			$(this).closest('tr').addClass('selected');        
		} else {
			$(this).closest('tr').removeClass('selected');
			$('.check-select-all').prop('checked', false);
		}
	});
}

/*Apex Column Chart*/
window.Apex = {
	chart: {
		foreColor: "#646A71",
		fontFamily: 'DM Sans',
		toolbar: {
			tools: {
				download: '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>',
				selection: '<img src="/static/icons/reset.png" width="20">',
				zoom: '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>',
				zoomin: '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>',
				zoomout: '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg>',
				pan: '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="5 9 2 12 5 15"></polyline><polyline points="9 5 12 2 15 5"></polyline><polyline points="15 19 12 22 9 19"></polyline><polyline points="19 9 22 12 19 15"></polyline><line x1="2" y1="12" x2="22" y2="12"></line><line x1="12" y1="2" x2="12" y2="22"></line></svg>',
				reset: '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
			}
		}
	},
	grid: {
		borderColor: '#F4F5F6',
	},
	xaxis: {
		labels: {
			style: {
				fontSize: '12px',
				fontFamily: 'inherit',
			},
		},
		axisBorder: {
			show: false,
		},
		title: {
			style: {
				fontSize: '12px',
				fontFamily: 'inherit',
			}
		}
	},
	yaxis: {
		labels: {
			style: {
				fontSize: '12px',
				fontFamily: 'inherit',
			},
		},
		title: {
			style: {
				fontSize: '12px',
				fontFamily: 'inherit',
			}
		},
	},
};
/*Stacked Column*/
var options1 = {
	series: [{
		name: 'PRODUCT A',
		data: [44, 55, 41, 67, 22, 43,44, 55, 41, 67, 22, 43]
	}, {
		name: 'PRODUCT B',
		data: [13, 23, 20, 8, 13, 27,13, 23, 20, 8, 13, 27]
	}, {
		name: 'PRODUCT C',
		data: [11, 17, 15, 15, 21, 14,11, 17, 15, 15, 21, 14]
	}],
	chart: {
		type: 'bar',
		height: 250,
		stacked: true,
		toolbar: {
			show: false
		},
		zoom: {
			enabled: false
		},
	},
	
	plotOptions: {
		bar: {
			horizontal: false,
			columnWidth: '35%',
			borderRadius: 5,
			
		},
	},
	xaxis: {
		type: 'datetime',
		categories: ['01/02/2021 GMT', '01/03/2021 GMT', '01/04/2021 GMT',
			'01/05/2021 GMT', '01/06/2021 GMT','01/07/2021 GMT', '01/08/2021 GMT', '01/09/2021 GMT', '01/10/2021 GMT',
			'01/11/2021 GMT', '01/12/2021 GMT','01/13/2021 GMT'
		],
	},
	legend: {
		show:false
	},
	colors: ['#007D88', '#25cba1', '#ebf3fe'],
	fill: {
		opacity: 1
	},
	dataLabels: {
		enabled: false,
	}
};
var chart1 = new ApexCharts(document.querySelector("#column_chart_2"), options1);
chart1.render();


/*Multiple Chart*/
var options2 = {
	series: [80, 75],
	stroke: {
		lineCap: 'round'
	},
	chart: {
		height: 255,
		type: 'radialBar',
	},
	plotOptions: {
		radialBar: {
			hollow: {
				margin: 0,
				size: "55%",
			},
			dataLabels: {
				showOn: "always",
				name: {
					show: false,
				},
				value: {
					fontSize: "1.75rem",
					show: true,
					fontWeight: '500'
				}	,
				total: {
					show: true,
					formatter: function () {
						return [('$2249')];
					}
				}
			  }
		}
	},
	colors: ['#007D88', '#25cba1'],
	labels: ['Subscriptions', 'Food'],
};

var chart2 = new ApexCharts(document.querySelector("#radial_chart_2"), options2);
chart2.render();

/*Animated Map*/

var root = am5.Root.new("anim_map_2", am5map.MapChart);
    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
     root.setThemes([am5themes_Animated.new(root)]);

    // Create the map chart
    // https://www.amcharts.com/docs/v5/charts/map-chart/
    var chart = root.container.children.push(
      am5map.MapChart.new(root, {
        panX: "rotateX",
        projection: am5map.geoEquirectangular()
      })
    );

    var cont = chart.children.push(
      am5.Container.new(root, {
        layout: root.horizontalLayout,
        x: 20,
        y: 40
      })
    );

    // Create series for background fill
    // https://www.amcharts.com/docs/v5/charts/map-chart/map-polygon-series/#Background_polygon
    var backgroundSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {}));
    backgroundSeries.mapPolygons.template.setAll({
      fill: am5.color(0xE6E9EB),
      fillOpacity: 0,
      strokeOpacity: 0
    });

    // Add background polygon
    // https://www.amcharts.com/docs/v5/charts/map-chart/map-polygon-series/#Background_polygon
    // backgroundSeries.data.push({
    //     geometry: am5map.getGeoRectangle(90, 180, -90, -180)
    // });

    // Create main polygon series for countries
    // https://www.amcharts.com/docs/v5/charts/map-chart/map-polygon-series/
    var polygonSeries = chart.series.push(
      am5map.MapPolygonSeries.new(root, {
        geoJSON: am5geodata_worldLow,
        exclude: ["AQ"],
        fill: am5.color(0xE6E9EB), //Map background color

      })
    );

    polygonSeries.mapPolygons.template.setAll({
      tooltipText: "{name}",
      templateField: "polygonSettings"
    });

    polygonSeries.mapPolygons.template.states.create("hover", {
      fill: am5.color(0xCCE5E7)
    });


    // Create line series for trajectory lines
    // https://www.amcharts.com/docs/v5/charts/map-chart/map-line-series/
    var lineSeries = chart.series.push(am5map.MapLineSeries.new(root, {}));
    lineSeries.mapLines.template.setAll({
      stroke: am5.color(0xE6E9EB),
      strokeOpacity: 0.3
    });

    // Create point series for markers
    // https://www.amcharts.com/docs/v5/charts/map-chart/map-point-series/
    var pointSeries = chart.series.push(am5map.MapPointSeries.new(root, {}));

    pointSeries.bullets.push(function () {
      var container = am5.Container.new(root, {
        tooltipText: "{title}",
        cursorOverStyle: "pointer",
      });

      container.events.on("click", (e) => {
        window.location.href = e.target.dataItem.dataContext.url;
      });

      var circle = container.children.push(
        am5.Circle.new(root, {
          radius: 3,
          tooltipY: 0,
          fill: am5.color(0x007D88),
          strokeOpacity: 0
        })
      );


      var circle2 = container.children.push(
        am5.Circle.new(root, {
          radius: 3,
          tooltipY: 0,
          fill: am5.color(0x007D88),
          strokeOpacity: 0,
          tooltipText: "{title}"
        })
      );

      circle.animate({
        key: "scale",
        from: 1,
        to: 5,
        duration: 1000,
        easing: am5.ease.out(am5.ease.cubic),
        loops: Infinity
      });
      circle.animate({
        key: "opacity",
        from: 1,
        to: 0,
        duration: 1000,
        easing: am5.ease.out(am5.ease.cubic),
        loops: Infinity
      });

      return am5.Bullet.new(root, {
        sprite: container
      });
    });

    var cities = [
      {
        title: "Brussels",
        latitude: 50.8371,
        longitude: 4.3676,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Copenhagen",
        latitude: 55.6763,
        longitude: 12.5681,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Paris",
        latitude: 48.8567,
        longitude: 2.351,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Reykjavik",
        latitude: 64.1353,
        longitude: -21.8952,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Moscow",
        latitude: 55.7558,
        longitude: 37.6176,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Madrid",
        latitude: 40.4167,
        longitude: -3.7033,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "London",
        latitude: 51.5002,
        longitude: -0.1262,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Peking",
        latitude: 39.9056,
        longitude: 116.3958,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "New Delhi",
        latitude: 28.6353,
        longitude: 77.225,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Tokyo",
        latitude: 35.6785,
        longitude: 139.6823,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Ankara",
        latitude: 39.9439,
        longitude: 32.856,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Buenos Aires",
        latitude: -34.6118,
        longitude: -58.4173,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Brasilia",
        latitude: -15.7801,
        longitude: -47.9292,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Ottawa",
        latitude: 45.4235,
        longitude: -75.6979,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Washington",
        latitude: 38.8921,
        longitude: -77.0241,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Kinshasa",
        latitude: -4.3369,
        longitude: 15.3271,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Cairo",
        latitude: 30.0571,
        longitude: 31.2272,
        url: "http://www.amcharts.com",
        color: '#007D88'
      },
      {
        title: "Pretoria",
        latitude: -25.7463,
        longitude: 28.1876,
        url: "http://www.amcharts.com",
        color: '#007D88'
      }
    ];

    for (var i = 0; i < cities.length; i++) {
      var city = cities[i];
      addCity(city.longitude, city.latitude, city.title, city.url);
    }

    function addCity(longitude, latitude, title, url) {
      pointSeries.data.push({
        url: url,
        geometry: { type: "Point", coordinates: [longitude, latitude] },
        title: title
      });
    }

    // Make stuff animate on load
    chart.appear(1000, 100);

  