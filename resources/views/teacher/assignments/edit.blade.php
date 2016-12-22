@extends('teacher/layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
    	<div class="row">
			<div class="col-md-6">@if(!empty($assignment->id)) Edit Tugas @else Tugas Baru @endif</div>
			<div class="col-md-6">
				<div class="btn-group pull-right" role="group">
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
    	@if(empty($assignment->id))
    		{{ Form::open(['url' => url('teacher/assignments/'.$assignment->id), 'method' => 'post', 'class' => 'form-horizontal']) }}
		@else
    		{{ Form::open(['url' => url('teacher/assignments/'.$assignment->id), 'method' => 'put', 'class' => 'form-horizontal']) }}
		@endif
			<div class="form-group">
				<label for="assignment-class" class="col-sm-2 control-label">Kelas</label>
				<div class="col-sm-10">
					{{ Form::select('class_id', $classes, $assignment->class_id, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="form-group">
				<label for="assignment-name" class="col-sm-2 control-label">Judul Tugas</label>
				<div class="col-sm-10">
					<input name="name" type="text" class="form-control" id="assignment-name" value="{{ $assignment->name }}">
				</div>
			</div>
			<div class="form-group">
				<label for="assignment-description" class="col-sm-2 control-label">Rincian Tugas</label>
				<div class="col-sm-10">
					<textarea name="description" class="form-control" id="assignment-description">{{ $assignment->description }}</textarea>
				</div>
			</div>
			<!-- Questions -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10">
							<h3 class="panel-title">Soal</h3>
						</div>
						<div class="col-md-2">
							<button type="button" class="btn btn-default btn-xs btn-success pull-right add-question">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Soal
							</button>
						</div>
					</div>
				</div>
				<table id="question_table" class="table table-responsive table-borderless table-question">
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
									<td>
										<!-- Order -->
										<input type="hidden" name="questions[{{ $question->id }}][order]" value="{{ $question->order }}">
										<input type="hidden" name="questions[{{ $question->id }}][id]" value="{{ $question->id }}">
										<span>{{ $question->order }}</span>
									</td>
									<td>
										<!-- Move up/down -->
										<div class="btn-group-vertical" role="group">
											<button type="button" class="btn btn-default btn-xs question-move-up">
												<span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
											</button>
											<button type="button" class="btn btn-default btn-xs question-move-down">
												<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
											</button>
										</div>
									</td>
									<td>
										<textarea name="questions[{{ $question->id }}][text]" class="form-control">{{ $question->text }}</textarea>
									</td>
									<td>
										<button type="button" class="btn btn-default btn-xs btn-danger delete-question">
											<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
										</button>
									</td>
								</tr>
								<!-- OPTIONS -->
								<tr>
									<td>
										<button type="button" class="btn btn-default btn-xs btn-success add-option"
											data-toggle="tooltip" data-placement="bottom"
											title="Click untuk menambahkan pilihan baru untuk soal ini.">
											<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
										</button>
									</td>
									<td class="option-column" colspan="3">
										<table class="table table-responsive table-borderless table-option">
											<input type="hidden" id="new_option_count_{{ $question->id }}" value="0">
											@php $options = $question->options()->orderBy('order')->get(); @endphp
											@if($options->count() == 0)
												<tr class="no-data"><td class="text-center" colspan="4">-- Belum ada pilihan --</td></tr>
											@else
												@foreach($options as $j => $option)
													<tr class="option-row">
														<td>
															<!-- Order -->
															<input
																type="hidden"
																name="questions[{{ $question->id }}][options][{{ $option->id }}][order]"
																value="{{ $option->order }}">
															<input
																type="hidden"
																name="questions[{{ $question->id }}][options][{{ $option->id }}][id]"
																value="{{ $option->id }}">
															<span>{{ $chars[$option->order - 1] }}</span>
														</td>
														<td>
															<!-- Move up/down -->
															<div class="btn-group" role="group">
																<button type="button" class="btn btn-default btn-xs option-move-up">
																	<span class="glyphicon glyphicon-triangle-top aria-hidden="true"></span>
																</button>
																<button type="button" class="btn btn-default btn-xs option-move-down">
																	<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
																</button>
															</div>
														</td>
														<td>
															<input
																type="text"
																name="questions[{{ $question->id }}][options][{{ $option->id }}][text]"
																class="form-control"
																value="{{ $option->text }}">
														</td>
														<td>
															<input
																type="checkbox"
																name="questions[{{ $question->id }}][options][{{ $option->id }}][is_correct]"
																data-toggle="tooltip"
																data-placement="bottom"
																title="Centang jika jawaban ini bernilai benar."
																value="1"
																@if($option->is_correct == 1) checked @endif>
														</td>
														<td>
															<button type="button" class="btn btn-default btn-xs btn-danger delete-option">
																<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
															</button>
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
						<div class="col-md-10">
							<a class="scroll-up"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span> Kembali ke atas</a>
						</div>
						<div class="col-md-2">
							<button type="button" class="btn btn-default btn-xs btn-success pull-right add-question">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Soal
							</button>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="id" value="{{ $assignment->id }}">
			<input type="hidden" id="new_question_count" value="0">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="btn-group" role="group">
						<button type="submit" class="btn btn-success">Simpan</button>
						<a href="{{ url('teacher/assignments') }}" class="btn btn-warning">Batal</a>
					</div>
				</div>
			</div>
		{{ Form::close() }}
    </div>
</div>
<script src="{{ asset('js/assignment.js') }}"></script>
@endsection
