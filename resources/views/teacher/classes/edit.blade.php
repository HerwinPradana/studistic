@extends('teacher/layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">@if(!empty($class->id)) Edit Kelas @else Kelas Baru @endif</div>

    <div class="panel-body">
    	@if(session('messages'))
    		<div class="alert @if(session('status') == 1) alert-success @else alert-danger @endif" role="alert">{{ session('messages') }}</div>
    	@endif
    	@if(!empty($class->id))
		    <form action="{{ url('teacher/classes/'.$class->id)}}" method="POST" class="form-horizontal">
    		{{ method_field('PUT') }}
		@else
		    <form action="{{ url('teacher/classes')}}" method="POST" class="form-horizontal">
		@endif
			<div class="form-group">
				<label for="class-name" class="col-sm-2 control-label">Nama</label>
				<div class="col-sm-10">
					<input name="name" type="text" class="form-control" id="class-name" value="{{ $class->name }}">
				</div>
			</div>
			<div class="form-group">
				<label for="class-subject" class="col-sm-2 control-label">Mata Pelajaran</label>
				<div class="col-sm-10">
					<input name="subject" type="text" class="form-control" id="class-subject" value="{{ $class->subject }}">
				</div>
			</div>
			<div class="form-group">
				<label for="class-semester" class="col-sm-2 control-label">Semester</label>
				<div class="col-sm-10">
					<input name="semester" type="text" class="form-control" id="class-semester" value="{{ $class->semester }}">
				</div>
			</div>
			<div class="form-group">
				<label for="class-year" class="col-sm-2 control-label">Tahun</label>
				<div class="col-sm-10">
					<input name="year" type="text" class="form-control" id="class-year" value="{{ $class->year }}">
				</div>
			</div>
			{{ csrf_field() }}
			<input type="hidden" name="id" value="{{ $class->id }}">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-success">Simpan</button>
					<a href="{{ url('teacher/classes') }}" class="btn btn-warning">Batal</a>
				</div>
			</div>
		</form>
    </div>
</div>
@endsection
