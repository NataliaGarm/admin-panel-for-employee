@extends('adminlte::page')

@section('content_header')
    <div class="row">
        <div class="col-md-9">
            <h1>Positions</h1>
        </div>
        <div class="col-md-3">
            <div class="float-right">
                <a class="btn btn-block btn-secondary btn-flat" href="{{ route('positions.create') }}">Add position</a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="bg-light p-3 rounded">

        <div class="col-md-12">
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li><i class="icon fa fa-ban"></i>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p><i class="icon fa fa-check"></i>{{ session('success') }}</p>
                </div>
            @endif
        </div>

        <div class="container">
            <div class="card">
                <div class="card-header">Manage Positions</div>
                <div class="card-body">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    {{ $dataTable->scripts() }}
@stop
