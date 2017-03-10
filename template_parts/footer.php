<!-- Footer -->
		<div class="footer text-muted">
			<?php echo COPYRIGHT_TEXT; ?>
		</div>
		<!-- /footer -->

	</div>
	<!-- /page container -->

</body>	


<!-- /////////////******** Dashboard Page Js Code ********///////////// -->
<?php if(PAGE_FILE == 'dashboard'){ 
?>  


    <?php if(array_key_exists(1, $user_data_exist_widgets_ids_array)) {                    
        foreach ($user_data_exist_widgets_ids_array[1] as $key => $value) {
            ?>
            <script>
            //////****** Google Demand Chart Js *******//////

            /* ------------------------------------------------------------------------------
             *
             *  # Dashboard configuration
             *
             *  Demo dashboard configuration. Contains charts and plugin inits
             *
             *  Version: 1.0
             *  Latest update: Aug 1, 2015
             *
             * ---------------------------------------------------------------------------- */

            $(function() {

                // App sales lines chart
                // ------------------------------

                appSalesLines('#app_sales<?php echo $value;?>', 255); // initialize chart

                // Chart setup
                function appSalesLines(element, height) {


                    // Basic setup
                    // ------------------------------

                    // Define main variables
                    var d3Container = d3.select(element),
                        margin = {top: 5, right: 30, bottom: 30, left: 50},
                        width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
                        height = height - margin.top - margin.bottom;

                    // Tooltip
                    var tooltip = d3.tip()
                        .attr('class', 'd3-tip')
                        .html(function (d) {
                            return "<ul class='list-unstyled mb-5'>" +
                                "<li>" + "<div class='text-size-base mt-5 mb-5'><i class='icon-circle-left2 position-left'></i>" + d.name + " app" + "</div>" + "</li>" +
                                "<li>" + "Sales: &nbsp;" + "<span class='text-semibold pull-right'>" + d.value + "</span>" + "</li>" +
                                "<li>" + "Revenue: &nbsp; " + "<span class='text-semibold pull-right'>" + "$" + (d.value * 25).toFixed(2) + "</span>" + "</li>" + 
                            "</ul>";
                        });

                    // Format date
                    var parseDate = d3.time.format("%Y/%m/%d").parse,
                        formatDate = d3.time.format("%b %d, '%y");

                    // Line colors
                    var scale = ["#4CAF50", "#FF5722", "#5C6BC0"],
                        color = d3.scale.ordinal().range(scale);



                    // Create chart
                    // ------------------------------

                    // Container
                    var container = d3Container.append('svg');

                    // SVG element
                    var svg = container
                        .attr('width', width + margin.left + margin.right)
                        .attr('height', height + margin.top + margin.bottom)
                        .append("g")
                            .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
                            .call(tooltip);



                    // Add date range switcher
                    // ------------------------------

                    // Menu
                    var menu = $("#select_date<?php echo $value;?>").multiselect({
                        buttonClass: 'btn btn-link text-semibold',
                        enableHTML: true,
                        dropRight: true,
                        onChange: function() { change(), $.uniform.update(); },
                        buttonText: function (options, element) {
                            var selected = '';
                            options.each(function() {
                                selected += $(this).html() + ', ';
                            });
                            return '<span class="status-mark border-warning position-left"></span>' + selected.substr(0, selected.length -2);
                        }
                    });

                    // Radios
                    $(".multiselect-container input").uniform({ radioClass: 'choice' });



                    // Load data
                    // ------------------------------

                    d3.csv(<?php echo ((isset($user_widgets_data_array[1]))? '"'.$user_widgets_data_array[1][$key].'"' : '"'.'assets/demo_data/dashboard/app_sales.csv'.'"') ?>, function(error, data) {
                        formatted = data;
                        redraw();
                    });



                    // Construct layout
                    // ------------------------------

                    // Add events
                    var altKey;
                    d3.select(window)
                        .on("keydown", function() { altKey = d3.event.altKey; })
                        .on("keyup", function() { altKey = false; });
                
                    // Set terms of transition on date change   
                    function change() {
                      d3.transition()
                          .duration(altKey ? 7500 : 500)
                          .each(redraw);
                    }



                    // Main chart drawing function
                    // ------------------------------

                    function redraw() { 

                        // Construct chart layout
                        // ------------------------------

                        // Create data nests
                        var nested = d3.nest()
                            .key(function(d) { return d.type; })
                            .map(formatted)
                        
                        // Get value from menu selection
                        // the option values correspond
                        //to the [type] value we used to nest the data  
                        var series = menu.val();
                        
                        // Only retrieve data from the selected series using nest
                        var data = nested[series];
                        
                        // For object constancy we will need to set "keys", one for each type of data (column name) exclude all others.
                        color.domain(d3.keys(data[0]).filter(function(key) { return (key !== "date" && key !== "type"); }));

                        // Setting up color map
                        var linedata = color.domain().map(function(name) {
                            return {
                                        name: name,
                                        values: data.map(function(d) {
                                            return {name: name, date: parseDate(d.date), value: parseFloat(d[name], 10)};
                                        })
                                    };
                                });

                        // Draw the line
                        var line = d3.svg.line()
                            .x(function(d) { return x(d.date); })
                            .y(function(d) { return y(d.value); })
                            .interpolate('cardinal');



                        // Construct scales
                        // ------------------------------

                        // Horizontal
                        var x = d3.time.scale()
                            .domain([
                                d3.min(linedata, function(c) { return d3.min(c.values, function(v) { return v.date; }); }),
                                d3.max(linedata, function(c) { return d3.max(c.values, function(v) { return v.date; }); })
                            ])
                            .range([0, width]);

                        // Vertical
                        var y = d3.scale.linear()
                            .domain([
                                d3.min(linedata, function(c) { return d3.min(c.values, function(v) { return v.value; }); }),
                                d3.max(linedata, function(c) { return d3.max(c.values, function(v) { return v.value; }); })
                            ])
                            .range([height, 0]);



                        // Create axes
                        // ------------------------------

                        // Horizontal
                        var xAxis = d3.svg.axis()
                            .scale(x)
                            .orient("bottom")
                            .tickPadding(8)
                            .ticks(d3.time.days)
                            .innerTickSize(4)
                            .tickFormat(d3.time.format("%a")); // Display hours and minutes in 24h format

                        // Vertical
                        var yAxis = d3.svg.axis()
                            .scale(y)
                            .orient("left")
                            .ticks(6)
                            .tickSize(0 -width)
                            .tickPadding(8);
                        


                        //
                        // Append chart elements
                        //

                        // Append axes
                        // ------------------------------

                        // Horizontal
                        svg.append("g")
                            .attr("class", "d3-axis d3-axis-horizontal d3-axis-solid")
                            .attr("transform", "translate(0," + height + ")");

                        // Vertical
                        svg.append("g")
                            .attr("class", "d3-axis d3-axis-vertical d3-axis-transparent");



                        // Append lines
                        // ------------------------------

                        // Bind the data
                        var lines = svg.selectAll(".lines")
                            .data(linedata)
                     
                        // Append a group tag for each line
                        var lineGroup = lines
                            .enter()
                            .append("g")
                                .attr("class", "lines")
                                .attr('id', function(d){ return d.name + "-line"; });

                        // Append the line to the graph
                        lineGroup.append("path")
                            .attr("class", "d3-line d3-line-medium")
                            .style("stroke", function(d) { return color(d.name); })
                            .style('opacity', 0)
                            .attr("d", function(d) { return line(d.values[0]); })
                            .transition()
                                .duration(500)
                                .delay(function(d, i) { return i * 200; })
                                .style('opacity', 1);
                      


                        // Append circles
                        // ------------------------------

                        var circles = lines.selectAll("circle")
                            .data(function(d) { return d.values; })
                            .enter()
                            .append("circle")
                                .attr("class", "d3-line-circle d3-line-circle-medium")
                                .attr("cx", function(d,i){return x(d.date)})
                                .attr("cy",function(d,i){return y(d.value)})
                                .attr("r", 3)
                                .style('fill', '#fff')
                                .style("stroke", function(d) { return color(d.name); });

                        // Add transition
                        circles
                            .style('opacity', 0)
                            .transition()
                                .duration(500)
                                .delay(500)
                                .style('opacity', 1);



                        // Append tooltip
                        // ------------------------------

                        // Add tooltip on circle hover
                        circles
                            .on("mouseover", function (d) {
                                tooltip.offset([-15, 0]).show(d);

                                // Animate circle radius
                                d3.select(this).transition().duration(250).attr('r', 4);
                            })
                            .on("mouseout", function (d) {
                                tooltip.hide(d);

                                // Animate circle radius
                                d3.select(this).transition().duration(250).attr('r', 3);
                            });

                        // Change tooltip direction of first point
                        // to always keep it inside chart, useful on mobiles
                        lines.each(function (d) { 
                            d3.select(d3.select(this).selectAll('circle')[0][0])
                                .on("mouseover", function (d) {
                                    tooltip.offset([0, 15]).direction('e').show(d);

                                    // Animate circle radius
                                    d3.select(this).transition().duration(250).attr('r', 4);
                                })
                                .on("mouseout", function (d) {
                                    tooltip.direction('n').hide(d);

                                    // Animate circle radius
                                    d3.select(this).transition().duration(250).attr('r', 3);
                                });
                        })

                        // Change tooltip direction of last point
                        // to always keep it inside chart, useful on mobiles
                        lines.each(function (d) { 
                            d3.select(d3.select(this).selectAll('circle')[0][d3.select(this).selectAll('circle').size() - 1])
                                .on("mouseover", function (d) {
                                    tooltip.offset([0, -15]).direction('w').show(d);

                                    // Animate circle radius
                                    d3.select(this).transition().duration(250).attr('r', 4);
                                })
                                .on("mouseout", function (d) {
                                    tooltip.direction('n').hide(d);

                                    // Animate circle radius
                                    d3.select(this).transition().duration(250).attr('r', 3);
                                })
                        })



                        // Update chart on date change
                        // ------------------------------

                        // Set variable for updating visualization
                        var lineUpdate = d3.transition(lines);
                        
                        // Update lines
                        lineUpdate.select("path")
                            .attr("d", function(d, i) { return line(d.values); });

                        // Update circles
                        lineUpdate.selectAll("circle")
                            .attr("cy",function(d,i){return y(d.value)})
                            .attr("cx", function(d,i){return x(d.date)});

                        // Update vertical axes
                        d3.transition(svg)
                            .select(".d3-axis-vertical")
                            .call(yAxis);   

                        // Update horizontal axes
                        d3.transition(svg)
                            .select(".d3-axis-horizontal")
                            .attr("transform", "translate(0," + height + ")")
                            .call(xAxis);



                        // Resize chart
                        // ------------------------------

                        // Call function on window resize
                        $(window).on('resize', appSalesResize);

                        // Call function on sidebar width change
                        $('.sidebar-control').on('click', appSalesResize);

                        // Resize function
                        // 
                        // Since D3 doesn't support SVG resize by default,
                        // we need to manually specify parts of the graph that need to 
                        // be updated on window resize
                        function appSalesResize() {

                            // Layout
                            // -------------------------

                            // Define width
                            width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;

                            // Main svg width
                            container.attr("width", width + margin.left + margin.right);

                            // Width of appended group
                            svg.attr("width", width + margin.left + margin.right);

                            // Horizontal range
                            x.range([0, width]);

                            // Vertical range
                            y.range([height, 0]);


                            // Chart elements
                            // -------------------------

                            // Horizontal axis
                            svg.select('.d3-axis-horizontal').call(xAxis);

                            // Vertical axis
                            svg.select('.d3-axis-vertical').call(yAxis.tickSize(0-width));

                            // Lines
                            svg.selectAll('.d3-line').attr("d", function(d, i) { return line(d.values); });

                            // Circles
                            svg.selectAll('.d3-line-circle').attr("cx", function(d,i){return x(d.date)})
                        }
                    }
                }

                // Monthly app sales area chart
                // ------------------------------

                monthlySalesArea("#monthly-sales-stats<?php echo $value;?>", 100, '#4DB6AC'); // initialize chart

                // Chart setup
                function monthlySalesArea(element, height, color) {


                    // Basic setup
                    // ------------------------------

                    // Define main variables
                    var d3Container = d3.select(element),
                        margin = {top: 20, right: 35, bottom: 40, left: 35},
                        width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
                        height = height - margin.top - margin.bottom;

                    // Date and time format
                    var parseDate = d3.time.format( '%Y-%m-%d' ).parse,
                        bisectDate = d3.bisector(function(d) { return d.date; }).left,
                        formatDate = d3.time.format("%b %d");



                    // Create SVG
                    // ------------------------------

                    // Container
                    var container = d3Container.append('svg');

                    // SVG element
                    var svg = container
                        .attr('width', width + margin.left + margin.right)
                        .attr('height', height + margin.top + margin.bottom)
                        .append("g")
                            .attr("transform", "translate(" + margin.left + "," + margin.top + ")")



                    // Construct chart layout
                    // ------------------------------

                    // Area
                    var area = d3.svg.area()
                        .x(function(d) { return x(d.date); })
                        .y0(height)
                        .y1(function(d) { return y(d.value); })
                        .interpolate('monotone')


                    // Construct scales
                    // ------------------------------

                    // Horizontal
                    var x = d3.time.scale().range([0, width ]);

                    // Vertical
                    var y = d3.scale.linear().range([height, 0]);


                    // Create axes
                    // ------------------------------

                    // Horizontal
                    var xAxis = d3.svg.axis()
                        .scale(x)
                        .orient("bottom")
                        .ticks(d3.time.days, 6)
                        .innerTickSize(4)
                        .tickPadding(8)
                        .tickFormat(d3.time.format("%b %d"));


                    // Load data
                    // ------------------------------

                    d3.json("assets/demo_data/dashboard/monthly_sales.json", function (error, data) {

                        // Show what's wrong if error
                        if (error) return console.error(error);

                        // Pull out values
                        data.forEach(function (d) {
                            d.date = parseDate(d.date);
                            d.value = +d.value;
                        });

                        // Get the maximum value in the given array
                        var maxY = d3.max(data, function(d) { return d.value; });

                        // Reset start data for animation
                        var startData = data.map(function(datum) {
                            return {
                                date: datum.date,
                                value: 0
                            };
                        });


                        // Set input domains
                        // ------------------------------

                        // Horizontal
                        x.domain(d3.extent(data, function(d, i) { return d.date; }));

                        // Vertical
                        y.domain([0, d3.max( data, function(d) { return d.value; })]);



                        //
                        // Append chart elements
                        //

                        // Append axes
                        // -------------------------

                        // Horizontal
                        var horizontalAxis = svg.append("g")
                            .attr("class", "d3-axis d3-axis-horizontal d3-axis-solid")
                            .attr("transform", "translate(0," + height + ")")
                            .call(xAxis);

                        // Add extra subticks for hidden hours
                        horizontalAxis.selectAll(".d3-axis-subticks")
                            .data(x.ticks(d3.time.days), function(d) { return d; })
                            .enter()
                                .append("line")
                                .attr("class", "d3-axis-subticks")
                                .attr("y1", 0)
                                .attr("y2", 4)
                                .attr("x1", x)
                                .attr("x2", x);



                        // Append area
                        // -------------------------

                        // Add area path
                        svg.append("path")
                            .datum(data)
                            .attr("class", "d3-area")
                            .attr("d", area)
                            .style('fill', color)
                            .transition() // begin animation
                                .duration(1000)
                                .attrTween('d', function() {
                                    var interpolator = d3.interpolateArray(startData, data);
                                    return function (t) {
                                        return area(interpolator (t));
                                    }
                                });



                        // Append crosshair and tooltip
                        // -------------------------

                        //
                        // Line
                        //

                        // Line group
                        var focusLine = svg.append("g")
                            .attr("class", "d3-crosshair-line")
                            .style("display", "none");

                        // Line element
                        focusLine.append("line")
                            .attr("class", "vertical-crosshair")
                            .attr("y1", 0)
                            .attr("y2", -maxY)
                            .style("stroke", "#e5e5e5")
                            .style('shape-rendering', 'crispEdges')


                        //
                        // Pointer
                        //

                        // Pointer group
                        var focusPointer = svg.append("g")
                            .attr("class", "d3-crosshair-pointer")
                            .style("display", "none");

                        // Pointer element
                        focusPointer.append("circle")
                            .attr("r", 3)
                            .style("fill", "#fff")
                            .style('stroke', color)
                            .style('stroke-width', 1)


                        //
                        // Text
                        //

                        // Text group
                        var focusText = svg.append("g")
                            .attr("class", "d3-crosshair-text")
                            .style("display", "none");

                        // Text element
                        focusText.append("text")
                            .attr("dy", -10)
                            .style('font-size', 12);


                        //
                        // Overlay with events
                        //

                        svg.append("rect")
                            .attr("class", "d3-crosshair-overlay")
                            .style('fill', 'none')
                            .style('pointer-events', 'all')
                            .attr("width", width)
                            .attr("height", height)
                                .on("mouseover", function() {
                                    focusPointer.style("display", null);        
                                    focusLine.style("display", null)
                                    focusText.style("display", null);
                                })
                                .on("mouseout", function() {
                                    focusPointer.style("display", "none"); 
                                    focusLine.style("display", "none");
                                    focusText.style("display", "none");
                                })
                                .on("mousemove", mousemove);


                        // Display tooltip on mousemove
                        function mousemove() {

                            // Define main variables
                            var mouse = d3.mouse(this),
                                mousex = mouse[0],
                                mousey = mouse[1],
                                x0 = x.invert(mousex),
                                i = bisectDate(data, x0),
                                d0 = data[i - 1],
                                d1 = data[i],
                                d = x0 - d0.date > d1.date - x0 ? d1 : d0;

                            // Move line
                            focusLine.attr("transform", "translate(" + x(d.date) + "," + height + ")");

                            // Move pointer
                            focusPointer.attr("transform", "translate(" + x(d.date) + "," + y(d.value) + ")");

                            // Reverse tooltip at the end point
                            if(mousex >= (d3Container.node().getBoundingClientRect().width - focusText.select('text').node().getBoundingClientRect().width - margin.right - margin.left)) {
                                focusText.select("text").attr('text-anchor', 'end').attr("x", function () { return (x(d.date) - 15) + "px" }).text(formatDate(d.date) + " - " + d.value + " sales");
                            }
                            else {
                                focusText.select("text").attr('text-anchor', 'start').attr("x", function () { return (x(d.date) + 15) + "px" }).text(formatDate(d.date) + " - " + d.value + " sales");
                            }
                        }



                        // Resize chart
                        // ------------------------------

                        // Call function on window resize
                        $(window).on('resize', monthlySalesAreaResize);

                        // Call function on sidebar width change
                        $('.sidebar-control').on('click', monthlySalesAreaResize);

                        // Resize function
                        // 
                        // Since D3 doesn't support SVG resize by default,
                        // we need to manually specify parts of the graph that need to 
                        // be updated on window resize
                        function monthlySalesAreaResize() {

                            // Layout variables
                            width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;


                            // Layout
                            // -------------------------

                            // Main svg width
                            container.attr("width", width + margin.left + margin.right);

                            // Width of appended group
                            svg.attr("width", width + margin.left + margin.right);


                            // Axes
                            // -------------------------

                            // Horizontal range
                            x.range([0, width]);

                            // Horizontal axis
                            svg.selectAll('.d3-axis-horizontal').call(xAxis);

                            // Horizontal axis subticks
                            svg.selectAll('.d3-axis-subticks').attr("x1", x).attr("x2", x);


                            // Chart elements
                            // -------------------------

                            // Area path
                            svg.selectAll('.d3-area').datum( data ).attr("d", area);

                            // Crosshair
                            svg.selectAll('.d3-crosshair-overlay').attr("width", width);
                        }
                    });
                } 
            });
            /////****** End Google Demand Chart Js *******//////
            </script>
        <?php
        }//End for each loop 
    } //End if condition
    ?>


    <?php if(array_key_exists(5, $user_data_exist_widgets_ids_array)) {                    
        foreach ($user_data_exist_widgets_ids_array[5] as $key => $value) {
            ?>
            <script>
            /////****** Bar Chart Js *******//////
            $(function() {

                    // Bar charts with random data
                    // ------------------------------

                    // Initialize charts
                    generateBarChart("#hours-available-bars<?php echo $value;?>", 24, 40, true, "elastic", 1200, 50, "#EC407A", "hours");
                    generateBarChart("#goal-bars<?php echo $value;?>", 24, 40, true, "elastic", 1200, 50, "#5C6BC0", "goal");

                    // Chart setup
                    function generateBarChart(element, barQty, height, animate, easing, duration, delay, color, tooltip) {


                        // Basic setup
                        // ------------------------------

                        // Add data set
                        var bardata = [];
                        for (var i=0; i < barQty; i++) {
                            bardata.push(Math.round(Math.random()*10) + 10)
                        }

                        // Main variables
                        var d3Container = d3.select(element),
                            width = d3Container.node().getBoundingClientRect().width;
                        


                        // Construct scales
                        // ------------------------------

                        // Horizontal
                        var x = d3.scale.ordinal()
                            .rangeBands([0, width], 0.3)

                        // Vertical
                        var y = d3.scale.linear()
                            .range([0, height]);



                        // Set input domains
                        // ------------------------------

                        // Horizontal
                        x.domain(d3.range(0, bardata.length))

                        // Vertical
                        y.domain([0, d3.max(bardata)])



                        // Create chart
                        // ------------------------------

                        // Add svg element
                        var container = d3Container.append('svg');

                        // Add SVG group
                        var svg = container
                            .attr('width', width)
                            .attr('height', height)
                            .append('g');



                        //
                        // Append chart elements
                        //

                        // Bars
                        var bars = svg.selectAll('rect')
                            .data(bardata)
                            .enter()
                            .append('rect')
                                .attr('class', 'd3-random-bars')
                                .attr('width', x.rangeBand())
                                .attr('x', function(d,i) {
                                    return x(i);
                                })
                                .style('fill', color);



                        // Tooltip
                        // ------------------------------

                        var tip = d3.tip()
                            .attr('class', 'd3-tip')
                            .offset([-10, 0]);

                        // Show and hide
                        if(tooltip == "hours" || tooltip == "goal" || tooltip == "members") {
                            bars.call(tip)
                                .on('mouseover', tip.show)
                                .on('mouseout', tip.hide);
                        }

                        // Daily meetings tooltip content
                        if(tooltip == "hours") {
                            tip.html(function (d, i) {
                                return "<div class='text-center'>" +
                                        "<h6 class='no-margin'>" + d + "</h6>" +
                                        "<span class='text-size-small'>meetings</span>" +
                                        "<div class='text-size-small'>" + i + ":00" + "</div>" +
                                    "</div>"
                            });
                        }

                        // Statements tooltip content
                        if(tooltip == "goal") {
                            tip.html(function (d, i) {
                                return "<div class='text-center'>" +
                                        "<h6 class='no-margin'>" + d + "</h6>" +
                                        "<span class='text-size-small'>statements</span>" +
                                        "<div class='text-size-small'>" + i + ":00" + "</div>" +
                                    "</div>"
                            });
                        }

                        // Online members tooltip content
                        if(tooltip == "members") {
                            tip.html(function (d, i) {
                                return "<div class='text-center'>" +
                                        "<h6 class='no-margin'>" + d + "0" + "</h6>" +
                                        "<span class='text-size-small'>members</span>" +
                                        "<div class='text-size-small'>" + i + ":00" + "</div>" +
                                    "</div>"
                            });
                        }



                        // Bar loading animation
                        // ------------------------------

                        // Choose between animated or static
                        if(animate) {
                            withAnimation();
                        } else {
                            withoutAnimation();
                        }

                        // Animate on load
                        function withAnimation() {
                            bars
                                .attr('height', 0)
                                .attr('y', height)
                                .transition()
                                    .attr('height', function(d) {
                                        return y(d);
                                    })
                                    .attr('y', function(d) {
                                        return height - y(d);
                                    })
                                    .delay(function(d, i) {
                                        return i * delay;
                                    })
                                    .duration(duration)
                                    .ease(easing);
                        }

                        // Load without animateion
                        function withoutAnimation() {
                            bars
                                .attr('height', function(d) {
                                    return y(d);
                                })
                                .attr('y', function(d) {
                                    return height - y(d);
                                })
                        }



                        // Resize chart
                        // ------------------------------

                        // Call function on window resize
                        $(window).on('resize', barsResize);

                        // Call function on sidebar width change
                        $('.sidebar-control').on('click', barsResize);

                        // Resize function
                        // 
                        // Since D3 doesn't support SVG resize by default,
                        // we need to manually specify parts of the graph that need to 
                        // be updated on window resize
                        function barsResize() {

                            // Layout variables
                            width = d3Container.node().getBoundingClientRect().width;


                            // Layout
                            // -------------------------

                            // Main svg width
                            container.attr("width", width);

                            // Width of appended group
                            svg.attr("width", width);

                            // Horizontal range
                            x.rangeBands([0, width], 0.3);


                            // Chart elements
                            // -------------------------

                            // Bars
                            svg.selectAll('.d3-random-bars')
                                .attr('width', x.rangeBand())
                                .attr('x', function(d,i) {
                                    return x(i);
                                });
                        }
                    }




                    // Animated progress chart
                    // ------------------------------

                    // Initialize charts
                    progressCounter('#hours-available-progress<?php echo $value;?>', 38, 2, "#F06292", 0.68, "icon-watch text-pink-400", 'Hours available', '64% average')
                    progressCounter('#goal-progress<?php echo $value;?>', 38, 2, "#5C6BC0", 0.82, "icon-trophy3 text-indigo-400", 'Productivity goal', '87% average')

                    // Chart setup
                    function progressCounter(element, radius, border, color, end, iconClass, textTitle, textAverage) {


                        // Basic setup
                        // ------------------------------

                        // Main variables
                        var d3Container = d3.select(element),
                            startPercent = 0,
                            iconSize = 32,
                            endPercent = end,
                            twoPi = Math.PI * 2,
                            formatPercent = d3.format('.0%'),
                            boxSize = radius * 2;

                        // Values count
                        var count = Math.abs((endPercent - startPercent) / 0.01);

                        // Values step
                        var step = endPercent < startPercent ? -0.01 : 0.01;



                        // Create chart
                        // ------------------------------

                        // Add SVG element
                        var container = d3Container.append('svg');

                        // Add SVG group
                        var svg = container
                            .attr('width', boxSize)
                            .attr('height', boxSize)
                            .append('g')
                                .attr('transform', 'translate(' + (boxSize / 2) + ',' + (boxSize / 2) + ')');



                        // Construct chart layout
                        // ------------------------------

                        // Arc
                        var arc = d3.svg.arc()
                            .startAngle(0)
                            .innerRadius(radius)
                            .outerRadius(radius - border);



                        //
                        // Append chart elements
                        //

                        // Paths
                        // ------------------------------

                        // Background path
                        svg.append('path')
                            .attr('class', 'd3-progress-background')
                            .attr('d', arc.endAngle(twoPi))
                            .style('fill', '#eee');

                        // Foreground path
                        var foreground = svg.append('path')
                            .attr('class', 'd3-progress-foreground')
                            .attr('filter', 'url(#blur)')
                            .style('fill', color)
                            .style('stroke', color);

                        // Front path
                        var front = svg.append('path')
                            .attr('class', 'd3-progress-front')
                            .style('fill', color)
                            .style('fill-opacity', 1);



                        // Text
                        // ------------------------------

                        // Percentage text value
                        var numberText = d3.select(element)
                            .append('h2')
                                .attr('class', 'mt-15 mb-5')

                        // Icon
                        d3.select(element)
                            .append("i")
                                .attr("class", iconClass + " counter-icon")
                                .attr('style', 'top: ' + ((boxSize - iconSize) / 2) + 'px');

                        // Title
                        d3.select(element)
                            .append('div')
                                .text(textTitle);

                        // Subtitle
                        d3.select(element)
                            .append('div')
                                .attr('class', 'text-size-small text-muted')
                                .text(textAverage);



                        // Animation
                        // ------------------------------

                        // Animate path
                        function updateProgress(progress) {
                            foreground.attr('d', arc.endAngle(twoPi * progress));
                            front.attr('d', arc.endAngle(twoPi * progress));
                            numberText.text(formatPercent(progress));
                        }

                        // Animate text
                        var progress = startPercent;
                        (function loops() {
                            updateProgress(progress);
                            if (count > 0) {
                                count--;
                                progress += step;
                                setTimeout(loops, 10);
                            }
                        })();
                    }
            });
            /////****** End Bar Chart Js *******//////
            </script>
            <?php 
        }// End for each loop
    }// End if condition
    ?>


    <?php if(array_key_exists(2, $user_data_exist_widgets_ids_array)){                  
        foreach ($user_data_exist_widgets_ids_array[2] as $key => $value) {
            ?>
            <!-- Market Share JS file
            <script type="text/javascript" src="assets/js/charts/echarts/pies_donuts.js"></script>-->
            <script type="text/javascript">
            //////****** Market Share JS *****//////
            /* ------------------------------------------------------------------------------
             *
             *  # Echarts - pies and donuts
             *
             *  Pies and donuts chart configurations
             *
             *  Version: 1.0
             *  Latest update: August 1, 2015
             *
             * ---------------------------------------------------------------------------- */

            $(function () {

                // Set paths
                // ------------------------------

                require.config({
                    paths: {
                        echarts: 'assets/js/plugins/visualization/echarts'
                    }
                });


                // Configuration
                // ------------------------------

                require(
                    [
                        'echarts',
                        'echarts/theme/limitless',
                        'echarts/chart/pie',
                        'echarts/chart/funnel'
                    ],


                    // Charts setup
                    function (ec, limitless) {


                        // Initialize charts
                        // ------------------------------

                        var basic_pie = ec.init(document.getElementById('basic_pie<?php echo $value;?>'), limitless);

                        // Charts setup
                        // ------------------------------                    

                        //
                        // Basic pie options
                        //

                        basic_pie_options = {

                            // Add title
                            title: {
                                text: 'Browser popularity',
                                subtext: 'Open source information',
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
                                data: <?php echo ((isset($user_widgets_data_array[2]))? $user_widgets_data_array[2][$key][0] : "['IE','Opera','Safari','Firefox','Chrom']") ?>
                            },

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
                                name: 'Browsers',
                                type: 'pie',
                                radius: '70%',
                                center: ['50%', '57.5%'],
                                data: <?php echo ((isset($user_widgets_data_array[2]))? $user_widgets_data_array[2][$key][1] : "[{value: 335, name: 'IE'}, {value: 310, name: 'Opera'}, {value: 234, name: 'Safari'}, {value: 135, name: 'Firefox'}, {value: 1548, name: 'Chrom'}]") ?>
                            }]
                        };


                        // Apply options
                        // ------------------------------

                        basic_pie.setOption(basic_pie_options);


                        // Resize charts
                        // ------------------------------

                        window.onresize = function () {
                            setTimeout(function (){
                                basic_pie.resize();
                            }, 200);
                        }
                    }
                );
            });
            //////****** Market Share JS *****//////
            </script>
            <?php 
        }//End for each loop
    }//End if condition 


    if(array_key_exists(3, $user_data_exist_widgets_ids_array)){                  
        foreach ($user_data_exist_widgets_ids_array[3] as $key => $value) {
            ?>
            <!-- Brand Sentiment JS files
            <script type="text/javascript" src="assets/js/charts/d3/bars/bars_advanced_stacked_multiple.js"></script>-->
            <script type="text/javascript">
            //////****** Brand Sentiment JS *****//////
            /* ------------------------------------------------------------------------------
             *
             *  # D3.js - stacked and multiple bars
             *
             *  Demo d3.js bar chart setup with animated transition between stacked and multiple bars
             *
             *  Version: 1.0
             *  Latest update: August 1, 2015
             *
             * ---------------------------------------------------------------------------- */

            $(function () {

                // Create Uniform checkbox
                $(".stacked-multiple").uniform({
                    radioClass: 'choice'
                });


                // Initialize chart
                stackedMultiples('#d3-bar-stacked-multiples<?php echo $value;?>', 400);

                // Chart setup
                function stackedMultiples(element, height) {


                    // Basic setup
                    // ------------------------------

                    // Define main variables
                    var d3Container = d3.select(element),
                        margin = {top: 5, right: 20, bottom: 20, left: 60},
                        width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
                        height = height - margin.top - margin.bottom - 5;


                    // Format data
                    var parseDate = d3.time.format("%Y-%m").parse,
                        formatYear = d3.format("02d"),
                        formatDate = function(d) { return "Q" + ((d.getMonth() / 3 | 0) + 1) + formatYear(d.getFullYear() % 100); };



                    // Construct scales
                    // ------------------------------

                    // Horizontal
                    var x = d3.scale.ordinal()
                        .rangeRoundBands([0, width], .2);

                    // Vertical
                    var y = d3.scale.ordinal()
                        .rangeRoundBands([height, 0]);

                    var y0 = d3.scale.ordinal()
                        .rangeRoundBands([height, 0]);

                    var y1 = d3.scale.linear();

                    // Colors
                    var color = d3.scale.category20();



                    // Create axes
                    // ------------------------------

                    // Horizontal
                    var xAxis = d3.svg.axis()
                        .scale(x)
                        .orient("bottom")
                        .tickFormat(formatDate);

                    // Vertical
                    var yAxis = d3.svg.axis()
                        .scale(y)
                        .orient("left")
                        .ticks(10, "%");



                    // Create chart
                    // ------------------------------

                    // Add SVG element
                    var container = d3Container.append("svg");

                    // Add SVG group
                    var svg = container
                        .attr("width", width + margin.left + margin.right)
                        .attr("height", height + margin.top + margin.bottom)
                        .append("g")
                            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



                    // Construct chart layout
                    // ------------------------------

                    // Nest
                    var nest = d3.nest()
                        .key(function(d) { return d.browser; });

                    // Stack
                    var stack = d3.layout.stack()
                        .values(function(d) { return d.values; })
                        .x(function(d) { return d.date; })
                        .y(function(d) { return d.value; })
                        .out(function(d, y0) { d.valueOffset = y0; });




                    // Load data
                    // ------------------------------

                    d3.tsv(<?php echo ((isset($user_widgets_data_array[3]))? '"'.$user_widgets_data_array[3][$key].'"' : '"'.'assets/demo_data/d3/bars/bars_stacked_multiple.tsv'.'"') ?>, function(error, data) {

                        // Pull out values
                        data.forEach(function(d) {
                            d.date = parseDate(d.date);
                            d.value = +d.value;
                        });

                        // Nest values
                        var dataByGroup = nest.entries(data);


                        // Set input domains
                        // ------------------------------

                        // Stack
                        stack(dataByGroup);

                        // Horizontal
                        x.domain(dataByGroup[0].values.map(function(d) { return d.date; }));

                        // Vertical
                        y0.domain(dataByGroup.map(function(d) { return d.key; }));
                        y1.domain([0, d3.max(data, function(d) { return d.value; })]).range([y0.rangeBand(), 0]);


                        //
                        // Append chart elements
                        //

                        // Add bars
                        // ------------------------------

                        // Group bars
                        var group = svg.selectAll(".d3-bar-group")
                            .data(dataByGroup)
                            .enter()
                            .append("g")
                                .attr("class", "d3-bar-group")
                                .attr("transform", function(d) { return "translate(0," + y0(d.key) + ")"; });

                        // Append text
                        group.append("text")
                            .attr("class", "d3-group-label")
                            .attr("x", -12)
                            .attr("y", function(d) { return y1(d.values[0].value / 2); })
                            .attr("dy", ".35em")
                            .style("text-anchor", "end")
                            .text(function(d) { return d.key; });

                        // Add bars
                        group.selectAll(".d3-bar")
                            .data(function(d) { return d.values; })
                            .enter()
                            .append("rect")
                                .attr("class", "d3-bar")
                                .attr("x", function(d) { return x(d.date); })
                                .attr("y", function(d) { return y1(d.value); })
                                .attr("width", x.rangeBand())
                                .attr("height", function(d) { return y0.rangeBand() - y1(d.value); })
                                .style("fill", function(d) { return color(d.browser); });


                        // Append axes
                        // ------------------------------

                        // Horizontal
                        group.filter(function(d, i) { return !i; }).append("g")
                            .attr("class", "d3-axis d3-axis-horizontal d3-axis-strong")
                            .attr("transform", "translate(0," + (y0.rangeBand() + 1) + ")")
                            .call(xAxis);

                        // Vertical
                        var verticalAxis = svg.append("g")
                            .attr("class", "d3-axis d3-axis-vertical d3-axis-strong")
                            .call(yAxis);

                        // Appent text label
                        verticalAxis.append("text")
                            .attr('class', 'browser-label')
                            .attr("x", -12)
                            .attr("y", 12)
                            .attr("dy", ".71em")
                            .style("text-anchor", "end")
                            .style("fill", "#999")
                            .style("font-size", 12)
                            .text("Browser");


                        // Setup layout change
                        // ------------------------------

                        // Add change event
                        d3.selectAll(".stacked-multiple").on("change", change);

                        // Change value on page load
                        var timeout = setTimeout(function() {
                            d3.select("input[value=\"stacked\"]").property("checked", true).each(change);
                            $.uniform.update();
                        }, 2000);

                        // Change function
                        function change() {
                            clearTimeout(timeout);
                            if (this.value === "multiples") transitionMultiples();
                            else transitionStacked();
                        }

                        // Transition to multiples
                        function transitionMultiples() {
                            var t = svg.transition().duration(750),
                            g = t.selectAll(".d3-bar-group").attr("transform", function(d) { return "translate(0," + y0(d.key) + ")"; });
                            g.selectAll(".d3-bar").attr("y", function(d) { return y1(d.value); });
                            g.select(".d3-group-label").attr("y", function(d) { return y1(d.values[0].value / 2); })
                        }

                        // Transition to stacked
                        function transitionStacked() {
                            var t = svg.transition().duration(750),
                            g = t.selectAll(".d3-bar-group").attr("transform", "translate(0," + y0(y0.domain()[0]) + ")");
                            g.selectAll(".d3-bar").attr("y", function(d) { return y1(d.value + d.valueOffset) });
                            g.select(".d3-group-label").attr("y", function(d) { return y1(d.values[0].value / 2 + d.values[0].valueOffset); })
                        }
                    });



                    // Resize chart
                    // ------------------------------

                    // Call function on window resize
                    $(window).on('resize', resize);

                    // Call function on sidebar width change
                    $('.sidebar-control').on('click', resize);

                    // Resize function
                    // 
                    // Since D3 doesn't support SVG resize by default,
                    // we need to manually specify parts of the graph that need to 
                    // be updated on window resize
                    function resize() {

                        // Layout variables
                        width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;


                        // Layout
                        // -------------------------

                        // Main svg width
                        container.attr("width", width + margin.left + margin.right);

                        // Width of appended group
                        svg.attr("width", width + margin.left + margin.right);


                        // Axes
                        // -------------------------

                        // Horizontal range
                        x.rangeRoundBands([0, width], .2);

                        // Horizontal axis
                        svg.selectAll('.d3-axis-horizontal').call(xAxis);


                        // Chart elements
                        // -------------------------

                        // Line path
                        svg.selectAll('.d3-bar').attr("x", function(d) { return x(d.date); }).attr("width", x.rangeBand());
                    }
                }
            });
            //////****** End Brand Sentiment JS *****//////
            </script>

            <script type="text/javascript">
            //////****** Basic Charts JS *****//////
            /* ------------------------------------------------------------------------------
             *
             *  # Echarts - pies and donuts
             *
             *  Pies and donuts chart configurations
             *
             *  Version: 1.0
             *  Latest update: August 1, 2015
             *
             * ---------------------------------------------------------------------------- */

            $(function () {

                // Set paths
                // ------------------------------

                require.config({
                    paths: {
                        echarts: 'assets/js/plugins/visualization/echarts'
                    }
                });


                // Configuration
                // ------------------------------

                require(
                    [
                        'echarts',
                        'echarts/theme/limitless',
                        'echarts/chart/pie',
                        'echarts/chart/funnel'
                    ],


                    // Charts setup
                    function (ec, limitless) {


                        // Initialize charts
                        // ------------------------------

                        var multiple_donuts = ec.init(document.getElementById('multiple_donuts<?php echo $value;?>'), limitless);


                        // Charts setup
                        // ------------------------------ 

                        //
                        // Multiple donuts options
                        //

                        // Top text label
                        var labelTop = {
                            normal: {
                                label: {
                                    show: true,
                                    position: 'center',
                                    formatter: '{b}\n',
                                    textStyle: {
                                        baseline: 'middle',
                                        fontWeight: 300,
                                        fontSize: 15
                                    }
                                },
                                labelLine: {
                                    show: false
                                }
                            }
                        };

                        // Format bottom label
                        var labelFromatter = {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return '\n\n' + (100 - params.value) + '%'
                                    }
                                }
                            }
                        }

                        // Bottom text label
                        var labelBottom = {
                            normal: {
                                color: '#eee',
                                label: {
                                    show: true,
                                    position: 'center',
                                    textStyle: {
                                        baseline: 'middle'
                                    }
                                },
                                labelLine: {
                                    show: false
                                }
                            },
                            emphasis: {
                                color: 'rgba(0,0,0,0)'
                            }
                        };

                        // Set inner and outer radius
                        var radius = [50, 80];

                        // Showing Data for Basics Charts
                        <?php 
                        $resultBasics = $conn->query("SELECT * FROM brand_sentiment_basics_data WHERE user_id = $uid AND user_widget_id = " . $value); 
                        $basicsArray = array();
                        if($countBasicsDataRows = $resultBasics->num_rows > 0){
                            while($rowBasics = $resultBasics->fetch_assoc()){
                                $basicsArray['Basic Negative'] = $rowBasics['Basic Negative'];
                                $basicsArray['Basic Neutral'] = $rowBasics['Basic Neutral'];
                                $basicsArray['Basic Positive'] = $rowBasics['Basic Positive'];
                            }
                        }else{
                            $basicsArray['Basic Negative'] = 29;
                            $basicsArray['Basic Neutral'] = 66;
                            $basicsArray['Basic Positive'] = 5;
                        }
                        //print_r($basicsArray);
                        ?>   

                        // Add options
                        multiple_donuts_options = {

                            // Add title
                            title: {
                                text: 'Basics Charts',
                                subtext: '',
                                x: 'center'
                            },

                            // Add legend
                            legend: {
                                x: 'center',
                                y: '20%',
                                data: ['Basic Negative', 'Basic Neutral', 'Basic Positive']
                            },

                            // Add series
                            series: [
                                {
                                    type: 'pie',
                                    center: ['25%', '50%'],
                                    radius: radius,
                                    itemStyle: labelFromatter,
                                    data: [
                                        {name: 'other', value: <?php echo (100 - $basicsArray['Basic Negative']);?>, itemStyle: labelBottom},
                                        {name: 'Basic Negative', value: <?php echo $basicsArray['Basic Negative'];?>,itemStyle: labelTop}
                                    ]
                                },
                                {
                                    type: 'pie',
                                    center: ['50%', '50%'],
                                    radius: radius,
                                    itemStyle: labelFromatter,
                                    data: [
                                        {name: 'other', value: <?php echo (100 - $basicsArray['Basic Neutral']);?>, itemStyle: labelBottom},
                                        {name: 'Basic Neutral', value: <?php echo $basicsArray['Basic Neutral'];?>,itemStyle: labelTop}
                                    ]
                                },
                                {
                                    type: 'pie',
                                    center: ['75%', '50%'],
                                    radius: radius,
                                    itemStyle: labelFromatter,
                                    data: [
                                        {name: 'other', value: <?php echo (100 -$basicsArray['Basic Positive']);?>, itemStyle: labelBottom},
                                        {name: 'Basic Positive', value: <?php echo $basicsArray['Basic Positive'];?>,itemStyle: labelTop}
                                    ]
                                }
                            ]
                        };



                        // Apply options
                        // ------------------------------

                        multiple_donuts.setOption(multiple_donuts_options);



                        // Resize charts
                        // ------------------------------

                        window.onresize = function () {
                            setTimeout(function (){
                                multiple_donuts.resize();
                            }, 200);
                        }
                    }
                );
            });
            //////****** End Basic Charts JS *****//////
            </script>
            <?php 
        }// End for each loop
    }// End if condition 


    if(array_key_exists(4, $user_data_exist_widgets_ids_array)){?>
        <!-- Topics and Trends JS files 
        <script type="text/javascript" src="assets/js/charts/d3/venn/venn_basic.js"></script>-->

        <!-- One time venn.js file inclusion for multiple Topics and Trends Charts -->
        <script type="text/javascript" src="assets/js/plugins/visualization/d3/venn.js"></script>
        <?php                  
        foreach ($user_data_exist_widgets_ids_array[4] as $key => $value) {
            ?>
            <script type="text/javascript">
            //////****** Topics and Trends JS *****//////
            /* ------------------------------------------------------------------------------
             *
             *  # D3.js - basic Venn diagram
             *
             *  Basic demo d3.js Venn diagram setup
             *
             *  Version: 1.0
             *  Latest update: August 1, 2015
             *
             * ---------------------------------------------------------------------------- */

            $(function () {


                // Data set
                // ------------------------------


                /////**** Dynamic Topics and Trends Chart Data showing for particular user ****////
                <?php 
                $change_widget_name = $change_widgets_names_array[4];
                $widget_data_table_name = $change_widget_name."_data";
                $resultTopicsTrends = $conn->query("SELECT * FROM  $widget_data_table_name WHERE user_id = $uid AND user_widget_id = " . $value);
                $countTopicsTrendsRows = $resultTopicsTrends->num_rows;
                if($countTopicsTrendsRows > 0){
                    $TopicsTrendsDataString = "[";
                    $i = 1;
                    while($rowTopicsTrends = $resultTopicsTrends->fetch_assoc()){
                        $TopicsTrendsDataString .= "{label: '".$rowTopicsTrends['label']."', size: '".$rowTopicsTrends['size']."'}".(($i == $countTopicsTrendsRows) ? "" : ",");
                        $i++;
                    }
                    $TopicsTrendsDataString .= "]";
                }else{
                    $TopicsTrendsDataString ="[
                                                {label: 'SE', size: 28},
                                                {label: 'Treat', size: 35},
                                                {label: 'Anti-CCP', size: 108},
                                                {label: 'DAS28', size: 106}
                                            ]";
                }
                ?>

                // Circles
                var sets = <?php echo $TopicsTrendsDataString; ?>;

                // Overlaps
                var overlaps = [
                    {sets: [0,1], size: 1},
                    {sets: [0,2], size: 1},
                    {sets: [0,3], size: 14},
                    {sets: [1,2], size: 6},
                    {sets: [1,3], size: 0},
                    {sets: [2,3], size: 1},
                    {sets: [0,2,3], size: 1},
                    {sets: [0,1,2], size: 0},
                    {sets: [0,1,3], size: 0},
                    {sets: [1,2,3], size: 0},
                    {sets: [0,1,2,3], size: 0}
                ];


                // Initialize chart
                // ------------------------------

                // Draw diagram
                var diagram = venn.drawD3Diagram(d3.select("#d3-venn-basic<?php echo $value;?>"), venn.venn(sets, overlaps), 350, 350);


                // Make text semi bold
                diagram.text.style("font-weight", "500");
            });
            //////****** End Topics and Trends JS *****//////
            </script>
            <?php 
        }//End for each loop
    }// End if condition

    if(array_key_exists(5, $user_data_exist_widgets_ids_array)){                  
        foreach ($user_data_exist_widgets_ids_array[5] as $key => $value) {
            ?>
            <!-- Desktop and Mobile Performance JS files 
            <script type="text/javascript" src="assets/js/charts/d3/lines/lines_basic_multi_series.js"></script>-->
            <script type="text/javascript">
            //////****** Desktop and Mobile Performance JS *****//////
            /* ------------------------------------------------------------------------------
             *
             *  # D3.js - multi series line chart
             *
             *  Demo d3.js multi series line chart setup with .tsv data source
             *
             *  Version: 1.0
             *  Latest update: August 1, 2015
             *
             * ---------------------------------------------------------------------------- */

            $(function () {

                // Initialize chart
                lineBasic('#d3-line-multi-series<?php echo $value;?>', 400);

                // Chart setup
                function lineBasic(element, height) {


                    // Basic setup
                    // ------------------------------

                    // Define main variables
                    var d3Container = d3.select(element),
                        margin = {top: 5, right: 100, bottom: 20, left: 40},
                        width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
                        height = height - margin.top - margin.bottom - 5;

                    // Format data
                    var parseDate = d3.time.format("%Y%m%d").parse;

                    // Colors
                    var color = d3.scale.category10();



                    // Construct scales
                    // ------------------------------

                    // Horizontal
                    var x = d3.time.scale()
                        .range([0, width]);

                    // Vertical
                    var y = d3.scale.linear()
                        .range([height, 0]);



                    // Create axes
                    // ------------------------------

                    // Horizontal
                    var xAxis = d3.svg.axis()
                        .scale(x)
                        .orient("bottom")
                        .ticks(5)
                        .tickFormat(d3.time.format("%b"));

                    // Vertical
                    var yAxis = d3.svg.axis()
                        .scale(y)
                        .orient("left");



                    // Create chart
                    // ------------------------------

                    // Add SVG element
                    var container = d3Container.append("svg");

                    // Add SVG group
                    var svg = container
                        .attr("width", width + margin.left + margin.right)
                        .attr("height", height + margin.top + margin.bottom)
                        .append("g")
                            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



                    // Construct chart layout
                    // ------------------------------

                    // Line
                    var line = d3.svg.line()
                        .interpolate("basis")
                        .x(function(d) { return x(d.date); })
                        .y(function(d) { return y(d.temperature); });



                    // Load data
                    // ------------------------------

                    d3.tsv(<?php echo ((isset($user_widgets_data_array[5]))? '"'.$user_widgets_data_array[5][$key].'"' : '"'.'assets/demo_data/d3/lines/lines_multi_series.tsv'.'"') ?>, function(error, data) {

                        // Pull out values
                        data.forEach(function(d) {
                            d.date = parseDate(d.date);
                        });


                        // Set color domains
                        // ------------------------------

                        // Filter by date
                        color.domain(d3.keys(data[0]).filter(function(key) { return key !== "date"; }));

                        // Set colors
                        var cities = color.domain().map(function(name) {
                            return {
                                name: name,
                                values: data.map(function(d) {
                                    return {date: d.date, temperature: +d[name]};
                                })
                            }
                        });



                        // Set input domains
                        // ------------------------------

                        // Horizontal
                        x.domain(d3.extent(data, function(d) { return d.date; }));

                        // Vertical
                        y.domain([
                            d3.min(cities, function(c) { return d3.min(c.values, function(v) { return v.temperature; }); }),
                            d3.max(cities, function(c) { return d3.max(c.values, function(v) { return v.temperature; }); })
                        ]);



                        //
                        // Append chart elements
                        //

                        // Bind data
                        var city = svg.selectAll(".multiline-city")
                            .data(cities)
                            .enter()
                            .append("g")
                                .attr("class", "multiline-city");

                        // Add line
                        city.append("path")
                            .attr("class", "d3-line d3-line-medium")
                            .attr("d", function(d) { return line(d.values); })
                            .style("stroke", function(d) { return color(d.name); });

                        // Add text
                        city.append("text")
                            .datum(function(d) { return {name: d.name, value: d.values[d.values.length - 1]}; })
                            .attr("transform", function(d) { return "translate(" + x(d.value.date) + "," + y(d.value.temperature) + ")"; })
                            .attr("class", "d3-cities")
                            .attr("x", 10)
                            .attr("dy", ".35em")
                            .text(function(d) { return d.name; });
                    


                        // Append axes
                        // ------------------------------

                        // Horizontal
                        svg.append("g")
                            .attr("class", "d3-axis d3-axis-horizontal d3-axis-strong")
                            .attr("transform", "translate(0," + height + ")")
                            .call(xAxis);

                        // Vertical
                        var verticalAxis = svg.append("g")
                            .attr("class", "d3-axis d3-axis-vertical d3-axis-strong")
                            .call(yAxis);

                        // Add text label
                        verticalAxis.append("text")
                            .attr("transform", "rotate(-90)")
                            .attr("y", 10)
                            .attr("dy", ".71em")
                            .style("text-anchor", "end")
                            .style("fill", "#999")
                            .style("font-size", 12)
                            .text("Temperature (ºF)");
                    })



                    // Resize chart
                    // ------------------------------

                    // Call function on window resize
                    $(window).on('resize', resize);

                    // Call function on sidebar width change
                    $('.sidebar-control').on('click', resize);

                    // Resize function
                    // 
                    // Since D3 doesn't support SVG resize by default,
                    // we need to manually specify parts of the graph that need to 
                    // be updated on window resize
                    function resize() {

                        // Layout variables
                        width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;


                        // Layout
                        // -------------------------

                        // Main svg width
                        container.attr("width", width + margin.left + margin.right);

                        // Width of appended group
                        svg.attr("width", width + margin.left + margin.right);


                        // Axes
                        // -------------------------

                        // Horizontal range
                        x.range([0, width]);

                        // Horizontal axis
                        svg.selectAll('.d3-axis-horizontal').call(xAxis);


                        // Chart elements
                        // -------------------------

                        // Line path
                        svg.selectAll('.d3-line').attr("d", function(d) { return line(d.values); });

                        // Text
                        svg.selectAll('.d3-cities').attr("transform", function(d) { return "translate(" + x(d.value.date) + "," + y(d.value.temperature) + ")"; })
                    }
                }
            });
            //////****** End Desktop and Mobile Performance JS *****//////
            </script>
            <?php 
        }// End for each loop
    } // End if condition
    

    if(array_key_exists(6, $user_data_exist_widgets_ids_array)){
        foreach($user_data_exist_widgets_ids_array[6] as $key => $value){
            ?>
            <!-- Marketing Performance JS files 
            <script type="text/javascript" src="assets/js/charts/d3/bars/bars_basic_vertical.js"></script>-->
            <script type="text/javascript">
            //////****** Marketing Performance JS *****//////
            /* ------------------------------------------------------------------------------
             *
             *  # D3.js - vertical bar chart
             *
             *  Demo d3.js vertical bar chart setup with .tsv data source
             *
             *  Version: 1.0
             *  Latest update: August 1, 2015
             *
             * ---------------------------------------------------------------------------- */

            $(function () {

                // Initialize chart
                barVertical('#d3-bar-vertical<?php echo $value;?>', 400);

                // Chart setup
                function barVertical(element, height) {


                    // Basic setup
                    // ------------------------------

                    // Define main variables
                    var d3Container = d3.select(element),
                        margin = {top: 5, right: 10, bottom: 20, left: 40},
                        width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
                        height = height - margin.top - margin.bottom - 5;



                    // Construct scales
                    // ------------------------------

                    // Horizontal
                    var x = d3.scale.ordinal()
                        .rangeRoundBands([0, width], .1, .5);

                    // Vertical
                    var y = d3.scale.linear()
                        .range([height, 0]);

                    // Color
                    var color = d3.scale.category20c();



                    // Create axes
                    // ------------------------------

                    // Horizontal
                    var xAxis = d3.svg.axis()
                        .scale(x)
                        .orient("bottom");

                    // Vertical
                    var yAxis = d3.svg.axis()
                        .scale(y)
                        .orient("left")
                        .ticks(10, "%");



                    // Create chart
                    // ------------------------------

                    // Add SVG element
                    var container = d3Container.append("svg");

                    // Add SVG group
                    var svg = container
                        .attr("width", width + margin.left + margin.right)
                        .attr("height", height + margin.top + margin.bottom)
                        .append("g")
                            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



                    // Load data
                    // ------------------------------

                    d3.tsv(<?php echo ((isset($user_widgets_data_array[6]))? '"'.$user_widgets_data_array[6][$key].'"' : '"'.'assets/demo_data/d3/bars/bars_basic.tsv'.'"') ?>, function(error, data) {

                        // Pull out values
                        data.forEach(function(d) {
                            d.frequency = +d.frequency;
                        });


                        // Set input domains
                        // ------------------------------

                        // Horizontal
                        x.domain(data.map(function(d) { return d.letter; }));

                        // Vertical
                        y.domain([0, d3.max(data, function(d) { return d.frequency; })]);


                        //
                        // Append chart elements
                        //

                        // Append axes
                        // ------------------------------

                        // Horizontal
                        svg.append("g")
                            .attr("class", "d3-axis d3-axis-horizontal d3-axis-strong")
                            .attr("transform", "translate(0," + height + ")")
                            .call(xAxis);

                        // Vertical
                        var verticalAxis = svg.append("g")
                            .attr("class", "d3-axis d3-axis-vertical d3-axis-strong")
                            .call(yAxis);

                        // Add text label
                        verticalAxis.append("text")
                            .attr("transform", "rotate(-90)")
                            .attr("y", 10)
                            .attr("dy", ".71em")
                            .style("text-anchor", "end")
                            .style("fill", "#999")
                            .style("font-size", 12)
                            .text("Frequency");


                        // Add bars
                        svg.selectAll(".d3-bar")
                            .data(data)
                            .enter()
                            .append("rect")
                                .attr("class", "d3-bar")
                                .attr("x", function(d) { return x(d.letter); })
                                .attr("width", x.rangeBand())
                                .attr("y", function(d) { return y(d.frequency); })
                                .attr("height", function(d) { return height - y(d.frequency); })
                                .style("fill", function(d) { return color(d.letter); });
                    });



                    // Resize chart
                    // ------------------------------

                    // Call function on window resize
                    $(window).on('resize', resize);

                    // Call function on sidebar width change
                    $('.sidebar-control').on('click', resize);

                    // Resize function
                    // 
                    // Since D3 doesn't support SVG resize by default,
                    // we need to manually specify parts of the graph that need to 
                    // be updated on window resize
                    function resize() {

                        // Layout variables
                        width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;


                        // Layout
                        // -------------------------

                        // Main svg width
                        container.attr("width", width + margin.left + margin.right);

                        // Width of appended group
                        svg.attr("width", width + margin.left + margin.right);


                        // Axes
                        // -------------------------

                        // Horizontal range
                        x.rangeRoundBands([0, width], .1, .5);

                        // Horizontal axis
                        svg.selectAll('.d3-axis-horizontal').call(xAxis);


                        // Chart elements
                        // -------------------------

                        // Line path
                        svg.selectAll('.d3-bar').attr("x", function(d) { return x(d.letter); }).attr("width", x.rangeBand());
                    }
                }
            });
            </script>
            <!--<script type="text/javascript" src="assets/js/charts/c3/c3_bars_pies.js"></script>-->
            <script type="text/javascript">/* ------------------------------------------------------------------------------
             *
             *  # C3.js - bars and pies
             *
             *  Demo setup of bars, pies and chart combinations
             *
             *  Version: 1.0
             *  Latest update: August 1, 2015
             *
             * ---------------------------------------------------------------------------- */

            $(function () {
                

                // Pie chart
                // ------------------------------

                // Generate chart
                var pie_chart = c3.generate({
                    bindto: '#c3-pie-chart',
                    size: { width: 350 },
                    color: {
                        pattern: ['#3F51B5', '#FF9800', '#4CAF50', '#00BCD4', '#F44336']
                    },
                    data: {
                        columns: [
                            ['data1', 30],
                            ['data2', 120],
                        ],
                        type : 'pie'
                    }
                });

                // Change data
                setTimeout(function () {
                    pie_chart.load({
                        columns: [
                            ["setosa", 0.2, 0.2, 0.2, 0.2, 0.2, 0.4, 0.3, 0.2, 0.2, 0.1, 0.2, 0.2, 0.1, 0.1, 0.2, 0.4, 0.4, 0.3, 0.3, 0.3, 0.2, 0.4, 0.2, 0.5, 0.2, 0.2, 0.4, 0.2, 0.2, 0.2, 0.2, 0.4, 0.1, 0.2, 0.2, 0.2, 0.2, 0.1, 0.2, 0.2, 0.3, 0.3, 0.2, 0.6, 0.4, 0.3, 0.2, 0.2, 0.2, 0.2],
                            ["versicolor", 1.4, 1.5, 1.5, 1.3, 1.5, 1.3, 1.6, 1.0, 1.3, 1.4, 1.0, 1.5, 1.0, 1.4, 1.3, 1.4, 1.5, 1.0, 1.5, 1.1, 1.8, 1.3, 1.5, 1.2, 1.3, 1.4, 1.4, 1.7, 1.5, 1.0, 1.1, 1.0, 1.2, 1.6, 1.5, 1.6, 1.5, 1.3, 1.3, 1.3, 1.2, 1.4, 1.2, 1.0, 1.3, 1.2, 1.3, 1.3, 1.1, 1.3],
                            ["virginica", 2.5, 1.9, 2.1, 1.8, 2.2, 2.1, 1.7, 1.8, 1.8, 2.5, 2.0, 1.9, 2.1, 2.0, 2.4, 2.3, 1.8, 2.2, 2.3, 1.5, 2.3, 2.0, 2.0, 1.8, 2.1, 1.8, 1.8, 1.8, 2.1, 1.6, 1.9, 2.0, 2.2, 1.5, 1.4, 2.3, 2.4, 1.8, 1.8, 2.1, 2.4, 2.3, 1.9, 2.3, 2.5, 2.3, 1.9, 2.0, 2.3, 1.8],
                        ]
                    });
                }, 4000);
                setTimeout(function () {
                    pie_chart.unload({
                        ids: 'data1'
                    });
                    pie_chart.unload({
                        ids: 'data2'
                    });
                }, 8000);



                // Donut chart
                // ------------------------------

                // Generate chart
                var donut_chart = c3.generate({
                    bindto: '#c3-donut-chart',
                    size: { width: 350 },
                    color: {
                        pattern: ['#3F51B5', '#FF9800', '#4CAF50', '#00BCD4', '#F44336']
                    },
                    data: {
                        columns: [
                            ['data1', 30],
                            ['data2', 120],
                        ],
                        type : 'donut'
                    },
                    donut: {
                        title: "Iris Petal Width"
                    }
                });

                // Change data
                setTimeout(function () {
                    donut_chart.load({
                        columns: [
                            ["setosa", 0.2, 0.2, 0.2, 0.2, 0.2, 0.4, 0.3, 0.2, 0.2, 0.1, 0.2, 0.2, 0.1, 0.1, 0.2, 0.4, 0.4, 0.3, 0.3, 0.3, 0.2, 0.4, 0.2, 0.5, 0.2, 0.2, 0.4, 0.2, 0.2, 0.2, 0.2, 0.4, 0.1, 0.2, 0.2, 0.2, 0.2, 0.1, 0.2, 0.2, 0.3, 0.3, 0.2, 0.6, 0.4, 0.3, 0.2, 0.2, 0.2, 0.2],
                            ["versicolor", 1.4, 1.5, 1.5, 1.3, 1.5, 1.3, 1.6, 1.0, 1.3, 1.4, 1.0, 1.5, 1.0, 1.4, 1.3, 1.4, 1.5, 1.0, 1.5, 1.1, 1.8, 1.3, 1.5, 1.2, 1.3, 1.4, 1.4, 1.7, 1.5, 1.0, 1.1, 1.0, 1.2, 1.6, 1.5, 1.6, 1.5, 1.3, 1.3, 1.3, 1.2, 1.4, 1.2, 1.0, 1.3, 1.2, 1.3, 1.3, 1.1, 1.3],
                            ["virginica", 2.5, 1.9, 2.1, 1.8, 2.2, 2.1, 1.7, 1.8, 1.8, 2.5, 2.0, 1.9, 2.1, 2.0, 2.4, 2.3, 1.8, 2.2, 2.3, 1.5, 2.3, 2.0, 2.0, 1.8, 2.1, 1.8, 1.8, 1.8, 2.1, 1.6, 1.9, 2.0, 2.2, 1.5, 1.4, 2.3, 2.4, 1.8, 1.8, 2.1, 2.4, 2.3, 1.9, 2.3, 2.5, 2.3, 1.9, 2.0, 2.3, 1.8],
                        ]
                    });
                }, 4000);
                setTimeout(function () {
                    donut_chart.unload({
                        ids: 'data1'
                    });
                    donut_chart.unload({
                        ids: 'data2'
                    });
                }, 8000);



                // Bar chart
                // ------------------------------

                // Generate chart
                var bar_chart = c3.generate({
                    bindto: '#c3-bar-chart',
                    size: { height: 400 },
                    data: {
                        columns: [
                            ['data1', 30, 200, 100, 400, 150, 250],
                            ['data2', 130, 100, 140, 200, 150, 50]
                        ],
                        type: 'bar'
                    },
                    color: {
                        pattern: ['#2196F3', '#FF9800', '#4CAF50']
                    },
                    bar: {
                        width: {
                            ratio: 0.5
                        }
                    },
                    grid: {
                        y: {
                            show: true
                        }
                    }
                });

                // Change data
                setTimeout(function () {
                    bar_chart.load({
                        columns: [
                            ['data3', 130, -150, 200, 300, -200, 100]
                        ]
                    });
                }, 6000);



                // Stacked bar chart
                // ------------------------------

                // Generate chart
                var bar_stacked_chart = c3.generate({
                    bindto: '#c3-bar-stacked-chart',
                    size: { height: 400 },
                    color: {
                        pattern: ['#FF9800', '#F44336', '#009688', '#4CAF50']
                    },
                    data: {
                        columns: [
                            ['data1', -30, 200, 200, 400, -150, 250],
                            ['data2', 130, 100, -100, 200, -150, 50],
                            ['data3', -230, 200, 200, -300, 250, 250]
                        ],
                        type: 'bar',
                        groups: [
                            ['data1', 'data2']
                        ]
                    },
                    grid: {
                        x: {
                            show: true
                        },
                        y: {
                            lines: [{value:0}]
                        }
                    }
                });

                // Change data
                setTimeout(function () {
                    bar_stacked_chart.groups([['data1', 'data2', 'data3']])
                }, 4000);
                setTimeout(function () {
                    bar_stacked_chart.load({
                        columns: [['data4', 100, -50, 150, 200, -300, -100]]
                    });
                }, 8000);
                setTimeout(function () {
                    bar_stacked_chart.groups([['data1', 'data2', 'data3', 'data4']])
                }, 10000);



                // Combined chart
                // ------------------------------

                //////////************** Dynamic Data show for marketting performance combination chart for  particular user *****************/////////////
                <?php      
                $change_widget_name = $change_widgets_names_array[6];
                $widget_data_table_name = $change_widget_name."_combination_data";

                $resultTableColumns = $conn->query("SHOW COLUMNS FROM " . $widget_data_table_name);
                $columnsArray = array();
                $changeColumnsArray = array();
                $i=0;

                while($rowWTableColumns = $resultTableColumns->fetch_assoc()){
                    if($i>1){
                        $columnsArray[] = $rowWTableColumns['Field'];
                        $changeColumnsArray[] = $rowWTableColumns['Field'];

                    }
                    $i++;
                }
                $changeColumnsString = implode(",", $changeColumnsArray);
                $resultMarketingPerformanceCombination = $conn->query("SELECT $changeColumnsString FROM $widget_data_table_name WHERE user_id = $uid AND user_widget_id = " . $value);
                $countMarketingPerformanceCombinationRows = $resultMarketingPerformanceCombination->num_rows;
                if($countMarketingPerformanceCombinationRows > 0){
                    $marketingPerformanceCombinationDataString = "["; 
                    $marketingPerformanceCombination = array();
                    $i = 0;
                    while($rowMarketingPerformanceCombination = $resultMarketingPerformanceCombination->fetch_row()){
                        $marketingPerformanceCombination[$i] = $rowMarketingPerformanceCombination;
                        $i++;
                    }

                    $flipMarketingPerformanceCombinationmarketingPerformanceCombination = array();

                    foreach ($marketingPerformanceCombination as $key => $subarr)
                    {
                            foreach ($subarr as $subkey => $subvalue)
                            {
                                 $flipMarketingPerformanceCombination[$subkey][$key] = $subvalue;
                            }
                    }
                    //print_r($flipMarketingPerformanceCombination);
                    $countFMPC = count($flipMarketingPerformanceCombination);
                    for($k=0; $k < $countFMPC; $k++){
                        $marketingPerformanceCombinationDataString .= "['data".($k+1)."',".implode(",",$flipMarketingPerformanceCombination[$k])."]".(($k < $countFMPC-1)? "," : "");
                    }
                    $marketingPerformanceCombinationDataString .= "]";
                }else{
                    $marketingPerformanceCombinationDataString ="[
                            ['data1', 30, 20, 50, 40, 60, 50],
                            ['data2', 200, 130, 90, 240, 130, 220],
                            ['data3', 300, 200, 160, 400, 250, 250],
                            ['data4', 200, 130, 90, 240, 130, 220],
                            ['data5', 130, 120, 150, 140, 160, 150],
                            ['data6', 90, 70, 20, 50, 60, 120],
                        ]";
                }
                //echo $marketingPerformanceCombinationDataString;
                ?>

                // Generate chart
                var combined_chart = c3.generate({
                    bindto: '#c3-combined-chart<?php echo $value;?>',
                    size: { height: 400 },
                    color: {
                        pattern: ['#FF9800', '#F44336', '#009688', '#4CAF50', '#03A9F4', '#8BC34A']
                    },
                    data: {
                        columns: <?php echo $marketingPerformanceCombinationDataString; ?>,
                        type: 'bar',
                        types: {
                            data3: 'spline',
                            data4: 'line',
                            data6: 'area',
                        },
                        groups: [
                            ['data1','data2']
                        ]
                    }
                });



                // Scatter chart
                // ------------------------------

                // Generate chart
                var scatter_chart = c3.generate({
                    size: { height: 400 },
                    bindto: '#c3-scatter-chart',
                    data: {
                        xs: {
                            setosa: 'setosa_x',
                            versicolor: 'versicolor_x',
                        },
                        columns: [
                            ["setosa_x", 3.5, 3.0, 3.2, 3.1, 3.6, 3.9, 3.4, 3.4, 2.9, 3.1, 3.7, 3.4, 3.0, 3.0, 4.0, 4.4, 3.9, 3.5, 3.8, 3.8, 3.4, 3.7, 3.6, 3.3, 3.4, 3.0, 3.4, 3.5, 3.4, 3.2, 3.1, 3.4, 4.1, 4.2, 3.1, 3.2, 3.5, 3.6, 3.0, 3.4, 3.5, 2.3, 3.2, 3.5, 3.8, 3.0, 3.8, 3.2, 3.7, 3.3],
                            ["versicolor_x", 3.2, 3.2, 3.1, 2.3, 2.8, 2.8, 3.3, 2.4, 2.9, 2.7, 2.0, 3.0, 2.2, 2.9, 2.9, 3.1, 3.0, 2.7, 2.2, 2.5, 3.2, 2.8, 2.5, 2.8, 2.9, 3.0, 2.8, 3.0, 2.9, 2.6, 2.4, 2.4, 2.7, 2.7, 3.0, 3.4, 3.1, 2.3, 3.0, 2.5, 2.6, 3.0, 2.6, 2.3, 2.7, 3.0, 2.9, 2.9, 2.5, 2.8],
                            ["setosa", 0.2, 0.2, 0.2, 0.2, 0.2, 0.4, 0.3, 0.2, 0.2, 0.1, 0.2, 0.2, 0.1, 0.1, 0.2, 0.4, 0.4, 0.3, 0.3, 0.3, 0.2, 0.4, 0.2, 0.5, 0.2, 0.2, 0.4, 0.2, 0.2, 0.2, 0.2, 0.4, 0.1, 0.2, 0.2, 0.2, 0.2, 0.1, 0.2, 0.2, 0.3, 0.3, 0.2, 0.6, 0.4, 0.3, 0.2, 0.2, 0.2, 0.2],
                            ["versicolor", 1.4, 1.5, 1.5, 1.3, 1.5, 1.3, 1.6, 1.0, 1.3, 1.4, 1.0, 1.5, 1.0, 1.4, 1.3, 1.4, 1.5, 1.0, 1.5, 1.1, 1.8, 1.3, 1.5, 1.2, 1.3, 1.4, 1.4, 1.7, 1.5, 1.0, 1.1, 1.0, 1.2, 1.6, 1.5, 1.6, 1.5, 1.3, 1.3, 1.3, 1.2, 1.4, 1.2, 1.0, 1.3, 1.2, 1.3, 1.3, 1.1, 1.3],
                        ],
                        type: 'scatter'
                    },
                    color: {
                        pattern: ['#4CAF50', '#F44336']
                    },
                    grid: {
                        y: {
                            show: true
                        }
                    },
                    point: { r: 5 },
                    axis: {
                        x: {
                            label: 'Sepal.Width',
                            tick: {
                                fit: false
                            }
                        },
                        y: {
                            label: 'Petal.Width'
                        }
                    }
                });

                // Change data
                setTimeout(function () {
                    scatter_chart.load({
                        xs: {
                            virginica: 'virginica_x'
                        },
                        columns: [
                            ["virginica_x", 3.3, 2.7, 3.0, 2.9, 3.0, 3.0, 2.5, 2.9, 2.5, 3.6, 3.2, 2.7, 3.0, 2.5, 2.8, 3.2, 3.0, 3.8, 2.6, 2.2, 3.2, 2.8, 2.8, 2.7, 3.3, 3.2, 2.8, 3.0, 2.8, 3.0, 2.8, 3.8, 2.8, 2.8, 2.6, 3.0, 3.4, 3.1, 3.0, 3.1, 3.1, 3.1, 2.7, 3.2, 3.3, 3.0, 2.5, 3.0, 3.4, 3.0],
                            ["virginica", 2.5, 1.9, 2.1, 1.8, 2.2, 2.1, 1.7, 1.8, 1.8, 2.5, 2.0, 1.9, 2.1, 2.0, 2.4, 2.3, 1.8, 2.2, 2.3, 1.5, 2.3, 2.0, 2.0, 1.8, 2.1, 1.8, 1.8, 1.8, 2.1, 1.6, 1.9, 2.0, 2.2, 1.5, 1.4, 2.3, 2.4, 1.8, 1.8, 2.1, 2.4, 2.3, 1.9, 2.3, 2.5, 2.3, 1.9, 2.0, 2.3, 1.8],
                        ]
                    });
                }, 4000);
                setTimeout(function () {
                    scatter_chart.unload({
                        ids: 'setosa'
                    });
                }, 8000);
                setTimeout(function () {
                    scatter_chart.load({
                        columns: [
                            ["virginica", 0.2, 0.2, 0.2, 0.2, 0.2, 0.4, 0.3, 0.2, 0.2, 0.1, 0.2, 0.2, 0.1, 0.1, 0.2, 0.4, 0.4, 0.3, 0.3, 0.3, 0.2, 0.4, 0.2, 0.5, 0.2, 0.2, 0.4, 0.2, 0.2, 0.2, 0.2, 0.4, 0.1, 0.2, 0.2, 0.2, 0.2, 0.1, 0.2, 0.2, 0.3, 0.3, 0.2, 0.6, 0.4, 0.3, 0.2, 0.2, 0.2, 0.2],
                        ]
                    });
                }, 10000);



                // Resize chart on sidebar width change
                $(".sidebar-control").on('click', function() {
                    pie_chart.resize();
                    donut_chart.resize();
                    bar_chart.resize();
                    bar_stacked_chart.resize();
                    combined_chart.resize();
                    scatter_chart.resize();
                });
            });
            //////****** End Marketing Performance JS *****//////
            </script>
            <?php 
        } // End for each loop
    } // End if condition


}///////////////******** End Dashboard Page Js Code ********/////////////
?>

</html>