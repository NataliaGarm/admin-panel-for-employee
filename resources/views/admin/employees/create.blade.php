@extends('adminlte::page')
@section('css')
    <link href="{{ asset('css/cropper.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
@stop
@section('plugins.BsCustomFileInput', true)
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)


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
                <form method="POST" action="{{ route('employees.store') }}" name="ajax-add-employee-form" id="ajax-add-employee-form" action="javascript:void(0)" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="col-md-12 mb-2">
                            <img id="show-image" src="#" alt="Loaded image" class="imageForInput img-bordered"/>
                        </div>
                        <x-adminlte-input-file name="img" igroup-size="sm" placeholder="Choose a photo..." class="image" required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-upload"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>
                        <label id="img-error" class="error" for="img"></label>
                        <x-adminlte-input type="hidden" id="base64image" name="base64image" />

                        <x-adminlte-input name="name" label="Name" required />
                        <label id="name-error" class="error" for="name"></label>

                        <x-adminlte-input required name="phone" label="Phone number" />
                        <label id="phone-error" class="error" for="phone"></label>


                        <x-adminlte-input required name="email" label="Email" />
                        <label id="email-error" class="error" for="email"></label>

                        @php
                            $config = [
                                "placeholder" => "Select positions...",
                            ];
                        @endphp
                        <x-adminlte-select-bs required name="position"  label="Position" :config="$config">
                                <x-adminlte-options :options=$positions />
                        </x-adminlte-select-bs>
                        <label id="position-error" class="error" for="position"></label>

                        <x-adminlte-input required name="salary" label="Salary" />
                        <label id="salary-error" class="error" for="salary"></label>

                        <x-adminlte-select2 required name="head" igroup-size="m" data-placeholder="Select a head...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                            </x-slot>
                            <x-adminlte-options :options=$employees />
                        </x-adminlte-select2>
                        <label id="head-error" class="error" for="head"></label>

                        {{-- With Label --}}
                        @php
                            $config = ['format' => 'DD.MM.YYYY'];
                        @endphp
                        <x-adminlte-input-date required name="employment_date" :config="$config" placeholder="Choose a date..."
                                               label="Date of Employment">
                            <x-slot name="appendSlot">
                                <x-adminlte-button icon="fas fa-calendar-alt" title="Set date of employment"/>
                            </x-slot>
                        </x-adminlte-input-date>
                        <label id="employment_date" class="error" for="employment_date"></label>
                    </div>

                    <div class="card-footer">
                        <x-adminlte-button class="btn-flat" type="reset" label="Cancel" />
                        <x-adminlte-button class="btn-flat" type="submit" id="submit" label="Save" theme="secondary" />
                    </div>
                </form>
            </div>

            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">How to crop image before upload image in laravel 9 - Techsolutionstuff</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="img-container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <img id="image" src="https://avatars0.githubusercontent.com/u/3456749" class="crop_image">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="preview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="crop">Crop</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.card -->
        </div>
        <!--/.col (left) -->
    </div>
@endsection

@section('plugins.jQuery Validation', true)
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
<script>
    let $modal = $('#modal');
    const image = document.getElementById('image');
    let cropper;

    $("body").on("change", ".image", function(e){
        let files = e.target.files;
        let done = function (url) {
            image.src = url;
            $modal.modal('show');
        };

        let reader;
        let file;

        if (files && files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 2,
            preview: '.preview',
            rotatable: true,
            minCropBoxWidth: 300,
            minCropBoxHeight: 300,
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function(){
        let canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
        });

        canvas.toBlob(function(blob) {
            let url = URL.createObjectURL(blob);
            let reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                let base64data = reader.result;
                $('#base64image').val(base64data);
                $modal.modal('hide');
                let show_image = document.getElementById("show-image");
                show_image.src = url;
            }
        });
    });
</script>
<script>
    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            return this.optional(element) || regexp.test(value);
        },
    );
    if ($("#ajax-add-employee-form").length > 0) {
        $("#ajax-add-employee-form").validate({
            //errorElement: "div",
            rules: {
                img: {
                    required: true,
                    extension: "png|jpe?g",
                    //maxFilesize: 5120,
                    //minHeight: 300,
                    //maxWidth: 300
                },
                name: {
                    required: true,
                    maxlength: 256,
                    minlength: 2,
                },
                phone: {
                    required: true,
                    regex: /^(\+380)(\s\((39|50|6[3678]|73|89|9[1-8])\))(\s\d{3})(\s\d{2}){2}$/  ///^(\+\d{1,3}[- ]?)?\d{10}$/
                },
                email: {
                    required: true,
                    email: true,
                },
                salary: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 500.000
                }
            },
            messages: {
                img: {
                    required: "Photo is required.",
                    extension: "File format only (jpg, jpeg, png) up to 5MB, minimum size of 300x300",
                    //maxFilesize: "File size must be up to 5MB",
                    //minHeight: "Minimum height 300px",
                    //maxWidth: "Minimum width 300px"
                },
                name: {
                    required: "Name is required.",
                    maxlength: "Name must be maximum 256 characters.",
                    minlength: "Name must be at least 2 characters.",
                },
                phone: {
                    required: "Phone is required",
                    regex: "Required format +380 (XX) XXX XX XX. Only Ukraine number allowed",
                },
                email: {
                    required: "Email is required",
                    email: "Invalid email",
                },
                salary: {
                    required: "Salary is required",
                    number: "Invalid number",
                    min: "Minimum 0",
                    max: "Maximum 500.000"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        })
    }
</script>
@stop