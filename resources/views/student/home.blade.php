@extends('student/layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">Dashboard</div>

    <div class="panel-body">
    	<canvas id="myChart"></canvas>
		<script>
			var options = {
				scales: {
					yAxes: [{
					    ticks: {
					        beginAtZero:true,
							steps: 10,
                            stepValue: 1,
                            max: 10
					    }
					}]
				}
			};
			
			var ctx = document.getElementById("myChart");
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ["Bidang 2 Dimensi", "Trigonometri", "Bidang 3 Dimensi", "Transformasi Bidang 2 Dimensi", "Transformasi Bidang 3 Dimensi", "Kalkulus Diferensial"],
					datasets: [{
						label: 'Rata-Rata Nilai Matematika',
			            data: [9, 8, 8, 9, 7, 6],
						backgroundColor: [
						    'rgba(255, 99, 132, 0.2)',
						    'rgba(54, 162, 235, 0.2)',
						    'rgba(255, 206, 86, 0.2)',
						    'rgba(75, 192, 192, 0.2)',
						    'rgba(153, 102, 255, 0.2)',
						    'rgba(255, 159, 64, 0.2)'
						],
						borderColor: [
						    'rgba(255,99,132,1)',
						    'rgba(54, 162, 235, 1)',
						    'rgba(255, 206, 86, 1)',
						    'rgba(75, 192, 192, 1)',
						    'rgba(153, 102, 255, 1)',
						    'rgba(255, 159, 64, 1)'
						],
						borderWidth: 1
					}]
				},
				options: options
			});
		</script>
    </div>
</div>
@endsection
