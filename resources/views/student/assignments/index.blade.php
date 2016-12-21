@extends('student/layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
    	<div class="row">
			<div class="col-md-12">
		    	Tugas
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
		    		<th class="text-center" style="width: 175px;">Tanggal</th>
		    		<th style="width: 70px;"></th>
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
							<td class="text-center">{{ $assignment->created_at }}</td>
							<td>
								<div class="btn-group pull-right" role="group">
								  	<a href="{{ url('/assignments/'.$assignment->id) }}" type="button" class="btn btn-primary btn-xs">
								  		<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
								  	</a>
								  	<a href="{{ url('/assignments/'.$assignment->id.'/edit') }}" type="button" class="btn btn-success btn-xs">
								  		<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
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
