@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Add Category'),
            'headerData' => __('Category'),
            'url' => 'category',
        ])
        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Add Category') }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{ url('category') }}" id="category_form" name="category_form" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group center">
                                            <label>{{ __('Image') }} {{ __('(Ratio : 2:1)') }}</label>
                                            <div id="image-preview" class="image-preview">
                                                <label for="image-upload" id="image-label"> <i
                                                        class="fas fa-plus"></i></label>
                                                <input type="file" name="image" id="image-upload" />
                                            </div>
                                            @error('image')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <label>{{ __('Name') }}</label>
                                            <input type="text" name="name" placeholder="{{ __('Name') }}"
                                                value="{{ old('name') }}"
                                                class="form-control @error('name')? is-invalid @enderror">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('status') }}</label>
                                            <select name="status" class="form-control select2">
                                                <option value="1">{{ __('Active') }}</option>
                                                <option value="0">{{ __('Inactive') }}</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>{{ __('Redirect Link') }}</label>
                                            <input type="text" name="redirect_link" placeholder="{{ __('Redirect Link') }}" value="{{ old('redirect_link') }}" class="form-control @error('redirect_link')? is-invalid @enderror">
                                            @error('redirect_link')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Banner Image') }}</label>
                                            <input type="file" name="banner_image" onchange="loadFile(event);" id="banner_image" class="form-control @error('banner_image')? is-invalid @enderror">
                                            <div id="img_preview">

                                            </div>
                                            @error('banner_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Type') }}</label>
                                            <select name="type" class="form-control select2">
                                                <option value="Offline">{{ __('Offline') }}</option>
                                                <option value="Online">{{ __('Online') }}</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Order') }}</label>
                                            <select name="order_num" class="form-control select2">
                                                @for($i=1;$i<=100;$i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Benefits') }}(comma separated to add multiple)</label>
                                            <input type="text" name="benefits" id="benefits" class="form-control">
                                        </div>


                                        


                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="continue_btn" class="btn btn-primary demo-button">{{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script> 
        $("#category_form").validate({
            rules: {
                image:{required:true},
                name:{required:true},
            },
            messages: {
                image:{required:"* Image is required"},
                name:{required:"* Name is required"}
            },
            errorElement: 'div',
            highlight: function(element, errorClass) {
                $(element).css({ border: '1px solid #f00' });
            },
            unhighlight: function(element, errorClass) {
                $(element).css({ border: '1px solid #c1c1c1' });
            },
            submitHandler: function(form) {
                document.category_form.submit();
                $("#continue_btn").attr('disabled','disabled').text('Processing...');
            }
        });
    </script>

    <script>
        var loadFile = function(event) {
            $("#img_preview").html(`<img src="${URL.createObjectURL(event.target.files[0])}" class="mt-3 img-fluid">`); ;
            
        }
    </script>
@endpush
