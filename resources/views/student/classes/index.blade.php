@extends('student/layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
    	<div class="row">
			<div class="col-md-12">
		    	Kelas
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
		    		<th>Mata Pelajaran</th>
		    		<th class="text-center" style="width: 175px;">Jumlah Siswa</th>
		    		<th class="text-center" style="width: 85px;">Semester</th>
		    		<th class="text-center" style="width: 75px;">Tahun</th>
		    		<th style="width: 70px;"></th>
        		</tr>
        	</thead>
        	<tbody>
        		@if($classes->count() > 0)
		    		@foreach($classes as $i => $class)
		    			<tr>
							<td>{{ $i + 1 }}</td>
							<td>{{ $class->name }}</td>
							<td>{{ $class->subject }}</td>
							<td class="text-center">{{ $class->students->count() }}</td>
							<td class="text-center">{{ $class->semester }}</td>
							<td class="text-center">{{ $class->year }}</td>
							<td>
								<div class="btn-group pull-right" role="group">
								  	<a href="{{ url('/classes/'.$class->id) }}" type="button" class="btn btn-primary btn-xs">
								  		<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
								  	</a>
								  	<a href="{{ url('/classes/'.$class->id.'/join') }}" type="button" class="btn btn-success btn-xs">
								  		<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
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
    </div>
</div>
@endsection
