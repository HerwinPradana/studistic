@extends('student/layouts.app')

@section('content')
<style>
	.table-borderless > tbody > tr > th,
	.table-borderless > tbody > tr > td{
		border-top: none;
	}
</style>
<div class="panel panel-default">
    <div class="panel-heading">
    	<div class="row">
			<div class="col-md-6">Informasi Kelas</div>
			<div class="col-md-6">
				<div class="btn-group pull-right" role="group">
					<a href="{{ url('/classes') }}" type="button" class="btn btn-warning btn-xs">
						<span class="glyphicon glyphicon-share" aria-hidden="true"></span> Kembali
					</a>
				</div>
			</div>
    	</div>
    </div>

    <div class="panel-body">
        <table class="table table-borderless">
        	<tbody>
				<tr>
					<th style="width: 150px;">Nama</th>
					<td>{{ $class->name }}</td>
				</tr>
				<tr>
					<th>Mata Pelajaran</th>
					<td>{{ $class->subject }}</td>
				</tr>
				<tr>
					<th>Semester</th>
					<td>{{ $class->semester }}</td>
				</tr>
				<tr>
					<th>Tahun</th>
					<td>{{ $class->year }}</td>
				</tr>
				<tr>
					<th>Daftar Siswa</th>
					<td>
						<table class="table">
							<thead>
								<tr>
									<th style="width: 50px;">No</th>
									<th class="text-center" style="width: 100px;">NIM</th>
									<th>Nama</th>
									<th class="text-center" style="width: 85px;">Semester</th>
									<th class="text-center" style="width: 75px;">Angkatan</th>
								</tr>
							</thead>
							<tbody>
								@if($class->students->count() > 0)
						    		@foreach($class->students as $i => $student)
										<tr>
											<td>{{ $i + 1 }}</td>
											<td>{{ $student->id_num }}</td>
											<td>{{ $student->name }}</td>
											<td class="text-center">5</td>
											<td class="text-center">{{ date('Y', strtotime($student->created_at)) }}</td>
											<!--
											<td>
												<div class="btn-group pull-right" role="group">
												  	<a href="{{ url('/student/detail/'.$student->id) }}" type="button" class="btn btn-primary btn-xs">
												  		<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
												  	</a>
												</div>
											</td>
											-->
										</tr>
									@endforeach
								@else
									<tr><td class="text-center" colspan="5">-- No data --</td></tr>
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
