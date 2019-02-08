
<?

	use App\Own\Own;

?>

@extends('layout')

@section('title')
	Income resume
@stop

@section('content')

			{{ csrf_field() }}
			
			<h1>Resumen de ingresos Septiembre 2016</h1>

			<br>

			<div class="row">
				
				<div class="col-lg-3">

					<legend>Giro comercial</legend>

					<div id="tradingsChart" style=""></div>

					<br>

					<? echo Own::arrayToTable($tradingResume, '', '', ['route' => '', 'glyphicon' => '', 'label' => '']) ?>
					
				</div>

				<div class="col-lg-3">
					
					<legend>Zona</legend>

					<div id="zonesChart" style=""></div>

					<br>
					
					<? echo Own::arrayToTable($zonesResume, '', '', ['route' => '', 'glyphicon' => '', 'label' => '']) ?>
					
					<br>	
				
				</div>

				<div class="col-lg-3">
					
					<legend>Origen</legend>

					<div id="isLocalChart" style=""></div>
	
					<br>

					<? echo Own::arrayToTable($localResume, '', '', ['route' => '', 'glyphicon' => '', 'label' => '']) ?>

				</div>

				<div class="col-lg-3">
					
					<legend>Dia</legend>

					<div id="dayChart" style=""></div>
	
					<br>

					<? echo Own::arrayToTable($dayResume, '', '', ['route' => '', 'glyphicon' => '', 'label' => '']) ?>
				</div>

			</div>

@stop	

@section('script')
	<script src="{{ asset('public/j/jquery-3.0.0.js') }}"></script>
	<script src="{{ asset('public/j/bootstrap.js') }}"></script>

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script>

		$(document).ready(function(){

			// Get data series from database
			$.ajax({

				url : 'getIncomeSeries',
				method : 'post',
				dataType : 'json',
				data : {
					'_token' : $('input[name=_token]').val()
				},
				success : function(incomeSeries){

					renderIncomeChart(incomeSeries.zones, '#zonesChart');
					renderIncomeChart(incomeSeries.isLocal, '#isLocalChart');
					renderIncomeChart(incomeSeries.day, '#dayChart');
					renderIncomeChart(incomeSeries.tradings, '#tradingsChart');

				}, 
				error: function(response){

					$('#message').html(response.responseText);

				}

			});


			// We render each data serie to a bar chart
			function renderIncomeChart(grossData, localizator){

				var serieValues = [];

				$.each(grossData, function(c, v){

					serieValue = {
						name : v.name,
						data : [parseInt(v.data)]
					}

					serieValues.push(serieValue);

				});

				$(localizator).highcharts({
			        chart: {
			            type: 'column'
			        },
			        title: {
			            text: ''
			        },
			        xAxis: {
			            categories: ['']
			        },
			        yAxis: {
			            min: 0,
			            title: {
			                text: 'Ingreso'
			            },
			            stackLabels: {
			                enabled: true,
			                style: {
			                    fontWeight: 'bold',
			                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
			                }
			            }
			        },
			        legend: {
			            align: 'center',
			            x: -30,
			            verticalAlign: 'bottom',
			            y: 25,
			            floating: false,
			            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
			            borderColor: '#CCC',
			            borderWidth: 1,
			            shadow: false,
			            enabled: false
			        },
			        tooltip: {
			            headerFormat: '<b>{point.x}</b><br/>',
			            pointFormat: '{series.name}:${point.y}<br/>Total:${point.stackTotal}'
			        },
			        plotOptions: {
			            column: {
			                stacking: 'normal',
			                dataLabels: {
			                    enabled: true,
			                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
			                    style: {
			                        textShadow: '0 0 3px black'
			                    }
			                }
			            }
			        },
			        series: serieValues,
			        credits: {
			        	enabled: false
			        },
			        exporting: {
			        	enabled: false
			        }
			    });

			}

		});
	</script>
@stop	