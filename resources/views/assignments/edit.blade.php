@extends('layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">@if(!empty($assignment->id)) Edit Tugas @else Tugas Baru @endif</div>

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
				<table class="table table-responsive table-borderless table-question">
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
										<button type="button" class="btn btn-default btn-xs btn-danger">
											<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
										</button>
									</td>
								</tr>
								<!-- OPTIONS -->
								<tr class="option-row">
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
													<tr>
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
															<button type="button" class="btn btn-default btn-xs btn-danger">
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
					<button type="submit" class="btn btn-success">Simpan</button>
					<a href="{{ url('teacher/assignments') }}" class="btn btn-warning">Batal</a>
				</div>
			</div>
		{{ Form::close() }}
    </div>
</div>
<script>
$(document).ready(function(){
	var chars = ['a', 'b', 'c', 'd', 'e'];
	
	$('.add-question').click(function(){
		var count = parseInt($('#new_question_count').val()) + 1;
		var order = 0;
		
    	$('#new_question_count').val(count);

		if($('.table-question').find('tr:first').hasClass('no-data')){
			$('.table-question').find('tr:first').remove();
			order = 1;
		}
		else{
	    	order = parseInt($('.table-question').find('.question-row:last').find('td:first').text()) + 1;
		}
		
		var html = [];
		
		html.push('<tr class="question-row">');
		html.push('<td><input type="hidden" name="new_questions[' + count + '][order]" value="' + order + '"><span>' + order + '.</span></td>');
		
		// Move buttons.
		html.push('<td><div class="btn-group-vertical" role="group">');
		html.push('<button type="button" class="btn btn-default btn-xs question-move-up">');
		html.push('<span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>');
		html.push('</button>');
		html.push('<button type="button" class="btn btn-default btn-xs question-move-down">');
		html.push('<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>');
		html.push('</button>');
		html.push('</div></td>');
		
		html.push('<td><textarea name="new_questions[' + count + '][text]" class="form-control"></textarea></td>');
		
		// Delete button.
		html.push('<td><button type="button" class="btn btn-default btn-xs btn-danger">');
		html.push('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>');
		html.push('</button></td>');
		html.push('</tr>');
		
		html.push('<tr class="option-row">');
		html.push('<td>');
		html.push('<button type="button" class="btn btn-default btn-xs btn-success add-option" data-toggle="tooltip" data-placement="bottom" title="Click untuk menambahkan pilihan baru untuk soal ini.">');
		html.push('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>');
		html.push('</button>');
		html.push('</td>');
		
		html.push('<td class="option-column" colspan="3"><table class="table table-responsive table-borderless table-option">');
		html.push('<tr class="no-data"><td class="text-center" colspan="4">-- Belum ada pilihan --</td></tr>');
		html.push('</table></td>');
		html.push('</tr>');
		
		var parent = $('.table-question').find('tbody:first');
		
		$(html.join('')).hide().appendTo(parent).show('normal');
		$('html, body').stop(true, false).animate({scrollTop: $('html').height()}, 800);
	});
	
	$(document).on('click', '.add-option', function(){
		var option_row	= $(this).parent().parent();
		var parent		= option_row.find('.table-option').find('tbody:first');
		var count		= parent.find('tr').length;
		
		if(count < chars.length){
			var order = 0;

			if(option_row.find('.table-option').find('tr:first').hasClass('no-data')){
				option_row.find('.table-option').find('tr:first').remove();
				order = 1;
				count = 0;
			}
			else{
				order = parseInt(option_row.find('.table-option').find('tr:last').find('td:first').find('input').val()) + 1;
			}
		
			var html = [];
			
			var question_name = option_row.prev().find('input').attr('name');
			question_name 	  = question_name.split('[');
			question_name	  = question_name[0] + '[' + question_name[1];
			
			html.push('<tr>');
			html.push('<td>');
			html.push('<input type="hidden" name="' + question_name + '[new_options][' + count + '][order]" value="' + order + '">');
			html.push('<span>' + chars[order-1] + '.</span>');
			html.push('</td>');
			html.push('<td>');
			html.push('<div class="btn-group" role="group">');
			html.push('<button type="button" class="btn btn-default btn-xs option-move-up">');
			html.push('<span class="glyphicon glyphicon-triangle-top aria-hidden="true"></span>');
			html.push('</button>');
			html.push('<button type="button" class="btn btn-default btn-xs option-move-down">');
			html.push('<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>');
			html.push('</button>');
			html.push('</div>');
			html.push('</td>');
			html.push('<td>');
			html.push('<input type="text" name="' + question_name + '[new_options][' + count + '][text]" class="form-control">');
			html.push('</td>');
			html.push('<td>');
			html.push('<input type="checkbox" name="' + question_name + '[new_options][' + count + '][is_correct]" data-toggle="tooltip" data-placement="bottom" title="Centang jika jawaban ini bernilai benar." value="1">');
			html.push('</td>');
			html.push('<td>');
			html.push('<button type="button" class="btn btn-default btn-xs btn-danger">');
			html.push('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>');
			html.push('</button>');
			html.push('</td>');
			html.push('</tr>');
		
			$(html.join('')).hide().appendTo(parent).show('normal');
		}
	});
	
	$('.scroll-up').click(function(){
		$('html, body').stop(true, false).animate({scrollTop: 0}, 800);
	});
	
	$('.question-move-up').click(function(){
		//alert('test');
	});
});
</script>
@endsection
