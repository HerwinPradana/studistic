@extends('student/layouts.app')

@section('content')

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
	
	var backgroundColors = [
	    'rgba(255, 99, 132, 0.2)',
	    'rgba(54, 162, 235, 0.2)',
	    'rgba(255, 206, 86, 0.2)',
	    'rgba(75, 192, 192, 0.2)',
	    'rgba(153, 102, 255, 0.2)',
	    'rgba(255, 159, 64, 0.2)'
	];
	
	var borderColors = [
	    'rgba(255,99,132,1)',
	    'rgba(54, 162, 235, 1)',
	    'rgba(255, 206, 86, 1)',
	    'rgba(75, 192, 192, 1)',
	    'rgba(153, 102, 255, 1)',
	    'rgba(255, 159, 64, 1)'
	];
	
	var containers = [];
	var charts = [];
</script>
<div class="panel panel-default">
    <div class="panel-heading">Dashboard</div>

    <div class="panel-body">
	    <ul class="nav nav-tabs">
			@foreach($classes as $i => $class)
				<li role="presentation" @if($i == 0) class="active" @endif>
					<a href="#class_{{ $class->id }}">{{ $class->name }} - {{ $class->subject }}</a>
				</li>
			@endforeach
		</ul>
		<div class="tab-content">
			@foreach($classes as $i => $subject)
				<div role="tabpanel" class="tab-pane @if($i == 0) active @endif" id="class_{{ $class->id }}">
					<div class="container-fluid">
						@php
							$chart_labels = array();
							$chart_scores = array();
							$highest		= null;
							$lowest			= null;
							$total			= 0;
							$total_attempts	= 0;

							foreach($subject->assignments as $assignment){
								$score = $assignment->scores->first();
								
								if($score){
									$score = $score->score;
	
									$total += $score;
									$total_attempts += $assignment->attempts->where('created_by', Auth::user()->id)->count();
	
									if($highest)
										$highest = ($score > $highest)? $score : $highest;
									else
										$highest = $score;
	
									if($lowest)
										$lowest = ($score < $lowest)? $score : $lowest;
									else
										$lowest = $score;
								}
								else{
									$score = 0;
								}

								$chart_labels[] = '"'.$assignment->name.'"';
								$chart_scores[] = $score;
							}

							$highest = ($highest)? $highest : 0;
							$lowest	 = ($lowest)? $lowest : 0;
							$average = ($total > 0)? $total / $subject->assignments->count() : 0;
							$attempt_average = ($total_attempts > 0)? $total_attempts / $subject->assignments->count() : 0;
						@endphp
						<div class="row">
							<div class="col-md-9 col-sm-8">
								<canvas id="chart_{{ $class->id }}"></canvas>
							</div>
							<div class="col-md-3 col-sm-4">
								<table class="table">
									<thead>
										<tr><th class="text-center" colspan="2">Rekap Pengerjaan</th></tr>
									</thead>
									<tbody>
										<tr><th>Nilai Tertinggi</th><td>{{ $highest }}</td></tr>
										<tr><th>Nilai Terendah</th><td>{{ $lowest }}</td></tr>
										<tr><th>Nilai Rata-rata</th><td>{{ $average }}</td></tr>
										<tr><th>Rata-rata Pengerjaan</th><td>{{ $attempt_average }}</td></tr>
									</tbody>
								</table>
							</div>
						</div>
						<script>
							containers[{{ $subject->id }}] = document.getElementById("chart_{{ $class->id }}");
							charts[{{ $subject->id }}] = new Chart(containers[{{ $subject->id }}], {
								type: 'bar',
								data: {
									labels: [{!! implode(',', $chart_labels) !!}],
									datasets: [{
										label: 'Nilai Tugas',
										data: [{!! implode(',', $chart_scores) !!}],
										backgroundColor: backgroundColors,
										borderColor: borderColors,
										borderWidth: 1
									}]
								},
								options: options
							});
						</script>
					</div>
				</div>
			@endforeach
		</div>
    </div>
</div>
@endsection
