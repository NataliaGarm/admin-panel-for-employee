@extends('adminlte::page')

@section('content_header')
    <div class="row">
        <div class="col-md-9">
            <h1>{{ $employee->name }}</h1>
        </div>
        <div class="col-md-3">
            <div class="float-right">
                <a class="btn btn-block btn-secondary btn-flat" href="{{ route('employees.edit', $employee) }}">Edit employee</a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="bg-light p-5 rounded">

    </div>
@endsection
