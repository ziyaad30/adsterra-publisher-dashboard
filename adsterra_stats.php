<style>
body {
    background: #f1f1f1;
    color: #444;
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
    line-height: 1.4em;
    min-width: 600px;
}
.custom_div_white {
	margin: 5px 5px 5px 5px;
    background: #fff;
    -moz-box-shadow: 0 0 7px 0 #BBB;
    -webkit-box-shadow: 0 0 7px 0 #BBB;
    box-shadow: 0 0 7px 0 #BBB;
    padding-left: 10px;
    font-size: 16px;
}

.money_purple {
font-size:28px;
color:#663399;
line-height: normal;
padding-bottom: 0px;
padding-top: 0px;
margin-top: 0px;
}
.money_green {
font-size:28px;
color:#009900;
line-height: normal;
padding-bottom: 0px;
padding-top: 0px;
margin-top: 0px;
}
.money_yellow {
font-size:28px;
color:#FF9900;
line-height: normal;
padding-bottom: 0px;
padding-top: 0px;
margin-top: 0px;
}
.money_red {
font-size:28px;
color:#FF3333;
line-height: normal;
padding-bottom: 0px;
padding-top: 0px;
margin-top: 0px;
}

.normal_txt {
font-size:12px;
line-height: normal;
margin-top: -20px;
}
</style>
<?php
$api_key = get_option('adsterra_option_apikey');

$first_day_of_year = date("Y-m-d", strtotime('first day of january this year'));

$start_day_last_month = date("Y-m-d", strtotime('first day of last month'));
$end_day_last_month = date("Y-m-d", strtotime('last day of last month'));

$start_day_this_month = date("Y-m-d", strtotime('first day of this month'));
$end_day_this_month = date("Y-m-d", strtotime('last day of this month'));

$today = date("Y-m-d");
?>
<div>
<br />
  <table width="100%" border="0" cellspacing="5" cellpadding="5">
    
    <tr>
      <td width="25%">&nbsp;</td>
      <td width="25%">&nbsp;</td>
      <td width="25%" align="center" valign="middle" class="custom_div_white">
	  <img src="<?php echo plugins_url( 'images/impression.png', __FILE__ );?>" width="34" height="36" align="absmiddle" /> Impressions
	  <p class="money_purple" id="impressions_this_year" align="center">0</p>	  </td>
      <td width="25%" align="center" valign="middle" class="custom_div_white">
	  <img src="<?php echo plugins_url( 'images/click.png', __FILE__ );?>" width="34" height="36" align="absmiddle" /> Clicks
	  <p class="money_purple" id="clicks_this_year" align="center">0</p>	  </td>
    </tr>
  </table>
</div>
<br />
<h1>
  <img src="<?php echo plugins_url( 'images/money-bag.png', __FILE__ );?>" width="34" height="36" align="absmiddle" /> Revenue
</h1>
<div class="custom_div_white">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td width="25%">
	Year to Date
	(YTD)
	  <p class="money_purple" id="revenue_this_year">$0.00</p>
	<p class="normal_txt"><?php echo date("F d", strtotime('first day of january this year'));?> - <?php echo date("F d, Y");?></p>
	</td>
    <td width="25%">
	Last Month
	<p class="money_green" id="revenue_last_month">$0.00</p>
	<p class="normal_txt"><?php echo date("F, Y", strtotime('last month'));?></p>
	</td>
    <td width="25%">
	This Month
	<p class="money_yellow" id="revenue_this_month">$0.00</p>
	<p class="normal_txt"><?php echo date("F, Y");?></p>
	</td>
    <td width="25%">
	<?php  echo date("l, F d, Y");?>
	<p class="money_red" id="revenue_today">$0.00</p>	</td>
  </tr>
</table>
</div>
<br />


<h1>
  <img src="<?php echo plugins_url( 'images/impressions.png', __FILE__ );?>" width="34" height="36" align="absmiddle" /> Statistics </h1>
<div class="custom_div_white">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="chart" align="center" style="width:auto; height:300px;"></div> </td>
  </tr>
