@extends('student/layouts.app')

@section('content')

@php

$n_questions	= $assignment->questions->count();
$chart_labels	= array();
$chart_data		= array();
$highest		= null;
$lowest			= null;
$total			= 0;

foreach($attempts as $no => $attempt){
	$chart_labels[]	= '"#'.($no + 1).'"';
	$chart_data[]	= $attempt->score;
	
	$total += $attempt->score;
	
	if($highest)
		$highest = ($attempt->score > $highest)? $attempt->score : $highest;
	else
		$highest = $attempt->score;
	
	if($lowest)
		$lowest = ($attempt->score < $lowest)? $attempt->score : $lowest;
	else
		$lowest = $attempt->score;
}

$highest = ($highest)? $highest : 0;
$lowest	 = ($lowest)? $lowest : 0;
$average = ($total > 0)? $total / $attempts->count() : 0;

@endphp

<div class="panel panel-default">
    <div class="panel-heading">
    	<div class="row">
			<div class="col-md-6">Hasil Pengerjaan</div>
			<div class="col-md-6">
				<div class="btn-group pull-right" role="group">
					<a href="{{ url('/assignments/'.$assignment->id.'/edit') }}" type="button" class="btn btn-success btn-xs">
						<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Kerjakan Lagi
					</a>
					<a href="{{ url('/assignments') }}" type="button" class="btn btn-warning btn-xs">
						<span class="glyphicon glyphicon-share" aria-hidden="true"></span> Kembali
					</a>
				</div>
			</div>
    	</div>
	</div>

    <div class="panel-body">
    	<div class="container-fluid">
			<div class="row">
				<div class="col-md-9 col-sm-8">
					<canvas id="attemptChart"></canvas>
				</div>
				<div class="col-md-3 col-sm-4">
					<table class="table">
						<thead>
							<tr><th class="text-center" colspan="2">Rekap Pengerjaan</th></tr>
						</thead>
						<tbody>
							<tr><th>Nilai Tertinggi</th><td>{{ $highest }}</td></tr>
							<tr><th>Nilai Terendah</th><td>{{ $lowest }}</td></tr>
							<tr><th>Nilai Rata-rata</th><td>{{ round($average, 2) }}</td></tr>
						</tbody>
					</table>
					<table class="table">
						<thead>
							<tr><th class="text-center" colspan="4">Rincian Pengerjaan</th></tr>
							<tr>
								<th class="text-center" style="width:35px;">No</th>
								<th class="text-center">Nilai</th>
								<th class="text-center">Jawaban Benar</th>
								<th style="width:35px;"></th>
							</tr>
						</thead>
						<tbody>
							@if(!empty($attempts))
								@foreach($attempts as $no => $attempt)
									<tr>
										<td>#{{ $no + 1 }}</td>
										<td class="text-center">{{ $attempt->score }}</td>
										<td class="text-center">
											{{ $attempt->answers()->whereHas('option', function($query){
												$query->where('is_correct', 1);
											})->count() }}
											/
											{{ $n_questions }}
										</td>
										<td>
										  	<a href="{{ url('/assignments/'.$attempt->assignment_id.'/attempts/'.$attempt->id) }}"
										  		type="button" class="btn btn-primary btn-xs">
										  		<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
										  	</a>
										</td>
									</tr>
								@endforeach
							@else
								<tr><td class="text-center" colspan="4">- Tugas ini belum pernah dikerjakan -</td></tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
    	</div>
    </div>
</div>
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
	
	var ctx = document.getElementById("attemptChart");
	var attemptChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: [{!! implode(',', $chart_labels) !!}],
			datasets: [{
				label: 'Nilai setiap pengerjaan',
	            data: [{{ implode(',', $chart_data) }}],
	            backgroundColor: "rgba(75,192,192,0.4)",
				borderWidth: 1,
				borderColor: "rgba(75,192,192,1)",
			}]
		},
		options: options
	});
</script>
@endsection
