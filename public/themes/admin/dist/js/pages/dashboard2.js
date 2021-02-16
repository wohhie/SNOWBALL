$(function () {
    'use strict';


    // var drawVerticalLine = function (ctx, dataset, scale, label, index) {
    //     var point = scatterChartData.data.datasets[0].data[index];
    //     console.log(point);
    //     var scale = scale;
    //     console.log(scale);
    //     // draw line
    //     ctx.beginPath();
    //     ctx.moveTo(point.x, scale.startPoint + 20);
    //     ctx.strokeStyle = '#ff0000';
    //     ctx.lineTo(point.x, scale.endPoint);
    //     ctx.stroke();
    //
    //     // write label
    //     ctx.textAlign = 'center';
    //     ctx.fillStyle = 'black';
    //     ctx.textBaseline = 'middle';
    //     ctx.fillText(label, point.x, scale.startPoint + 10);
    // };
    //
    // var ctx = document.getElementById('temperatureChart').getContext('2d');
    // var scatterChartData = {
    //     type: 'scatter',
    //     data: {
    //         datasets: [{
    //             label: 'Scatter Dataset',
    //             data: [
    //                 { x: 0, y: 10},
    //                 {x: 10, y: 5}
    //             ]
    //         }],
    //         lineAtIndex: 4
    //     },
    //
    //     options: {
    //         scales: {
    //             xAxes: [{
    //                 type: 'linear',
    //                 position: 'bottom'
    //             }]
    //         }
    //     }
    // };
    //
    // var options = {
    //         bezierCurve: false,
    //         topOfSnowIndex: 1,
    //         topOfSnowLabel: 'Top of Snow',
    //
    //         // topOfIceIndex: 7,
    //         // topOfIceLabel: 'Top of Ice',
    //         //
    //         // bottomOfIceIndex: 12,
    //         // bottomOfIceLabel: 'Bottom of Ice',
    // };
    //
    // var custom = Chart.controllers.scatter.extend({
    //     draw: function() {
    //         Chart.controllers.scatter.prototype.draw.call(this);
    //
    //
    //     }
    // });
    //
    // new Chart(ctx, scatterChartData);




    function generateLabels() {
        var labels = [];
        for (var i = 0; i < 60 * 4; i = i + 4) {
            labels.push(i);
        }
        return labels;

    }


    var drawHorizontalLine = function (ctx, chartWidth, dataset, scale, label, index, color) {
        var point = dataset.points[index];
        var scale = scale;

        // draw line
        ctx.beginPath();
        ctx.moveTo(scale.startPoint + 20, point.y);
        ctx.strokeStyle = color;
        ctx.lineTo(chartWidth, point.y); //this.chart.width
        ctx.stroke();

        // write label
        ctx.textAlign = 'center';
        ctx.fillStyle = 'black';
        ctx.textBaseline = 'middle';
        ctx.fillText(label, scale.startPoint + 45, point.y - 10);
    };


    var drawVerticalLine = function (ctx, dataset, scale, label, index) {
        var point = dataset.points[index];
        var scale = scale;

        // draw line
        ctx.beginPath();
        ctx.moveTo(point.x, scale.startPoint + 20);
        ctx.strokeStyle = '#ff0000';
        ctx.lineTo(point.x, scale.endPoint);
        ctx.stroke();

        // write label
        ctx.textAlign = 'center';
        ctx.fillStyle = 'black';
        ctx.textBaseline = 'middle';
        ctx.fillText(label, point.x, scale.startPoint + 10);
    };



    Chart.types.Line.extend({
        name: "LineAlt",
        initialize: function (data) {
            var strokeColors = [];

            Chart.types.Line.prototype.initialize.apply(this, arguments);

            var self = this;

        },

        draw: function () {
            Chart.types.Line.prototype.draw.apply(this, arguments);


            // from Chart.js library code
            var hasValue = function (item) {
                    return item.value !== null;
                },
                nextPoint = function (point, collection, index) {
                    return Chart.helpers.findNextWhere(collection, hasValue, index) || point;
                },
                previousPoint = function (point, collection, index) {
                    return Chart.helpers.findPreviousWhere(collection, hasValue, index) || point;
                };

            var ctx = this.chart.ctx;
            var self = this;
            var firstDataSet = self.datasets[0];

            // Draw Today Line
            drawVerticalLine(ctx, firstDataSet, self.scale, self.options.topOfIceLabel, self.options.topOfIceIndex);
            drawVerticalLine(ctx, firstDataSet, self.scale, self.options.topOfSnowLabel, self.options.topOfSnowIndex);
            drawVerticalLine(ctx, firstDataSet, self.scale, self.options.bottomOfIceLabel, self.options.bottomOfIceIndex);
            //drawHorizontalLine(ctx, this.chart.width, firstDataSet, self.scale, self.options.topOfSnowLabel, self.options.topOfSnowIndex, '#ff0000');
            // drawHorizontalLine(ctx, this.chart.width, firstDataSet, self.scale, self.options.topOfIceLabel, self.options.topOfIceIndex, '#81ACF2');
            // drawHorizontalLine(ctx, this.chart.width, firstDataSet, self.scale, self.options.bottomOfIceLabel, self.options.bottomOfIceIndex, '#C5E5F3');

            ctx.save();
            ctx.restore();
        }
    });


    var temperatures = "{{ json_encode($temperatures) }}";
    console.log(temperatures);
    var data = {
        labels: generateLabels(),
        type: 'scatter',
        datasets: [{
            label: "Whole Project",
            fillColor: "rgba(151,187,205,0)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,0)",
            pointStrokeColor: "rgba(151,187,205,0)",
            pointHighlightFill: "rgba(151,187,205,0)",
            pointHighlightStroke: "rgba(151,187,205,0)",
            data: temperatures,
            dottedFromLabel: "week8"
        }],
        options: {
            labelString: 'Welcome',
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        max: 100,
                        min: 0,
                        stepSize: 20
                    },
                    gridLines: {
                        display: true,
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: false,
                        max: 100,
                        min: 0,
                        stepSize: 20
                    }
                }]
            }
        },

    };

    var ctx = document.getElementById("temperatureChart").getContext("2d");

    var options = {

        title: true,
        bezierCurve: false,
        topOfSnowIndex: 2,
        topOfSnowLabel: 'Top of Snow',

        topOfIceIndex: 7,
        topOfIceLabel: 'Top of Ice',

        bottomOfIceIndex: 12,
        bottomOfIceLabel: 'Bottom of Ice',
    };


    // top_of_snow
    // top_of_ice
    // bottom_of_ice




    $('.delectLevel').on('keyup', function () {





        var inputID = $(this).attr('id');
        // check if the value is 'empty' then set == 0
        var topOfSnow = parseInt(($("#top_of_snow").val() > 0) ? $("#top_of_snow").val() : 0);
        var topOfIce = parseInt(($("#top_of_ice").val() > 0) ? $("#top_of_ice").val() : 0);
        var bottomOfIce = parseInt(($("#bottom_of_ice").val() > 0) ? $("#bottom_of_ice").val() : 0);


        var items = generateLabels();


        var options = {
            bezierCurve: false,
            topOfSnowIndex: items.indexOf(topOfSnow),
            topOfSnowLabel: 'Top of Snow',

            topOfIceIndex: items.indexOf(topOfIce),
            topOfIceLabel: 'Top of Ice',

            bottomOfIceIndex: items.indexOf(bottomOfIce),
            bottomOfIceLabel: 'Bottom of Ice',
        };


        // setting the result in display
        var depthOfSnow =  parseInt(topOfIce) - parseInt(topOfSnow);
        var iceThikness = parseInt(bottomOfIce) - parseInt(topOfIce);

        $("#depth_of_snow").html("<b>" + data.labels[depthOfSnow] + "</b>");
        $("#depth_of_snow_width").width(data.labels[depthOfSnow] + "%");

        $("#ice_thikness").html("<b>" + data.labels[iceThikness] + "</b>");
        $("#ice_thikness_width").width(data.labels[iceThikness] + "%");

        new Chart(ctx).LineAlt(data, options);

    });



    new Chart(ctx).LineAlt(data, options);


    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    // -----------------------
    // - MONTHLY SALES CHART -
    // -----------------------
    //
    // Get context with jQuery - using jQuery's .get() method.
    // var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
    // // This will get the first returned node in the jQuery collection.
    // var salesChart       = new Chart(salesChartCanvas);
    //
    //
    // var gradientFill = salesChartCanvas.createLinearGradient(500, 0, 100, 0);
    // gradientFill.addColorStop(1, "rgba(158, 216, 240, 0.6)");
    // gradientFill.addColorStop(1, "rgba(212, 241, 249, 0.6)");
    // gradientFill.addColorStop(1, "rgba(48, 198, 227, 0.6)");
    // gradientFill.addColorStop(1, "rgba(117, 174, 220, 0.6)");
    //
    // var salesChartData = {
    //   labels  : [0, 10, 20, 30, 40, 50, 60, 70, 80],
    //   datasets: [
    //     {
    //       label               : 'Electronics',
    //       fillColor           : gradientFill,
    //       strokeColor         : 'rgb(210, 214, 222)',
    //       pointColor          : 'rgb(210, 214, 222)',
    //       pointStrokeColor    : '#c1c7d1',
    //       pointHighlightFill  : '#fff',
    //       pointHighlightStroke: 'rgb(220,220,220)',
    //       data                : [65, 59, 80, 81, 56, 55, 40],
    //
    //     }
    //   ]
    // };
    //
    //
    //
    //
    // var salesChartOptions = {
    //   // Boolean - If we should show the scale at all
    //   showScale               : true,
    //   // Boolean - Whether grid lines are shown across the chart
    //   scaleShowGridLines      : true,
    //   // String - Colour of the grid lines
    //   scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //   // Number - Width of the grid lines
    //   scaleGridLineWidth      : 1,
    //   // Boolean - Whether to show horizontal lines (except X axis)
    //   scaleShowHorizontalLines: true,
    //   // Boolean - Whether to show vertical lines (except Y axis)
    //   scaleShowVerticalLines  : true,
    //   // Boolean - Whether the line is curved between points
    //   bezierCurve             : true,
    //   // Number - Tension of the bezier curve between points
    //   bezierCurveTension      : 0.3,
    //   // Boolean - Whether to show a dot for each point
    //   pointDot                : true,
    //   // Number - Radius of each point dot in pixels
    //   pointDotRadius          : 3,
    //   // Number - Pixel width of point dot stroke
    //   pointDotStrokeWidth     : 1,
    //   // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    //   pointHitDetectionRadius : 20,
    //   // Boolean - Whether to show a stroke for datasets
    //   datasetStroke           : true,
    //   // Number - Pixel width of dataset stroke
    //   datasetStrokeWidth      : 2,
    //   // Boolean - Whether to fill the dataset with a color
    //   datasetFill             : true,
    //   // String - A legend template
    //   legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
    //   // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    //   maintainAspectRatio     : true,
    //   // Boolean - whether to make the chart responsive to window resizing
    //   responsive              : true
    // };
    //
    //
    //
    // // Create the line chart
    // salesChart.Line(salesChartData, salesChartOptions);
    //
    //
    //
    // $('#update').click(function() {
    //
    //   var xValue = parseFloat($('#xValue').val());
    //   var yValue = parseFloat($('#yValue').val());
    //   // alert(xValue);
    //
    //   new Chart(salesChart).LineWithLine(data, {
    //       datasetFill : true,
    //       lineAtIndex: 2
    //   });
    //
    //   //items.salesChartData.datasets[0].data.push({ x: xValue, y: yValue });
    //   //items.update();
    // });


    // var data = {
    //   labels: [40, 3, 2, 1, 8, 8, 2, 2, 3, 5, 7, 1],
    //   datasets: [{[0
    //     data: [40, 3, 2, 1, 8, 8, 2, 2, 3, 5, 7, 1]
    //   }]
    // };
    //
    // var ctx = document.getElementById("LineWithLine").getContext("2d");
    //
    //
    // Chart.types.Line.extend({
    //   name: "LineWithLine",
    //   draw: function () {
    //     Chart.types.Line.prototype.draw.apply(this, arguments);
    //
    //     var point = this.datasets[0].points[this.options.lineAtIndex]
    //     var scale = this.scale
    //
    //     // draw line
    //     this.chart.ctx.beginPath();
    //     this.chart.ctx.moveTo(point.x, scale.startPoint + 24);
    //     this.chart.ctx.strokeStyle = '#eeee3f';
    //     this.chart.ctx.lineTo(point.x, scale.endPoint);
    //     this.chart.ctx.stroke();
    //
    //
    //     // write TODAY
    //     this.chart.ctx.textAlign = 'center';
    //     // this.chart.ctx.fillText("TODAY", point.x, scale.startPoint + 12);
    //   }
    // });
    //
    // new Chart(ctx).LineWithLine(data, {
    //   datasetFill : true,
    //   lineAtIndex: 2
    // });
    //
    //
    //
    // $('#update').click(function() {
    //
    //   var xValue = parseFloat($('#xValue').val());
    //   var yValue = parseFloat($('#yValue').val());
    //
    //   salesChart.data.datasets[0].data.push({ x: xValue, y: yValue });
    //   salesChart.update();
    // });


    // ---------------------------
    // - END MONTHLY SALES CHART -
    // ---------------------------

    // -------------
    // - PIE CHART -
    // -------------
    // Get context with jQuery - using jQuery's .get() method.
    // var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    // var pieChart       = new Chart(pieChartCanvas);
    // var PieData        = [
    //   {
    //     value    : 700,
    //     color    : '#f56954',
    //     highlight: '#f56954',
    //     label    : 'Chrome'
    //   },
    //   {
    //     value    : 500,
    //     color    : '#00a65a',
    //     highlight: '#00a65a',
    //     label    : 'IE'
    //   },
    //   {
    //     value    : 400,
    //     color    : '#f39c12',
    //     highlight: '#f39c12',
    //     label    : 'FireFox'
    //   },
    //   {
    //     value    : 600,
    //     color    : '#00c0ef',
    //     highlight: '#00c0ef',
    //     label    : 'Safari'
    //   },
    //   {
    //     value    : 300,
    //     color    : '#3c8dbc',
    //     highlight: '#3c8dbc',
    //     label    : 'Opera'
    //   },
    //   {
    //     value    : 100,
    //     color    : '#d2d6de',
    //     highlight: '#d2d6de',
    //     label    : 'Navigator'
    //   }
    // ];
    // var pieOptions     = {
    //   // Boolean - Whether we should show a stroke on each segment
    //   segmentShowStroke    : true,
    //   // String - The colour of each segment stroke
    //   segmentStrokeColor   : '#fff',
    //   // Number - The width of each segment stroke
    //   segmentStrokeWidth   : 1,
    //   // Number - The percentage of the chart that we cut out of the middle
    //   percentageInnerCutout: 50, // This is 0 for Pie charts
    //   // Number - Amount of animation steps
    //   animationSteps       : 100,
    //   // String - Animation easing effect
    //   animationEasing      : 'easeOutBounce',
    //   // Boolean - Whether we animate the rotation of the Doughnut
    //   animateRotate        : true,
    //   // Boolean - Whether we animate scaling the Doughnut from the centre
    //   animateScale         : false,
    //   // Boolean - whether to make the chart responsive to window resizing
    //   responsive           : true,
    //   // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    //   maintainAspectRatio  : false,
    //   // String - A legend template
    //   legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
    //   // String - A tooltip template
    //   tooltipTemplate      : '<%=value %> <%=label%> users'
    // };
    // // Create pie or douhnut chart
    // // You can switch between pie and douhnut using the method below.
    // pieChart.Doughnut(PieData, pieOptions);
    // // -----------------
    // // - END PIE CHART -
    // // -----------------
    //
    // /* jVector Maps
    //  * ------------
    //  * Create a world map with markers
    //  */
    // $('#world-map-markers').vectorMap({
    //   map              : 'world_mill_en',
    //   normalizeFunction: 'polynomial',
    //   hoverOpacity     : 0.7,
    //   hoverColor       : false,
    //   backgroundColor  : 'transparent',
    //   regionStyle      : {
    //     initial      : {
    //       fill            : 'rgba(210, 214, 222, 1)',
    //       'fill-opacity'  : 1,
    //       stroke          : 'none',
    //       'stroke-width'  : 0,
    //       'stroke-opacity': 1
    //     },
    //     hover        : {
    //       'fill-opacity': 0.7,
    //       cursor        : 'pointer'
    //     },
    //     selected     : {
    //       fill: 'yellow'
    //     },
    //     selectedHover: {}
    //   },
    //   markerStyle      : {
    //     initial: {
    //       fill  : '#00a65a',
    //       stroke: '#111'
    //     }
    //   },
    //   markers          : [
    //     { latLng: [41.90, 12.45], name: 'Vatican City' },
    //     { latLng: [43.73, 7.41], name: 'Monaco' },
    //     { latLng: [-0.52, 166.93], name: 'Nauru' },
    //     { latLng: [-8.51, 179.21], name: 'Tuvalu' },
    //     { latLng: [43.93, 12.46], name: 'San Marino' },
    //     { latLng: [47.14, 9.52], name: 'Liechtenstein' },
    //     { latLng: [7.11, 171.06], name: 'Marshall Islands' },
    //     { latLng: [17.3, -62.73], name: 'Saint Kitts and Nevis' },
    //     { latLng: [3.2, 73.22], name: 'Maldives' },
    //     { latLng: [35.88, 14.5], name: 'Malta' },
    //     { latLng: [12.05, -61.75], name: 'Grenada' },
    //     { latLng: [13.16, -61.23], name: 'Saint Vincent and the Grenadines' },
    //     { latLng: [13.16, -59.55], name: 'Barbados' },
    //     { latLng: [17.11, -61.85], name: 'Antigua and Barbuda' },
    //     { latLng: [-4.61, 55.45], name: 'Seychelles' },
    //     { latLng: [7.35, 134.46], name: 'Palau' },
    //     { latLng: [42.5, 1.51], name: 'Andorra' },
    //     { latLng: [14.01, -60.98], name: 'Saint Lucia' },
    //     { latLng: [6.91, 158.18], name: 'Federated States of Micronesia' },
    //     { latLng: [1.3, 103.8], name: 'Singapore' },
    //     { latLng: [1.46, 173.03], name: 'Kiribati' },
    //     { latLng: [-21.13, -175.2], name: 'Tonga' },
    //     { latLng: [15.3, -61.38], name: 'Dominica' },
    //     { latLng: [-20.2, 57.5], name: 'Mauritius' },
    //     { latLng: [26.02, 50.55], name: 'Bahrain' },
    //     { latLng: [0.33, 6.73], name: 'São Tomé and Príncipe' }
    //   ]
    // });
    //
    // /* SPARKLINE CHARTS
    //  * ----------------
    //  * Create a inline charts with spark line
    //  */
    //
    // // -----------------
    // // - SPARKLINE BAR -
    // // -----------------
    // $('.sparkbar').each(function () {
    //   var $this = $(this);
    //   $this.sparkline('html', {
    //     type    : 'bar',
    //     height  : $this.data('height') ? $this.data('height') : '30',
    //     barColor: $this.data('color')
    //   });
    // });
    //
    // // -----------------
    // // - SPARKLINE PIE -
    // // -----------------
    // $('.sparkpie').each(function () {
    //   var $this = $(this);
    //   $this.sparkline('html', {
    //     type       : 'pie',
    //     height     : $this.data('height') ? $this.data('height') : '90',
    //     sliceColors: $this.data('color')
    //   });
    // });
    //
    // // ------------------
    // // - SPARKLINE LINE -
    // // ------------------
    // $('.sparkline').each(function () {
    //   var $this = $(this);
    //   $this.sparkline('html', {
    //     type     : 'line',
    //     height   : $this.data('height') ? $this.data('height') : '90',
    //     width    : '100%',
    //     lineColor: $this.data('linecolor'),
    //     fillColor: $this.data('fillcolor'),
    //     spotColor: $this.data('spotcolor')
    //   });
    // });
});
