@extends('teacher/layouts.app')

@section('content')
<style>
	.table-borderless > tbody > tr > th,
	.table-borderless > tbody > tr > td{
		border-top: none;
	}
</style>
<div class="panel panel-default">
    <div class="panel-heading">Class Details</div>

    <div class="panel-body">
        <table class="table table-borderless">
        	<tbody>
				<tr>
					<th style="width: 50px;">Name</th>
					<td>{{ $class->name }}</td>
				</tr>
				<tr>
					<th>Subject</th>
					<td>{{ $class->subject }}</td>
				</tr>
				<tr>
					<th>Semester</th>
					<td>{{ $class->semester }}</td>
				</tr>
				<tr>
					<th>Year</th>
					<td>{{ $class->year }}</td>
				</tr>
				<tr>
					<th>Students</th>
					<td>
						<table class="table">
							<thead>
								<tr>
									<th style="width: 50px;">No</th>
									<th class="text-center" style="width: 100px;">NIM</th>
									<th>Name</th>
									<th>Best Subject</th>
									<th class="text-center" style="width: 85px;">Semester</th>
									<th class="text-center" style="width: 75px;">Year</th>
									<th style="width: 30px;"></th>
								</tr>
							</thead>
							<tbody>
								@if($class->students->count() > 0)
						    		@foreach($class->students as $i => $student)
										<tr>
											<td>{{ $i + 1 }}</td>
											<td>{{ $student->id_num }}</td>
											<td>{{ $student->name }}</td>
											<td>Lolilogy</td>
											<td class="text-center">5</td>
											<td class="text-center">{{ date('Y', strtotime($student->created_at)) }}</td>
											<td>
												<div class="btn-group pull-right" role="group">
												  	<a href="{{ url('/student/detail/'.$student->id) }}" type="button" class="btn btn-primary btn-xs">
												  		<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
												  	</a>
												</div>
											</td>
										</tr>
									@endforeach
								@else
									<tr><td class="text-center" colspan="7">-- No data --</td></tr>
								@endif
							</tbody>
						</table>
					</td>
				</tr>
        	</tbody>
        </table>
    </div>
</div>
@endsection