@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('All Events'))
@section('content')
<section class="page-wrapper">
    <div class="content container-fluid">
        <!-- Page Header -->
        <!-- /Page Header -->
        @include('eventDashboard.common-links')
        @include('messages')
        @isset($checkEvent) @php $checkEvent = json_decode($checkEvent->photos_info,true); @endphp @endisset
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <form action="" method="POST" enctype="multipart/form-data">
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
                                        @if (isset($checkEvent['postcardImage']))
                                            <img src="{{asset('/images/upload/'.$checkEvent['postcardImage'].'')}}" class="upimage img-fluid img-thumbnail d-block mb-2" alt="">
                                            <div class="uploader">
                                                <input type="file" accept="image/*" name="image" id="image" class="uploader form-control" onchange="prevImage(this)" value="{{$checkEvent['postcardImage']}}" required>
                                            </div>
                                        @else
                                            <img src="{{asset('/images/upload/default-img.png')}}" class="upimage img-fluid img-thumbnail d-block mb-2" alt="">
                                            <div class="uploader">
                                                <input type="file" accept="image/*" name="image" id="image" class="uploader form-control" onchange="prevImage(this)" value="" required>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                           
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Description Page Images</label>
                                        <code>Dimension is 1280 X 500</code>
                                        @if (isset($checkEvent['postcardImage']))
                                            <img src="{{asset('/images/upload/'.$checkEvent['postcardImage'].'')}}" class="upimage img-fluid img-thumbnail d-block mb-2" alt="">
                                            <div class="uploader">
                                                <input type="file" accept="image/*" name="main_image" id="main_image" class="uploader form-control" onchange="prevImage(this)" value="{{$checkEvent['banner_img']}}" required>
                                            </div>
                                        @else
                                            <img src="{{asset('/images/upload/default-img.png')}}" class="upimage img-fluid img-thumbnail d-block mb-2" alt="">
                                            <div class="uploader">
                                                <input type="file" accept="image/*" name="main_image" id="main_image" class="uploader form-control" onchange="prevImage(this)" value="" required>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <h5>Coaches <button type="button" id="add_more_temples" class="btn btn-light text-dark btn-sm">+ Add More</button></h5>
                            <br><code>Dimension is 300 X 300</code>
                            <hr>
                            @if (isset($checkEvent['gallery']))
                            <div class="row" id="more_temples">
                                @php $gallery = explode(",", $checkEvent['gallery'])  @endphp
                                @if ($gallery != NULL)
                                    @foreach ($gallery as $item)
                                        <div class="col-lg-3 col-md-3 col-12 remove_slot_prnt">
                                            <div class="form-group">
                                                <label class="w-100">Gallery Image <button type="button" class="float-right remove_temp badge badge-danger"><i class="fas fa-times"></i> Remove </button></label>
                                                <img src="{{asset('/images/upload/'.$item.'')}}" class="upimage img-fluid img-thumbnail d-block mb-2" alt="">
                                                <div class="uploader"><input onchange="prevImage(this)" name="gallery_image[]" type="file" value="{{$item}}" class="form-control"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            @else
                            <div class="row" id="more_temples">
                            </div>
                            @endif
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
    $("#event_form").validate({
       rules: {
           image:{required:true},
       },
       messages: {
           image:{required:"* This Feild is required"},
       },
       errorElement: 'div',
       highlight: function(element, errorClass) {
           $(element).css({ border: '1px solid #f00' });
       },
       submitHandler: function(form) {
           document.event_form.submit();
           $("#continue_btn").attr('disabled','disabled').text('Processing...');
       }
   });
</script>
<script>
    $("#add_more_temples").on('click',function(){
        $("#more_temples").append(`<div class="col-lg-3 col-md-3 col-12 remove_slot_prnt">
                                    <div class="form-group">
                                        <label class="w-100">Gallery Image <button type="button" class="float-right remove_temp badge badge-danger"><i class="fas fa-times"></i> Remove </button></label>
                                        <img src="{{asset('/images/upload/default-img.png')}}" class="upimage img-fluid img-thumbnail d-block mb-2" alt="">
                                        <div class="uploader">
                                            <input onchange="prevImage(this)" accept="image/*" name="gallery_image[]" type="file" class="form-control" required>
                                        </div>
                                        <input type="text" name="coach_name[]" class="form-control mt-3" placeholder="Coach Name"/>
                                    </div>
                                </div>`);
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
            $('.upimage').attr('src', '{{asset('/images/upload/default-img.png')}}');
        }
    }
</script>
@endpush
@endsection