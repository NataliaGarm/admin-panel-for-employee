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
                    <h5>Edit position</h5>
                </div>

                <!-- form start -->
                <form method="POST" action="{{ route('positions.update', $position) }}" name="ajax-edit-position-form" id="ajax-edit-position-form" action="javascript:void(0)">
                    @csrf
                    @method("PUT")
                    <div class="card-body">
                        <x-adminlte-input name="name" value="{{ $position->name }}" label="Name"
                                          disable-feedback/>
                        <label id="name-error" class="error" for="name"></label>

                        <x-adminlte-input name="admin_created_id" type="hidden" value="{{ $position->admin_created_id }}"
                                          disable-feedback/>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <p><b>Created at:</b> {{ $position->created_at }}</p>
                                    <p><b>Updated at:</b> {{ $position->updated_at }}</p>
                                </div>
                                <div class="col-6">
                                    <p><b>Admin created ID:</b> {{ $position->adminCreatedId->name }}</p>

                                    <p><b>Admin updated ID:</b> {{ $position->adminUpdatedId->name }}</p>
                                </div>
                            </div>
                        </div>
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
        if ($("#ajax-edit-position-form").length > 0) {
            $("#ajax-edit-position-form").validate({
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