@extends('backend.layouts.starter')

@section('title') All Buoys  @endsection
@section('headIncludes')

    <meta name="_token" content="{{csrf_token()}}">
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
    <style type="text/css">
        .axis {
            font: 10px sans-serif;
        }

		.current-month-title {
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }


        .axis path,
        .axis line {
            fill: none;
            stroke: #2c3b41;
            stroke-width: 3px;
            shape-rendering: crispEdges;
        }

        .line {
            fill: none;
            stroke: #6F257F;
            stroke-width: 3px;
        }

        .overlay {
            fill: none;
            pointer-events: all;
        }

        .focus circle {
            fill: #F1F3F3;
            stroke: #6F257F;
            stroke-width: 5px;
        }

        .hover-line {
            stroke: #6F257F;
            stroke-width: 2px;
            stroke-dasharray: 3,3;
        }



		.focus text {
			font-size: 14px;
		}

		.tooltip-custom {
			fill: none;
			stroke: #000 !important;
			border: 2px;
		}

		.tooltip-date, .tooltip-likes{
			font-weight: bold;
		}

		.title {
			font-weight: bold;
			text-decoration: underline;
		}

		.grid .tick {
			stroke: lightgrey;
			opacity: 0.7;
		}
		.grid path {
			stroke-width: 0;
		}
		.grid .tick {
			stroke: lightgrey;
			opacity: 0.1;
		}
		.grid path {
			stroke-width: 0;
		}

    </style>
@endsection

@section('bodyClass')class="hold-transition skin-blue sidebar-mini"@endsection

