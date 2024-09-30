@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
    'title' => __('Add Event Post Card'),
    'headerData' => __('Event'),
    'url' => 'events',
    ])

    <div class="section-body">
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="my-5 form-group text-center" style="border:1px solid #6c757d;padding:20px;border-radius:10px;" id="group_1">
                                    <h3 class="mb-3 text-uppercase">Choose An Image To Upload</h3>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div id="result_image" class="d-flex align-items-center">
                                            <form action="{{ url('upload-gallery') }}" method="post" class="d-flex flex-column" enctype="multipart/form-data" >
                                                @csrf
                                                <img src="" height="200px" alt="" class="d-none">
                                                <input type="hidden" name="event_gallery" id="base64-image" hidden>
                                                <button id="uploadButton" type="button" class="form-control" data-toggle="modal"
                                                    data-target="#event_form">Crop Image</button>
                                                <button type="submit" id="submitButton" class="mt-2 btn btn-success d-none">Upload Image</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<form id="event_form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="event_form" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Upload Image</h5>
                <button type="button" class="close" id="modelClose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="file" name="file" id="image-input" class="form-control mb-3" accept="image/*">
                <img src="" id="image-preview">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="uploadIMg">Upload</button>
            </div>
        </div>
    </div>
</form>

{{-- <!-- Modal -->
<form id="event_form" method="post" name="event_form" enctype="multipart/form-data" action="{{ url('upload-gallery') }}"
class="modal fade" tabindex="-1" role="dialog" aria-labelledby="event_form"
aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Upload Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="file" name="event_gallery[]" id="image-input" class="form-control mb-3" accept="image/*">
                <img src="" id="image-preview">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="uploadIMg">Upload</button>
            </div>
        </div>
    </div>
</form> --}}

<!-- Modal -->
{{-- <div class="modal fade" id="event_form" tabindex="-1" role="dialog" aria-labelledby="event_form" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="uploadIMg">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}


@endsection
@push('scripts')
@stack('scripts')
<script src="{{ asset('f-js/jquery.js') }}"></script>
<script src="{{ asset('f-js/croppie.js') }}"></script>
{{-- Model End --}}
<script>
    $(document).ready(function() {
        var preview = new Croppie($('#image-preview')[0], {
            boundary: {
                width: 550,
                height: 800
            },
            viewport: {
                width: 480,
                height: 720,
                type: 'rectangle'
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
                $('#result_image img').toggleClass("d-none");
                $('#uploadButton').hide();
                $('#submitButton').toggleClass("d-none");
            });
            $(function() {
                $('#modelClose').click();
            });
        });
    });
</script>
@endpush