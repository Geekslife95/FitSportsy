@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Edit Subscription'),
        ])
        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Edit Subscription') }}</h2>
                </div>
            </div>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $error }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endforeach
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <label>{{ __('Subscription Title') }}</label>
                                            <input type="text" name="title" placeholder="{{ __('Subscription Title') }}"
                                                value="{{$subDeatils->title}}" required
                                                class="form-control @error('title')? is-invalid @enderror">
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group" id="addServices">
                                            <label>{{ __('Services') }}</label>
                                            {{-- <div class="d-flex align-items-center">
                                                <input type="text" name="services[]" placeholder="{{ __('Subscription services') }}"
                                                value="{{ old('services') }}" required
                                                class="form-control @error('services')? is-invalid @enderror">
                                                <button type="button" id="addMore" class="btn btn-primary ms-2" style="min-width:100px;">Add More</button>
                                            </div> --}}
                                            @if ($subDeatils->services != NULL)
                                                @php $service = json_decode($subDeatils->services); @endphp
                                                @foreach ($service as $item)
                                                   @if ($loop->index == 0)
                                                    <div class="d-flex align-items-center">
                                                        <input type="text" name="services[]" placeholder="{{ __('Subscription services') }}"
                                                        value="{{$item}}" required
                                                        class="form-control @error('services')? is-invalid @enderror">
                                                        <button type="button" id="addMore" class="btn btn-primary ms-2" style="min-width:100px;">Add More</button>
                                                    </div>
                                                   @else
                                                    <div class="d-flex align-items-center remove_slot_prnt">
                                                        <input type="text" name="services[]" placeholder="{{ __('Subscription services') }}"
                                                        value="{{$item}}" required
                                                        class="form-control @error('services')? is-invalid @enderror">
                                                        <button type="button" class="btn btn-danger btn-sm remove_slot" style="min-width:100px;"><i class="fas fa-times"></i> Remove</button>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                            @error('services')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Subscription Price') }}</label>
                                            <input type="number" name="sub_price" placeholder="{{ __('Subscription Price') }}"
                                            value="{{$subDeatils->price}}"
                                            class="form-control" required>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-6">
                                                <label>{{ __('Subscription Type') }}</label>
                                                <select name="sub_type"  class="form-control" id="" required>
                                                    <option value="Month" {{$subDeatils->type == "Month" ? "selected" : ""}}>Monthly</option>
                                                   <option value="Year" {{$subDeatils->type == "Year" ? "selected" : ""}}>Yearly</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <label>{{ __('Subscription Duration') }}</label>
                                                <select name="sub_duration"  class="form-control" id="" required>
                                                   @for ($i = 1; $i < 12; $i++)
                                                   <option value="{{$i}}" {{$subDeatils->duration == $i ? "selected" : ""}}>{{$i}}</option>
                                                   @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Status') }}</label>
                                            <select name="status" class="form-control select2" required>
                                                <option value="1" {{$subDeatils->status == 1 ? "selected" : ""}}>{{ __('Active') }}</option>
                                                <option value="0" {{$subDeatils->status == 0 ? "selected" : ""}}>{{ __('Inactive') }}</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary demo-button">{{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@push('scripts')
    <script>
        $(document).on('click','#addMore',function(e){
            e.preventDefault();
            $('#addServices').append(`<div class="d-flex align-items-center remove_slot_prnt">
                <input type="text" name="services[]" placeholder="{{ __('Subscription services') }}"
                value="{{ old('services') }}" required
                class="form-control @error('services')? is-invalid @enderror">
                <button type="button" class="btn btn-danger btn-sm remove_slot" style="min-width:100px;"><i class="fas fa-times"></i> Remove</button>
            </div>`);
        })
    </script>    
    <script>
        $(document).on('click','.remove_slot',function(){
            $(this).parents('.remove_slot_prnt').remove();
        })
    </script>
@endpush
@endsection
