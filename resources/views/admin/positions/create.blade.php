@extends('adminlte::page')

@section('content_header')
    <div class="row">
        <div class="col-12">
            <h1>Positions</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">

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

        <!-- general form elements -->
            <div class="card card-outline">
                <div class="card-header">
                    <h5>Add position</h5>
                </div>

                <!-- form start -->
                <form method="POST" action="{{ route('positions.store') }}" name="ajax-add-position-form" id="ajax-add-position-form" action="javascript:void(0)">
                    @csrf
                    <div class="card-body">
                        <x-adminlte-input name="name" label="Name" placeholder="Developer"
                                          disable-feedback/>
                        <label id="name-error" class="error" for="name"></label>
                        @if ($errors->has('name'))
                            <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <x-adminlte-button class="btn-flat" type="reset" label="Cancel" />
                        <x-adminlte-button class="btn-flat" type="submit" id="submit" label="Save" theme="secondary" />
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
@endsection

@section('plugins.jQuery Validation', true)
@section('js')
    <script>
        if ($("#ajax-add-position-form").length > 0) {
            $("#ajax-add-position-form").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 256,
                        minlength: 2,
                    },
                },
                messages: {
                    name: {
                        required: "The name field is required.",
                        maxlength: "The name must be maximum 256 characters.",
                        minlength: "The name must be at least 2 characters.",
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            })
        }
    </script>
@stop