@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Event Gallery'),
            'headerData' => __('Event'),
            'url' => 'events',
        ])
        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Event Gallery') }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-lg-12 form-group">
                                    <div class="image-gallery">
                                        <div class="row">
                                            @foreach (array_filter(explode(',', $data->gallery)) as $item)
                                                <div class="col-lg-12">
                                                    <div class="img">
                                                        <img src="{{ url('images/upload/' . $item) }}">
                                                        <h4>{{ $item }}</h4>
                                                        <a href="{{ url('remove-image/' . $item . '/' . $data->id) }}"
                                                            title="Remove Image" class="text-danger"><i
                                                                class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="my-5 d-flex justify-content-center align-items-center">
                                        <div id="result_image" class="d-flex align-items-center">
                                            <form action="{{ url('add-event-gallery') }}" method="post" class="d-flex flex-column" enctype="multipart/form-data" >
                                                @csrf
                                                <img src="" height="200px" alt="" class="d-none">
                                                <input type="hidden" name="id" id="data_id" value="{{ $data->id }}">
                                                <input type="hidden" name="event_gallery" id="base64-image" hidden>
                                                <button id="uploadButton" type="button" class="form-control" data-toggle="modal"
                                                    data-target="#exampleModalCenter">Crop Image</button>
                                                <button type="submit" id="submitButton" class="mt-2 btn btn-success d-none">Upload Image</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ url('events') }} " class="btn" style="background-color: #65469b;color:#fff;">
                                            Back</a>
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
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Upload Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form">
                    <div class="modal-body">
                        <input type="file" name="file" id="image-input" class="mb-3" accept="image/*">
                        <img src="" id="image-preview">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="uploadIMg">Crop</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stack('scripts')
<script src="{{ asset('f-js/jquery.js') }}" type="text/javascript"></script>
<script src="{{ asset('f-js/croppie.js') }}" type="text/javascript"></script>
{{-- Model End --}}
<script>
$(document).ready(function() {
    var preview = new Croppie($('#image-preview')[0], {
        boundary: {
                width: 250,
                height: 250
        },
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
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
            $('#exampleModalCenter').modal('toggle');
        });
    });
});
</script>
@endsection
