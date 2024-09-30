@extends('master')
@section('content')
<section class="section">

    @include('admin.layout.breadcrumbs', ['title' => __('Add Popup'),])

    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-6">
                <form action="/add-popup" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>City Name</label>
                            <input type="text" name="city" placeholder="Enter City Name" class="form-control">
                            @error('city') {{$message}} @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Url</label>
                            <input type="text" name="url" placeholder="Enter Url" class="form-control">
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Popup Image</label>
                        <div id="result_image" class="">
                            <img src="" width="auto" height="100px" alt="">
                            <button type="button" class="form-control w-100" data-toggle="modal"
                                data-target="#exampleModalCenter">Upload Image</button>
                        </div>
                        <input type="hidden" id="base64-image" name="image" value="{{old('profile_img')}}">
                        @error('profile_img') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="col-lg-12">
                        <button class="btn btn-primary w-100" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
{{-- model --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" style="z-index:20000;">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Upload Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    @csrf
                    <input type="file" name="image" id="image-input" class="mb-3" accept="image/*">
                    <img src="" id="image-preview">
                    {{-- <input type="hidden" name="base64_image" id="base64-image"> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="uploadIMg">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Model End --}}
<script src="{{ asset('f-js/jquery.js') }}" type="text/javascript"></script>
<script src="{{ asset('f-js/croppie.js') }}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        var preview = new Croppie($('#image-preview')[0], {
            boundary: {
                width: 600,
                height: 600
            },
            viewport: {
                width: 550,
                height: 550,
                type: 'square'
            },
            // enableResize: true,
            // enableOrientation: true,
            // enableExif: true,
        });
        $('#image-input').on('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = function() {
                var base64data = reader.result;
                $('#base64-image').val(base64data);
                preview.bind({
                    url: base64data
                }).then(function() {
                    console.log('Croppie bind complete');
                });
            }
            reader.readAsDataURL(file);
        });
        $('#uploadIMg').on('click', function(e) {
            e.preventDefault();
            preview.result('base64').then(function(result) {
                $('#base64-image').val(result);
                $('#result_image img').attr('src', result);
            });
            $(function() {
                $('#exampleModalCenter').modal('toggle');
            });
        });
    });
</script>
@endsection