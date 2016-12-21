@extends('student/layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">{{ $assignment->classes->name }} - {{ $assignment->name }}</div>

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
						<tr class="no-data"><td class="text-center" colspan="4">-- Belum ada soal --</td></tr>
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
										<table class="table table-responsive table-borderless table-option">
											<input type="hidden" id="new_option_count_{{ $question->id }}" value="0">
											@php $options = $question->options()->orderBy('order')->get(); @endphp
											@if($options->count() == 0)
												<tr class="no-data"><td class="text-center" colspan="4">-- Belum ada pilihan --</td></tr>
											@else
												@foreach($options as $j => $option)
													<tr>
														<td style="width:20px;">{{ $chars[$option->order - 1] }}</td>
														<td>{{ $option->text }}</td>
														<td>
															<input
																type="radio"
																name="questions[{{ $question->id }}]"
																value="{{ $option->id }}"
																@if($option->answer == 1) checked @endif>
														</td>
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
			<input type="hidden" name="id" value="{{ $assignment->id }}">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-success">Simpan</button>
					<a href="{{ url('assignments') }}" class="btn btn-warning">Batal</a>
				</div>
			</div>
		{{ Form::close() }}
    </div>
</div>
@endsection