@section('contentHeader')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Buoy Summary (Ice Thickness)</h1>

        <ol class="breadcrumb">
            <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Buoy Summary</li>
        </ol>



        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title custom-button"><span class="label label-primary">{{ $imei }}</span> Ice Thickness</h3>
						 <a href="{{ url ('email/'. $imei ) }}" class="btn btn-success btn-sm pull-right custom-btn"><i class="fa fa-gear"></i> Check Transmissions</a>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form class="form-inline" action="#">

                            <input type="hidden" name="imei" id="imei" value="{{ $imei }}">
                            <div class="form-group">
                                <label for="month">Year</label>
                                <select class="form-control" id="years" name="years">
                                    <option value='all'>All Year</option>
                                    @for($year = 2019; $year <= date("Y"); $year++)
                                        <option {{ (date("Y") == $year) ? 'selected' : '' }} value='{{ $year }}'>{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group" id="months-block">
                                <label for="month">Month</label>
                                <select class="form-control" id="months" name="months">
                                    @foreach($getMonths as $index => $getMonth)
                                        <option {{ (date("F") === $getMonth) ? 'selected' : ''  }} value="{{ $getMonth }}">{{ $getMonth }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" id="btn-submit" class="btn btn-success">Summary</button>
                        </form>

                        <svg width="1100" height="500"></svg>
						<h4 class="current-month-title" id="current-month-title"></h4>

                        <div class="row">
                            <form class="form-inline" id = "form1" method="">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="latitude">Start Date</label>

                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='text' class="form-control" id= 'datepicker1'/>
                                        <span class="input-group-addon">
                                                 <span class="glyphicon glyphicon-calendar"></span>
                                                 </span>
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="latitude">End Date</label>

                                    <div class='input-group date' id='datetimepicker2'>
                                        <input type='text' class="form-control" id = 'datepicker2'/>
                                        <span class="input-group-addon">
                                                 <span class="glyphicon glyphicon-calendar"></span>
                                                 </span>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="btnSave" class="btn btn-success">Submit</button>
                            </form>
                        </div>



                        <div class="responsive-plot" id='myDiv'><!-- Plotly chart will be drawn inside this DIV --></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
@endsection



@section('content')

@endsection

@section('scriptIncludes')
    <!-- Js -->
    <!-- DataTables -->
    <script src="{{ asset('themes/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('themes/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('themes/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('themes/admin/dist/js/demo.js') }}"></script>
    <script src="{{ asset('themes/admin/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

    <!-- Load in the d3 library -->
    <script src="https://d3js.org/d3.v4.min.js"></script>
    <script src='https://cdn.plot.ly/plotly-latest.min.js'></script>

    <script type="text/javascript">

		//var markers = new Array();
		//markers = '[{"rmcDate":"010320","ice_thickness":64},{"rmcDate":"020320","ice_thickness":68},{"rmcDate":"030320","ice_thickness":68},{"rmcDate":"040320","ice_thickness":72},{"rmcDate":"050320","ice_thickness":76},{"rmcDate":"060320","ice_thickness":80},{"rmcDate":"070320","ice_thickness":80},{"rmcDate":"080320","ice_thickness":80},{"rmcDate":"090320","ice_thickness":80},{"rmcDate":"100320","ice_thickness":80},{"rmcDate":"110320","ice_thickness":64},{"rmcDate":"120320","ice_thickness":76}]'
		//var data = JSON.parse(markers)
		//console.log(data)
		//renderGraph(data)



		var markers = new Array();
		markers = @json($json);
		var data = JSON.parse(markers)
		console.log(data);
		renderGraph(data)
        renderGraph2(data);

        $(function () {
            $('#datetimepicker1').datepicker({
                "autoclose": true,
                });


        });
        $(function () {
            $('#datetimepicker2').datepicker({
                "autoclose": true,
                });
        });
        $('#btnSave').click(function (){

                //console.log($("#datepicker1").val());
                renderGraph3(data,$("#datepicker1").val(),$("#datepicker2").val());

            }
        )


        $(document).ready(function() {
            function getMonthFromString(mon){
                var date = new Date(Date.parse(mon +" 1, 2012")).getMonth()+1
                return date
            }

			var month = $("#months").val()
            var year = $("#years").val()
            $("#current-month-title").html(month + " - " + year)

            // IF ALL SELECT THEN CHANGE THE VALUE OF THE MONTH
            $('#years').on('change', function (e) {
                // toogle display 'months-block'
                if(this.value === 'all'){
                    $("#months-block").hide();
                }else{
                    $("#months-block").show();
                }
            })

            $("#btn-submit").click(function(event) {
                // getting the value
                var tempMonth = $("#months").val()
                var month = getMonthFromString(tempMonth)
                var year = $("#years").val()
                var imei = $("#imei").val()

                $.ajaxSetup({
                    header: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })

                $.ajax({
                    type: 'GET',
                    url: '/buoy/summary/'+ imei.toString() + '/' + month.toString() + '/' + year.toString(),
                    dataType: 'json',
                    success: function (data) {
						$("#current-month-title").html(bottomTitle)
						renderGraph(data)
                        renderGraph2(data)
                    },
                    error: function (data) {
                        var errors = $.parseJSON(data.responseText)

                    }
                })

                event.preventDefault()

            })
        })


		// RENDERING THE GRAPH
		// =============================================
		function renderGraph(data){
			var margin = { top: 30, right: 120, bottom: 30, left: 50 },
			width = 1200 - margin.left - margin.right,
			height = 500 - margin.top - margin.bottom,
			tooltip = { width: 100, height: 100, x: 10, y: -30 };

			var parseDate = d3.timeParse("%Y-%m-%d"),
				bisectDate = d3.bisector(function(d) { return d.rmcDate; }).left,
				formatValue = d3.format(","),
				dateFormatter = d3.timeFormat("%d-%b-%Y");

			var x = d3.scaleTime()
				.range([0, width]);

			var y = d3.scaleLinear()
				.range([height, 0]);

			var xAxis = d3.axisBottom(x)
				.tickFormat(d3.timeFormat("%d-%b"));

			var yAxis = d3.axisLeft(y)




			var line = d3.line()
				.x(function(d) { return x(d.rmcDate); })
				.y(function(d) { return y(d.ice_thickness); });


			var svg = d3.select("svg");
			svg.selectAll("*").remove();

			var svg = d3.select("svg")
				.attr("width", width + margin.left + margin.right)
				.attr("height", height + margin.top + margin.bottom)
				.append("g")
				.attr("transform", "translate(" + margin.left + "," + margin.top + ")");



			// LOOPING THOUGH THE DATA AND FETCH THE INFORMATION FROM THE DATA
			// AND PLOTTING INTO THE GRAPH WITH WITH THE X AXIS AND Y AXIS
			// =======================================================================

			data.forEach(function(d, i) {
				var curr = (d.rmcDate)
				var currDate = curr.toString()
				var modified_date = '20' + currDate.substring(4, 6) + "-" + currDate.substring(2, 4) + "-" + currDate.substring(0, 2)

				d.rmcDate = parseDate(modified_date);
				d.ice_thickness = +d.ice_thickness;
				if(d.ice_thickness === 0) {
					// take the previous date data manually.
					d.ice_thickness = data[i-1].ice_thickness
				}


			});

			data.sort(function (a, b) {
				return a.rmcDate - b.rmcDate;
			});

			x.domain([data[0].rmcDate, data[data.length - 1].rmcDate])
			y.domain([0, d3.max(data, function(d) { return d.ice_thickness; }) + 50]);


			// GRIDLINE ADDED
			// =====================================
			// gridlines in x axis function
			function make_x_gridlines() {
				return d3.axisBottom(x)
					.ticks(50)
			}

			// gridlines in y axis function
			function make_y_gridlines() {
				return d3.axisLeft(y)
					.ticks(50)
			}


			// add the X gridlines
			svg.append("g")
				.attr("class", "grid")
				.attr("transform", "translate(0," + height + ")")
				.call(make_x_gridlines()
					.tickSize(-height)
					.tickFormat("")
				)

			// add the Y gridlines
			svg.append("g")
				.attr("class", "grid")
				.call(make_y_gridlines()
					.tickSize(-width)
					.tickFormat("")
				)

			// END GRIDLINE

			svg.append("g")
				.attr("class", "x axis")
				.attr("transform", "translate(0," + height + ")")
				.call(xAxis);

			// Y AXIS LABEL
			// ==========================================
			svg.append("g")
				.attr("class", "y axis")
				.call(yAxis)
				.append("text")
				.attr("transform", "rotate(-90)")
				.attr("y", 6)
				.attr("dy", ".71em")
				.style("text-anchor", "end")
				.text("Ice Thickness");

			svg.append("path")
				.datum(data)
				.attr("class", "line")
				.attr("d", line);

				// text label for the y axis
            svg.append("text")
                .attr("transform", "rotate(-90)")
                .attr("y", 0 - margin.left)
                .attr("x",0 - (height / 2))
                .attr("dy", "1em")
                .style("text-anchor", "middle")
                .text("Temperature (℃)");


			var focus = svg.append("g")
				.attr("class", "focus")
				.style("display", "none");

			focus.append("circle")
				.attr("r", 5);


			//      FOCUS LABEL INFORMATION
			// =======================================
			focus.append("rect")
				.attr("class", "tooltip-custom")
				.attr("width", 170)
				.attr("height", 70)
				.attr("x", 10)
				.attr("y", -22)
				.attr("rx", 4)
				.attr("ry", 4);

			focus.append("text")
				.attr("class", "title")
				.attr("x", 18)
				.attr("y", -2)
				.text("Information:");

			focus.append("text")
				.attr("x", 18)
				.attr("y", 18)
				.text("Date:");

			focus.append("text")
				.attr("class", "tooltip-date")
				.attr("x", 60)
				.attr("y", 18);

			focus.append("text")
				.attr("x", 18)
				.attr("y", 36)
				.text("Ice Thickness:");


			focus.append("text")
				.attr("class", "tooltip-likes")
				.attr("x", 110)
				.attr("y", 36);

			svg.append("rect")
				.attr("class", "overlay")
				.attr("width", width)
				.attr("height", height)
				.on("mouseover", function() { focus.style("display", null); })
				.on("mouseout", function() { focus.style("display", "none"); })
				.on("mousemove", mousemove);


			function mousemove() {
				var x0 = x.invert(d3.mouse(this)[0]),
					i = bisectDate(data, x0, 1),
					d0 = data[i - 1],
					d1 = data[i],
					d = x0 - d0.date > d1.date - x0 ? d1 : d0;
				focus.attr("transform", "translate(" + x(d.rmcDate) + "," + y(d.ice_thickness) + ")");
				focus.select(".tooltip-date").text(dateFormatter(d.rmcDate));
				focus.select(".tooltip-likes").text(formatValue(d.ice_thickness) + " cm");
			}

		}

		function renderGraph2(data){


            var date = [];
            var date2 = [];
            var ice_thickness = [];

            data.forEach(function(d, i) {
                ice_thickness.push(d.ice_thickness)
                date.push(convert(d.rmcDate));
                date2.push(convert2(d.rmcDate));
            });

           // console.log(date);
            $('#datetimepicker2').datepicker('update', date2[date2.length - 1]);
            $('#datetimepicker1').datepicker('update', date2[0])




            function  convert(str) {
                var date = new Date(str),
                    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    day = ("0" + date.getDate()).slice(-2);
                return [date.getFullYear(), mnth, day].join("-");
            }

            function  convert2(str) {
                var date = new Date(str),
                    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    day = ("0" + date.getDate()).slice(-2);
                return [ mnth,day, date.getFullYear()].join("-");
            }

            var data = [
                {
                    x: date,
                    y: ice_thickness,
                    type: 'scatter'
                }
            ];

            var layout = {
                title:'Ice Thickness',
                xaxis: {
                    range: [date[0], date[date.length -1]],
                    type: 'date',
                    title: 'Date'
                },
                yaxis:{
                    title:'Thickness (cm)'
                }
            };

            Plotly.newPlot('myDiv', data, layout);

        }


        function renderGraph3(data,datepicker1, datepicker2){

            datepicker1 = datepicker1.replace(/(\d\d)\/(\d\d)\/(\d{4})/, "$3-$1-$2")
            datepicker2 = datepicker2.replace(/(\d\d)\/(\d\d)\/(\d{4})/, "$3-$1-$2")

            var date = [];
            var date2 = [];
            var ice_thickness = [];

            data.forEach(function(d, i) {
                ice_thickness.push(d.ice_thickness)
                date.push(convert(d.rmcDate));
                date2.push(convert2(d.rmcDate));
            });

            if(date.includes(datepicker1) && date.includes(datepicker2))
            {
                var data = [
                    {
                        x: date,
                        y: ice_thickness,
                        type: 'scatter'
                    }
                ];

                var layout = {
                    title:'Ice Thickness',
                    xaxis: {
                        range: [datepicker1, datepicker2],
                        type: 'date',
                        title: 'Date'
                    },
                    yaxis:{
                        title:"Thickness (cm)"
                    }
                };

                Plotly.newPlot('myDiv', data, layout);
            }
            else {
                window.alert("Please select a date between: "+date2[0] +" and: "+date2[date2.length -1]);
            }


            function  convert(str) {
                var date = new Date(str),
                    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    day = ("0" + date.getDate()).slice(-2);
                return [date.getFullYear(), mnth, day].join("-");
            }

            function  convert2(str) {
                var date = new Date(str),
                    mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                    day = ("0" + date.getDate()).slice(-2);
                return [ mnth,day, date.getFullYear()].join("-");
            }



        }






    </script>
@endsection
