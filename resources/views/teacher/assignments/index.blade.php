@extends('teacher/layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
    	<div class="row">
			<div class="col-md-9">
		    	Tugas
    		</div>
			<div class="col-md-3">
				<a class="btn btn-success btn-sm pull-right" href="{{ url('teacher/assignments/create') }}">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tugas Baru
				</a>
			</div>
    	</div>
    </div>

    <div class="panel-body">
    	@if(session('messages'))
    		<div class="alert @if(session('status') == 1) alert-success @else alert-danger @endif" role="alert">{{ session('messages') }}</div>
    	@endif
        <table class="table">
        	<thead>
        		<tr>
		    		<th style="width: 50px;">No</th>
		    		<th>Nama</th>
		    		<th>Kelas</th>
		    		<th>Mata Pelajaran</th>
		    		<th class="text-center" style="width: 175px;">Status Pengerjaan</th>
		    		<th style="width: 90px;"></th>
        		</tr>
        	</thead>
        	<tbody>
        		@if($assignments->count() > 0)
		    		@foreach($assignments as $i => $assignment)
		    			<tr>
							<td>{{ $i + 1 }}</td>
							<td>{{ $assignment->name }}</td>
							<td>{{ $assignment->classes->name }}</td>
							<td>{{ $assignment->classes->subject }}</td>
							<td class="text-center">{{ $assignment->classes->students->count() }}/{{ $assignment->classes->students->count() }}</td>
							<td>
								<div class="btn-group pull-right" role="group">
								  	<a href="{{ url('/teacher/assignments/'.$assignment->id) }}" type="button" class="btn btn-primary btn-xs">
								  		<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
								  	</a>
								  	<a href="{{ url('/teacher/assignments/'.$assignment->id.'/edit') }}" type="button" class="btn btn-warning btn-xs">
								  		<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
								  	</a>
								  	<a href="javascript:void(0);" class="btn btn-danger btn-xs" onclick="$(this).find('form').submit();" >
								  		<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
										<form action="{{ url('/teacher/assignments/'.$assignment->id) }}" method="post">
											{{ csrf_field() }}
											{{ method_field('DELETE') }}
										</form>
									</a>
								</div>
							</td>
		    			</tr>
		    		@endforeach
	    		@else
					<tr><td class="text-center" colspan="5">-- No data --</td></tr>
	    		@endif
        	</tbody>
        </table>
    </div>
</div>
@endsection