</table>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
$(document).ready(function(){

function load_stats_today()
{
	$.getJSON('<?php echo plugins_url( 'api.php', __FILE__ );?>?id=<?php print $api_key?>&start_day=<?php echo $today;?>&end_day=<?php echo $today;?>', function (data) {
		for (i = 0; i < data.length; i++) {
			$('#revenue_today').html('$' + data[i].revenue.toFixed(3));
		}
	});
}

function load_stats_last_month()
{
	$.getJSON('<?php echo plugins_url( 'api.php', __FILE__ );?>?id=<?php print $api_key?>&start_day=<?php echo $start_day_last_month;?>&end_day=<?php echo $end_day_last_month;?>', function (data) {
		for (i = 0; i < data.length; i++) {
			$('#revenue_last_month').html('$' + data[i].revenue.toFixed(2));
		}
	});
}

function load_stats_this_month()
{
	$.getJSON('<?php echo plugins_url( 'api.php', __FILE__ );?>?id=<?php print $api_key?>&start_day=<?php echo $start_day_this_month;?>&end_day=<?php echo $end_day_this_month;?>', function (data) {
		for (i = 0; i < data.length; i++) {
			$('#revenue_this_month').html('$' + data[i].revenue.toFixed(2));
		}	
	});
}

function load_stats_this_year()
{
	$.getJSON('<?php echo plugins_url( 'api.php', __FILE__ );?>?id=<?php print $api_key?>&start_day=<?php echo $first_day_of_year;?>&end_day=<?php echo $end_day_this_month;?>', function (data) {
		for (i = 0; i < data.length; i++) {
			$('#revenue_this_year').html('$' + data[i].revenue.toFixed(2));
			$('#impressions_this_year').html(data[i].impressions);
			$('#clicks_this_year').html(data[i].clicks);
		}	
	});
}

// LOAD THE FUNCTIONS BELOW
load_stats_today();
load_stats_last_month();
load_stats_this_month();
load_stats_this_year();
});
</script>
<script>
    // Visualization API with the 'corechart' package.
    google.charts.load('visualization', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawLineChart);

    function drawLineChart() {
        $.ajax({
            xhrFields: {
                withCredentials: true
                },
            url: "<?php echo plugins_url( 'api.php', __FILE__ );?>?id=<?php print $api_key?>&start_day=<?php echo $first_day_of_year;?>&end_day=<?php echo $end_day_this_month;?>",
            beforeSend: function(){
                $("#chart").html('<img src="<?php echo plugins_url( 'images/loader.gif', __FILE__ );?>">');
            },
            dataType: "json",
            type: "GET",
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                var arrSales = [['Month', 'Revenue', 'Impressions']];    // Define an array and assign columns for the chart.

                // Loop through each data and populate the array.
                $.each(data, function (index, value) {
                    arrSales.push([new Date(value.date), value.value, value.daily_impressions]);
                });

                // Set chart Options.
                var options = {
                    curveType: 'function',
                    // y-axis settings
                    vAxes: 
                    {
                        0: 
                        {
                            title: 'Revenue',
                            format: 'currency'
                        },
                        1:
                        {
                            title: 'Impressions',
                            format: 'decimal'
                        }
                    },
                    // map series
                    series: 
                    {
                        0: 
                        {
                            targetAxisIndex: 0
                        },
                        1: 
                        {
                            targetAxisIndex: 1
                        }
                    },
                    hAxis: {
                        format: 'dd MMM yy',
                        gridlines:{color:'#fff'},
                        minorGridlines:{color:'#fff'},
                        textStyle: {color: '#7a7d80', fontSize: 12}
                    },
                    vAxis: {minorGridlines:{color:'#fff'}, textStyle: {color: '#7a7d80', fontSize: 12}},
                    legend: { position: 'bottom', textStyle: { color: '#555', fontSize: 14} },
                    pointSize: 5
                };

                // Create DataTable and add the array to it.
                var figures = google.visualization.arrayToDataTable(arrSales);
                
                var formatter = new google.visualization.DateFormat({pattern: 'dd MMM yy'});
                formatter.format(figures, 0);

                // Define the chart type (LineChart) and the container (a DIV in our case).
                var chart = new google.visualization.LineChart(document.getElementById('chart'));
                chart.draw(figures, options, formatter);      // Draw the chart with Options.
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Got an Error');
            }
        });
    }
</script>