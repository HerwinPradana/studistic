@extends('student/layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
    	<div class="row">
			<div class="col-md-6">{{ $assignment->classes->name }} - {{ $assignment->name }}</div>
			<div class="col-md-6">
				<div class="btn-group pull-right" role="group">
					<a href="{{ url('/assignments/'.$assignment->id) }}" type="button" class="btn btn-primary btn-xs">
						<span class="glyphicon glyphicon-search" aria-hidden="true"></span> Lihat Rekap
					</a>
					<a href="{{ url('/assignments') }}" type="button" class="btn btn-warning btn-xs">
						<span class="glyphicon glyphicon-share" aria-hidden="true"></span> Kembali
					</a>
				</div>
			</div>
		</div>
    </div>

    <div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				{{ empty($assignment->description)? '-' : $assignment->description }}
				<div class="alert alert-info" role="alert">Nilai: {{ $attempt->score }}</div>
			</div>
    	</div>
		<!-- Questions -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-12">
						<h3 class="panel-title">Soal</h3>
					</div>
				</div>
			</div>
			<table class="table table-responsive table-borderless">
				<tbody>
					@php
						$questions	= $assignment->questions()->orderBy('order')->get();
						
						$answers	= array();
						foreach($attempt->answers as $answer){
							$answers[$answer->question_id] = $answer;
						}
						
						$chars		= array('a', 'b', 'c', 'd', 'e');
					@endphp
			    	@if($questions->count() == 0)
					<tr class="no-data"><td class="text-center" colspan="4">-- Belum ada soal --</td></tr>
					@else
			    		@foreach($questions as $i => $question)
			    			@php $correct = $answers[$question->id]->option->is_correct == 1; @endphp
							<tr>
								<td style="width:20px;">{{ $question->order }}</td>
								<td colspan="2">{{ $question->text }}</td>
							</tr>
							@if(!isset($answers[$question->id]))
								<tr class="no-data"><td class="text-center" colspan="2">-- Belum dijawab --</td></tr>
							@else
							<tr class="{{ $correct? 'success' : 'danger'}}">
								<td><span class="glyphicon glyphicon-{{ $correct? 'ok' : 'remove'}}"></span></td>
								<td style="width:20px;">{{ $chars[$answers[$question->id]->option->order - 1] }}</td>
								<td>{{ $answers[$question->id]->option->text }}</td>
							</tr>
							@endif
						@endforeach
					@endif
				</tbody>
			</table>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-12">
						<a class="scroll-up"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span> Kembali ke atas</a>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
