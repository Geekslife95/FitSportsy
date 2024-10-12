@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('All Events'))
@section('content')
<section class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <!-- /Page Header -->
        @include('user.coach-booking.top-bar')
        @include('messages')
       
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <form action="{{url('user/store-coach-book-media')}}" name="event_form" id="event_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Images </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Main Page Image <span class="text-danger">*</span></label>
                                        <code>Dimension is 400 X 250</code>
                                        <img src="{{asset('/images/upload/default-img.png')}}" class="upimage img-fluid img-thumbnail d-block mb-2" alt="">
                                        <div class="uploader">
                                            <input type="file" name="image" id="image" class="uploader form-control" onchange="prevImage(this)" value="" required accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Description Page Image <span class="text-danger">*</span></label>
                                        <code>Dimension is 1280 X 500</code>
                                        <img src="{{asset('/images/upload/default-img.png')}}" class="upimage img-fluid img-thumbnail d-block mb-2" alt="">
                                        <div class="uploader">
                                            <input type="file" name="desc_page_img" id="desc_page_img" class="uploader form-control" onchange="prevImage(this)" value="" required accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Coaches Info</h4>
                                </div>
                                <div class="col-md-6 text-right mb-5">
                                    <button class="btn btn-warning" type="button" id="add_more_coaches">Add More Coaches</button>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12" id="add_more_block">
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <code>Coach Image</code>
                                                <img src="{{asset('/images/upload/default-img.png')}}" class="upimage img-fluid img-thumbnail d-block mb-2" alt="">
                                                <div class="uploader">
                                                    <input type="file" name="gallery_image[]" class="uploader form-control" onchange="prevImage(this)" value="" required accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Coach Name</label>
                                            <input type="text" name="coach_name[]" class="form-control"  placeholder="Coach Name" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Age</label>
                                            <input type="number" name="coach_age[]" class="form-control"  placeholder=" Age" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="">Experience</label>
                                            <input type="text" name="coach_experience[]" class="form-control"  placeholder=" Experience" required>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="continue_btn" class="btn btn-primary d-block">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    $("#add_more_coaches").on('click',function(){
        $("#add_more_block").append(`
        <div class="row mb-4 remove_slot_prnt">
            <div class="col-md-3">
                <div class="form-group">
                    <code>Coach Image</code>
                    <img src="{{asset('/images/upload/default-img.png')}}" class="upimage img-fluid img-thumbnail d-block mb-2" alt="">
                    <div class="uploader">
                        <input type="file" name="gallery_image[]" class="uploader form-control" onchange="prevImage(this)" value="" required accept="image/*">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <label for="">Coach Name</label>
                <input type="text" name="coach_name[]" class="form-control"  placeholder="Coach Name" required>
            </div>
            <div class="col-md-2">
                <label for="">Age</label>
                <input type="number" name="coach_age[]" class="form-control"  placeholder=" Age" required>
            </div>
            <div class="col-md-2">
                <label for="">Experience</label>
                <input type="text" name="coach_experience[]" class="form-control"  placeholder=" Experience" required>
            </div>
             <div class="col-md-2">
                <label for="" class="d-block">-</label>
                <button type="button" class="btn btn-danger remove_temp">Remove</button>
            </div>
        </div>
        `);
    })
</script>
<script>
    $(document).on('click','.remove_temp',function(){
        $(this).parents(".remove_slot_prnt").remove();
    })
</script>

<script>
    function prevImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(input).parents('.uploader').prev('.upimage').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            alert('select a file to see preview');
            $('.upimage').attr('src', '{{asset("/images/upload/default-img.png")}}');
        }
    }
</script>
@endpush
@endsection