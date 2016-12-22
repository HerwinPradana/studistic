@extends('teacher/layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
    	<div class="row">
			<div class="col-md-6">{{ $assignment->classes->name }} - {{ $assignment->name }}</div>
			<div class="col-md-6">
				<div class="btn-group pull-right" role="group">
					<a href="{{ url('/teacher/assignments/'.$assignment->id.'/edit') }}" type="button" class="btn btn-warning btn-xs">
						<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
					</a>
					<a href="{{ url('/teacher/assignments') }}" type="button" class="btn btn-warning btn-xs">
						<span class="glyphicon glyphicon-share" aria-hidden="true"></span> Kembali
					</a>
				</div>
			</div>
    	</div>
    </div>

    <div class="panel-body">
    	@if(session('messages'))
    		<div class="alert @if(session('status') == 1) alert-success @else alert-danger @endif" role="alert">{{ session('messages') }}</div>
    	@endif
		{{ Form::open(['url' => url('assignments/'.$assignment->id), 'method' => 'put', 'class' => 'form-horizontal']) }}
			<div class="form-group">
				<div class="col-sm-12">{{ empty($assignment->description)? '-' : $assignment->description }}</div>
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
							$chars		= array('a', 'b', 'c', 'd', 'e');
						@endphp
				    	@if($questions->count() == 0)
						<tr class="no-data"><td class="text-center" colspan="2">-- Belum ada soal --</td></tr>
						@else
				    		@foreach($questions as $i => $question)
								<tr class="question-row">
									<td style="width:20px;">{{ $question->order }}</td>
									<td>{{ $question->text }}</td>
								</tr>
								<!-- OPTIONS -->
								<tr class="option-row">
									<td></td>
									<td class="option-column">
										<table class="table table-responsive table-borderless">
											<input type="hidden" id="new_option_count_{{ $question->id }}" value="0">
											@php $options = $question->options()->orderBy('order')->get(); @endphp
											@if($options->count() == 0)
												<tr class="no-data"><td class="text-center" colspan="3">-- Belum ada pilihan --</td></tr>
											@else
												@foreach($options as $j => $option)
													<tr>
														<td style="width:20px;">{{ $chars[$option->order - 1] }}</td>
														<td>{{ $option->text }}</td>
													</tr>
												@endforeach
											@endif
										</table>
									</td>
								</tr>
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
		{{ Form::close() }}
    </div>
</div>
@endsection
