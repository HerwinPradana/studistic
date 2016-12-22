$(document).ready(function(){
	var chars = ['a', 'b', 'c', 'd', 'e'];
	
	var deletedQuestions = [];
	var deletedOptions	 = [];
	
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
		html.push('<td><button type="button" class="btn btn-default btn-xs btn-danger delete-question">');
		html.push('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>');
		html.push('</button></td>');
		html.push('</tr>');
		
		html.push('<tr>');
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
		var optionRow	= $(this).parent().parent();
		var parent		= optionRow.find('.table-option').find('tbody:first');
		var count		= parent.find('tr').length;
		
		if(count < chars.length){
			var order = 0;

			if(optionRow.find('.table-option').find('tr:first').hasClass('no-data')){
				optionRow.find('.table-option').find('tr:first').remove();
				order = 1;
				count = 0;
			}
			else{
				order = parseInt(optionRow.find('.table-option').find('tr:last').find('td:first').find('input').val()) + 1;
			}
		
			var html = [];
			
			var questionName = optionRow.prev().find('input').attr('name');
			questionName 	 = questionName.split('[');
			questionName	 = questionName[0] + '[' + questionName[1];
			
			html.push('<tr class="option-row">');
			html.push('<td>');
			html.push('<input type="hidden" name="' + questionName + '[new_options][' + count + '][order]" value="' + order + '">');
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
			html.push('<input type="text" name="' + questionName + '[new_options][' + count + '][text]" class="form-control">');
			html.push('</td>');
			html.push('<td>');
			html.push('<input type="checkbox" name="' + questionName + '[new_options][' + count + '][is_correct]" data-toggle="tooltip" data-placement="bottom" title="Centang jika jawaban ini bernilai benar." value="1">');
			html.push('</td>');
			html.push('<td>');
			html.push('<button type="button" class="btn btn-default btn-xs btn-danger delete-option">');
			html.push('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>');
			html.push('</button>');
			html.push('</td>');
			html.push('</tr>');
		
			$(html.join('')).hide().appendTo(parent).show('normal');
		}
	});
	
	$(document).on('click', '.option-move-up', function(){
		var row 	= $(this).closest('.option-row');
		var order	= row[0].rowIndex;
		if(order > 0){
			var prevRow = row.prev();
			
			// Swap order values.
			row.find('input:first').val(order);
			row.find('span:first').html(chars[order - 1]);
			
			prevRow.find('input:first').val(order + 1);
			prevRow.find('span:first').html(chars[order]);
			
			// Swap locations.
			prevRow.before(row);
		}
	});
	
	$(document).on('click', '.option-move-down', function(){
		var row 	= $(this).closest('.option-row');
		var order	= row[0].rowIndex;
		
		if(order < row.closest('table').find('.option-row').length){
			var nextRow = row.next();
			
			// Swap order values.
			row.find('input:first').val(order + 2);
			row.find('span:first').html(chars[order + 1]);
			
			nextRow.find('input:first').val(order + 1);
			nextRow.find('span:first').html(chars[order]);
			
			// Swap locations.
			nextRow.after(row);
		}
	});
	
	$(document).on('click', '.question-move-up', function(){
		var row = ($(this).closest('.question-row')[0].rowIndex / 2) + 1;
		if(row > 0){
			var questionRow = $(this).closest('.question-row');
			var optionRow	= questionRow.next();
					
			var prevQuestionRow = questionRow.prev().prev();

			// Swap order values.
			questionRow.find('input:first').val(row - 1);
			questionRow.find('span:first').html(row - 1);

			prevQuestionRow.find('input:first').val(row);
			prevQuestionRow.find('span:first').html(row);
		
			// Swap position.
			prevQuestionRow.before(questionRow);
			optionRow.prev().prev().before(optionRow);
		}
	});
	
	$(document).on('click', '.question-move-down', function(){
		var row = ($(this).closest('.question-row')[0].rowIndex / 2) + 1;
		if(row < $('#question_table .question-row').length){
			var questionRow = $(this).closest('.question-row');
			var optionRow	= questionRow.next();
			
			var nextQuestionRow = questionRow.next().next();
			var nextOptionRow	= nextQuestionRow.next();
		
			// Swap order values.
			questionRow.find('input:first').val(row + 1);
			questionRow.find('span:first').html(row + 1);

			nextQuestionRow.find('input:first').val(row);
			nextQuestionRow.find('span:first').html(row);
		
			// Swap position.
			nextQuestionRow.after(questionRow);
			nextOptionRow.after(questionRow);
			questionRow.after(optionRow);
		}
	});

	$(document).on('click', '.delete-question', function(){
		var questionRow = $(this).closest('.question-row');
		var optionRows  = questionRow.next().find('.option-row');
		
		// Record deleted ids.
		deletedQuestions.push(questionRow.find('input:nth-child(2)').val());
		
		optionRows.each(function(i, optionRow){
			deletedOptions.push($(optionRow).find('input:nth-child(2)').val());
		});
		
		// Delete DOM elements.
		questionRow.next().remove();
		questionRow.remove();
		
		// Refresh row orders.
		var questionRows = $('#question_table').find('.question-row');
		questionRows.each(function(order, questionRow){
			$(questionRow).find('input:first').val(order + 1);
			$(questionRow).find('span:first').html(order + 1);
		});
	});

	$(document).on('click', '.delete-option', function(){
		var row		= $(this).closest('.option-row');
		var table	= row.closest('table');
		
		// Record deleted ids.
		deletedOptions.push(row.find('input:nth-child(2)').val());
		
		// Delete DOM element.
		row.remove();
		
		// Refresh row orders.
		var optionRows = table.find('.option-row');
		optionRows.each(function(order, optionRow){
			$(optionRow).find('input:first').val(order + 1);
			$(optionRow).find('span:first').html(chars[order]);
		});
	});
});

