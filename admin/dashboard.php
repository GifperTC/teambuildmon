<title> Dashboard </title>

<h2> Dashboard </h2>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="bg-white p-3 my-1 border rounded">
            <h4>Revenue chart</h4>

            <script type="text/javascript">
                google.charts.load('current', {
                    'packages': ['corechart']
                });

                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Topping');
                    data.addColumn('number', 'Slices');
                    data.addRows([
                        ['Apple', 3],
                        ['Orange', 1],
                        ['Strawberry', 1],
                        ['Banana', 1],
                        ['Peach', 2]
                    ]);

                    var options = {
                        'title': 'How Many Fruit I Ate Last Night',
                        'width': '95%',
                        'height': 300
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('chart1'));
                    chart.draw(data, options);
                }
            </script>

            <div id="chart1"></div>

        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="bg-white p-3 my-2 border rounded">
            <h4>Revenue by product group</h4>
            <script type="text/javascript">
                google.charts.load('current', {
                    'packages': ['corechart']
                });

                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Topping');
                    data.addColumn('number', 'Slices');
                    data.addRows([
                        ['Mushrooms', 3],
                        ['Onions', 1],
                        ['Olives', 1],
                        ['Zucchini', 1],
                        ['Pepperoni', 2]
                    ]);

                    var options = {
                        'title': 'How Much Pizza I Ate Last Night',
                        'width': '95%',
                        'height': 300
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('chart2'));
                    chart.draw(data, options);
                }
            </script>

            <div id="chart2"></div>

        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="bg-white p-3 my-2 border rounded">
            <h4>Revenue growth chart</h4>

            <script type="text/javascript">
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Year', 'Sales', 'Expenses'],
                        ['2004', 1000, 400],
                        ['2005', 1170, 460],
                        ['2006', 660, 1120],
                        ['2007', 1030, 540]
                    ]);

                    var options = {
                        title: 'Company Performance',
                        curveType: 'function',
                        legend: {
                            position: 'bottom'
                        }
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('chart3'));

                    chart.draw(data, options);
                }
            </script>

            <div id="chart3"></div>

        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="bg-white p-3 my-2 border rounded">
            <h4>Revenue by market</h4>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="bg-white p-3 my-2 border rounded">
            <h4>Top 5 product groups</h4>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="bg-white p-3 my-2 border rounded">
            <h4>Top 5 domestic products</h4>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="bg-white p-3 my-2 border rounded">
            <h4>Top 5 overseas products</h4>
        </div>
    </div>


</div>